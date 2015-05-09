
CREATE TABLE IF NOT EXISTS `ack_usuario_configuracao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `main_menu_cache` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
