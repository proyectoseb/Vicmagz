<?php
/**
 * @package SJ Simple Tabs for K2
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/' . $module->module . '/assets/css/style.css');

if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
	JHtml::script('modules/' . $module->module . '/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
$tag_id = 'sj_mostviewed_' . rand() . time();

?>

<?php
if ($params->get('pretext') != '') {
	?>
	<div class="pre-text"><?php echo $params->get('pretext'); ?></div>
<?php } ?>
<!--[if lt IE 9]>
<div class="sj-mostviewed mv-pre-load msie lt-ie9" id="<?php echo $tag_id; ?>"><![endif]-->
<!--[if IE 9]>
<div class="sj-mostviewed mv-pre-load msie" id="<?php echo $tag_id; ?>"><![endif]-->
<!--[if gt IE 9]><!-->
<div class="sj-mostviewed mv-pre-load" id="<?php echo $tag_id; ?>"><!--<![endif]-->
	<div class="mv-wrap">
		<?php include JModuleHelper::getLayoutPath($module->module, $layout . '_items'); ?>
	</div>
</div>
<?php
if ($params->get('posttext') != '') {
	?>
	<div class="post-text"><?php echo $params->get('posttext'); ?></div>
<?php } ?>
