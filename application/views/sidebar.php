<div class="sidebar-menu">
	<div class="sidebar-menu-inner">
		<header class="logo-env">
			<!-- logo collapse icon -->
			<div class="sidebar-collapse"> <a href="#" class="sidebar-collapse-icon">
					<!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a> </div>
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs"> <a href="#" class="with-animation">
					<!-- add class "with-animation" to support animation --> <i class="entypo-menu"></i>
				</a>
			</div>
		</header>
		<div class="sidebar-user-info">
			<div class="sui-normal"> <a href="#" class="user-link"> <img src="<?php echo base_url(); ?>assets/images/favicon.ico" width="55" alt="" class="img-circle" />
					<span>Welcome,</span> <strong>Melissa</strong> </a> </div>
			<div class="sui-hover inline-links animate-in"> <a href="#"> <i class="entypo-pencil"></i>
					New Page
				</a> <a href="#"> <i class="entypo-mail"></i>
					Inbox
				</a> <a href="#"> <i class="entypo-lock"></i>
					Log Off
				</a> <span class="close-sui-popup">&times;</span></div>
		</div>
		<ul id="main-menu" class="main-menu">
			<li class="<?php if ($page_name == 'dashboard') {
							echo 'active';
						} ?>"> <a href="<?php echo base_url(); ?>"><i class="entypo-gauge"></i><span class="title">Dashboard</span></a>
			</li>
			<li class="has-sub <?php if ($page_name == 'app') {
									echo 'active';
								} ?>"> <a href="">
					<i class="entypo-gauge"></i><span class="title">Apps</span></a>
				<ul>
					<?php foreach ($this->db->get('apps')->result_array() as $app) : ?>
						<li class="<?php if ($page_title == $app['app_name']) {
										echo 'active';
									} ?>">
							<a href="<?php echo base_url('app/' . $app['app_id']); ?>"><img src="<?php echo $app['app_logo']; ?>" style="width: 20px; border-radius: 5px; margin-right: 10px;" /><span class="title"><?php echo $app['app_name']; ?></span></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="<?php if ($page_name == 'reviews') {
							echo 'active';
						} ?>"> <a href="<?php echo base_url('reviews'); ?>"><i class="entypo-gauge"></i><span class="title">Reviews</span></a>
			</li>
			<li class="<?php if ($page_name == 'revenue') {
							echo 'active';
						} ?>"> <a href="<?php echo base_url('revenue'); ?>"><i class="entypo-gauge"></i><span class="title">Revenue</span></a>
			</li>
			<li class="has-sub <?php if ($page_name == 'fund') {
									echo 'active';
								} ?>"> <a href="<?php echo base_url(); ?>payroll">
					<i class="entypo-tag"></i><span class="title">Funds</span></a>
				<ul>
					<li class="<?php if ($page_title == 'fund 5') {
									echo 'active';
								} ?>"> <a href="<?php echo base_url('fund/5'); ?>"><i class="entypo-book-open"></i><span class="title">Fund 5</span></a>
					</li>
					<li class="<?php if ($page_title == 'fund 6') {
									echo 'active';
								} ?>"> <a href="<?php echo base_url('fund/6'); ?>"><i class="entypo-book-open"></i><span class="title">Fund 6</span></a>
					</li>
					<li class="<?php if ($page_title == 'fund 7') {
									echo 'active';
								} ?>"> <a href="<?php echo base_url('fund/7'); ?>"><i class="entypo-book-open"></i><span class="title">Fund 7</span></a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>