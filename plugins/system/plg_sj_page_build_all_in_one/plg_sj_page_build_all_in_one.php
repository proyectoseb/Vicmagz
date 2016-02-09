<?php
/**
 * @package SJ Page Build
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com MD
 */

defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');
jimport('joomla.html.html');
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class plgSystemPlg_sj_page_build_all_in_one extends JPlugin
{
	protected $app = array();
	protected $_params = null;

	function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		$this->app = JFactory::getApplication();
		$this->_params = $this->params;
		
		
	}

	function onBeforeRender()
	{
		if ($this->app->isSite()) {		
			$document = JFactory::getDocument();
			$document->addStyleSheet(JURI::root(true) . '/plugins/system/plg_sj_page_build_all_in_one/assets/css/bootrap/bootstrap.min.css');
			$sj_pb = JRequest::getVar('sj_pb');
			if($sj_pb == 1){
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes' . '/core/data.php');
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes'. "/includes/shortcodes-func.php");
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes' . "/includes/shortcodes-prepa.php");
				$shortcode = JRequest::getVar('shortcode');
				$shortcode = parse_shortcode($shortcode);
			
			}
			return;
		}
		if ($this->app->isAdmin()) {
			
			$app = JFactory::getApplication();
			$document = JFactory::getDocument();
			if (( int )$this->params->get('include_jquery', '1')) {
				
			}
			if(JRequest::getVar('option') AND JRequest::getVar('view') AND JRequest::getVar('layout')){
				$option = JRequest::getVar('option');
				$view = JRequest::getVar('view');
				$layout = JRequest::getVar('layout');
				if($option == 'com_content' AND $view == 'article' AND $layout == 'edit'){
					$document = JFactory::getDocument();
					$document->addStyleSheet(JURI::root(true) . '/plugins/system/plg_sj_page_build_all_in_one/assets/css/pageBuild.css');
					$document->addStyleSheet(JURI::root(true) . '/plugins/system/plg_sj_page_build_all_in_one/assets/css/bootrap/bootstrap.min.css');
					JHtml::stylesheet(JUri::root()."plugins/system/ytshortcodes/shortcodes/box/css/box.css");
					JHtml::stylesheet(JUri::root()."plugins/system/ytshortcodes/shortcodes/highlighter/css/highlighter.css");
				}
			}
		}
		return true;
		
	}

	public function onAfterRender()
	{	
		if ($this->app->isSite()) {		
			$app = JFactory::getApplication();
			$sj_pb = JRequest::getVar('sj_pb');
			if($sj_pb == 1){
				$document = JFactory::getDocument();
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes' . '/core/data.php');
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes'. "/includes/shortcodes-func.php");
				require_once ($_SERVER['DOCUMENT_ROOT'] . JURI::root(true). '/plugins/system/ytshortcodes' . "/includes/shortcodes-prepa.php");
				$shortcode = JRequest::getVar('shortcode');
				$shortcode = '<div class="sj_pb_not_remove">'.parse_shortcode($shortcode).'</div>';
				$body = JResponse::GetBody();
				
				$body = str_replace('</body>', '<script type="text/javascript">jQuery(document).ready(function($) { $("body footer").remove();$("body div").addClass("sj_pb_remove");$(".sj_pb_not_remove").removeClass("sj_pb_remove");$(".sj_pb_not_remove").find("div").removeClass("sj_pb_remove");$("body .sj_pb_remove").remove(); })</script>' . '</body>', $body);
				$body = str_replace('</body>', $shortcode . '</body>', $body);
				JResponse::setBody($body);
				return true;
			}
			$body = JResponse::GetBody();
			$body = str_replace('</body>', $this->_addScriptQVSite() . '</body>', $body);
			JResponse::setBody($body);
		}
		
		if ($this->app->isAdmin()){
			if(JRequest::getVar('option') AND JRequest::getVar('view') AND JRequest::getVar('layout')){
				$option = JRequest::getVar('option');
				$view = JRequest::getVar('view');
				$layout = JRequest::getVar('layout');
				if($option == 'com_content' AND $view == 'article' AND $layout == 'edit'){					
					$document = JFactory::getDocument();
					$document->addStyleSheet(JURI::root(true) . '/plugins/system/plg_sj_page_build_all_in_one/assets/css/pageBuild.css');
					$document->addStyleSheet(JURI::root(true) . '/plugins/system/plg_sj_page_build_all_in_one/assets/css/bootrap/bootstrap.min.css');					
					$app = JFactory::getApplication();
					$body = JResponse::GetBody();
					$body = str_replace('</body>', '<div class="sj_page_build_wrap_all_element"><div class="sj_content_descreption_page_build"></div><div class="sj_page_build_wrap_element"><div class="sj_page_build_title_element"></div></div></div>'.$this->_addScriptQV() . '</body>', $body);
					JResponse::setBody($body);
				}
			}
			return true;
		}
	}

	function onAfterDispatch(){
		$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
		$get_all_elements = (int)JRequest::getVar('plg_pb_get_all_element', 0);
		if($is_ajax){
			if($get_all_elements == 1){
				require_once dirname(__FILE__) . '/core/helper.php';
				$return = array();
			}
		}
	}	
	public function onBeforeCompileHead(){
		//get language and direction
		
		
	}
	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	protected function _addScriptQVSite(){
		
		ob_start();
	?>
		<script type="text/javascript">
			//<![CDATA[
					jQuery(document).ready(function($) {	
						var window_width = $(document).width();
						$('.sj_pb_column_row').each(function(){
							var m_top = $(this).attr('data-margin_top');
							var m_bottom = $(this).attr('data-margin_bottom');
							var p_top = $(this).attr('data-padding_top');
							var p_bottom = $(this).attr('data-padding_bottom');
							var b_color = $(this).attr('data-background_color');
							var b_image = $(this).attr('data-background_image');
							var d_css = $(this).attr('data-css_config');
							var d_class = $(this).attr('data-class_config');
							var style = '';
							if(typeof m_top != "undefined" && m_top != '' && m_top != "undefined"){
								style = style + 'margin-top: ' + m_top + ';';
							}
							if(typeof m_bottom != "undefined" && m_bottom != '' && m_bottom != "undefined"){
								style = style + 'margin-bottom: ' + m_bottom + ';';
							}
							if(typeof p_top != "undefined" && p_top != '' && p_top != "undefined"){
								style = style + 'padding-top: ' + p_top + ';';
							}
							if(typeof p_bottom != "undefined" && p_bottom != '' && p_bottom != "undefined"){
								style = style + 'padding-bottom: ' + p_bottom + ';';
							}
							if(typeof b_color != "undefined" && b_color != '' && b_color != "undefined"){
								style = style + 'background-color: ' + b_color + ';';
							}
							
							if(typeof b_image != "undefined" && b_image != '' && b_image != "undefined"){
								style = style + 'background-image: url("<?php echo JURI::root();?>' + b_image + '");';
							}
							if(typeof d_css != "undefined" && d_css != '' && d_css != "undefined"){
								style = style + d_css;
							}
							$(this).addClass(d_class);
							$(this).attr('style',style);
						})
						$('.sj_pb_column').each(function(){
							var width = $(this).attr('data-width');
							var m_top = $(this).attr('data-margin_top');
							var m_bottom = $(this).attr('data-margin_bottom');
							var p_top = $(this).attr('data-padding_top');
							var p_bottom = $(this).attr('data-padding_bottom');
							var b_color = $(this).attr('data-background_color');
							var b_image = $(this).attr('data-background_image');
							var d_css = $(this).attr('data-css_config');
							var d_class = $(this).attr('data-class_config');
							var style = '';
							if(typeof m_top != "undefined" && m_top != ''){
								style = style + 'margin-top: ' + m_top + ';';
							}
							if(typeof m_bottom != "undefined" && m_bottom != ''){
								style = style + 'margin-bottom: ' + m_bottom + ';';
							}
							if(typeof p_top != "undefined" && p_top != ''){
								style = style + 'padding-top: ' + p_top + ';';
							}
							if(typeof p_bottom != "undefined" && p_bottom != ''){
								style = style + 'padding-bottom: ' + p_bottom + ';';
							}
							if(typeof b_color != "undefined" && b_color != ''){
								style = style + 'background-color: ' + b_color + ';';
							}
							
							if(typeof b_image != "undefined" && b_image != ''){
								style = style + 'background-image: url("<?php echo JURI::root();?>' + b_image + '");';
							}
							if(typeof d_css != "undefined" && d_css != ''){
								style = style + d_css;
							}
							$(this).attr('style',style);
							$(this).addClass(d_class);
							var object_div = $(this).find('.sj_pb_relative').eq(0);
							var html = object_div.html();
							if(typeof width != "undefined" && width != ''){
								if(parseInt(window_width) > 1100){
									object_div.css('width',width);
									object_div.css('margin','auto');
									object_div.css('float','none');
								}
							}
						})
					})
			//]]>
		</script>
	<?php
		$jq = ob_get_contents();
		ob_end_clean();
		return $jq;
	}
	protected function _addScriptQV()
	{
		
		ob_start();
		?>
		
		<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function($) {
					var html = $('#jform_articletext').html();
					var click_close = 'sj_pb_close';
					var check_click_close = 0;
					var check_show = 0; 
					var bootrap_wrap_class = 'row';
					var bootrap_container_class = 'container-fluid';
					var row = new Array();
					row[1] = "col-md-1 col-sm-6";
					row[2] = "col-md-2 col-sm-6";
					row[3] = "col-md-3 col-sm-6";
					row[4] = "col-md-4 col-sm-6";
					row[5] = "col-md-5 col-sm-6";
					row[6] = "col-md-6 col-sm-6";
					row[7] = "col-md-7 col-sm-6";
					row[8] = "col-md-8 col-sm-6";
					row[9] = "col-md-9 col-sm-6";
					row[10] = "col-md-10 col-sm-6";
					row[11] = "col-md-11col-sm-6";
					row[12] = "col-md-12";
					var check_hover = 0;
					var html_filed_media = '<div class="sj_pb_media"><input type="text" name="" value="" id="photo_background_wrap" class="su-generator-attr su-generator-upload-value photo" />';
					html_filed_media = html_filed_media + '<a class="btn btn-primary sj_pb_media_btn" title="Select image" onClick="SqueezeBox.open(this, {handler:\'iframe\', size: {x: 850, y: 580}}); return false;" href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=photo_background_wrap&folder=" rel="{handler: \'iframe\', size: {x: 790, y: 580}}"><i class="fa fa-image"></i>Select media</a>';
					html_filed_media = html_filed_media + '</div>';
					var html_filed_media_c = '<div class="sj_pb_media"><input type="text" name="" value="" id="photo_background_wrap_row" class="su-generator-attr su-generator-upload-value photo" />';
					html_filed_media_c = html_filed_media_c + '<a class="btn btn-primary sj_pb_media_btn" title="Select image" onClick="SqueezeBox.open(this, {handler:\'iframe\', size: {x: 850, y: 580}}); return false;" href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=photo_background_wrap_row&folder=" rel="{handler: \'iframe\', size: {x: 790, y: 580}}"><i class="fa fa-image"></i>Select media</a>';
					html_filed_media_c = html_filed_media_c + '</div>';
					var ajax_url = '<?php echo JUri::getInstance();?>';

				<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
					$('.form-horizontal').prepend('<div class="sj_pb_controler"><div class="sj_pb_controler_pb btn btn-warning">Page Build</div></div>');
					$('body').prepend('<div class="sj_pb_wrap"></div>');
					$('body').append('<div class="sj_pb_background_body"></div>');
					$('body .sj_pb_wrap').append('<div class="sj_pb_relative"><div class="sj_pb_menu"></div></div>');
					$('body .sj_pb_wrap .sj_pb_menu').append('<div class="sj_pb_menu_save btn btn-info">Save</div>');
					$('body .sj_pb_wrap .sj_pb_menu').append('<div class="sj_pb_menu_config btn btn-info">Config</div>');
					$('body .sj_pb_wrap .sj_pb_menu').append('<div class="sj_pb_menu_cancel btn btn-info">Cancel</div>');
					$('body .sj_pb_wrap .sj_pb_menu').append('<div class="sj_pb_menu_add_column btn btn-info sj_pb_add_column_content">Add Row</div>');
					$('body .sj_pb_wrap').append('<div class="'+bootrap_wrap_class+'"><div class="'+row[12]+'"><div class="sj_pb_relative sj_pb_content" data-width="100%" data-background="#fff" data-background_image=""><div class="sj_pb_container '+bootrap_container_class+'"></div></div></div></div></div>');
					$('body').prepend('<div class="sj_pb_config_wrap"></div>')
					$('body .sj_pb_config_wrap').append('<div class="sj_pb_config_wrap_width"><div class="sj_pb_label">Width Theme:</div><div class="sj_pb_input"><input type="text"/></div></div>');
					$('body .sj_pb_config_wrap').append('<div class="sj_pb_config_wrap_background"><div class="sj_pb_label">Background:</div><div class="sj_pb_input"><input type="text"/></div></div>');
					$('body .sj_pb_config_wrap').append('<div class="sj_pb_config_wrap_background_image"><div class="sj_pb_label">Background Image:</div><div class="sj_pb_input"></div></div>');
					$('body .sj_pb_config_wrap .sj_pb_config_wrap_background_image .sj_pb_input').append('<div class="sj_pb_media"><input type="text" name="" value="" id="photo_background_wrap" class="su-generator-attr su-generator-upload-value photo" /></div>');
					$('body .sj_pb_config_wrap .sj_pb_config_wrap_background_image .sj_pb_input .sj_pb_media').append('<a class="btn btn-primary sj_pb_media_btn" title="Select image" onClick="SqueezeBox.open(this, {handler:\'iframe\', size: {x: 790, y: 580}}); return false;" href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=photo_background_wrap&folder=" rel="{handler: \'iframe\', size: {x: 790, y: 580}}"><i class="fa fa-image"></i>Select media</a>');
					$('body .sj_pb_config_wrap').append('<div class="sj_pb_config_wrap_control"><div class="sj_pb_label sj_pb_config_wrap_control_save btn btn-info">Save</div><div class="sj_pb_label sj_pb_config_wrap_control_cancel btn btn-info">Cancel</div></div>');
					$('body').append('<div class="sj_pb_config_column_row"></div>');
					$('.sj_pb_config_column_row').append('<div class="sj_pb_relative"></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap width"><div class="sj_pb_input_label">Width Content:</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap margin_top"><div class="sj_pb_input_label">Margin Top</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap margin_bottom"><div class="sj_pb_input_label">Margin Bottom</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap padding_top"><div class="sj_pb_input_label">Padding Top</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap padding_bottom"><div class="sj_pb_input_label">Padding Bottom</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap background_color"><div class="sj_pb_input_label">Background Color</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap class"><div class="sj_pb_input_label">Add Class</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap css"><div class="sj_pb_input_label">Add Css</div><div class="sj_pb_input_text"><input type="text"/></div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_input_wrap background_image_wrap"><div class="sj_pb_input_label">Background Image</div><div class="sj_pb_input_text">'+html_filed_media_c+'</div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_config_wrap_controlcr"><div class="sj_pb_label sj_pb_config_wrap_control_cancel_cr btn btn-info">Cancel</div><div class="sj_pb_label sj_pb_config_wrap_control_save_cr btn btn-info">Save</div></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_left sj_pb_absolute"></div>');
					$('.sj_pb_config_column_row .sj_pb_relative').append('<div class="sj_pb_right sj_pb_absolute"></div>');
				<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
					$('.sj_pb_menu .sj_pb_menu_config').click(function(){
						$('.sj_pb_config_wrap').css('display','block');
						$('.sj_pb_config_wrap').addClass(click_close);
						var width = $('.sj_pb_content').attr('data-width');
						var background = $('.sj_pb_content').attr('data-background');
						var background_image = $('.sj_pb_content').attr('data-background_image');
						$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_width input').val(width);
						$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background input').val(background);
						$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background_image input').val(background_image);
						check_show = 1;
					});
					
					$('body').on('click','.'+click_close,function(){
						check_click_close = 1;
					})
					
					$('body').click(function(){
						if(check_show == 1){
							check_show = 0;	
						}else{
							if(check_click_close == 1){
								check_click_close = 0;
							}else{
								$('.'+click_close).css('display','none');
								$('.'+click_close).removeClass(click_close);
							}
						}
					})
					$('body').on('click','.'+click_close+' .sj_pb_config_wrap_control_cancel',function(){
						check_click_close = 0;
						$('.'+click_close).css('display','none');
						$('.'+click_close).removeClass(click_close);
					})
					
					$('body').on('click','.sj_pb_config_wrap_control_save',function(){
						$('.sj_pb_content').css('width',$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_width input').val());
						$('.sj_pb_content').css('background-color',$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background input').val());
						$('.sj_pb_content').css('background-image','url("'+'<?php echo JURI::root();?>'+$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background_image input').val()+'")');
						check_click_close = 0;
						$('.'+click_close).css('display','none');
						$('.'+click_close).removeClass(click_close);
						$('.sj_pb_content').attr('data-width',$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_width input').val());
						$('.sj_pb_content').attr('data-background',$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background input').val());
						$('.sj_pb_content').attr('data-background_image',$('.sj_pb_config_wrap').find('.sj_pb_config_wrap_background_image input').val());
					})
					
					$('body').on('click','.sj_pb_add_column_content',function(){
						var html = $('.sj_pb_content').html();
						var add_html = htmlColumn();
						$('.sj_pb_content .sj_pb_container').append(add_html);						
					});
					
					$('body').on('click','.sj_pb_column_row_config_add_column',function(){
						var add_html = htmlColumn();
						$(this).parent().parent().append(add_html);
						$(this).parent().parent().css('background','#fff');
					});
					
					$('body').on('click','.sj_column_layout',function(){
						var layout = $(this).attr('data-layout');
						var layout_array = layout.split(',');
						var html = '';
						html = html+'<div class="'+bootrap_wrap_class+'">';
						for(var i = 0; i < layout_array.length; i++){
							var index = layout_array[i];
							html = html + htmlRow(index);
						}
						html = html+'</div>';
						$(this).parent().parent().parent().parent().parent().parent().css('background','#fff');
						$(this).parent().parent().parent().parent().parent().parent().find('.sj_pb_column_content').html(html);
					});
					
					$('body').on('mouseover','.sj_pb_column_row',function(){
						$(this).find('.sj_pb_column_row_config').eq(0).css('display','block');
					})
					$('body').on('mouseout','.sj_pb_column_row',function(){
						$(this).find('.sj_pb_column_row_config').eq(0).css('display','none');
					})
					
					$('body').on('mouseover','.sj_pb_column',function(){
						$(this).find('.sj_pb_column_config_option').eq(0).css('display','block');
						$(this).find('.sj_pb_column_config_layout').eq(0).css('display','block');
					})
					$('body').on('mouseout','.sj_pb_column',function(){
						$(this).find('.sj_pb_column_config_option').eq(0).css('display','none');
						$(this).find('.sj_pb_column_config_layout').eq(0).css('display','none');
					})
					
					$('body').on('click','.sj_pb_column_row_config_add_element',function(){
						$('.yt_shortcode_overlay').css('display','block');
						$('.yt_shortcodes_plugin').css('display','block');
						$('.yt_shortcodes_close').css('display','block');
						$('#yt-generator-search').focus();
						$('#yt-generator-search').focusout();
						tinyMCE.activeEditor.setContent('');
						$('.sj_pb_column_row_content .sj_pb_background').removeClass("sj_pb_add_element");
						$('.sj_pb_element').removeClass('sj_pb_edit_element');
						$(this).parent().parent().find('.sj_pb_column_row_content .sj_pb_background').eq(0).addClass("sj_pb_add_element");
					});
					
					$('body').on('click','.yt-generator-insert',function(){
						$('.yt-generator-show-code').click();
						var shortcode = $(".show-yt_shortcode").html();
						var html = htmlElement(shortcode);
						var open_tag = shortcode.split(' ')[0];
						var array = open_tag.split('_');
						var element = array[1];
						
						if($('.sj_pb_add_element').length == 1){
							$('.sj_pb_add_element').append(html);
							var attrShortcode = shortcode.replace(/\"/g,"'");
							var length = parseInt($('.sj_pb_add_element .sj_pb_element').length) - 1;
							$('.sj_pb_add_element .sj_pb_element').eq(length).attr('data-shortcode',attrShortcode);
							$('.sj_pb_add_element .sj_pb_element').eq(length).attr('data-element',element);
							$('.sj_pb_column_row_content .sj_pb_background').removeClass("sj_pb_add_element");
							$('.sj_pb_element').removeClass('sj_pb_edit_element');
						}
						if($('.sj_pb_edit_element').length == 1){
							$('.sj_pb_edit_element').html(htmlEditElement(shortcode));
							var attrShortcode = shortcode.replace(/\"/g,"'");
							$('.sj_pb_edit_element').attr('data-shortcode',attrShortcode);
							$('.sj_pb_edit_element').attr('data-element',element);
							$('.sj_pb_element').removeClass('sj_pb_edit_element');
							$('.sj_pb_column_row_content .sj_pb_background').removeClass("sj_pb_add_element");
						}
						$('.sj_pb_element').removeClass('sj_pb_edit_element');
						$('.sj_pb_column_row_content .sj_pb_background').removeClass("sj_pb_add_element");
					});
					
					$('body').on('click','.sj_pb_element_config_edit',function(){
						$('.sj_pb_element').removeClass('sj_pb_edit_element');
						$('.sj_pb_column_row_content .sj_pb_background').removeClass("sj_pb_add_element");
						$(this).parent().parent().parent().parent().find('.sj_pb_element').addClass("sj_pb_edit_element");
						$('.yt_shortcode_overlay').css('display','block');
						$('.yt_shortcodes_plugin').css('display','block');
						$('.yt_shortcodes_close').css('display','block');
						$('#yt-generator-search').focus();
						$('#yt-generator-search').focusout();
						var div = $(this).parent().parent().parent().parent().find('.sj_pb_element');
						var element = div.attr('data-element');
						var shortcode = div.attr('data-shortcode');
						var i = 0;
						var index;
						$('.yt_shortcode_element').each(function(){
							if($(this).attr('data-shortcode') == element){
								index = i;
							}else{
								i++;
							}
						});
						setTimeout(function(){
							$('.yt_shortcode_element').eq(index).click();
						},500);
						
						var check = '/yt_'+element+'_item';
						var length = parseInt(shortcode.split(check).length) - 2;
						if(length != -1){
							var q = setInterval(function(){ 
								var son = $('.yt_shortcodes_son_form_element').html();
								if(typeof son != 'undefined'){
									for(var a = 0; a < length; a++){
										$('.yt_shortcodes_add_element').click();
									}
									
									setTimeout(function(){ 
										var element_son_array = shortcode.split(' [');
										var o = 0;
										var data_short_code;
										var data_short_code_son = new Array();
										var p = 0;
										element_son_array.each(function(){
											if(element_son_array[o].indexOf('/') == -1)
											if(o == 0){
												data_short_code = element_son_array[o];
											}
											if(o % 2 == 1){
												data_short_code_son[p] = element_son_array[o];
												p++;
											}
											o++;
										});
										data_short_code = data_short_code.replace(/\'/g,' ');
										var data_short_code_array = data_short_code.split('  ');
										i = 0;
										data_short_code_array.each(function(){
												if(data_short_code_array[i].indexOf('=') != -1){
													if(i == 0){
														var first = data_short_code_array[i].split(' ');
														data_short_code_array[i] = first[1]+first[2];
													}
													
													var data_array_value = data_short_code_array[i].split('=');
													$('.yt_shortcodes_parent_form_element').find('#yt-generator-attr-'+data_array_value[0].replace(' ','')).val(data_array_value[1].replace(' ',''));
													var id = '#yt-generator-attr-'+data_array_value[0].replace(' ','');

													if($('.yt_shortcodes_parent_form_element '+id).parent().hasClass('yt-field-type-select') || $('.yt_shortcodes_parent_form_element '+id).parent().hasClass('yt-field-type-module')){
														$('.yt_shortcodes_parent_form_element '+id).find('option').removeAttr('selected');
														$('.yt_shortcodes_parent_form_element '+id).find('option').each(function(){
															if($(this).attr('value') == data_array_value[1].replace(' ','')){
																$(this).attr('selected','selected');
															}
														});
													}
													if($('.yt_shortcodes_parent_form_element '+id).parent().hasClass('yt-generator-select-color')){
														$('.yt_shortcodes_parent_form_element '+id).css('background-color',data_array_value[1].replace(' ',''));
													}
												}
											i++;
										});
										i = 0;
										data_short_code_son.each(function(){
											var id_attr = $('.yt_shortcodes_son_wrap').eq(i).find('.yt_shortcodes_wrap_form .yt-generator-attr').eq(0).attr('id');
											data_short_code_son[i] = data_short_code_son[i].replace(/\'/g,' ');
											var data_value_data_short_code_son = data_short_code_son[i].split('  ');
											e = 0;
											data_value_data_short_code_son.each(function(){
												if(data_value_data_short_code_son[e].indexOf('=') != -1){
												
													if(e== 0){
														var first = data_value_data_short_code_son[e].split(' ');
														data_value_data_short_code_son[e] = first[1]+first[2];
													}
													data_value_data_short_code_son[e] = data_value_data_short_code_son[e].replace(' ','');
													var data_son_array_value = data_value_data_short_code_son[e].split('=');
													if(i != 0){
														var array_attr = id_attr.split('-');
														var stt = array_attr[(array_attr.length - 1)];
														var id = '#yt-generator-attr-'+data_son_array_value[0].replace(' ','')+'-'+stt;
														
													}else{
														var id = '#yt-generator-attr-'+data_son_array_value[0].replace(' ','');
													}
													
													$('.yt_shortcodes_son_wrap').find(id).val(data_son_array_value[1].replace(' ',''));
													if($('.yt_shortcodes_son_wrap '+id).eq(e).parent().hasClass('yt-field-type-select') || $('.yt_shortcodes_son_wrap '+id).parent().hasClass('yt-field-type-module')){
														$('.yt_shortcodes_son_wrap '+id).eq(e).find('option').removeAttr('selected');
														$('.yt_shortcodes_son_wrap '+id).eq(e).find('option').each(function(){
															if($(this).attr('value') == data_son_array_value[1].replace(' ','')){
																$(this).attr('selected','selected');
															}
														});
													}
													if($('.yt_shortcodes_son_wrap '+id).eq(e).parent().hasClass('yt-generator-select-color')){
														$('.yt_shortcodes_son_wrap '+id).eq(e).css('background-color',data_son_array_value[1].replace(' ',''));
													}
												}
												e++;
											});
											i++;
										});										
									}, 500);
									clearInterval(q);
								}
							}, 500);
						}else{
							var q = setInterval(function(){ 
								var check = $('.yt_shortcodes_wrap_form_element').html();
								if(typeof check != 'undefined'){
									var id;
									var data_array = shortcode.split(' ');
									var i = 0;
									var content;
									data_array.each(function(){
										if(data_array[i].indexOf('[') == -1 && data_array[i].indexOf("]") == -1){
											if(data_array[i].indexOf('=') != -1){
												content = '';
												var string = data_array[i].split('=');
												var data = string[1].replace(/\'/g,'');
												content = data;
												id = '#yt-generator-attr-'+string[0];
												$('.yt_shortcodes_wrap_form_element #yt-generator-attr-'+string[0]).val(data);
												if($('.yt_shortcodes_wrap_form_element '+id).parent().hasClass('yt-generator-select-color')){
													$('.yt_shortcodes_wrap_form_element '+id).css('background-color',data);
												}
												if(string[1].replace("'",'').indexOf("'") != -1){
													if($('.yt_shortcodes_wrap_form_element '+id).parent().hasClass('yt-field-type-select') || $('.yt_shortcodes_wrap_form_element '+id).parent().hasClass('yt-field-type-module')){
														$('.yt_shortcodes_wrap_form_element '+id).find('option').removeAttr('selected');
														$('.yt_shortcodes_wrap_form_element '+id).find('option').each(function(){
															if($(this).attr('value') == content){
																$(this).attr('selected','selected');
															}
														});
													}
													id = '';
												}
											}else {																
												if(id != ''){
													if(data_array[i].indexOf("\'") != -1){		
														var val = $('.yt_shortcodes_wrap_form_element '+id).val();
														$('.yt_shortcodes_wrap_form_element '+id).val(val + ' ' + data_array[i].replace("'",''));		
														content = content + ' ' + data_array[i].replace("'",'');
														if($('.yt_shortcodes_wrap_form_element '+id).parent().hasClass('yt-field-type-select') || $('.yt_shortcodes_wrap_form_element '+id).parent().hasClass('yt-field-type-module')){
															$('.yt_shortcodes_wrap_form_element '+id).find('option').removeAttr('selected');
															$('.yt_shortcodes_wrap_form_element '+id).find('option').each(function(){
																if($(this).attr('value') == content){

																	$(this).attr('selected','selected');
																}
															});
														}
														
														id = '';
													}else{
														var val = $('.yt_shortcodes_wrap_form_element '+id).val();
														$('.yt_shortcodes_wrap_form_element '+id).val(val + ' ' + data_array[i].replace("'",''));	
														content = content + ' ' + data_array[i].replace("'",'');
													}
												}
											}
											
										}
										
										i++;
									});
									if(shortcode.indexOf('/yt_'+element) != -1){
										var st_shortcode = shortcode.replace('[/yt_'+element+']','');
										var data_content_array = st_shortcode.split('] ');
										var content = data_content_array[1];
										$('#yt-generator-attr-content').val(content);
									}

									clearInterval(q);
								}
							}, 500);
						}
						
						
					})

					$('body').on('click','.sj_pb_element_config_remove',function(){
						$(this).parent().parent().parent().parent().parent().remove();
					})

					$('body').on('click','.sj_pb_column_row_config_remove',function(){
						$(this).parent().parent().find('.sj_pb_background').empty();
					})

					$('body').on('click','.sj_pb_column_config_option_remove',function(){
						$(this).parent().parent().parent().parent().remove();
					})

					$('body').on('click','.sj_pb_column_config_option_copy',function(){
						var html = $(this).parent().parent().parent().parent().parent().html();
						$('<div class="container-fluid">'+html+'</div>').insertAfter($(this).parent().parent().parent().parent().parent());
						
					})
					$('body').on('click','.sj_pb_element_config_copy',function(){
						var html = $(this).parent().parent().parent().parent().parent().html();
						$('<div class="row">'+html+'</div>').insertAfter($(this).parent().parent().parent().parent().parent());
					})

					$('body').on('click','.sj_pb_column_row_config_copy',function(){
						var html = $(this).parent().parent().parent().find('.sj_pb_background').html();
					})
					$('.sj_pb_menu_save').click(function(){
						var wrap = $('.sj_pb_wrap .row').eq(0);
						
						var html = wrap.html();
						$('.sj_pb_data_save').html(html);
						wrap.find('.sj_pb_column_config').remove();
						wrap.find('.sj_pb_column_row_config ').remove();
						wrap.find('.sj_pb_element_config').parent().parent().html('');
						wrap.find('.sj_pb_element').each(function(){
							var sc = $(this).attr('data-shortcode');
							sc = sc.replace(/\'/g,'"');
							$(this).html(sc);
							$(this).attr('data-shortcode','');
						});
						var html = wrap.html();
						$('.sj_pb_wrap').css('display','none');
						tinyMCE.activeEditor.setContent('');							
						jInsertEditorText(html,'#jform_articletext');	
						
						$('.sj_pb_wrap').css('display','none');
					});

					$('.sj_pb_wrap').css('display','none');
					

					$('.sj_pb_controler_pb').click(function(){
						$('.sj_pb_wrap').css('display','block');
					})
					var cancel = 0;
					$('.sj_pb_menu_cancel').click(function(){
						cancel = 1;
						$('.sj_pb_wrap').css('display','none');
					})
					var window_width = $(document).width();
					var config_width = $('.sj_pb_config_column_row').width();
					$('body').on('click','.sj_pb_column_row_config_edit',function(e){
						$('.sj_pb_background_body').css('display','block');
						$('.sj_pb_config_column_row').find('.sj_pb_input_wrap').eq(0).css('display','none');
						var x = e.pageX;
						var y = e.pageY;
						$('.sj_pb_config_column_row').css('display','block');
						$('.sj_pb_config_column_row').css('position','absolute');
						
						var check = window_width - x;
						if(check < config_width){
							x = x - config_width - 20;
						}
							$('.sj_pb_config_column_row').css('top',y+'px');
							$('.sj_pb_config_column_row').css('left',x+'px');
						var m_top = $('.sj_pb_config_column_row').find('.margin_top').parent().find('.sj_pb_input_text input').val();
					})
					
					$('body').on('click','.sj_pb_column_row_config_edit',function(e){
						$('.sj_pb_background_body').css('display','block');
						$('.sj_pb_config_column_row').find('.sj_pb_input_wrap').eq(0).css('display','none');
						var x = e.pageX;
						var y = e.pageY;
						$('.sj_pb_config_column_row').css('display','block');
						$('.sj_pb_config_column_row').css('position','absolute');
						
						var check = window_width - x;
						if(check < config_width){
							x = x - config_width - 20;
						}
						$('.sj_pb_config_column_row').css('top',y+'px');
						$('.sj_pb_config_column_row').css('left',x+'px');
						$('.sj_pb_column_row').removeClass('sj_pb_chose_config');
						$(this).parent().parent().addClass('sj_pb_chose_config');
						/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------ */
						var m_top = $('.sj_pb_chose_config').attr('data-margin_top');
						var m_bottom = $('.sj_pb_chose_config').attr('data-margin_bottom');
						var p_top = $('.sj_pb_chose_config').attr('data-padding_top');
						var p_bottom = $('.sj_pb_chose_config').attr('data-padding_bottom');
						var b_color = $('.sj_pb_chose_config').attr('data-background_color');
						var b_image = $('.sj_pb_chose_config').attr('data-background_image');
						var d_css = $('.sj_pb_chose_config').attr('data-css_config');
						var d_class = $('.sj_pb_chose_config').attr('data-class_config');
						if(typeof m_top == "undefined"){
							$('.sj_pb_config_column_row .margin_top').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .margin_top').find('.sj_pb_input_text input').val(m_top);
						}
						if(typeof m_bottom == "undefined"){
							$('.sj_pb_config_column_row .margin_bottom').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .margin_bottom').find('.sj_pb_input_text input').val(m_bottom);
						}
						if(typeof p_top == "undefined"){
							$('.sj_pb_config_column_row .padding_top').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .padding_top').find('.sj_pb_input_text input').val(p_top);
						}
						if(typeof p_bottom == "undefined"){
							$('.sj_pb_config_column_row .padding_bottom').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .padding_bottom').find('.sj_pb_input_text input').val(p_bottom);
						}
						if(typeof b_color == "undefined"){
							$('.sj_pb_config_column_row .background_color').find('.sj_pb_input_text input').val('#fff');
						}else{
							$('.sj_pb_config_column_row .background_color').find('.sj_pb_input_text input').val(b_color);
						}
						if(typeof d_css == "undefined"){
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val(d_css);
						}
						if(typeof d_class == "undefined"){
							$('.sj_pb_config_column_row .class').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .class').find('.sj_pb_input_text input').val(d_class);
						}
						if(typeof d_css == "undefined"){
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val(d_css);
						}
						if(typeof b_image == "undefined"){
							$('.sj_pb_config_column_row .sj_pb_media').find('#photo_background_wrap_row').val('');
						}else{
							$('.sj_pb_config_column_row .sj_pb_media').find('#photo_background_wrap_row').val(b_image);
						}
						/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------ */
					})
					
					$('body').on('click','.sj_pb_column_config_option_edit',function(e){
						$('.sj_pb_background_body').css('display','block');
						$('.sj_pb_config_column_row').find('.sj_pb_input_wrap').eq(0).css('display','block');
						var x = e.pageX;
						var y = e.pageY;
						$('.sj_pb_config_column_row').css('display','block');
						$('.sj_pb_config_column_row').css('position','absolute');
						
						var check = window_width - x;
						if(check < config_width){
							x = x - config_width - 20;
						}
						$('.sj_pb_config_column_row').css('top',y+'px');
						$('.sj_pb_config_column_row').css('left',x+'px');
						$('.sj_pb_column').removeClass('sj_pb_chose_config');
						$(this).parent().parent().parent().parent().addClass('sj_pb_chose_config');
						/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------ */
						var width = $('.sj_pb_chose_config').attr('data-width');
						var m_top = $('.sj_pb_chose_config').attr('data-margin_top');
						var m_bottom = $('.sj_pb_chose_config').attr('data-margin_bottom');
						var p_top = $('.sj_pb_chose_config').attr('data-padding_top');
						var p_bottom = $('.sj_pb_chose_config').attr('data-padding_bottom');
						var b_color = $('.sj_pb_chose_config').attr('data-background_color');
						var b_image = $('.sj_pb_chose_config').attr('data-background_image');
						var d_css = $('.sj_pb_chose_config').attr('data-css_config');
						var d_class = $('.sj_pb_chose_config').attr('data-class_config');
						if(typeof width == "undefined"){
							$('.sj_pb_config_column_row .width').find('.sj_pb_input_text input').val('100%');
						}else{
							$('.sj_pb_config_column_row .width').find('.sj_pb_input_text input').val(width);
						}
						if(typeof m_top == "undefined"){
							$('.sj_pb_config_column_row .margin_top').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .margin_top').find('.sj_pb_input_text input').val(m_top);
						}
						if(typeof m_bottom == "undefined"){
							$('.sj_pb_config_column_row .margin_bottom').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .margin_bottom').find('.sj_pb_input_text input').val(m_bottom);
						}
						if(typeof p_top == "undefined"){
							$('.sj_pb_config_column_row .padding_top').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .padding_top').find('.sj_pb_input_text input').val(p_top);
						}
						if(typeof p_bottom == "undefined"){
							$('.sj_pb_config_column_row .padding_bottom').find('.sj_pb_input_text input').val('10px');
						}else{
							$('.sj_pb_config_column_row .padding_bottom').find('.sj_pb_input_text input').val(p_bottom);
						}
						if(typeof b_color == "undefined"){
							$('.sj_pb_config_column_row .background_color').find('.sj_pb_input_text input').val('#fff');
						}else{
							$('.sj_pb_config_column_row .background_color').find('.sj_pb_input_text input').val(b_color);
						}
						if(typeof d_css == "undefined"){
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val(d_css);
						}
						if(typeof d_class == "undefined"){
							$('.sj_pb_config_column_row .class').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .class').find('.sj_pb_input_text input').val(d_class);
						}
						if(typeof d_css == "undefined"){
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val('');
						}else{
							$('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val(d_css);
						}
						if(typeof b_image == "undefined"){
							$('.sj_pb_config_column_row .sj_pb_media').find('#photo_background_wrap_row').val('');
						}else{
							$('.sj_pb_config_column_row .sj_pb_media').find('#photo_background_wrap_row').val(b_image);
						}
						/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------ */
					})
					
					$('.sj_pb_config_wrap_control_cancel_cr').click(function(){
						$('.sj_pb_background_body').css('display','none');
						$('.sj_pb_config_column_row').css('display','none');
						$('.sj_pb_column_row').removeClass('sj_pb_chose_config');
						$('.sj_pb_column').removeClass('sj_pb_chose_config');
					})
					
					$('.sj_pb_config_wrap_control_save_cr').click(function(){
						var width = $('.sj_pb_config_column_row .width').find('.sj_pb_input_text input').val();
						var m_top = $('.sj_pb_config_column_row .margin_top').find('.sj_pb_input_text input').val();
						var m_bottom = $('.sj_pb_config_column_row .margin_bottom').find('.sj_pb_input_text input').val();
						var p_top = $('.sj_pb_config_column_row .padding_top').find('.sj_pb_input_text input').val();
						var p_bottom = $('.sj_pb_config_column_row .padding_bottom').find('.sj_pb_input_text input').val();
						var b_color = $('.sj_pb_config_column_row .background_color').find('.sj_pb_input_text input').val();
						var b_image = $('.sj_pb_config_column_row .background_image_wrap').find('#photo_background_wrap_row').val();
						var d_css = $('.sj_pb_config_column_row .css').find('.sj_pb_input_text input').val();
						var d_class = $('.sj_pb_config_column_row .class').find('.sj_pb_input_text input').val();
						$('.sj_pb_chose_config').attr('data-width',width);
						$('.sj_pb_chose_config').attr('data-margin_top',m_top);
						$('.sj_pb_chose_config').attr('data-margin_bottom',m_bottom);
						$('.sj_pb_chose_config').attr('data-padding_top',p_top);
						$('.sj_pb_chose_config').attr('data-padding_bottom',p_bottom);
						$('.sj_pb_chose_config').attr('data-background_color',b_color);
						$('.sj_pb_chose_config').attr('data-background_image',b_image);
						$('.sj_pb_chose_config').attr('data-css_config',d_css);
						$('.sj_pb_chose_config').attr('data-class_config',d_class);
						$('.sj_pb_column_row').removeClass('sj_pb_chose_config');
						$('.sj_pb_column').removeClass('sj_pb_chose_config');
						$('.sj_pb_background_body').css('display','none');
						$('.sj_pb_config_column_row').css('display','none');
					})
					<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
						function htmlColumn(){
							var html = '';
							html = html+'<div class="'+bootrap_container_class+'">';
							html = html+'<div class="sj_pb_column '+bootrap_wrap_class+'">';
							html = html+'<div class="sj_pb_relative '+row[12]+'">';
							html = html+'<div class="sj_pb_column_config sj_pb_relative '+bootrap_wrap_class+'">';
							html = html+'<div class="'+row[12]+'">';
							html = html+'<div class="sj_pb_column_config_layout sj_pb_absolute"><div class="sj_pb_relative sj_pb_over">';
								html = html+'<div class="sj_column_layout" data-layout="12" title="12"><div class="sj_layout_column_12"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="6,6" title="6,6"><div class="sj_layout_column_6"></div><div class="sj_layout_column_6"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="4,4,4" title="4,4,4"><div class="sj_layout_column_4"></div><div class="sj_layout_column_4"></div><div class="sj_layout_column_4"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="3,3,3,3" title="3,3,3,3"><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="4,8" title="4,8"><div class="sj_layout_column_4"></div><div class="sj_layout_column_8"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="8,4" title="8,4"><div class="sj_layout_column_8"></div><div class="sj_layout_column_4"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="3,9" title="3,9"><div class="sj_layout_column_3"></div><div class="sj_layout_column_9"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="9,3" title="9,3"><div class="sj_layout_column_9"></div><div class="sj_layout_column_3"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="3,6,3" title="3,6,3"><div class="sj_layout_column_3"></div><div class="sj_layout_column_6"></div><div class="sj_layout_column_3"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="6,3,3" title="6,3,3"><div class="sj_layout_column_6"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="3,3,6" title="3,3,6"><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_6"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="1,10,1" title="1,10,1"><div class="sj_layout_column_1"></div><div class="sj_layout_column_10"></div><div class="sj_layout_column_1"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="2,8,2" title="2,8,2"><div class="sj_layout_column_2"></div><div class="sj_layout_column_8"></div><div class="sj_layout_column_2"></div></div>';
								html = html+'<div class="sj_column_layout" data-layout="2,2,2,2,2,2" title="2,2,2,2,2,2"><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div></div>';
							html = html+'</div></div></div>';
							html = html+'<div class="sj_pb_column_config_option sj_pb_absolute">';
								html = html+'<div class="sj_pb_column_config_option_edit sj_pb_column_option_item" title="Edit Row"><i class="fa fa-pencil-square-o"></i></div>';
								html = html+'<div class="sj_pb_column_config_option_copy sj_pb_column_option_item" title="Copy Row"><i class="fa fa-files-o"></i></div>';
								html = html+'<div class="sj_pb_column_config_option_remove sj_pb_column_option_item" title="Remove Row"><i class="fa fa-times"></i></div>';
							html = html+'</div>';
							html = html+'</div>';
							html = html+'<div class="'+bootrap_wrap_class+'">';
							html = html+'<div class="sj_pb_column_content sj_pb_relative '+row[12]+'"><div class="sj_pb_background"></div>';
							
							html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							return html;
						}
					
						function htmlRow(index){
							var html = '';
							html = html+'<div class="sj_pb_row '+row[index]+'">';
							html = html+'<div class="'+bootrap_wrap_class+'">';
							html = html+'<div class="sj_pb_column_row sj_pb_relative '+row[12]+'">';
								html = html+'<div class="sj_pb_column_row_config sj_pb_absolute">';
									html = html+'<div class="sj_pb_column_row_config_remove" title="Remove Column"><i class="fa fa-times"></i></div>';
									html = html+'<div class="sj_pb_column_row_config_add_column" title="Add Layout"><i class="fa fa-plus-square-o"></i></div>';
									html = html+'<div class="sj_pb_column_row_config_add_element" title="Add Element"><i class="fa fa-plus-square"></i></div>';
									html = html+'<div class="sj_pb_column_row_config_edit" title="Edit Column"><i class="fa fa-pencil-square-o"></i></div>';
								html = html+'</div>';
								html = html+'<div class="'+bootrap_wrap_class+'">';
									html = html+'<div class="sj_pb_column_row_content  '+row[12]+'"><div class="sj_pb_background"></div></div>';
								html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							
							return html;
						}
						
						function htmlElement(shortcode){
							var html = '';
							var abc = shortcode.replace(/\"/g,"'");
							abc = abc.replace(/\#/g,"%23");
							var iframe = '<iframe src="<?php echo JUri::root();?>?sj_pb=1&shortcode='+abc+'"></iframe>';
							
							html = html+'<div class="'+bootrap_wrap_class+'">';
							html = html+'<div class="'+row[12]+'">';
							html = html+'<div class="'+bootrap_wrap_class+'">';
							html = html+'<div class="sj_pb_relative '+row[12]+'">';
									html = html+'<div class="sj_pb_element_config sj_pb_absolute">';
										html = html+'<div class="sj_pb_element_config_remove" title="Remove Element"><i class="fa fa-times"></i></div>';
										html = html+'<div class="sj_pb_element_config_edit" title="Edit Element"><i class="fa fa-pencil-square-o"></i></div>';
										html = html+'<div class="sj_pb_element_config_copy" title="Copy Element"><i class="fa fa-files-o"></i></div>';
									html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							html = html+'<div class="sj_pb_element">';
								html = html + iframe;
							html = html+'</div>';
							html = html+'</div>';
							html = html+'</div>';
							return html;
						}
						
						function htmlEditElement(shortcode){
							var abc = shortcode.replace(/\"/g,"'");
							abc = abc.replace(/\#/g,"%23");
							var iframe = '<iframe src="<?php echo JUri::root();?>?sj_pb=1&shortcode='+abc+'"></iframe>';
							return iframe;
						}
					<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
						$('body').append('<div class="sj_pb_data_save" style="display:none;"></div>');
						$('.sj_pb_controler_pb').click(function(){
							if(cancel == 1){
								cancel = 0;
								return;
							}
							var html = $('#jform_articletext').val();
							var wrap = $('.sj_pb_wrap .row').eq(0);
							if($('.sj_pb_data_save').html() != ''){
								var html = $('.sj_pb_data_save').html();
								wrap.html(html);
								return;
							}
							$('.sj_pb_wrap').css('display','block');
							$('body').append('<div class="sj_build_data" style="display:none;"></div>');
							$('.sj_build_data').html(html);
							if($('.sj_build_data').find('.sj_pb_container').length == 0){
								return;
							}
							
							var content = $('.sj_build_data').find('.sj_pb_container');
							var config_column_layout = '<div class="col-md-12"><div class="sj_pb_column_config_layout sj_pb_absolute" style="display: none;">'+
														'<div class="sj_pb_relative sj_pb_over"><div class="sj_column_layout" data-layout="12" title="12">'+
														'<div class="sj_layout_column_12"></div></div><div class="sj_column_layout" data-layout="6,6" title="6,6">'+
														'<div class="sj_layout_column_6"></div><div class="sj_layout_column_6"></div></div><div class="sj_column_layout" data-layout="4,4,4" title="4,4,4">'+
														'<div class="sj_layout_column_4"></div><div class="sj_layout_column_4"></div><div class="sj_layout_column_4">'+
														'</div></div><div class="sj_column_layout" data-layout="3,3,3,3" title="3,3,3,3"><div class="sj_layout_column_3">'+
														'</div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3">'+
														'</div></div><div class="sj_column_layout" data-layout="4,8" title="4,8"><div class="sj_layout_column_4">'+
														'</div><div class="sj_layout_column_8"></div></div><div class="sj_column_layout" data-layout="8,4" title="8,4">'+
														'<div class="sj_layout_column_8"></div><div class="sj_layout_column_4"></div></div><div class="sj_column_layout" data-layout="3,9" title="3,9">'+
														'<div class="sj_layout_column_3"></div><div class="sj_layout_column_9"></div></div><div class="sj_column_layout" data-layout="9,3" title="9,3">'+
														'<div class="sj_layout_column_9"></div><div class="sj_layout_column_3"></div></div><div class="sj_column_layout" data-layout="3,6,3" title="3,6,3">'+
														'<div class="sj_layout_column_3"></div><div class="sj_layout_column_6"></div><div class="sj_layout_column_3"></div></div><div class="sj_column_layout" data-layout="6,3,3" title="6,3,3">'+
														'<div class="sj_layout_column_6"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div></div><div class="sj_column_layout" data-layout="3,3,6" title="3,3,6">'+
														'<div class="sj_layout_column_3"></div><div class="sj_layout_column_3"></div><div class="sj_layout_column_6"></div></div><div class="sj_column_layout" data-layout="1,10,1" title="1,10,1">'+
														'<div class="sj_layout_column_1"></div><div class="sj_layout_column_10"></div><div class="sj_layout_column_1"></div></div>'+
														'<div class="sj_column_layout" data-layout="2,8,2" title="2,8,2"><div class="sj_layout_column_2"></div><div class="sj_layout_column_8"></div><div class="sj_layout_column_2"></div></div>'+
														'<div class="sj_column_layout" data-layout="2,2,2,2,2,2" title="2,2,2,2,2,2">'+
														'<div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2"></div><div class="sj_layout_column_2">'+
														'</div><div class="sj_layout_column_2"></div></div></div></div></div>'
							var	config_column = '<div class="sj_pb_column_config_option sj_pb_absolute" style="display: none;">'+
														 '<div class="sj_pb_column_config_option_edit sj_pb_column_option_item"><i class="fa fa-pencil-square-o"></i></div><div class="sj_pb_column_config_option_copy sj_pb_column_option_item"><i class="fa fa-files-o"></i></div>'+
														 '<div class="sj_pb_column_config_option_remove sj_pb_column_option_item"><i class="fa fa-times"></i></div></div>';					
							content.find('.sj_pb_column').each(function(){
								$(this).find('.sj_pb_relative').eq(0).prepend('<div class="sj_pb_column_config sj_pb_relative row"></div></div>');
							})
							content.find('.sj_pb_column .sj_pb_column_config').append(config_column_layout);
							content.find('.sj_pb_column .sj_pb_column_config').append(config_column);
							var config_row = '<div class="sj_pb_column_row_config sj_pb_absolute" style="display: none;">'+
														'<div class="sj_pb_column_row_config_remove"><i class="fa fa-times"></i></div><div class="sj_pb_column_row_config_add_column"><i class="fa fa-plus-square-o"></i></div>'+
														'<div class="sj_pb_column_row_config_add_element"><i class="fa fa-plus-square"></i></div><div class="sj_pb_column_row_config_edit"><i class="fa fa-pencil-square-o"></i></div></div>';
							content.find('.sj_pb_column .sj_pb_column_row').prepend(config_row);
							var config_element = '<div class="sj_pb_element_config sj_pb_absolute"><div class="sj_pb_element_config_remove"><i class="fa fa-times"></i></div>'+
															   '<div class="sj_pb_element_config_edit"><i class="fa fa-pencil-square-o"></i></div>'+
															   '<div class="sj_pb_element_config_copy"><i class="fa fa-files-o"></i></div></div>';
							content.find('.sj_pb_column .sj_pb_element ').each(function(){
								$(this).parent().find('.row').eq(0).prepend('<div class="<div class="sj_pb_relative col-md-12">'+config_element+'</div>');
							})
							$('.sj_build_data .sj_pb_row').each(function(){
								var html = $(this).html();
								if(html == '&nbsp;' || html == ''){
									var abcxyz = '<div class="row"><div class="sj_pb_column_row sj_pb_relative col-md-12">'+
														  '<div class="sj_pb_column_row_config sj_pb_absolute" style="display: none;"><div class="sj_pb_column_row_config_remove">'+
														  '<i class="fa fa-times"></i></div><div class="sj_pb_column_row_config_add_column">'+
														  '<i class="fa fa-plus-square-o"></i></div><div class="sj_pb_column_row_config_add_element">'+
														  '<i class="fa fa-plus-square"></i></div><div class="sj_pb_column_row_config_edit"><i class="fa fa-pencil-square-o"></i></div></div><div class="row"><div class="sj_pb_column_row_content  col-md-12">'+
														  '<div class="sj_pb_background"></div></div></div></div></div>';
									$(this).html(abcxyz);
								}
							})
							$('.sj_build_data .container-fluid').each(function(){
								if($(this).html() == '&nbsp;' || $(this).html() == ''){
									$(this).remove();
								}
							})
							$('.sj_build_data .sj_pb_column_row .sj_pb_column_row_config').each(function(){
								var html = '<div class="sj_pb_column_row_content  col-md-12"><div class="sj_pb_background"></div></div>';
								if($(this).next().html() == '&nbsp;' || $(this).next().html() == ''){
									$(this).next().html(html);
								}
							})
							$('.sj_build_data div').each(function(){
								if($(this).html() == '&nbsp;' || $(this).html() == ''){
									$(this).html('');
								}
							})
							
							$('.sj_pb_element').each(function(){
								var sc = $(this).html();
								var iframe = htmlEditElement(sc);
								$(this).html(iframe);
								sc = sc.replace(/\"/g,"\'");
								$(this).attr('data-shortcode',sc);
							})
							html = $('.sj_build_data').html();
							$('.sj_build_data').remove();
							wrap.html(html);
							
						})
					<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
				});
			//]]>
		</script>
		
		<?php
		$jq = ob_get_contents();
		ob_end_clean();
		return $jq;
	}
}
