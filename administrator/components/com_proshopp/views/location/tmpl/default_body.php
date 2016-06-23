<div class="row">
	<div class="col-lg-7">
		<div class="ibox float-e-margins" >
			<div class="ibox-title">
				<h5><?php echo $this -> form -> getLabel('title'); ?></h5>
				<?php echo $this -> form -> getInput('title'); ?>
			</div>
			<div class="ibox-content" >
				<div class="row">
					<div class="col-lg-12">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('alias'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('alias'); ?>
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
					<div class="col-lg-6">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this -> form -> getLabel('parent_id'); ?>
							</div>
							<div class="controls">
								<?php echo $this -> form -> getInput('parent_id'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="jumbotron">
			<h1>Steps</h1>
			<p>Smart UI component which allows you to easily create wizard-like interfaces.</p>
			<div class="control-group">
				<div class="control-label">
					<?php echo $this -> form -> getLabel('path'); ?>
				</div>
				<div class="controls">
					<?php echo $this -> form -> getValue('path'); ?>
				</div>
			</div>
			<?php echo $this -> form -> getInput('id'); ?>
			<?php echo $this -> form -> getInput('lft'); ?>
			<?php echo $this -> form -> getInput('rgt'); ?>
			<?php echo $this -> form -> getInput('level'); ?>
		</div>
	</div>
</div>