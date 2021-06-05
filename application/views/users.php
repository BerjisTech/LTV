<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="input-group">

                    </div>
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user-data" data-toggle="tab">Daily Users</a></li>
                        <li class=""><a href="#plans-data" data-toggle="tab">Users per Plans</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="user-data active" class="tab-pane">
                    </div>
                    <div id="plans-data" class="tab-pane">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="input-group">

                    </div>
                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#daily-installs" data-toggle="tab">Daily Installs</a></li>
                        <li class=""><a href="#daily-uninstalls" data-toggle="tab">Daily Uninstalls</a></li>
                        <li class=""><a href="#app-plans" data-toggle="tab">App Plans</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="daily-installs">
                        <form class="daily_installs_form">
                            <input type="hidden" name="app_id" value="<?php echo $app->app_id; ?>" />
                            <?php foreach ($plans as $plan) : ?>
                                <div>
                                    <p><?php echo $plan['plan_name']; ?></p>
                                    <input style="height: 40px; color: #333333;" type="number" class="form-control" name="<?php echo $plan['plan_name']; ?>" placeholder="Installs for <?php echo $plan['plan_name']; ?>" />
                                </div>
                            <?php endforeach; ?>
                            <div>
                                <p>Closed</p>
                                <input style="height: 40px; color: #333333;" type="number" class="form-control" name="reopened" placeholder="Number of reopened stores" />
                            </div>
                            <hr />
                            <input type="submit" class="btn btn-sm btn-success" value="Update Installs" />
                        </form>
                    </div>
                    <div class="tab-pane " id="daily-uninstalls">
                        <form class="daily_uninstalls_form">
                            <input type="hidden" name="app_id" value="<?php echo $app->app_id; ?>" />
                            <?php foreach ($plans as $plan) : ?>
                                <div>
                                    <label for="<?php echo $plan['plan_name']; ?>"><?php echo $plan['plan_name']; ?></label>
                                    <input style="height: 40px; color: #333333;" class="form-control" type="number" name="<?php echo $plan['plan_name']; ?>" placeholder="Uninstalls for <?php echo $plan['plan_name']; ?>" />
                                </div>
                            <?php endforeach; ?>
                            <div>
                                <p>Closed</p>
                                <input style="height: 40px; color: #333333;" type="number" class="form-control" name="closed" placeholder="Number of closed stores" />
                            </div>
                            <hr />
                            <input type="submit" class="btn btn-sm btn-success" value="Update Uninstalls" />
                        </form>
                    </div>
                    <div class="tab-pane" id="app-plans">
                        <form class="col-sm-12 plan_form">
                            <div class="alert alert-success" style="display: flex;">
                                <input style="height: 40px;" type="text" name="plan_name" placeholder="Plan Name" />
                                <input style="height: 40px; width: 90px;" type="text" name="price" placeholder="Price" />
                                <input type="hidden" name="app_id" value="<?php echo $app->app_id; ?>" />
                                <input style="flex-grow: 4;" type="submit" class="btn btn-sm btn-success" value="Add Plan" />
                            </div>
                        </form>
                        <div class="plans col-sm-12" style="margin-top: 10px;">
                            <?php foreach ($plans as $plan) : ?>
                                <div class="alert alert-info">
                                    <strong><?php echo $plan['plan_name']; ?></strong>
                                    <span>$<?php echo $plan['price']; ?></span>
                                    <!-- <span><?php echo $plan_total_users; ?></span> -->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.plan_form').on('submit', (e) => {
        e.preventDefault()
        $.ajax({
            url: '<?php echo base_url('add_plan'); ?>',
            method: 'POST',
            data: $('.plan_form').serialize(),
            success: (r) => {
                $().insertBefore();
                $('.plans').append($(`<div class="alert alert-info">
                                    <strong>${$('[name="plan_name"]').val()}</strong>
                                    <span>${$('[name="price"]').val()}</span>
                                    <!-- <span><?php echo $plan_total_users; ?></span> -->
                                </div>`))
            },
            error: (e) => {}
        })
    })
</script>