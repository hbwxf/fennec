{#extends file='layoutWithBars.tpl'#}
{#block name='content'#}
    <div id="project-upload-message-area"></div>
    <form>
        <input class="btn" id="project-fileupload" type="file" name="files[]" multiple>
    </form>
    <script src="{#$WebRoot#}/js/uploadProject.js" type="text/javascript"></script>
    {#include file='components/otuTable.tpl'#}
    {#include file='components/metadataTable.tpl'#}
{#/block#}