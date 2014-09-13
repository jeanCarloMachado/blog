

CREATE TABLE IF NOT EXISTS `ack_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(255) NOT NULL,
  `resposta` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL returned an empty result set (i.e. zero rows).


-- --------------------------------------------------------

--
-- Table structure for table `ack_faq_categorias`
--

CREATE TABLE IF NOT EXISTS `ack_faq_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;# MySQL returned an empty result set (i.e. zero rows).
