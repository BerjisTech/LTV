<div class="row">
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
        <button type="submit" class="btn btn-lg btn-primary">ADD REVIEW</button>
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
                $(`<div class="alert alert-success"><strong>Well done!</strong> Review succesfully added.</div>`).insertBefore($('[name="submit_review"]'));
                setTimeout(() => {
                    $('.alert-success').remove()
                }, 1000)
            },
            success: (e) => {
                alert(e)
            },
        })
    })
</script>