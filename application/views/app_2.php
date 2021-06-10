<div class="row mwili_ya_mkuu">
    <div class="col-sm-12">
        <button class="btn btn-lg btn-info pull-right importButtonShowHideClass" onclick="startImport('users','')">Import <?php echo strtoupper($app->app_code); ?> User Data</button>
    </div>
    <div class="col-sm-12">
        <br />
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    Revenue Last 30 days
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#" style="background: #21A9E1; color: #ffffff;" class="importButtonShowHideClass" onclick="startImport('financials','')">Import <?php echo strtoupper($app->app_code); ?> Financial Data</a></li>
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
                        <!-- <li class="active"><a href="#user-chart" data-toggle="tab">User Growth</a></li> -->
                        <li class="active"><a href="#installs-chart" data-toggle="tab">Installs</a></li>
                        <li class=""><a href="#uninstalls-chart" data-toggle="tab">Uninstalls</a></li>
                        <!-- <li class=""><a href="#churn-chart" data-toggle="tab">Churn</a></li> -->
                        <li class=""><a href="<?php echo base_url("users/$app_id"); ?>" target="_BLANK" style="background: #00A651; color: #ffffff;"><span class="entypo-plus"></span> Add Records</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <!-- <div class="tab-pane active" id="user-chart">
                        <div id="users_chart" class="morrischart" style="height: 300px"></div>
                    </div> -->
                    <div class="tab-pane active" id="installs-chart">
                        <div id="installs_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="uninstalls-chart">
                        <div id="uninstalls_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <!-- <div class="tab-pane" id="churn-chart">
                        <div id="churn_chart" class="morrischart" style="height: 300px"></div>
                    </div> -->
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

<script>
    let imported_data = 0;

    function startImport(data_set, cursor) {
        $('.importButtonShowHideClass').hide()
        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-info imports"><strong>Importing...</strong> </div></div>`))
        importDaily(data_set, '')
    }

    function importDaily(data_set, cursor) {
        $.ajax({
            url: `<?php echo base_url("run_importer/$app_id/"); ?>${data_set}/${cursor}`,
            success: (r) => {
                // r = JSON.parse(r)
                console.log(r)
                if (r.status == '200') {
                    imported_data += r.total_data
                    setTimeout(() => {
                        $('.imports').html(`<strong>Importing...</strong> ${imported_data} ${data_set} data imported so far : (${r.cursor})`)
                        if (r.cursor != '' && r.cursor != 'DONE') {
                            importDaily(data_set, r.cursor)
                        } else {
                            $('.alert-info').remove()
                        }
                    }, 1000)

                    if (r.cursor == 'DONE') {
                        $('.alert-info').remove()
                        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-success fullImport"><strong>SUCCESS</strong> All ${imported_data} ${data_set} data succesfully imported <span class="entypo-cancel pull-right" onclick="$('.fullImport').remove()" style="cursor: pointer; margin-right: 20px;"></span></div></div>`))
                    }
                }
                if (r.status == '500') {
                    if (r.cursor == 'DONE') {
                        $('.alert-info').remove()
                        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-success 500Error"><strong>Oh Snap!</strong> Something went wrong when importing the data <span class="entypo-cancel pull-right" onclick="$('.fullImport').remove()" style="cursor: pointer; margin-right: 20px;"></span></div></div>`))
                    }
                }
                $('.importButtonShowHideClass').show()
                fetch_revenue_data('<?php echo $app_id ?>', 0, 366)
                fetch_user_data('<?php echo $app_id ?>', 0, 366)
            },
            error: (e) => {
                console.log(e)
                e = JSON.parse(e)
                $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-danger"><strong>Oh snap!</strong> ${e} </div></div>`))
                setTimeout(() => {
                    $('.alert-danger').remove()
                }, 1000)
                $('.importButtonShowHideClass').show()
            }
        })
    }

    function startFullImport(data_set, cursor) {
        $('.importButtonShowHideClass').hide()
        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-info imports"><strong>Importing...</strong> </div></div>`))
        importFull(data_set, '')
    }

    function importFull(data_set, cursor) {
        $.ajax({
            url: `<?php echo base_url("run_full_importer/$app_id/"); ?>${data_set}/${cursor}`,
            success: (r) => {
                // r = JSON.parse(r)
                console.log(r)
                if (r.status == '200') {
                    imported_data += r.total_data
                    setTimeout(() => {
                        $('.imports').html(`<strong>Importing...</strong> ${imported_data} ${data_set} data imported so far : (${r.cursor})`)
                        if (r.cursor != '' && r.cursor != 'DONE') {
                            importFull(data_set, r.cursor)
                        } else {
                            $('.alert-info').remove()
                        }
                    }, 1000)
                    if (r.cursor == 'DONE') {
                        $('.alert-info').remove()
                        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-success fullImport"><strong>SUCCESS</strong> All ${imported_data} ${data_set} data succesfully imported <span class="entypo-cancel pull-right" onclick="$('.fullImport').remove()" style="cursor: pointer; margin-right: 20px;"></span></div></div>`))
                    }
                }
                if (r.status == '500') {
                    if (r.cursor == 'DONE') {
                        $('.alert-info').remove()
                        $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-success 500Error"><strong>Taran!</strong> You're good. There's no new data to import at the moment <span class="entypo-cancel pull-right" onclick="$('.fullImport').remove()" style="cursor: pointer; margin-right: 20px;"></span></div></div>`))
                    }
                }
                $('.importButtonShowHideClass').show()
            },
            error: (e) => {
                console.log(e)
                e = JSON.parse(e)
                $('.mwili_ya_mkuu').prepend($(`<div class="col-sm-12"><div class="alert alert-danger"><strong>Oh snap!</strong> ${e} </div></div>`))
                setTimeout(() => {
                    $('.alert-danger').remove()
                }, 1000)
                $('.importButtonShowHideClass').show()
            }
        })
    }
</script>


<?php
include('separate_data.php');
?>