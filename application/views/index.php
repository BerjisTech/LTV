<!DOCTYPE html>
<html lang="en">


<?php include 'header.php'; ?>

<body class="page-body skin-purple <?php if ($page_name == 'dashboard') {
                                        echo 'gray';
                                    } ?>" data-url="<?php echo base_url(); ?>">

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <div class="page-container">

        <?php include 'sidebar.php'; ?>

        <div class="main-content">

            <?php include 'profile.php'; ?>

            <hr />

            <?php include $page_name . '.php'; ?>

            <!-- Footer -->
            <footer class="main">
                <div class="pull-right"> <strong>Powered by Berjis Technologies</strong></div>
                &copy; <?php echo date('Y'); ?> <strong>LTV Group SaaS Fund</strong> <small>Your financial base</small>
            </footer>
        </div>

        <?php include 'chat.php'; ?>

    </div>

    <?php include 'modal.php'; ?>

    <script type="text/javascript">
        function showAjaxModal(url) {
            $('.customized-modal').css('margin-top', window.scrollY);
            // SHOWING AJAX PRELOADER IMAGE
            jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" style="height:25px;" /></div>');

            // LOADING THE AJAX MODAL
            jQuery('#modal_ajax').modal('show', {
                backdrop: 'true'
            });

            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: url,
                success: function(response) {
                    jQuery('#modal_ajax .modal-body').html(response);
                }
            });
        }
    </script>

    <!-- (Ajax Modal)-->
    <div class="modal fade customized-modal" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">LTV Fund</h4>
                </div>

                <div class="modal-body" style="height:500px; overflow:auto;">


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        function confirm_modal(delete_url) {
            jQuery('#modal-4').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('delete_link').setAttribute('href', delete_url);
        }
    </script>

    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>


                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!--    custom width modal -->

    <script type="text/javascript">
        function showCustomWidthModal(url) {
            // SHOWING AJAX PRELOADER IMAGE
            jQuery('#modal-2 .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" style="height:25px;" /></div>');

            // LOADING THE AJAX MODAL
            jQuery('#modal-2').modal('show', {
                backdrop: 'true'
            });

            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: url,
                success: function(response) {
                    jQuery('#modal-2 .modal-body').html(response);
                }
            });
        }
    </script>

    <div class="modal fade custom-width" id="modal-2">
        <div class="modal-dialog" style="width: 75%;">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">LTV Fund</h4>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>