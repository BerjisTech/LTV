<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="tile-stats tile-white stat-tile">
            <h3>Fund 5</h3>
            <p><?php echo $this->db->where('app_fund', 5)->get('apps')->num_rows(); ?> App</p> <span class="fund-5"></span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="tile-stats tile-white stat-tile">
            <h3>Fund 6</h3>
            <p><?php echo $this->db->where('app_fund', 6)->get('apps')->num_rows(); ?> Apps</p> <span class="fund-6"></span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="tile-stats tile-white stat-tile">
            <h3>Fund 7</h3>
            <p><?php echo $this->db->where('app_fund', 7)->get('apps')->num_rows(); ?> Apps</p> <span class="fund-7"></span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="tile-stats tile-white stat-tile">
            <p>App Comparison by Revenue</p>
            <span class="pie-chart"></span>
        </div>
    </div>
</div> <br />
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="input-group">
                        <select class="form-control adjust-stats">
                            <option value="">Choose stats time</option>
                            <option value="0">Last 24 hours</option>
                            <option value="1">Yesterday</option>
                            <option value="7">Last 7 days</option>
                            <option value="30">Lat 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last 365 days</option>
                            <option value="31">Last month</option>
                            <option value="366">Last year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#users-chart" data-toggle="tab">User Growth</a></li>
                        <li class="active"><a href="#revenue-chart" data-toggle="tab">Revenue</a></li>
                        <li class=""><a href="#comparison-chart" data-toggle="tab">App Comparison by Revenue</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class=" tab-pane" id="comparison-chart">
                        <div id="comparison_chart" class="morrischart" style="height: 500px;"></div>
                    </div>
                    <div class="tab-pane active" id="revenue-chart">
                        <div id="revenue_chart" class="morrischart" style="height: 500px"></div>
                    </div>
                    <div class="tab-pane" id="users-chart">
                        <div id="users_chart" class="morrischart" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <br />
<div class=" row">
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="padding-bottom-none text-center"> <br /> <br /> <span class="monthly-sales"></span> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="panel-heading">
                            <h4>Monthly Registrations (All Apps)</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Latest registrations</div>
                <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($apps as $fetch) : ?>
                        <tr>
                            <td><?php echo $fetch['app_id'] ?></td>
                            <td><?php echo $fetch['app_name'] ?></td>
                            <td class="text-center"><span class="<?php echo $fetch['app_code'] ?>-bar inlinebar"></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> <br />
<?php include('dashboard_graphs.php'); ?>