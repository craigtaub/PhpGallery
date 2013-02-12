<?php 
if(!$config || !$settings)
exit;

mysql_query("CREATE TABLE IF NOT EXISTS `".$config['prefix']."albums` (
  `album_id` int(11) NOT NULL auto_increment,
  `title` varchar(255) collate latin1_general_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL default '1',
  `pictures` int(11) NOT NULL,
  `image` varchar(255) collate latin1_general_ci NOT NULL,
  `sortorder` int(11) NOT NULL default '0',
  PRIMARY KEY  (`album_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;");



mysql_query("CREATE TABLE IF NOT EXISTS `".$config['prefix']."gallery` (
  `gallery_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `albums` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  PRIMARY KEY  (`gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");

mysql_query("CREATE TABLE IF NOT EXISTS `".$config['prefix']."pictures` (
  `picture_id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL default '0000-00-00 00:00:00',
  `date_updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `album_id` int(11) NOT NULL,
  `sortorder` int(11) NOT NULL default '0',
  PRIMARY KEY  (`picture_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `".$config['prefix']."setting` (
  `setting_id` int(11) NOT NULL auto_increment,
  `notes` varchar(255) collate utf8_unicode_ci NOT NULL,
  `flag` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `value` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;
");

mysql_query("INSERT INTO `".$config['prefix']."setting` (`setting_id`, `notes`, `flag`, `value`) VALUES
(1, 'Error Log File Name', 'config_error_filename', 'error.txt'),
(2, 'Log the Errors', 'config_error_log', '1'),
(3, 'Display The Errors', 'config_error_display', '0'),
(4, 'Enable Seo Urls', 'config_seo_url', '1'),
(5, 'Website Logo URL', 'config_logo', '/pictures/logo.jpg'),
(6, 'Template Folder Name <br> Note: Ending slash needed', 'config_template', 'default/'),
(7, 'Admin Email', 'config_email', 'admin@domain.com'),
(8, 'Memory limit (In MB)', 'config_memory_limit', '10'),
(9, 'Host Name : ', 'config_site_url', 'http://localhost/ajgallery'),
(10, 'Website Title', 'config_site_title', 'AjaxMint Gallery'),
(11, 'Description', 'config_site_description', 'descr'),
(12, 'Favicon', 'config_icon', '/pictures/favicon.ico'),
(13, 'Albums Per Page (In px)', 'albums_per_page', '12'),
(14, 'Pictures Per Page (In px)', 'pictures_per_page', '12'),
(15, 'Picture Thumbnail Width(In px)', 'config_thumb_width', '220'),
(16, 'Picture Thumbnail Height(In px)', 'config_thumb_height', '150'),
(17, 'Large Picture Width (In px)', 'config_large_width', '480'),
(18, 'Large Picture Height (In px)', 'config_large_height', '300'),
(19, 'Gallery Cover Thumbnail  Width (In px)', 'gallery_thumb_width', '300'),
(20, 'Gallery Cover Thumbnail  Height(In px)', 'gallery_thumb_height', '250'),
(21, 'Album Cover Thumb Width(In px)', 'album_thumb_width', '300'),
(22, 'Album Cover Thumb Height(In px)', 'album_thumb_height', '250');

");

mysql_query("CREATE TABLE IF NOT EXISTS `".$config['prefix']."user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `ip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;
");

mysql_query("INSERT INTO `".$config['prefix']."user` (`user_id`, `username`, `password`, `ip`, `status`, `last_login`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '127.0.0.1', 1, '2010-01-04 13:00:17');
");