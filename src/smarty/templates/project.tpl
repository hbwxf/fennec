{#extends file='layoutWithBars.tpl'#}
{#block name='content'#}
{#if !isset($user)#}
    <h3> Please log in to see your projects or add new ones. </h3>
{#else#}
    <h3> Upload projects in <a href="http://biom-format.org/documentation/format_versions/biom-1.0.html">biom format (version 1.0)</a></h3>
    <div id="project-upload-message-area"></div>
    <form>
        <input class="btn" id="project-fileupload" type="file" name="files[]" multiple>
    </form>
    <script src="{#$WebRoot#}/js/uploadProject.js" type="text/javascript"></script>
    <i class="fa fa-refresh fa-spin" style="font-size:24px; display:none" id="project-upload-busy-indicator"></i>

    <h3> My projects </h3>
    <table id="project-table" class="table project-table project-table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Import Date</th><th># OTUs</th><th># Samples</th><th>Actions</th></tr>
        </thead>
    </table>
    <script type="text/javascript">
        var table = $('#project-table').DataTable( {
            ajax: {
                url: '{#$ServicePath#}/listing/projects?dbversion={#$DbVersion#}',
                dataSrc: 'data',
                complete: function(){
                    addFunctionality();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'import_date' },
                { data: 'rows' },
                { data: 'columns' },
                { data: null }
            ],
            columnDefs: [ 
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class=\"fa fa-trash project-remove-button\"></button>"
                }
            ]
        } );
        
        function addFunctionality(){
            $('.project-remove-button').on( 'click', function () {
                var table = $('#project-table').DataTable({
                    retrieve: true
                });
                var data = table.row( $(this).parents('tr') ).data();
                $.ajax({
                    url: WebRoot+'/ajax/manage/ProjectRemove',
                    type: 'POST',
                    data: {
                        'dbversion': DbVersion,
                        'ids': [data.internal_project_id]
                    },
                    cache: false,
                    dataType: 'json',
                    /* jshint unused:vars */
                    success: function(data, textStatus, jqXHR)
                    {
                        var removed = data.removedProjects;
                        showProjectUploadDialog(removed+" project"+(removed > 1 ? "s" : "")+" removed successfully", 'alert-success');
                        $('#project-table').DataTable({
                            retrieve: true
                        }).ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        showProjectUploadDialog("There was an error: "+textStatus, 'alert-danger');
                    }
                });
            });
        }
    </script>
{#/if#}
{#/block#}