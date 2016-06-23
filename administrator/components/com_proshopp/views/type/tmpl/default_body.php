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
					</div>
					<?php echo $this -> form -> getInput('id'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="thumbnail">
			<?php if($this -> form -> getValue('default_pic')){ ?>
				<img width="100%" height="auto" class="center" src="<?php echo JURI::root( true ).'/'.$this -> form -> getValue('icon') ?>"/>
			<?php }else{ ?>
				<img width="100%" height="auto" class="center" src="components/com_proshopp/assets/theme/img/default.jpg"/>
			<?php } ?>
		</div>
		<fieldset class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">
					<?php echo $this -> form -> getLabel('icon'); ?>
				</label>
				<div class="col-sm-10 picgallery">
					<?php echo $this -> form -> getInput('icon'); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>