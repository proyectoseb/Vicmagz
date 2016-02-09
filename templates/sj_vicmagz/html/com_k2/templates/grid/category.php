<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>
<script type="text/javascript">
	jQuery(document).ready(function () {
	
		jQuery('.vm-view-list .vm-view').each(function() {
			var ua = navigator.userAgent,
			event = (ua.match(/iPad/i)) ? 'touchstart' : 'click';
			
			jQuery(this).bind(event, function() {
				
				jQuery(this).addClass(function() {
					if(jQuery(this).hasClass('active')) return ''; 
					return 'active';
				});
				jQuery(this).siblings('.vm-view').removeClass('active');
				k2view = jQuery(this).data('view');
				jQuery(this).closest(".itemListView").stripClass('list-').addClass(k2view);
				
				if(k2view=='list-grid') {
					jQuery('.itemList .itemContainerList').removeClass('col-sm-12');
				}else if (k2view=='list-thumb'){
					jQuery('.itemList .itemContainerList').addClass('col-sm-12');
				}
				else if (k2view=='list-full'){
					jQuery('.itemList .itemContainerList').addClass('col-sm-12');
				}
			});
			
		});
		
});
	
jQuery.fn.stripClass = function (partialMatch, endOrBegin) {
	// The way removeClass should have been implemented -- accepts a partialMatch (like "btn-") to search on and remove
	var x = new RegExp((!endOrBegin ? "\\b" : "\\S+") + partialMatch + "\\S*", 'g');
	this.attr('class', function (i, c) {
		if (!c) return;
		return c.replace(x, '');
	});
	return this;
};
</script>
<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListViewGrid itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon 
	<div class="k2FeedIcon">
		<a href="<?php //echo $this->feed; ?>" title="<?php// echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php //echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>-->
	<?php endif; ?>
	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination k2PaginationTop">
		<div class="pull-right">
			<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
			<div class="clr"></div>
		</div>
		
		<div class="pull-left catPaginationResults">
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
		<!-- Blocks for current category and subcategories -->
		<?php if(( $this->params->get('catImage') || 
			$this->params->get('catTitle') || 
			$this->params->get('catDescription') ||
			$this->category->event->K2CategoryDisplay ) ||
			($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories))
		): ?>
		<div class="itemListCategoriesBlock">

			<?php if(( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
			<!-- Category block -->
			<div class="itemListCategory">

				<?php if(isset($this->addLink)): ?>
				<!-- Item add link -->
				<span class="catItemAddLink">
					<a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->addLink; ?>">
						<?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?>
					</a>
				</span>
				<?php endif; ?>

				
				<?php if($this->params->get('catTitle')): ?>
				<!-- Category title -->
				<h2><?php echo $this->category->name; ?><?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?></h2>
				<?php endif; ?>
				<div class="vm-view-list">
					<div class="vm-view active" data-view="list-grid"><i class="fa fa-th"></i></div>
					<div class="vm-view " data-view="list-thumb"><i class="fa fa-list"></i></div>
					<div class="vm-view " data-view="list-full"><i class="fa fa-bars"></i></div>
				</div>
				<div class="main-cate">
					<?php if($this->params->get('catImage') && $this->category->image): ?>
					<!-- Category image -->
					<img alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" src="<?php echo $this->category->image; ?>" style="width:<?php echo $this->params->get('catImageWidth'); ?>px; height:auto;" />
					<?php endif; ?>
		
					<?php if($this->params->get('catDescription')): ?>
					<!-- Category description -->
						<?php echo $this->category->description; ?>
					<?php endif; ?>
		
					<!-- K2 Plugins: K2CategoryDisplay -->
					<?php echo $this->category->event->K2CategoryDisplay; ?>
				</div>
				<div class="clr"></div>
			</div>
			<?php endif; ?>

			<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
			<!-- Subcategories -->
			<div class="itemListSubCategories row">
				<h3><?php echo JText::_('K2_CHILDREN_CATEGORIES'); ?></h3>
				
				<?php foreach($this->subCategories as $key=>$subCategory): ?>

				<?php
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('subCatColumns'))==0))
					$lastContainer= ' subCategoryContainerLast';
				else
					$lastContainer='';
				?>
				
				<div class="subCategoryContainer col-xs-12 col-md-<?php echo number_format(12/$this->params->get('subCatColumns')) ?> <?php echo $lastContainer; ?>">
					<div class="subCategory">
						<?php if($this->params->get('subCatImage') && $subCategory->image): ?>
						<!-- Subcategory image -->
						<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
							<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
						</a>
						<?php endif; ?>

						<?php if($this->params->get('subCatTitle')): ?>
						<!-- Subcategory title -->
						<h3>
							<a href="<?php echo $subCategory->link; ?>">
								<?php echo $subCategory->name; ?><?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$subCategory->numOfItems.')'; ?>
							</a>
						</h3>
						<?php endif; ?>

						<?php if($this->params->get('subCatDescription')): ?>
						<!-- Subcategory description -->
							<p><?php echo $subCategory->description; ?></p>
						<?php endif; ?>

						<!-- Subcategory more... -->
						<a class="button" href="<?php echo $subCategory->link; ?>">
							<?php echo JText::_('ME_K2_VIEW_ITEMS'); ?>
						</a>

						<div class="clr"></div>
					</div>
				</div>
				<?php if(($key+1)%($this->params->get('subCatColumns'))==0): ?>
				<div class="clr"></div>
				<?php endif; ?>
				<?php endforeach; ?>

				<div class="clr"></div>
			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	
	<!-- Item list -->
	<div class="itemList">
		<?php if(isset($this->leading) && count($this->leading)): ?>
		
		<!-- Leading items -->
		<div id="itemListLeading">
			<div class="row">
				<?php foreach($this->leading as $key=>$item): ?>

				<?php
				$lastContainer = ($this->params->get('num_leading_columns') == 1 || count($this->leading) == 1) ? 'List' : 'Grid';
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('num_leading_columns'))==0) || count($this->leading)<$this->params->get('num_leading_columns') )
					$lastContainer .= ' itemContainerListLast';
				else
					$lastContainer .='';
				?>
				
				<div class="itemContainer itemContainer<?php echo $lastContainer; ?> col-md-<?php echo (count($this->leading) == 1) ? 12 : number_format( 12/$this->params->get('num_leading_columns'), 0) ?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				
				<?php if(($key+1)%($this->params->get('num_leading_columns'))==0 && ($key+1) < count($this->leading)): ?>
			</div>
			<div class="row">
				<?php endif; ?>
				
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div id="itemListPrimary">
			<div class="row">
				<?php foreach($this->primary as $key=>$item): ?>
					
				<?php
				$lastContainer = ($this->params->get('num_primary_columns') == 1 || count($this->primary) == 1) ? 'List' : 'Grid';
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('num_primary_columns'))==0) || count($this->primary)<$this->params->get('num_primary_columns') )
					$lastContainer .= ' itemContainerListLast';
				else
					$lastContainer .='';
				?>
				
				<div class="itemContainer itemContainer<?php echo $lastContainer; ?> col-md-<?php echo (count($this->primary) == 1) ? 12 : number_format(12/$this->params->get('num_primary_columns'), 0); ?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				
				<?php if(($key+1)%($this->params->get('num_primary_columns'))==0 && ($key+1) < count($this->primary)): ?>
			</div>
			<div class="row">
				<?php endif; ?>
				
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
		<div id="itemListSecondary">
			<div class="row">
				<?php foreach($this->secondary as $key=>$item): ?>
				
				<?php
				$lastContainer = ($this->params->get('num_secondary_columns') == 1 || count($this->secondary) == 1) ? 'List' : 'Grid';
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('num_secondary_columns'))==0) || count($this->secondary)<$this->params->get('num_secondary_columns') )
					$lastContainer .= ' itemContainerListLast';
				else
					$lastContainer .='';
				?>
				
				<div class="itemContainer itemContainer<?php echo $lastContainer; ?> col-md-<?php echo (count($this->secondary) == 1) ? 12 : number_format(12/$this->params->get('num_secondary_columns'), 0); ?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				<?php if(($key+1)%($this->params->get('num_secondary_columns'))==0 && ($key + 1) < count($this->secondary)): ?>
			</div>
			<div class="row">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination k2PaginationBottom">
		<div class="pull-right">
			<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
			<div class="clr"></div>
		</div>
		
		<div class="pull-left catPaginationResults">
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->
