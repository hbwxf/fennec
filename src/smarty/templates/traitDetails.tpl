{#extends file='layoutWithBars.tpl'#}
{#block name='content'#}
{#call_webservice path="details/Traits" data=["type_cvterm_id"=>$type_cvterm_id, "dbversion"=>$DbVersion] assign='data'#}
<h1 class="page-header">{#$data['name']#}</h1>
<h4 class="page-header">Definition</h4>
<div class="row">
    <div class='col-xs-8'>
        <a class='trait-details-link' href='{#$data['definition']#}' target='_blank'>Go to EOL definition</a>
    </div>
    <div class="col-xs-4">
        <div class="panel panel-trait-details">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-paw fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{#$data['all_organisms']#}</div>
                        <div>Organisms</div>
                    </div>
                </div>
            </div>
            <a href="{#$WebRoot#}/{#$DbVersion#}/organism/details/byTrait/{#$data['trait_cvterm_id']#}" onclick="parent.$.fancybox.close();">
                <div class="panel-footer info-trait-details">
                    <span class="pull-left">View all organisms with this trait</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<h4 class="page-header">Data</h4>
<div class='row'>
    {#if $data['value_type'] == 'value' #}
        <div class='col-xs-12'>
            <div id='histogram'></div>
            <input type='hidden' value='{#$data['trait_cvterm_id']#}' id='cvterm_id'/>
            <script src="{#$WebRoot#}/bower_components/plotly.js/dist/plotly.min.js"></script>
            <script src='{#$WebRoot#}/js/drawCharts.js'></script>
            <script>drawHistogram();</script>
        </div>
    {#elseif $data['value_type'] == 'cvterm' #}
        {#if $data['name'] != 'geographic distribution' #}
            <div class='col-xs-12'>
                <div id='pieChart'></div>
                <input type='hidden' value='{#$data['trait_cvterm_id']#}' id='cvterm_id'/>
                <script src="{#$WebRoot#}/bower_components/plotly.js/dist/plotly.min.js"></script>
                <script src='{#$WebRoot#}/js/drawCharts.js'></script>
                <script>drawPieChart();</script>
            </div>
            <div class="col-xs-12" id="displayValueRange">
                <svg width='1000' height='750' style='background-image: url("{#$WebRoot#}/css/img/traitInteractiveBrowse_{#$data['name']#}.png")'/>
            </div>
        {#else#}
            <div class='col-xs-12'>
                <div id='map'></div>
                <input type='hidden' value='{#$data['trait_cvterm_id']#}' id='cvterm_id'/>
                <script src='{#$WebRoot#}/js/createCSV.js'></script>
                <script src='{#$WebRoot#}/bower_components/file-saver.js/FileSaver.js'></script>
                <script src="{#$WebRoot#}/bower_components/plotly.js/dist/plotly.min.js"></script>
                <script src='{#$WebRoot#}/js/drawCharts.js'></script>
                <script>drawMap();</script>
            </div>
        {#/if#}
    {#/if#}
</div>
{#/block#}