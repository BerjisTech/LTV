<?php
include('review_graphs.php');
?>
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">

                </div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <?php foreach ($all_apps as $key => $graph_dom) : ?>
                            <li class="<?php if ($key == 0) : ?>active<?php endif; ?>"><a href="#<?php echo $graph_dom['app_code']; ?>_chart" data-toggle="tab"><?php echo $graph_dom['app_code']; ?></a></li>
                        <?php endforeach; ?>
                        <li class=""><a href="#edit_chart" data-toggle="tab">Edit Reviews</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <?php foreach ($all_apps as $key => $graph_dom) : ?>
                        <div class="tab-pane <?php if ($key == 0) : ?>active<?php endif; ?>" id="<?php echo $graph_dom['app_code']; ?>_chart">
                            <div id="<?php echo $graph_dom['app_code']; ?>_reviews_chart" class="morrischart" style="height: 300px"></div>
                        </div>
                    <?php endforeach; ?>
                    <!-- <div id="pc_reviews_chart" class="morrischart" style="height: 300px"></div>
                        <div id="icu_reviews_chart" class="morrischart" style="height: 300px"></div>
                        <div id="pon_reviews_chart" class="morrischart" style="height: 300px"></div>
                        <div id="bdn_reviews_chart" class="morrischart" style="height: 300px"></div>
                        <div id="wpn_reviews_chart" class="morrischart" style="height: 300px"></div>
                        <div id="tfx_reviews_chart" class="morrischart" style="height: 300px"></div> -->
                    <div class="tab-pane active" id="edit_chart"></div>
                </div>
            </div>
        </div>
    </div>
    <form action="recordReviews" method="POST" class="review_form col-sm-4">
        <h3>Add Reviews Data for <?php echo $app->app_name; ?></h3>
        <div class="input-group col-sm-12">
            <label>Rating</label>
            <input type="number" min="1" max="5" class="form-control" name="rating" />
        </div>
        <input type="hidden" class="form-control" name="app_id" readonly value="<?php echo $app->app_id ?>">
        <div class="input-group col-sm-12">
            <label>Review Date</label>
            <input type="date" class="form-control" name="review_date" />
        </div>
        <div class="input-group col-sm-12">
            <label>Requested By</label>
            <input type="text" class="form-control" name="credited_to" />
        </div>
        <div class="input-group col-sm-12">
            <label>Reviewed By</label>
            <input type="text" class="form-control" name="review_by" />
        </div><br />
        <button type="submit" class="submit_review btn btn-lg btn-primary">ADD REVIEW</button>
    </form>
</div>
<script>
    $('.review_form').on('submit', (e) => {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url('recordReviews'); ?>',
            method: 'POST',
            data: $('.review_form').serialize(),
            success: (r) => {
                if (r.includes('already exists')) {
                    $(`<div class="alert alert-danger"><strong>Oh snap!</strong> ${r} </div>`).insertBefore($('.submit_review'));
                    setTimeout(() => {
                        $('.alert-danger').remove()
                    }, 2000)
                    exit;
                }
                $(`<div class="alert alert-success"><strong>Well done!</strong> Review succesfully added.</div>`).insertBefore($('.submit_review'));
                setTimeout(() => {
                    $('.alert-success').remove()
                }, 1000)
                $("#<?php echo $app->app_code ?>_reviews_chart").empty();
                drawLine('<?php echo $app->app_code ?>_reviews_chart', <?php echo $app->app_code ?>_reviews_data, reviews_keys, reviews_labels, reviews_colors)
            },
            error: (e) => {
                $(`<div class="alert alert-danger"><strong>Oh snap!</strong> ${e} </div>`).insertBefore($('.submit_review'));
                setTimeout(() => {
                    $('.alert-danger').remove()
                }, 1000)
            }
        })
    })
</script>