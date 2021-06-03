<?php include('dashboard_graphs.php'); ?>
<div class="row">
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3>Big number here</h3>
			<p>Total Monthly Deposits</p> <span class="contributions"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3><?php echo $this->db->get('apps')->num_rows(); ?> Apps</h3>
			<p><?php echo $this->db->get('apps')->num_rows(); ?> more acquired this month</p> <span class="registrations"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3>Big number here</h3>
			<p>Total Shares</p> <span class="share-capital"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<p>
				<?php $total = $this->db->where('app_id', 1)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 2)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 3)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 4)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 5)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 6)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 7)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value +
					$this->db->where('app_id', 8)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value; ?>
				<span style="color: #ec3b83;">PC <?php echo number_format((($this->db->where('app_id', 1)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span> <br />
				<span style="color: #00acd6;">ICU <?php echo number_format((($this->db->where('app_id', 2)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span> <br />
				<span style="color: #e8b51b;">PON <?php echo number_format((($this->db->where('app_id', 3)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span><br />
				<span style="color: #e8b51b;">BDN <?php echo number_format((($this->db->where('app_id', 4)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span><br />
				<span style="color: #e8b51b;">WPN <?php echo number_format((($this->db->where('app_id', 5)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span><br />
				<span style="color: #e8b51b;">TFX <?php echo number_format((($this->db->where('app_id', 6)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span><br />
				<span style="color: #e8b51b;">T2G <?php echo number_format((($this->db->where('app_id', 7)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span><br />
				<span style="color: #e8b51b;">SK <?php echo number_format((($this->db->where('app_id', 8)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->value * 100) / $total)); ?>%</span>
			</p> <span class="pie-chart"></span>
		</div>
	</div>
</div> <br />
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="input-group">
						<select class="form-control adjust-stats">
							<option value="">Choose stats time</option>
							<option value="0">Last 24 hours</option>
							<option value="1">Yesterday</option>
							<option value="7">Last 7 days</option>
							<option value="30">Lat 30 days</option>
							<option value="90">Last 90 days</option>
							<option value="365">Last 365 days</option>
							<option value="31">Last month</option>
							<option value="366">Last year</option>
							<option value="all">All Time</option>
						</select>
					</div>
				</div>
				<div class="panel-options">
					<ul class="nav nav-tabs">
						<li class=""><a href="#area-chart" data-toggle="tab">Loans</a></li>
						<li class="active"><a href="#line-chart" data-toggle="tab">Deposits &amp; Shares</a></li>
						<li class=""><a href="#pie-chart" data-toggle="tab">Comparison Chart</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane" id="area-chart">
						<div id="area-chart-demo" class="morrischart" style="height: 500px"></div>
					</div>
					<div class="tab-pane active" id="line-chart">
						<div id="line-chart-demo" class="morrischart" style="height: 500px"></div>
					</div>
					<div class="tab-pane" id="pie-chart">
						<div id="donut-chart-demo" class="morrischart" style="height: 500px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <br />
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th class="padding-bottom-none text-center"> <br /> <br /> <span class="monthly-sales"></span> </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="panel-heading">
							<h4>Monthly Registrations (All Apps)</h4>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Latest registrations</div>
				<div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
			</div>
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->db->get('apps')->result_array() as $fetch) : ?>
						<tr>
							<td><?php echo $fetch['app_id'] ?></td>
							<td><?php echo $fetch['app_name'] ?></td>
							<td class="text-center"><span class="inlinebar">
									<?php
									foreach ($this->db->where('app_id', $fetch['app_id'])->get('quaterly')->result_array() as $fetch) {
										echo $fetch['value'] . ',';
									}
									?>
								</span></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div> <br />