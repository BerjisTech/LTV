<?php
include('separate_data.php');
?>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    Revenue Last 30 days
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="<?php echo base_url("revenue/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="revenue-chart">
                        <div id="revenue_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">

                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user-chart" data-toggle="tab">User Growth</a></li>
                        <li class=""><a href="#installs-chart" data-toggle="tab">Installs</a></li>
                        <li class=""><a href="#uninstalls-chart" data-toggle="tab">Uninstalls</a></li>
                        <li class=""><a href="#churn-chart" data-toggle="tab">Churn</a></li>
                        <li class=""><a href="<?php echo base_url("users/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="user-chart">
                        <div id="users_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="installs-chart">
                        <div id="installs_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="uninstalls-chart">
                        <div id="uninstalls_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="churn-chart">
                        <div id="churn_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    Reviews
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="<?php echo base_url("reviews/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="area-chart">
                        <div id="reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    Key words Tracking
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#keywords" data-toggle="tab">Keywords</a></li>
                        <li class=""><a href="#ranking" data-toggle="tab">Ranking</a></li>
                        <li class=""><a href="<?php echo base_url("keywords/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="keywords">
                        <table class="table table-responsive table-active table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>KeyWord</th>
                                    <th>#</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="ranking">
                        <div id="keywords_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="area-chart">
                        <div id="keywords_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    Ad Spend
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="<?php echo base_url("ad_spend/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="area-chart">
                        <div id="ads_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>