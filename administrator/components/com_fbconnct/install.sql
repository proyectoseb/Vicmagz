

CREATE TABLE IF NOT EXISTS `#__facebook_joomla_connect` (
  `joomla_userid` int(15) NOT NULL,
  `facebook_userid` bigint(20) unsigned NOT NULL,
  `joined_date` int(15) NOT NULL,
  `linked` smallint(4) NOT NULL,
  PRIMARY KEY (`joomla_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;