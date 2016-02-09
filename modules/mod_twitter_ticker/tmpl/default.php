<?php
/*------------------------------------------------------------------------
# Twitter Ticker - Version 1.0
# Copyright (C) 2009-2010 YouTechClub.Com. All Rights Reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: YouTechClub.Com
# Websites: http://www.youtechclub.com
-------------------------------------------------------------------------*/
$strTweets = '';
if ($tweetUsers != '') {
	$tweets = explode(',', $tweetUsers);
	if (sizeof($tweets) > 0) {
		for ($i = 0; $i < sizeof($tweets); $i++) {
			if ($i == 0) {
				$strTweets .= "'" . $tweets[$i] . "'";
			} else {
				$strTweets .= ",'" . $tweets[$i] . "'";
			}
		}		
	}
	
}

?>
<script language="javascript">
var tweetUsers = [<?php echo $strTweets?>];
var buildString = "";

JTT(document).ready(function(){

	JTT('#twitter-ticker').slideDown('slow');
	
	for(var i=0;i<tweetUsers.length;i++)
	{
		if(i!=0) buildString+='+OR+';
		buildString+='from:'+tweetUsers[i];
	}
	
	var fileref = document.createElement('script');
	
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", "http://search.twitter.com/search.json?q="+buildString+"&callback=TweetTick&rpp=50");
	
	document.getElementsByTagName("head")[0].appendChild(fileref);
	
});

function TweetTick(ob)
{
	var container=JTT('#tweet-container');
	container.html('');
	
	JTT(ob.results).each(function(el){
	
		var str = '	<div class="tweet">\
					<div class="avatar"><a href="http://twitter.com/'+this.from_user+'" target="_blank"><img src="'+this.profile_image_url+'" alt="'+this.from_user+'" /></a></div>\
					<div class="user"><a href="http://twitter.com/'+this.from_user+'" target="_blank">'+this.from_user+'</a></div>\
					<div class="time">'+relativeTime(this.created_at)+'</div>\
					<div class="txt">'+formatTwitString(this.text)+'</div>\
					</div>';
		
		container.append(str);
	
	});
	
	container.jScrollPane();
}

function formatTwitString(str)
{
	str=' '+str;
	str = str.replace(/((ftp|https?):\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?)/gm,'<a href="$1" target="_blank">$1</a>');
	str = str.replace(/([^\w])\@([\w\-]+)/gm,'$1@<a href="http://twitter.com/$2" target="_blank">$2</a>');
	str = str.replace(/([^\w])\#([\w\-]+)/gm,'$1<a href="http://twitter.com/search?q=%23$2" target="_blank">#$2</a>');
	return str;
}

function relativeTime(pastTime)
{	
	var origStamp = Date.parse(pastTime);
	var curDate = new Date();
	var currentStamp = curDate.getTime();
	
	var difference = parseInt((currentStamp - origStamp)/1000);

	if(difference < 0) return false;

	if(difference <= 5)				return "Just now";
	if(difference <= 20)			return "Seconds ago";
	if(difference <= 60)			return "A minute ago";
	if(difference < 3600)			return parseInt(difference/60)+" minutes ago";
	if(difference <= 1.5*3600) 		return "One hour ago";
	if(difference < 23.5*3600)		return Math.round(difference/3600)+" hours ago";
	if(difference < 1.5*24*3600)	return "One day ago";
	
	var dateArr = pastTime.split(' ');
	return dateArr[4].replace(/\:\d+$/,'')+' '+dateArr[2]+' '+dateArr[1]+(dateArr[3]!=curDate.getFullYear()?' '+dateArr[3]:'');
}

</script>

<div id="twitter-ticker" class="twitter-ticker" style="width:<?php echo $module_width?>px;height:<?php echo $module_height?>px">
  <div id="top-bar">
    <div id="twitIcon"><img src="<?php echo JURI::base()?>modules/mod_twitter_ticker/assets/twitter_64.png" width="64" height="64" alt="Twitter icon" /></div>
    <h2 class="tut"><?php echo $tweet_title;?></h2>
  </div>
  <div id="tweet-container" style="height:<?php echo $module_height - 70?>px"><img id="loading" src="<?php echo JURI::base()?>modules/mod_twitter_ticker/assets/loading.gif" width="16" height="11" alt="Loading.." /></div>
  <div id="scroll"></div>
</div>
