<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<div class="col-md-3">
		<div class="ibox">
			<div class="ibox-content product-box">

				<div class="product-imitation">
					<?php if($item->default_pic){ ?>
						<img width="100%" height="auto" class="center" src="<?php echo JURI::root( true ).'/'.$item->default_pic ?>"/>
					<?php }else{ ?>
						<img width="100%" height="auto" class="center" src="components/com_proshopp/assets/theme/img/default.jpg"/>
		            <?php } ?>
				</div>
				<div class="product-desc">
					<?php if($item->badge){ ?>
						<span class="product-price">
							<?php echo $item->badge; ?>
	                    </span>
					<?php } ?>
					<small class="text-muted"><?php echo $item->title ?></small>
					<a href="<?php echo JRoute::_('index.php?option=com_proshopp&task=product.edit&id=' . $item->id); ?>" class="product-name"><?php echo $item->name ?></a>

					<div class="small m-t-xs">
						<?php echo ProshoppHelper::splitString($item->summary,50); ?>
					</div>
					<div class="m-t text-left">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?><?php echo JHtml::_('jgrid.published', $item->published, $i, 'products.',true); ?>
						<a href="<?php echo JRoute::_('index.php?option=com_proshopp&task=product.edit&id=' . $item->id); ?>" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endforeach; ?>