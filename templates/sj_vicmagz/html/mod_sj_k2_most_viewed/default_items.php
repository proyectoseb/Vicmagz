<?php
/**
 * @package SJ Most Viewed for K2
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

ImageHelper::setDefault($params);

?>
<?php
include JModuleHelper::getLayoutPath($module->module, $layout . '_tabs');
?>
<div class="mv-tabs-content">
	<?php 
	$j =1;
	foreach ($list as $key => $items) {
		
	?>
	<div class="tab-selected-<?php echo $key; ?> <?php if ($j == 1) echo "selected"; ?>">
		<div class="mv-tab-content">
			<?php if(count($items) == 0){
				echo JText::_('Has no content to show!');
			}?>
			<?php
			for($i=0;$i< count($items);$i++)
			{
				$img = K2MostViewedHelper::getK2Image($items[$i], $params);
				if($i==0)
				{
				?>
					<div class="tab-item-first">
						<?php 
							if ($img) {
						?>
						<a title="<?php echo $items[$i]->title; ?>"
						   href="<?php echo $items[$i]->link; ?>"  <?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
							<?php echo K2MostViewedHelper::imageTag($img); ?>
						</a>
						<?php }?>
						<span class="count-item"><?php echo (int)($i+1);?></span>
						<div class="content">
							<?php if ((int)$params->get('item_cate_display', 1) && K2MostViewedHelper::_trimEncode($items[$i]->categoryname)) { ?>
							<span>
								<?php echo $items[$i]->categoryname ; ?>
							</span>
							<?php } ?>
							<?php if((int) $params->get('item_title_display',1)){?>
								<h3>
									<a title="<?php echo $items[$i]->title; ?>"
							   href="<?php echo $items[$i]->link; ?>"  
									<?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
									<?php echo $items[$i]->displaytitle; ?>
									</a>
								</h3>
							<?php }?>
							<?php if ($params->get('itemCommentsCounter', 1) == 1) {
									?>
									<div class="mv-comments">
										<a href="<?php echo $items[$i]->link; ?>" <?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
											<i class="icon-comments-2"></i> 
											<?php echo $items[$i]->numOfComments.'&nbsp;'; ?>
											<?php
											if ($items[$i]->numOfComments > 1) {
												echo JText::_('COMMENTS');
											} else {
												echo JText::_('COMMENT');
											} ?>
										</a>
									</div>
								<?php 
							} ?>
						</div>
					</div>
				<?php
				} else {
					?>
					<div class="tab-item">
						<div class="tab-content-left">
							<span class="count-item"><?php echo (int)($i+1);?></span>
							<div class="tab-content-left-img">
								<?php 
									if ($img) {
								?>
								<a title="<?php echo $items[$i]->title; ?>"
								   href="<?php echo $items[$i]->link; ?>"  <?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
									<?php echo K2MostViewedHelper::imageTag($img); ?>
								</a>
								<?php }?>
							</div>
						</div>
						<div class="tab-content-right">
							<?php if ((int)$params->get('item_cate_display', 1) && K2MostViewedHelper::_trimEncode($items[$i]->categoryname)) { ?>
							<span>
								<?php echo $items[$i]->categoryname ; ?>
							</span>
							<?php } ?>
							<?php if((int) $params->get('item_title_display',1)){?>
								<h3>
									<a title="<?php echo $items[$i]->title; ?>"
							   href="<?php echo $items[$i]->link; ?>"  
									<?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
									<?php echo $items[$i]->displaytitle; ?>
									</a>
								</h3>
							<?php }?>
							<?php if ($params->get('itemCommentsCounter', 1) == 1) {
									?>
									<div class="mv-comments">
										<a href="<?php echo $items[$i]->link; ?>" <?php echo K2MostViewedHelper::parseTarget($params->get('item_link_target')); ?>>
											<i class="icon-comments-2"></i>
											<?php echo $items[$i]->numOfComments.'&nbsp;'; ?>
											<?php
											if ($items[$i]->numOfComments > 1) {
												echo JText::_('COMMENTS');
											} else {
												echo JText::_('COMMENT');
											} ?>
										</a>
									</div>
								<?php 
							} ?>
						</div>
					</div>
			<?php }				
			}
			?>
		</div>
		
	</div>
	<?php	
		$j++;
	}
	
	?>
</div> <!-- END mv-tabs-content -->
<script>
jQuery(document).ready(function($){
	$("ul.mv-tabs li.mv-tab:first-child span.mv-tab-inner").addClass("selected");
	$('.mv-tabs-content').children('.selected').show("slow","linear");
	$("ul.mv-tabs li.mv-tab").click(function(){
		$("ul.mv-tabs li.mv-tab span.mv-tab-inner").removeClass("selected");
		$(this).children('span.mv-tab-inner').addClass("selected");
		var classSelected = $(this).children('span.mv-tab-inner').attr("class");
		classSelected = classSelected.replace('selected', '');
		classSelected = classSelected.replace('mv-tab-inner', '');
		classSelected = classSelected.replace('tab-', '');
		classSelected = $.trim(classSelected);
		
		$('.mv-tabs-content').children().removeClass("selected");
		$('.mv-tabs-content').children().hide("slow","swing");
		$('.mv-tabs-content').children('.tab-selected-'+classSelected).addClass("selected");
		$('.mv-tabs-content').children('.selected').show("slow","swing");
	});
	
});
</script>