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

//Function definition
if (!function_exists('timeAgo'))
{
	function timeAgo($time_ago)
	{
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "just now";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute ago";
			}
			else{
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "an hour ago";
			}else{
				return "$hours hrs ago";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "yesterday";
			}else{
				return "$days days ago";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "a week ago";
			}else{
				return "$weeks weeks ago";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "a month ago";
			}else{
				return "$months months ago";
			}
		}
		//Years
		else{
			if($years==1){
				return "one year ago";
			}else{
				return "$years years ago";
			}
		}
	}
}
?>

<?php if(JRequest::getInt('print')==1): ?>
<!-- Print button at the top of the print page only -->
<a class="itemPrintThisPage" rel="nofollow" href="#" onclick="window.print();return false;">
	<span><?php echo JText::_('K2_PRINT_THIS_PAGE'); ?></span>
</a>
<?php endif; ?>

<!-- Start K2 Item Layout -->
<span id="startOfPageId<?php echo JRequest::getInt('id'); ?>"></span>

<div id="k2Container" class=" itemViewPopup <?php echo ($this->item->featured) ? ' itemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">
	<div class="itemSidebarBlock">
		<div class="itemSidebarInner">
			<?php if($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias) ||
			$this->item->params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)
			): ?>
				<div class="itemAuthor">
					<div class="itemAuthorWrapper">
						<?php if($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias)): ?>
						<!-- Author Block -->
						<div class="itemAuthorBlock">

							<?php if($this->item->params->get('itemAuthorImage') && !empty($this->item->author->avatar)): ?>
								<img class="itemAuthorAvatar" src="<?php echo $this->item->author->avatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->item->author->name); ?>" />
							<?php endif; ?>

							<div class="itemAuthorDetails">
								<div class="itemAuthorName">
									<?php echo JText::_('By');?>
									<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
								</div>

								<?php if($this->item->params->get('itemAuthorDescription') && !empty($this->item->author->profile->description)): ?>
									<div class="itemAuthorDescription"><?php echo $this->item->author->profile->description; ?></div>
								<?php endif; ?>

								<?php if($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)): ?>
									<span class="itemAuthorUrl"><?php echo JText::_('K2_WEBSITE'); ?> <a rel="me" href="<?php echo $this->item->author->profile->url; ?>" target="_blank"><?php echo str_replace('http://','',$this->item->author->profile->url); ?></a></span>
								<?php endif; ?>

								<?php if($this->item->params->get('itemAuthorEmail')): ?>
								<span class="itemAuthorEmail"><?php echo JText::_('K2_EMAIL'); ?> <?php echo JHTML::_('Email.cloak', $this->item->author->email); ?></span>
								<?php endif; ?>

								<div class="clr"></div>

								<!-- K2 Plugins: K2UserDisplay -->
								<?php echo $this->item->event->K2UserDisplay; ?>

							</div>
							<div class="clr"></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="itemCategoryDate">
				<?php if($this->item->params->get('itemCategory')): ?>
				<!-- Item category -->
				<div class="itemCategory pull-left">
					<i class="fa fa-folder-open"></i>
					<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
				</div>
				<?php endif; ?>
				
				<?php if($this->item->params->get('itemDateCreated')): ?>
				<!-- Date created -->
				<span class="itemDateCreated pull-right">
					<i class="fa fa-clock-o"></i>
					<?php echo timeAgo($this->item->created); ?>
				</span>
				<?php endif; ?>
			</div>
			
			<?php if($this->item->params->get('itemCommentsAnchor') && $this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
			<!-- Anchor link to comments below - if enabled -->
			<div class="itemComent">
				<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
					<!-- K2 Plugins: K2CommentsCounter -->
					<?php echo $this->item->event->K2CommentsCounter; ?>
				<?php else: ?>
					<?php if($this->item->numOfComments > 0): ?>
					<a class="itemCommentsLink k2Anchor" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<i class="fa fa-comments"></i>
						<span><?php echo $this->item->numOfComments; ?></span> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
					</a>
					<?php else: ?>
					<i class="fa fa-comments"></i>
					<a class="itemCommentsLink k2Anchor" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
					</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if($this->item->params->get('itemTags') && count($this->item->tags)): ?>
			<!-- Item tags -->
			<div class="itemTagsBlock">
				
				<ul class="itemTags">
					<?php foreach ($this->item->tags as $tag): ?>
					<li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="clr"></div>
			</div>
			<?php endif; ?>
			<?php if($this->item->params->get('itemSocialButton') && !is_null($this->item->params->get('socialButtonCode', NULL))): ?>
			<!-- Item Social Button -->
			<div class="itemSocialButton">
			<ul class="media">
				
				<li class="pull-left"><?php echo JText::_('Share');?></li>
				<li class="pull-left">
					<?php echo $this->item->params->get('socialButtonCode'); ?>
					<div class="addthis_sharing_toolbox"></div>
				</li>
			</ul>
			</div>
			<?php endif; ?>

		</div>
	</div>
	<div class="itemContentBlock">
		<div class="itemContentInner">
		<div class="container">
			<!-- Plugins: BeforeDisplay -->
			<?php echo $this->item->event->BeforeDisplay; ?>

			<!-- K2 Plugins: K2BeforeDisplay -->
			<?php echo $this->item->event->K2BeforeDisplay; ?>

			<div class="itemHeader">
			
				
				<?php if($this->item->params->get('itemTitle')): ?>
				<!-- Item title -->
				<h2 class="itemTitle">
					<?php if(isset($this->item->editLink)): ?>
					<!-- Item edit link -->
					<span class="itemEditLink">
						<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
							<?php echo JText::_('K2_EDIT_ITEM'); ?>
						</a>
					</span>
					<?php endif; ?>

				<?php echo $this->item->title; ?>

				<?php if($this->item->params->get('itemFeaturedNotice') && $this->item->featured): ?>
				<!-- Featured flag -->
				<span>
					<sup>
						<?php echo JText::_('K2_FEATURED'); ?>
					</sup>
				</span>
				<?php endif; ?>

				</h2>
				<?php endif; ?>

			</div>

			<!-- Plugins: AfterDisplayTitle -->
			<?php echo $this->item->event->AfterDisplayTitle; ?>

			<!-- K2 Plugins: K2AfterDisplayTitle -->
			<?php echo $this->item->event->K2AfterDisplayTitle; ?>

			<div class="itemBody">

				<!-- Plugins: BeforeDisplayContent -->
				<?php echo $this->item->event->BeforeDisplayContent; ?>

				<!-- K2 Plugins: K2BeforeDisplayContent -->
				<?php echo $this->item->event->K2BeforeDisplayContent; ?>

				<?php if($this->item->params->get('itemImage')): ?>

				<!-- Item Image -->
				<div class="itemImageBlock">
					<span class="itemImage">
						<a class="" data-rel="prettyPhoto" href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
						<?php 
							//Create placeholder items images
							$src = $this->item->image;
							if (!empty( $src)) {								
								$thumb_img = '<img src="'.$src.'" alt="'.$this->item->title.'" />';
							} else if ($is_placehold) {					
								$thumb_img = yt_placehold($placehold_size['article'],$this->item->title);
							}	
							echo $thumb_img;
						?>
						</a>
					</span>

					<?php if($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)): ?>
					<!-- Image caption -->
						<span class="itemImageCaption"><?php echo $this->item->image_caption; ?></span>
					<?php endif; ?>

					<?php if($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)): ?>
					<!-- Image credits -->
						<span class="itemImageCredits"><?php echo $this->item->image_credits; ?></span>
					<?php endif; ?>

				  <div class="clr"></div>
				</div>
				<?php endif; ?>
				
				<?php if($this->item->params->get('itemVideo') && !empty($this->item->video)): ?>
				<!-- Item video -->
				<a name="itemVideoAnchor" id="itemVideoAnchor"></a>

				<div class="itemVideoBlock">
				<h3><?php echo JText::_('K2_MEDIA'); ?></h3>

					<?php if($this->item->videoType=='embedded'): ?>
					<div class="itemVideoEmbedded">
						<?php echo $this->item->video; ?>
					</div>
					<?php else: ?>
					<span class="itemVideo"><?php echo $this->item->video; ?></span>
					<?php endif; ?>

					<?php if($this->item->params->get('itemVideoCaption') && !empty($this->item->video_caption)): ?>
					<span class="itemVideoCaption"><?php echo $this->item->video_caption; ?></span>
					<?php endif; ?>

					<?php if($this->item->params->get('itemVideoCredits') && !empty($this->item->video_credits)): ?>
					<span class="itemVideoCredits"><?php echo $this->item->video_credits; ?></span>
					<?php endif; ?>

				  <div class="clr"></div>
				</div>
				<?php endif; ?>

				<?php if(!empty($this->item->fulltext)): ?>
					<?php if($this->item->params->get('itemIntroText')): ?>
					<!-- Item introtext -->
						<div class="itemIntroText">
							<?php echo $this->item->introtext; ?>
						</div>
					<?php endif; ?>
					
					<?php if($this->item->params->get('itemFullText')): ?>
					<!-- Item fulltext -->
					<div class="itemFullText">
						<?php echo $this->item->fulltext; ?>
					</div>
					<?php endif; ?>
				<?php else: ?>
					<!-- Item text -->
					<div class="itemFullText">
						<?php echo $this->item->introtext; ?>
					</div>
				<?php endif; ?>

				<!-- Plugins: AfterDisplayContent -->
				<?php echo $this->item->event->AfterDisplayContent; ?>

				<!-- K2 Plugins: K2AfterDisplayContent -->
				<?php echo $this->item->event->K2AfterDisplayContent; ?>
				
				
				<div class="clr"></div>
			</div>
		
			

			<?php if($this->item->params->get('itemAttachments')): ?>
			
				<?php if($this->item->params->get('itemAttachments') && count($this->item->attachments)): ?>
				<div class="itemLinks">
				<!-- Item attachments -->
					<div class="itemAttachmentsBlock">
						<span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
						<ul class="itemAttachments">
						<?php foreach ($this->item->attachments as $attachment): ?>
							<li>
								<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
								<?php if($this->item->params->get('itemAttachmentsCounter')): ?>
									<span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<?php endif; ?>

				<div class="clr"></div>
		 
			<?php endif; ?>
		  
			
			

			<?php if($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)): ?>
			<!-- Item image gallery -->
			<a name="itemImageGalleryAnchor" id="itemImageGalleryAnchor"></a>
			<div class="itemImageGallery">
				<h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
				<?php echo $this->item->gallery; ?>
			</div>
			<?php endif; ?>


			<!-- Plugins: AfterDisplay -->
			<?php echo $this->item->event->AfterDisplay; ?>

			<!-- K2 Plugins: K2AfterDisplay -->
			<?php echo $this->item->event->K2AfterDisplay;?>

			<?php if($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
			<!-- K2 Plugins: K2CommentsBlock -->
			<?php echo $this->item->event->K2CommentsBlock; ?>
			<?php endif; ?>

			<?php if($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)): ?>
			<!-- Item comments -->
			<a name="itemCommentsAnchor" id="itemCommentsAnchor"></a>

			<div class="itemComments">

				<?php if($this->item->params->get('commentsFormPosition')=='above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
				<!-- Item comments form -->
				<div class="itemCommentsForm">
					<?php echo $this->loadTemplate('comments_form'); ?>
				</div>
				<?php endif; ?>

				<?php if($this->item->numOfComments>0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))): ?>
				<!-- Item user comments -->
				
				<h3 class="itemCommentsCounter">
					<span><?php echo count($this->item->comments) ?></span>
					<span> <?php echo JText::_('K2_COMMENT'); ?></span>
				</h3>

				<ul class="itemCommentsList">
					<?php foreach ($this->item->comments as $key=>$comment): ?>
					<li class="<?php echo ($key%2) ? "odd" : "even"; echo (!$this->item->created_by_alias && $comment->userID==$this->item->created_by) ? " authorResponse" : ""; echo($comment->published) ? '':' unpublishedComment'; ?>">

						<?php if($comment->userImage): ?>
						<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $this->item->params->get('commenterImgWidth'); ?>" />
						<?php endif; ?>

						<span class="commentAuthorName">
							<?php if(!empty($comment->userLink)): ?>
							<a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
								<?php echo $comment->userName; ?>
							</a>
							<?php else: ?>
							<?php echo $comment->userName; ?>
							<?php endif; ?>
						</span>
						<div>
							<span class="commentDate">
							<i class="fa fa-clock-o"></i>
							<?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?>

							</span>
						</div>
						<p><?php echo $comment->commentText; ?></p>

							<?php if($this->inlineCommentsModeration || ($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest)))): ?>
							<span class="commentToolbar">
								<?php if($this->inlineCommentsModeration): ?>
								<?php if(!$comment->published): ?>
								<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_APPROVE')?></a>
								<?php endif; ?>

								<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_REMOVE')?></a>
								<?php endif; ?>

								<?php if($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest))): ?>
								<a class="modal" rel="{handler:'iframe',size:{x:560,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id)?>"><?php echo JText::_('K2_REPORT')?></a>
								<?php endif; ?>

								<?php if($comment->reportUserLink): ?>
								<a class="k2ReportUserButton" href="<?php echo $comment->reportUserLink; ?>"><?php echo JText::_('K2_FLAG_AS_SPAMMER'); ?></a>
								<?php endif; ?>

							</span>
							<?php endif; ?>

							<div class="clr"></div>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="itemCommentsPagination">
					<?php echo $this->pagination->getPagesLinks(); ?>
					<div class="clr"></div>
				 </div>
				<?php endif; ?>

				<?php if($this->item->params->get('commentsFormPosition')=='below' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
				 <!-- Item comments form -->
				<div class="itemCommentsForm">
					<?php echo $this->loadTemplate('comments_form'); ?>
				</div>
				<?php endif; ?>

				<?php $user = JFactory::getUser(); if ($this->item->params->get('comments') == '2' && $user->guest): ?>
					<div><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS'); ?></div>
				<?php endif;?>

			</div>
			<?php endif; ?>


			<div class="clr"></div>
		</div>
		</div>
	</div>
</div>
<!-- End K2 Item Layout -->
