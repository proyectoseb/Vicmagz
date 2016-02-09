<?php
/**
 * @package SJ Most Viewed for K2
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */
defined('_JEXEC') or die;
?>
<div class="menu-tabs">
	<ul class="mv-tabs">
		<?php foreach($tabViewed as $tab){?>
		<li class="mv-tab">
			<span class="mv-tab-inner tab-<?php echo $tab ?>">
				<?php $textTab = "TEXT_".strtoupper($tab); echo JText::_($textTab);?>
			</span>
		</li>
		<?php }?>
	</ul>
</div>