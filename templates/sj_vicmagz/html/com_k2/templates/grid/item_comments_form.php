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

<h3><?php echo JText::_('K2_LEAVE_A_COMMENT') ?></h3>

<?php if($this->params->get('commentsFormNotes') && $this->params->get('commentsFormNotesText')): ?>
<p class="itemCommentsFormNotes">
	<?php if($this->params->get('commentsFormNotesText')): ?>
		<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
	<?php else: ?>
		<?php echo JText::_('K2_COMMENT_FORM_NOTES') ?>
	<?php endif; ?>
</p>
<?php endif; ?>

<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate">
	<div class="row">
	<div class="col-sm-4">

		<input class="inputbox " type="text" name="userName" id="us_erName" value="<?php echo JText::_('K2_NAME'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_NAME'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_NAME'); ?>') this.value='';" />
	</div>
	
	<div class="col-sm-4">
		<input class="inputbox me-inline" type="text" name="commentEmail" id="commentEmail" value="<?php echo JText::_('K2_EMAIL'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_EMAIL'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_EMAIL'); ?>') this.value='';" />
	</div>
	
	<div class="col-sm-4">

		<input class="inputbox me-inline" type="text" name="commentURL" id="commentURL" value="<?php echo JText::_('K2_WEBSITE_URL'); ?>"  onblur="if(this.value=='') this.value='<?php echo JText::_('K2_WEBSITE_URL'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_WEBSITE_URL'); ?>') this.value='';" />
	</div>
	
	<div class="col-sm-12">

		<textarea rows="20" cols="10" class="inputbox" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_COMMENT')."&#8230"; ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_COMMENT')."&#8230"; ?>') this.value='';" name="commentText" id="commentText"><?php echo JText::_('K2_COMMENT')."&#8230"; ?></textarea>
	</div>
	<div class="col-sm-12">
	<?php if($this->params->get('recaptcha') && ($this->user->guest || $this->params->get('recaptchaForRegistered', 1))): ?>
	<label class="formRecaptcha"><?php echo JText::_('K2_ENTER_THE_TWO_WORDS_YOU_SEE_BELOW'); ?></label>
	<div id="recaptcha"></div>
	<?php endif; ?>
	</div>
	<div class="col-sm-12">
	<input type="submit" class="button" id="submitCommentButton" value="<?php echo JText::_('K2_POST_COMMENT'); ?>" />
	</div>
	</div>
	<span id="formLog"></span>

	<input type="hidden" name="option" value="com_k2" />
	<input type="hidden" name="view" value="item" />
	<input type="hidden" name="task" value="comment" />
	<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
