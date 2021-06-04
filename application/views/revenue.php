<?php
include('revenue_data.php');
?>
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">

                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#revenue_line_chart" data-toggle="tab">Line</a></li>
                        <li class=""><a href="#revenue_area_chart" data-toggle="tab">Area</a></li>
                        <li class="active"><a href="#revenue_bar_chart" data-toggle="tab">Bar</a></li>
                        <li class=""><a href="#revenue_pie_chart" data-toggle="tab">Pie</a></li>
                        <li class=""><a href="#revenue_table_chart" data-toggle="tab">Table</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane" id="revenue_line_chart">
                        <div id="revenue_line" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="revenue_area_chart">
                        <div id="revenue_area" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane active" id="revenue_bar_chart">
                        <div id="revenue_bar" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="revenue_pie_chart">
                        <div id="revenue_pie" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="revenue_table_chart">
                        <div id="revenue_table" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>