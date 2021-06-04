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
                        <li class=""><a href="#plans-data" data-toggle="tab">App Plans</a></li>
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
                        <li class="active"><a href="#daily-users" data-toggle="tab">Daily Users</a></li>
                        <li class=""><a href="#app-plans" data-toggle="tab">App Plans</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="daily-users">
                    </div>
                    <div class="tab-pane" id="app-plans">
                        <form class="review_form">
                            <div>
                                <input type="text" name="plan_name" placeholder="plan name" />
                                <input type="hidden" name="app_id" value="<?php echo $app->app_id; ?>" />
                                <input type="number" name="price" placeholder="plan name" />
                                <input type="submit" class="btn btn-primary" value="Add Plan" />
                            </div>
                        </form>
                        <div>
                            <?php foreach ($plans as $plan) : ?>
                                <div>
                                    <span><?php echo $plan['plan_name']; ?></span>
                                    <span><?php echo $plan['plan_price']; ?></span>
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