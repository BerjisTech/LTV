<script>
    $('.morrischart').html(`<img src="<?php echo base_url('assets/images/loader.gif'); ?>" />`)
    let revenue_keys = ['a']
    let revenue_labels = ['Revenue']
    let revenue_colors = ['#D05421']
    let revenue_data;

    fetch_quaterly_data('<?php echo $app_id ?>', 0, 30)

    function fetch_quaterly_data(app, from, to) {
        fetch(`${base_url}/get_quaterly/${app}/${from}/${to}`).then((r) => {
            r.text().then((d) => {
                revenue_data = JSON.parse(d)
                $('#revenue_chart').empty()
                drawLine('revenue_line', revenue_data, revenue_keys, revenue_labels, revenue_colors)
                drawArea('revenue_area', revenue_data, revenue_keys, revenue_labels, revenue_colors)
                drawBar('revenue_bar', revenue_data, revenue_keys, revenue_labels, revenue_colors)
            })
        })
    }
</script>