<div class="row">
	<div class="col-lg-7">
		<div class="ibox float-e-margins" >
			<div class="ibox-title">
				<h5><?php echo $this -> form -> getLabel('name'); ?></h5>
				<?php echo $this -> form -> getInput('name'); ?>
			</div>
			<div class="ibox-content" >
				<div class="row">
					<div class="col-lg-4">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('published'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('published'); ?>
							</div>
						</div>
						<?php echo $this -> form -> getInput('id'); ?>
					</div>
					<div class="col-lg-4">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('required'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('required'); ?>
							</div>
						</div>
						<?php echo $this -> form -> getInput('id'); ?>
					</div>
					<div class="col-lg-4">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('search_type'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('search_type'); ?>
							</div>
						</div>
						<?php echo $this -> form -> getInput('id'); ?>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-12">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('type'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('type'); ?>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this -> form -> getLabel('field_type_option'); ?>
					</div>
					<div class="controls">
						<?php echo $this -> form -> getInput('field_type_option'); ?>
					</div>
				</div>
				<div id="fields_measurement" class="control-group">
					<hr>
					<div class="control-label">
						<?php echo $this -> form -> getLabel('measurement'); ?>
					</div>
					<div class="controls">
						<?php echo $this -> form -> getInput('measurement'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="jumbotron">
			<h1>Steps</h1>
			<p>Smart UI component which allows you to easily create wizard-like interfaces.</p>
		</div>
	</div>
</div>