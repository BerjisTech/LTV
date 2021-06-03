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
                        <li class="active"><a href="#pc_chart" data-toggle="tab">PC</a></li>
                        <li class=""><a href="#icu_chart" data-toggle="tab">ICU</a></li>
                        <li class=""><a href="#pon_chart" data-toggle="tab">PON</a></li>
                        <li class=""><a href="#bdn_chart" data-toggle="tab">BDN</a></li>
                        <li class=""><a href="#wpn_chart" data-toggle="tab">WPN</a></li>
                        <li class=""><a href="#tfx_chart" data-toggle="tab">TFX</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="pc_chart">
                        <div id="pc_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="icu_chart">
                        <div id="icu_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="pon_chart">
                        <div id="pon_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="bdn_chart">
                        <div id="bdn_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="wpn_chart">
                        <div id="wpn_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                    <div class="tab-pane" id="tfx_chart">
                        <div id="tfx_reviews_chart" class="morrischart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="recordReviews" method="POST" class="review_form col-sm-4">
        <div class="input-group col-sm-12">
            <label>Rating</label>
            <input type="number" min="1" max="5" class="form-control" name="rating" />
        </div>
        <div class="input-group col-sm-12">
            <label>Rating</label>
            <select type="number" min="1" max="8" class="form-control" name="app_id">
                <?php foreach ($this->db->get('apps')->result_array() as $app) : ?>
                    <option value="<?php echo $app['app_id']; ?>"><?php echo $app['app_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-group col-sm-12">
            <label>Review Date</label>
            <input type="date" class="form-control" name="review_date" />
        </div>
        <div class="input-group col-sm-12">
            <label>Credits To</label>
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