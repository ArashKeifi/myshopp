<div class="row">
	<div class="col-lg-7">
		<div class="ibox float-e-margins" >
			<div class="ibox-title">
				<h5><?php echo $this -> form -> getLabel('name'); ?></h5>
				<?php echo $this -> form -> getInput('name'); ?>
				<?php echo $this -> form -> getInput('id'); ?>
			</div>
			<div class="ibox-content" >
				<div class="row">
					<div class="col-lg-6">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('type'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('type'); ?>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('published'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('published'); ?>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="control-group">
					<div class="controls">
						<?php echo $this -> form -> getInput('items'); ?>
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