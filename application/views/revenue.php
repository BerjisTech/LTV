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
    <div class="col-sm-4">
        <form autocomplete="off" method="POST" action="<?php echo base_url('add_revenue'); ?>" class="revenue_form col-sm-12">
            <div class="input-group col-sm-12">
                <p>Last 30 days</p>
                <input class="form-control" style="height: 40px;" type="text" name="last_30_days" placeholder="Last 30 Days" />
            </div>
            <div class="input-group col-sm-12">
                <p>Net Sales</p>
                <input class="form-control" style="height: 40px;" type="text" name="net_sales" placeholder="Net Sales" />
            </div>
            <div class="input-group col-sm-12">
                <p>Gross MRR</p>
                <input class="form-control" style="height: 40px;" type="text" name="gross_mrr" placeholder="Gross MRR" />
            </div><br />
            <p>Date</p>
            <div class="input-group">
                <input type="text" name="recorded" class="form-control datepicker" data-format="D, dd MM yyyy">
                <div class="input-group-addon"> <a href="#"><i class="entypo-calendar"></i></a> </div>
            </div>
            <input type="hidden" name="app_id" value="<?php echo $app->app_id; ?>" />
            <input type="hidden" name="year" value="<?php echo date('Y', time()); ?>" />
            <input type="hidden" name="q" value="
            <?php
            if (date('m', time()) <= 3) {
                echo 1;
            }
            if (date('m', time()) >= 4 && date('m', time()) <= 6) {
                echo 2;
            }
            if (date('m', time()) >= 7 && date('m', time()) <= 9) {
                echo 3;
            }
            if (date('m', time()) >= 10) {
                echo 4;
            }
            ?>
            " />
            <br />
            <button type="submit" class="submit_revenue btn btn-success form-control">Add Plan</button>
        </form>
    </div>
</div>

<script>
    $('.revenue_form').on('submit', (e) => {
        e.preventDefault()

        $.ajax({
            url: '<?php echo base_url('add_revenue'); ?>',
            method: 'POST',
            data: $('.revenue_form').serialize(),
            success: (r) => {
                console.log(r)
                if (r.includes('already exists') || r.includes('no data')) {
                    $(`<div class="alert alert-danger"><strong>Oh snap!</strong> ${r} </div>`).insertBefore($('.submit_revenue'));
                    setTimeout(() => {
                        $('.alert-danger').remove()
                    }, 5000)
                    exit;
                }
                $(`<div class="alert alert-success"><strong>Well done!</strong> Revenuve succesfully recorded.</div>`).insertBefore($('.submit_revenue'));
                setTimeout(() => {
                    $('.alert-success').remove()
                }, 1000)
                $('.morrischart').empty()
                drawLine('revenue_line', revenue_data, revenue_keys, revenue_labels, revenue_colors)
                drawArea('revenue_area', revenue_data, revenue_keys, revenue_labels, revenue_colors)
                drawBar('revenue_bar', revenue_data, revenue_keys, revenue_labels, revenue_colors)
            },
            error: (e) => {
                console.log(e)
                $(`<div class="alert alert-danger"><strong>Oh snap!</strong> ${e} </div>`).insertBefore($('.submit_revenue'));
                setTimeout(() => {
                    $('.alert-danger').remove()
                }, 1000)
            }
        })
    })
</script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>" id="script-resource-12"></script>