<div class="row">
	<div class="col-lg-7">
		<div class="ibox float-e-margins" >
			<div class="ibox-title">
				<h5><?php echo $this -> form -> getLabel('title'); ?></h5>
				<?php echo $this -> form -> getInput('title'); ?>
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
						<?php echo $this -> form -> getInput('id'); ?>
					</div>
				</div>

<hr>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this -> form -> getLabel('body'); ?>
						</div>
						<div class="controls">
							<?php echo $this -> form -> getInput('body'); ?>
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