<div class="panel-body" >
	<div class="row">
		<div class="col-lg-7">
			<fieldset class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('name'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('name'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('meta_title'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('meta_title'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('published'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('published'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('category_id'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('category_id'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('summary'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('summary'); ?></div>
				</div>
			</fieldset>
			<fieldset>
				<legend>SEO Options</legend>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('meta_keywords'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('meta_keywords'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('meta_description'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('meta_description'); ?></div>
				</div>
			</fieldset>
		</div>
		<div class="col-lg-5">
			<div class="thumbnail">
				<?php if(!empty($this -> form -> getValue('badge'))){ ?>
				<span class="label label-info"><?php echo $this -> form -> getValue('badge'); ?></span>
				<?php } ?>
			<?php if($this -> form -> getValue('default_pic')){ ?>
				<img width="100%" height="auto" class="center" src="<?php echo JURI::root( true ).'/'.$this -> form -> getValue('default_pic') ?>"/>
			<?php }else{ ?>
				<img width="100%" height="auto" class="center" src="components/com_proshopp/assets/theme/img/default.jpg"/>
			<?php } ?>
			</div>
			<fieldset class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('default_pic'); ?></label>
					<div class="col-sm-10 picgallery"><?php echo $this -> form -> getInput('default_pic'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('badge'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('badge'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $this -> form -> getLabel('tags'); ?></label>
					<div class="col-sm-10"><?php echo $this -> form -> getInput('tags'); ?></div>
				</div>
			</fieldset>
		</div>
	</div>
</div>