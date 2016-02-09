<?php
/**
 * @package Sj Contact Ajax
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;

$tag_id = 'contact_ajax'.time().rand();
JHtml::stylesheet('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_contact_ajax/css/styles.css');
JHtml::stylesheet('modules/'.$module->module.'/assets/css/font-awesome.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
JHtml::script('modules/'.$module->module.'/assets/js/bootstrap-tooltip.js');

?>


<?php if($params->get('maps_display') == 1) { ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
     function showLatLgn() {
		var geocoder = new google.maps.Geocoder();
		var sLat = "<?php echo $params->get('sLat'); ?>";
		var sLong = "<?php echo $params->get('sLong'); ?>";
		
		var latlng = new google.maps.LatLng(sLat, sLong);
		
		geocoder.geocode({"latLng":latlng},function(data,status){
			if(status == google.maps.GeocoderStatus.OK){
				var add = data[1].formatted_address; //this is the full address
				var myOptions = {
				  zoom: <?php echo $params->get('map_zoom'); ?>,
				  center: latlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
				var marker = new google.maps.Marker({
				  map: map,
				  position: latlng
				});
				marker.setTitle('Address');
				attachSecretMessage(marker, add);
			}else {
			try {
			  alert("Address not found");
			} catch(e) {}
		  }
		 
		})
    }
	
	function attachSecretMessage(marker, message) {
		var infowindow = new google.maps.InfoWindow(
			{ content: message
			});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(marker.get('map'),marker);
		});
	}
	
	function showLocation(){
		var address = '<?php echo $params->get('address_text','Hanoi, Viet nam'); ?>';
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { "address": address }, function(results, status) {
		  // If the Geocoding was successful
		  if (status == google.maps.GeocoderStatus.OK) {
			var myOptions = {
			  zoom: <?php echo $params->get('map_zoom'); ?>,scrollwheel:0,
			  center: results[0].geometry.location,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

			// Add a marker at the address.
			var marker = new google.maps.Marker({
			  map: map,
			  position: results[0].geometry.location
			});
			marker.setTitle('Address');
			attachSecretMessage(marker, address);
		  } else {
			try {
			  alert(address + " not found");
			} catch(e) {}
		  }
		});
	}

	<?php if($params->get('select_type') == 0){ ?> 
		google.maps.event.addDomListener(window, 'load', showLocation);
	<?php } else { ?>
		google.maps.event.addDomListener(window, 'load', showLatLgn);
	<?php } ?>
</script>
<?php } ?>	

<?php
	$uri=JURI::getInstance();
	$uri->setVar('contact_ajax', rand(100000,999999).time());
	$uri->setVar('ctajax_modid',$module->id);

 ?>		

<!--[if lt IE 9]><div class="contact-ajax contact-default msie lt-ie9" id="<?php echo $tag_id; ?>" ><![endif]--> 
<!--[if IE 9]><div class="contact-ajax contact-default msie" id="<?php echo $tag_id; ?>" ><![endif]-->
<!--[if gt IE 9]><!--><div class="contact-ajax contact-default" id="<?php echo $tag_id; ?>" ><!--<![endif]--> 
	<div class="ctajax-wrap">
		<div class="container">
				<div class="row">
				<div class="ctajax-element contact-information col-md-6 col-sm-6">
					<div class="el-inner">
						<h2 class="el-heading"><span><?php echo JText::_('AJAX_CONTACT_INFORMATION');?></span></h2>
						<?php 
						$desc = trim($list->misc);
						if($desc != '' ) ?>	
						<div class="el-desc">
							<?php echo $desc; ?>
						</div>
						<div class="el-info-contact">
							<div class="row">
								<?php $address = trim($list->address);
								if($address != '') {
								?>
								<div class="info-address col-md-12 cf">
									<div class="info-label">
										<h5><?php echo JText::_('ADD_LABEL') ?></h5>
										<span><?php echo $address; ?></span>
									</div>
								</div>
								<?php }
								
								$mail_to = trim($list->email_to);
								if($mail_to != '' ){
								?>
								<div class="info-mail col-md-5 cf">
									<div class="info-label">
										<h5><?php echo JText::_('MAIL_LABEL') ?></h5>
										<a href="mailto:<?php echo $mail_to; ?>"><?php echo $mail_to; ?></a>
									</div>
									
								</div>
								<?php }
								//var_dump($list);
								$telephone = trim($list->telephone);
								if($telephone != '' ){		
								?>
								<div class="info-telephone col-md-5 cf">
									<div class="info-label">
										<h5><?php echo JText::_('PHONE_LABEL') ?></h5>
										<span><?php echo $telephone; ?></span>
									</div>
								</div>
								<?php }
								
								$mobile = trim($list->mobile);
								if($mobile != '' ){		
								?>
								<div class="info-mobie col-md-5 cf">
									<div class="info-label">
										<h5><?php echo JText::_('TEL_LABEL') ?></h5>
										<span><?php echo $mobile; ?></span>
									</div>
								</div>
								
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="ctajax-element contact-form col-md-6 col-sm-6">
					<div class="el-inner cf">
						<div class="el-form cf">
							<h2 class="el-heading"><span><?php echo JText::_('AJAX_CONTACT_DROP_US_LINE');?></span></h2>
							<form class="el-ctajax-form" id="el_ctajax_form" method="post" action="">
								<div class="row">
									<div class="el-control col-sm-6">
										<label for="name"><?php echo JText::_('NAME_LABEL_CONTACT');?></label>
										<input type="text" autocomplete="off"  name="cainput_name" class="el-input" id="cainput_name" placeholder="<?php echo JText::_('NAME_LABEL_CONTACT');?>">
										<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('NAME_ERROR'); ?>">
											<i class="icon-exclamation-sign el-error"></i>
										</span>
										<i class="icon-ok-sign el-ok"></i>
									</div>
									<div class="el-control col-sm-6">
										<label for="email"><?php echo JText::_('EMAIL_LABEL_CONTACT');?></label>
										<input autocomplete="off" type="text"  name="cainput_email" class="el-input" id="cainput_email" placeholder="<?php echo JText::_('EMAIL_LABEL_CONTACT');?>">
										<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('EMAIL_ERROR'); ?>">
											<i class="icon-exclamation-sign el-error"></i>
										</span>
										<i class="icon-ok-sign el-ok"></i>
									</div>
									<div class="el-control col-sm-12">
										<label for="subject"><?php echo JText::_('SUBJECT_CONTACT');?></label>
										<input type="text" autocomplete="off"  name="cainput_subject" class="el-input" id="cainput_subject" placeholder="<?php echo JText::_('SUBJECT_CONTACT');?>">
										<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('SUBJECT_ERROR'); ?>">
											<i class="icon-exclamation-sign el-error"></i>
										</span>	
										<i class="icon-ok-sign el-ok"></i>
									</div>
									<div class="el-control col-sm-12">	
										<label for="message"><?php echo JText::_('MESSAGE_LABEL_CONTACT');?></label>
										<textarea name="cainput_message" maxlength="1000" class="el-input" id="cainput_message" placeholder="<?php echo JText::_('MESSAGE_LABEL_CONTACT');?>"></textarea>
										<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('MESSAGE_ERROR'); ?>">	
											<i class="icon-exclamation-sign el-error"></i>
										</span>	
										<i class="icon-ok-sign el-ok"></i>
									</div>
									<?php 
									if($captcha_dis == 1) { 
										if($captcha_disable == 1 && $user->id != 0 ){
										}else{
											if($captcha_type == 1){?>
												<div class="el-control captcha-form col-sm-12">	
													<?php  JFactory::getApplication()->triggerEvent('showCaptcha', array($module->id)); ?>
												</div>
												<div class="el-control col-sm-12">
													<label for="subject"><?php echo JText::_('CAPTCHA_LABEL');?></label>
													<input type="text" name="cainput_captcha" maxlength="6" class="el-input" id="cainput_captcha" placeholder="<?php echo JText::_('CAPTCHA_LABEL');?>">
													<i class="icon-spinner  icon-large icon-spin el-captcha-loadding"></i>
													<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('CAPTCHA_ERROR'); ?>">
														<i class="icon-exclamation-sign el-error"></i>
													</span>	
													<i class="icon-ok-sign el-ok"></i>
												</div>
											<?php } else {  ?>
												<div class="el-control col-sm-12">
													<?php 
													JPluginHelper::importPlugin('captcha');
													$dispatcher = JDispatcher::getInstance();
													$dispatcher->trigger('onInit','dynamic_recaptcha_1');
													?>
													<div id="dynamic_recaptcha_1"></div>
													<span class="ca-tooltip" title=""  data-toggle="tooltip" href="#" data-original-title="<?php echo JText::_('CAPTCHA_ERROR'); ?>">
														<i class="icon-exclamation-sign el-error"></i>
													</span>	
													<i class="icon-ok-sign el-ok"></i>
												</div>
											<?php } 
										}
									}  
									?>
									<?php if($params->get('email_copy_dis') == 1) { ?>
									<div class="el-control col-sm-12">
										<input type="checkbox" value="" id="contact_email_copy" name="contact_email_copy">
										<label title="" class="el-label-email-copy" for="contact_email_copy" ><?php echo JText::_('SEND_MAIL_COPY'); ?></label>
									</div>
									<?php } ?>	
									<div class="el-control el-submit col-sm-12">
										<input type="submit"  value="<?php echo JText::_('SEND_MAIL_LABEL_CONTACT'); ?>"  id="cainput_submit" class="headingsFont">
										<span class="el-ctajax-loadding"></span>
										<span class="el-ctajax-return return-error">
											<i class="icon-exclamation-sign icon-large">&nbsp;&nbsp;<?php echo JText::_('MAIL_IS_NOT_SENT'); ?></i>
										</span>
										<span class="el-ctajax-return return-success">
											<i class="icon-ok-circle icon-large">&nbsp;&nbsp;<?php echo JText::_('MAIL_IS_SENT'); ?></i>
										</span>
									</div>
								</div>
							</form>
						</div>
						<?php if($params->get('twitter_dis') == 1 ||
							$params->get('facebook_dis') == 1 ||
							$params->get('rss_dis') == 1 ||
							$params->get('linkedin_dis') == 1 ||
							$params->get('google_plus_dis') == 1
						){ ?>
						<div class="social-networks">
							<?php 
							//var_dump($params);
							if($params->get('twitter_dis') == 1 && $params->get('twitter_text') != '') { ?>
								<a title="<?php echo JText::_('TWITTER_LABEL'); ?>" target="blank" href="<?php echo $params->get('twitter_text'); ?>" class="network"><i class="icon-twitter"></i></a>
							<?php }
							if($params->get('facebook_dis') == 1 && $params->get('facebook_text') != '') { ?>
								<a title="<?php echo JText::_('FACEBOOK_LABEL'); ?>" target="blank" href="<?php echo $params->get('facebook_text'); ?>" class="network"><i class="icon-facebook"></i></a>
							<?php } 
							if($params->get('rss_dis') == 1 && $params->get('rss_text') != '') { ?>
								<a title="<?php echo JText::_('RSS_LABEL'); ?>" target="blank" href="<?php echo $params->get('rss_text')?>" class="network"><i class="icon-rss"></i></a>
							<?php } 
							if($params->get('linkedin_dis') == 1 && $params->get('linkedin_text') != '') { ?>
								<a title="<?php echo JText::_('LINKEDIN_LABEL'); ?>" target="blank"  href="<?php  echo $params->get('linkedin_text'); ?>" class="network"><i class="icon-linkedin"></i></a>
							<?php } 
							if($params->get('google_plus_dis') == 1 && $params->get('google_plus_text') != '') { ?>
								<a title ="<?php echo JText::_('GOOGLE_PLUS_LABEL'); ?>" target="blank"  href="<?php echo $params->get('google_plus_text'); ?>" class="network"><i class="icon-google-plus"></i></a>
							<?php } ?>
						</div>
						<?php };?>
					 <!--<span class="el-aircaft"></span>-->
					</div>
				</div>
			</div>
		</div>
		<?php if($params->get('maps_display') == 1) { ?>
		<div class="el-map">
			<div id="map-canvas" style="height:<?php echo $params->get('map_height')?>px; width:<?php echo $params->get('map_width')?>px;"></div>
			
			<div class="controlMaps headingsFont">
				<div class="closedMaps">
					<i class="fa fa-long-arrow-up"></i><span class="closedmp"><?php echo JText::_("Closed Maps");?></span>
				</div>
				<div class="openMaps">
					<i class="fa fa-long-arrow-down"></i><span class="closedmp"><?php echo JText::_("Open Maps");?></span>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
