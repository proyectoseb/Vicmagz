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
// includes placehold
$yt_temp = JFactory::getApplication()->getTemplate();
include (JPATH_BASE . '/templates/'.$yt_temp.'/includes/placehold.php');

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="itemsPopular k2ItemsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<?php if($params->get('itemPreText')): ?>
	<div class="modulePretext before-top"><span><?php echo $params->get('itemPreText'); ?></span></div>
	<?php endif; ?>

	<?php if(count($items)): ?>
	<div class="row">
		<?php
		foreach ($items as $key=>$item):?>
		<?php if(count($items) == 5 && $key == 0){ ?>
		<div class="col-sm-3">
		<?php } else if(count($items) != 5) {?>
			<div class="col-sm-<?php echo count($items) < 5 ? 12/count($items) : 4;?>">
		<?php }?>
			<div class="item">

				<!-- Plugins: BeforeDisplay -->
				<?php echo $item->event->BeforeDisplay; ?>

				<!-- K2 Plugins: K2BeforeDisplay -->
				<?php echo $item->event->K2BeforeDisplay; ?>

				<?php if($params->get('itemAuthorAvatar')): ?>
					<a class="k2Avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
						<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" style="width:<?php echo $avatarWidth; ?>px;height:auto;" />
					</a>
				<?php endif; ?>
				<!-- Plugins: AfterDisplayTitle -->
				<?php echo $item->event->AfterDisplayTitle; ?>

				<!-- K2 Plugins: K2AfterDisplayTitle -->
				<?php echo $item->event->K2AfterDisplayTitle; ?>

				<!-- Plugins: BeforeDisplayContent -->
				<?php echo $item->event->BeforeDisplayContent; ?>

				<!-- K2 Plugins: K2BeforeDisplayContent -->
				<?php echo $item->event->K2BeforeDisplayContent; ?>

				<?php if($params->get('itemImage') || $params->get('itemIntroText')): ?>
				<div class="moduleItemIntrotext">
					<?php if($params->get('itemImage')): ?>
					<div class="moduleItemImageBlock">
						<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
							<?php 	
							//Create placeholder items images
							if(isset($item->image)){
							$src =$item->image;  }
							if (!empty( $src)) {								
								$thumb_img = '<img src="'.$src.'" alt="'.$item->title.'" />'; 
							} else if ($is_placehold) {					
								$thumb_img = yt_placehold($placehold_size['medium'],$item->title,$item->title); 
							}	
							echo $thumb_img;
							?>
						</a>
					</div>
					<?php endif; ?>
						
					<div class="main">
						<div class="main-inner">
							<?php if($params->get('itemCategory')): ?>
							<?php
								$string_color1=strstr($item->categoryname, "|" );
								$string_color2=str_replace("|", "#", $string_color1);
								$string_cate=str_replace($string_color1, "", $item->categoryname);
							?>
								<div class="moduleItemCategory" >
									<a class="bnt btn-color" href="<?php echo $item->categoryLink; ?>"><?php echo $string_cate; ?></a>
								</div>
							<?php endif; ?>
							<?php if($params->get('itemTitle')): ?>
								<h3 class="moduleItemTitle"><a href="<?php echo $item->link; ?>"><?php echo substr($item->title, 0, 40); ?></a></h3>
							<?php endif; ?>
							
							<?php if($params->get('itemDateCreated')): ?>
								<span class="moduleItemDateCreated"><i class="fa fa-calendar"></i><?php echo JHTML::_('date', $item->created , 'j M Y'); ?></span>
							<?php endif; ?>
							<?php if($params->get('itemIntroText')): ?>
								<div class="introtext">
									<?php echo $item->introtext; ?>
								</div>
							<?php endif; ?>
							<ul class="inline">
							<?php if($params->get('itemAuthor')): ?>
								<li class="moduleItemAuthor">
									<?php //echo K2HelperUtilities::writtenBy($item->authorGender); ?>
									<?php echo JText::_('K2_BY'); ?>
									
									<?php if(isset($item->authorLink)): ?>
										<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
									<?php else: ?>
										<?php echo $item->author; ?>
									<?php endif; ?>
									
									<?php if($params->get('userDescription')): ?>
										<?php //echo $item->authorDescription; ?>
									<?php endif; ?>
									
								</li>
							<?php endif; ?>
							
							<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>	
								<li class="catItemCommentsLink">
								<?php if(!empty($item->event->K2CommentsCounter)): ?>
									<!-- K2 Plugins: K2CommentsCounter -->
									<?php echo $item->event->K2CommentsCounter; ?>
								<?php else: ?>
									<?php if($item->numOfComments>0): ?>
									<a class="" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
										<?php echo $item->numOfComments; ?> <?php if($item->numOfComments>1) echo JText::_('K2_COMMENTS'); else echo JText::_('K2_COMMENT'); ?>
									</a>
									<?php else: ?>
									<a class="" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
										0 <?php echo JText::_('K2_COMMENT'); ?>
									</a>
									<?php endif; ?>
								<?php endif; ?>
								</li>
							<?php endif; ?>
							</ul>
						</div>
					</div><!-- end main-->

				</div>
				<?php endif; ?>

				<?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
				<div class="moduleItemExtraFields">
					<b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
					<ul>
						<?php foreach ($item->extra_fields as $extraField): ?>
							<?php if($extraField->value != ''): ?>
							<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
								<?php if($extraField->type == 'header'): ?>
								<h4 class="moduleItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
								<?php else: ?>
								<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
								<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
								<?php endif; ?>
								<div class="clr"></div>
							</li>
							<?php endif; ?>
					<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<div class="clr"></div>

				<?php if($params->get('itemVideo')): ?>
				<div class="moduleItemVideo">
					<?php echo $item->video ; ?>
					<span class="moduleItemVideoCaption"><?php echo $item->video_caption ; ?></span>
					<span class="moduleItemVideoCredits"><?php echo $item->video_credits ; ?></span>
				</div>
				<?php endif; ?>

				<div class="clr"></div>

				<!-- Plugins: AfterDisplayContent -->
				<?php echo $item->event->AfterDisplayContent; ?>

				<!-- K2 Plugins: K2AfterDisplayContent -->
				<?php echo $item->event->K2AfterDisplayContent; ?>

				<?php if($params->get('itemTags') && count($item->tags)>0): ?>
				<div class="moduleItemTags">
					<b><?php echo JText::_('K2_TAGS'); ?>:</b>
					<?php foreach ($item->tags as $tag): ?>
						<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<?php if($params->get('itemAttachments') && count($item->attachments)): ?>
					<div class="moduleAttachments">
						<?php foreach ($item->attachments as $attachment): ?>
						<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

					

					<?php if($params->get('itemHits')): ?>
					<span class="moduleItemHits">
						<?php echo JText::_('K2_READ'); ?> <?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?>
					</span>
					<?php endif; ?>

					<?php if($params->get('itemReadMore') && $item->fulltext): ?>
					<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
						<?php echo JText::_('LEARN_MORE'); ?>
					</a>
					<?php endif; ?>

				<!-- Plugins: AfterDisplay -->
				<?php echo $item->event->AfterDisplay; ?>

				<!-- K2 Plugins: K2AfterDisplay -->
				<?php echo $item->event->K2AfterDisplay; ?>
			</div>
		<?php if(count($items) == 5 && $key == 1 ) {?>
			</div><div class="col-sm-6 center">
		<?php } else if(count($items) == 5 && $key == 2 ) { ?>
			</div><div class="col-sm-3">
		<?php } else if((count($items) == 5 && $key == 4) || count($items) != 5) {?>
			</div>
		<?php }?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<div class="before-bottom">
		<div class="moduleCustomLink">
			<a class="btn btn-border" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
		</div>
	</div>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
