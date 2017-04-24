$('document').ready(() => {
    $('#add-trait-to-project-button').on('click', function () {
        var trait_metadata = biom.getMetadata({dimension: 'rows', attribute: ['fennec', dbversion, 'fennec_id']}).map(
            function (value) {
                if(value in traitValues){
                    return traitValues[value];
                }
                return null;
            }
        );
        var trait_citations = biom.getMetadata({dimension: 'rows', attribute: ['fennec', dbversion, 'fennec_id']}).map(
            function (value) {
                if(value in traitCitations){
                    return traitCitations[value];
                }
                return [];
            }
        );
        biom.addMetadata({dimension: 'rows', attribute: traitName, values: trait_metadata});
        biom.addMetadata({dimension: 'rows', attribute: ['trait_citations', traitName], values: trait_citations});
        let webserviceUrl = Routing.generate('api', {'namespace': 'edit', 'classname': 'updateProject'});
        $.ajax(webserviceUrl, {
            data: {
                "dbversion": dbversion,
                "project_id": internalProjectId,
                "biom": biom.toString()
            },
            method: "POST",
            success: () => showMessageDialog('Successfully added '+traitName+ ' to metadata.', 'success'),
            error: (error) => showMessageDialog(error, 'danger')
        });
    });

    let projectUrl = Routing.generate('project_details', {'dbversion': dbversion, 'project_id': internalProjectId})+"#traits"
    $('#page-title').html(
        `<a href="${projectUrl}"><i class="fa fa-arrow-circle-left" style="padding-right: 10px"></i></a>`+$('#page-title').html()
    )
});