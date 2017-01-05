'use strict';

$('document').ready(function () {
    $('#add-trait-to-project-button').on('click', function () {
        var trait_metadata = biom.getMetadata({ dimension: 'rows', attribute: ['fennec', dbversion, 'fennec_id'] }).map(function (value) {
            if (value in traitValues) {
                return traitValues[value];
            }
            return null;
        });
        biom.addMetadata({ dimension: 'rows', attribute: traitName, values: trait_metadata });
        var webserviceUrl = Routing.generate('api', { 'namespace': 'edit', 'classname': 'updateProject' });
        $.ajax(webserviceUrl, {
            data: {
                "dbversion": dbversion,
                "project_id": internalProjectId,
                "biom": biom.toString()
            },
            method: "POST",
            success: function success() {
                return showMessageDialog('Successfully added ' + traitName + ' to metadata.', 'success');
            },
            error: function error(_error) {
                return showMessageDialog(_error, 'danger');
            }
        });
    });
});