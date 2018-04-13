/* global internalProjectId */
/* global dbversion */

const addTraitToProject = require('../helpers/addTraitToProject');
const removeTraitFromProject = require('../helpers/removeTraitFromProject');
const biomPromise = require('./biom');
let biom;

$('document').ready(async () => {
    biom = await biomPromise;
    let attribute = $('#project-data').data('attribute');
    $('#project-show-trait-otu').on('click', () => getAndShowTraits('#trait-table', 'rows', attribute));
    $('#project-show-trait-sample').on('click', () => getAndShowTraits('#trait-table-sample', 'columns', attribute));

    function getAndShowTraits(id, dimension, attribute){
        $('#trait-table-progress').show();
        // Extract row fennec_ids from biom
        var fennec_ids = biom.getMetadata({dimension: dimension, attribute: ['fennec', dbversion, 'fennec_id']})
            .filter( element => element !== null );
        // Get traits for rows
        var webserviceUrl = Routing.generate('api_details_traits_of_organisms', {'dbversion': dbversion});
        $.ajax(webserviceUrl, {
            method: "POST",
            data: {
                'fennecIds': fennec_ids
            },
            success: function (data) {
                let traits = [];
                let number_of_unique_fennec_ids = _.uniq(fennec_ids).length
                $.each(data, function (key, value) {
                    var thisTrait = {
                        id: key,
                        trait: value['traitType'],
                        count: value['traitEntryIds'].length,
                        range: 100 * value['fennec'].length / number_of_unique_fennec_ids
                    };
                    traits.push(thisTrait);
                });
                $('#trait-table-progress').hide();
                $(id).show();
                initTraitsOfProjectTable(id, dimension, traits);
            }
        });
    }

    // Init traits of project table with values
    function initTraitsOfProjectTable(tableId, dimension, traits) {
        let metadataKeys = getMetadataKeys(biom, dimension)
        let dataTableOptions = {
            data: traits,
            columns: [
                {data: 'trait'},
                {data: 'count'},
                {data: 'range'},
                {data: null},
                {data: null},
                {data: null}
            ],
            order: [2, "desc"],
            columnDefs: [
                {
                    targets: 2,
                    render: data =>
                        '<span title="' + data / 100 + '"></span>' +
                        '<div class="progress">' +
                        '<div class="progress-bar progress-bar-trait" role="progressbar" style="width: ' + data + '%">' +
                        Math.round(data) + '%</div></div>',
                    type: 'title-numeric'
                },
                {
                    targets: 0,
                    render: (data, type, full) => {
                        var href = Routing.generate('trait_details', {
                            'dbversion': dbversion,
                            'attribute': attribute,
                            'trait_type_id': full.id
                        });
                        return '<a href="' + href + '">' + full.trait + '</a>';
                    }
                },
                {
                    targets: 3,
                    render: (data, type, full) => {
                        var href = Routing.generate('project_trait_details', {
                            'dbversion': dbversion,
                            'trait_type_id': full.id,
                            'project_id': internalProjectId,
                            'dimension': dimension,
                            'attribute': attribute
                        });
                        return '<a href="' + href + '"><i class="fa fa-search"></i></a>';
                    }
                },
                {
                    targets: 4,
                    render: (data, type, full) => {
                        return _.indexOf(metadataKeys, full.trait) != -1 ? '<i class="fa fa-check"></i>' : ''
                    }
                },
                {
                    targets: 5,
                    render: (data, type, full) => {
                        return _.indexOf(metadataKeys, full.trait) != -1 ? '<a onclick="removeTraitFromProjectTableAction('+"'"+full.trait+"','"+dimension+"'"+')"><i class="fa fa-trash"></i></a>' : '<a onclick="addTraitToProjectTableAction('+full.id+','+"'"+dimension+"'"+')"><i class="fa fa-plus"></i></a>';
                    }
                }
            ]
        };
        if (permission === 'view'){
            dataTableOptions.columnDefs[4].visible = false;
        }
        $(tableId).DataTable(dataTableOptions);
    }
});

function addTraitToProjectTableAction(traitTypeId, dimension){
    $.ajax({
            url: Routing.generate('api_details_trait_of_project', {'dbversion': dbversion}),
            method: "POST",
            data: {
                'projectId': internalProjectId,
                'traitTypeId': traitTypeId,
                'includeCitations': true,
                'dimension': dimension
            },
            success: function (data) {
                var traitValues;
                if(data.trait_format === 'numerical'){
                    traitValues = condenseNumericalTraitValues(data.values)
                } else {
                    traitValues = condenseCategoricalTraitValues(data.values)
                }
                addTraitToProject(data.type, traitValues, data.citations, biom, dimension, dbversion, internalProjectId, () => window.location.reload())
            }
        });
}

function removeTraitFromProjectTableAction(traitName, dimension){
    removeTraitFromProject(traitName, biom, dimension, dbversion, internalProjectId, () => window.location.reload())
}

// Make action functions global for now in order to work with the onclick string
global.addTraitToProjectTableAction = addTraitToProjectTableAction;
global.removeTraitFromProjectTableAction = removeTraitFromProjectTableAction;