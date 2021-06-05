<script>
    jQuery(document).ready(function($) {
        let countries = <?php echo json_encode($countries); ?>;
        let continents = <?php echo json_encode($continents); ?>;

        let csv_data = <?php echo json_encode($csv_data); ?>;
        let csv_titles = csv_data[0];
        let csv_rows = csv_data.filter(a => csv_data.indexOf(a) != 0)

        let installs = csv_rows.filter(x => x[1] === "Installed")
        let reopened = csv_rows.filter(x => x[1] === "Re-opened Store")
        let uninstalls = csv_rows.filter(x => x[1] === "Uninstalled")
        let closed = csv_rows.filter(x => x[1] === "Closed Store")

        let continental = []
        let user_country_code = []
        let user_country_name = []
        let country_pie_data = []
        let country_uninstall_data = []
        let installed_countries = []
        let colors = []
        let count_installs, days, today, country_code, country_name, total_users


        $(countries).each((i, c) => {
            country_name = c.country_name
            country_code = c.country_code

            count_installs = installs.filter(i => i[5] === country_code)

            if (count_installs.length > 0) {
                colors.push("#" + Math.floor(Math.random() * 16777215).toString(16))
                user_country_code.push(country_code)
                user_country_name.push(country_name)
                continental[c.country_code] = count_installs

                country_pie_data.push({
                    "label": country_name,
                    "value": count_installs.length
                })
            }
        })

        let sum = 0
        let sum_i = 0
        let sum_r = 0
        let sum_c = 0
        let sum_u = 0
        let sum_up = 0
        let sum_down = 0
        let day_up = 0
        let day_low = 0
        let country_install_data = []
        
        for (days = 2000; days > 0; days--) {
            today = new Date().setDate(new Date().getDate() - days)
            day_up = new Date().setDate(new Date().getDate() - (days + 1))
            // console.log(`Today ${today} Day Up ${day_up}`)

            sum_i += installs.filter(i => Math.floor((new Date(i[0])).getTime()) >= day_up && Math.floor((new Date(i[0])).getTime()) <= today).length
            // sum_r += reopened.filter(i => Math.floor((new Date(i[0])).getTime()) >= day_up && Math.floor((new Date(i[0])).getTime()) <= today).length
            // sum_u += uninstalls.filter(i => Math.floor((new Date(i[0])).getTime()) >= day_up && Math.floor((new Date(i[0])).getTime()) <= today).length
            // sum_c += closed.filter(i => Math.floor((new Date(i[0])).getTime()) >= day_up && Math.floor((new Date(i[0])).getTime()) <= today).length

            // sum_up += (sum_i + sum_r)
            // sum_down = (sum_u + sum_c)

            // sum += (sum_up - sum_down)

            //console.log(`Installed ${sum_i}\nReopened ${sum_r}\nUninstalled ${sum_u}\nClosed ${sum_c}\nRemaining that day ${sum}\n\n\n`)
            // sum += total_users
            country_install_data.push({
                y: today,
                a: sum_i
            })
        }

        drawLongLine('country_line', country_install_data, ['a'], ['Installs'], ['#D05421'])
        // drawLine('country_line', country_install_data, ['a', 'b', 'c', 'd', 'e'], ['Installs', 'Reopened', 'Uninstalled', 'Closed', 'Total'], ['#D05421', '#21D1B1', '#C90100', '#3CC2EB', '#FFDCBE'])
        // drawArea('revenue_area', country_pie_data, user_country_code, user_country_name, colors)
        // drawBar('revenue_bar', country_pie_data, user_country_code, user_country_name, colors)
        drawPie('country_pie', country_pie_data, user_country_code, user_country_name, colors)
    })
</script>