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

/*
Important note:
If you wish to use the live search option, it's important that you maintain the same class names for wrapping elements, e.g. the wrapping div and form.
*/

?>
<div class="SearchBlock-toggle-wrapper">
	<a href="#" class="dropdown-toggle"><i class="fa fa-search"></i></a>
	<div id="k2ModuleBox<?php echo $module->id; ?>" class="dropdown-toggle-content k2SearchBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); if($params->get('liveSearch')) echo ' k2LiveSearchBlock'; ?>">
		
		<form action="<?php echo $action; ?>" method="get" autocomplete="off" class="k2SearchBlockForm">

			<input type="text" value="<?php echo $text; ?>" name="searchword" maxlength="<?php echo $maxlength; ?>" size="<?php echo $width; ?>"  class="inputbox" onblur="if(this.value=='') this.value='<?php echo $text; ?>';" onfocus="if(this.value=='<?php echo $text; ?>') this.value='';" />
			<?php  if($params->get('moduleclass_sfx') == ' search_top') : ?>
			<button class="button" onclick="this.form.searchword.focus();" ><i class="fa fa-search "></i></button>
			
			<?php elseif($button): ?>
				<?php if($imagebutton): ?>
					<input type="image" value="<?php echo $button_text; ?>" class="button" onclick="this.form.searchword.focus();" src="<?php echo JURI::base(true); ?>/components/com_k2/images/fugue/search.png" />
				<?php else: ?>
					<?php 
					if( $button_text == "fa-search") {
						$button_text = '<i class="fa fa-search "></i>';
					}
					?>
					<button class="button" onclick="this.form.searchword.focus();" >
					<?php
						echo $button_text;
					?>
					</button>
				<?php endif; ?>
			<?php endif; ?>

			<input type="hidden" name="categories" value="<?php echo $categoryFilter; ?>" />
			<?php if(!$app->getCfg('sef')): ?>
			<input type="hidden" name="option" value="com_k2" />
			<input type="hidden" name="view" value="itemlist" />
			<input type="hidden" name="task" value="search" />
			<?php endif; ?>
			<?php if($params->get('liveSearch')): ?>
			<input type="hidden" name="format" value="html" />
			<input type="hidden" name="t" value="" />
			<input type="hidden" name="tpl" value="search" />
			<?php endif; ?>
		</form>

		<?php if($params->get('liveSearch')): ?>
		<div class="k2LiveSearchResults"></div>
		<?php endif; ?>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    //$('.SearchBlock-toggle-wrapper .dropdown-toggle-content').slideToggle("hidden");
	$(".SearchBlock-toggle-wrapper .dropdown-toggle").on('click', function() {
		$('.SearchBlock-toggle-wrapper .dropdown-toggle-content').slideToggle("show");
		$('.SearchBlock-toggle-wrapper .dropdown-toggle .fa-search ').toggleClass("fa-close");
		
	});
});
</script>
