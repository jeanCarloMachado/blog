-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 04, 2013 at 03:34 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elefran-2013-09-06`
--

-- --------------------------------------------------------

--
-- Table structure for table `ack_solicitacao_acesso`
--

CREATE TABLE IF NOT EXISTS `ack_solicitacao_acesso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(199) NOT NULL,
  `email` varchar(199) NOT NULL,
  `fone` varchar(199) NOT NULL,
  `acesso_garantido` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_id` int(11) DEFAULT NULL,
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `ack_solicitacao_acesso`
--

INSERT INTO `ack_solicitacao_acesso` (`id`, `nome`, `email`, `fone`, `acesso_garantido`, `usuario_id`, `visivel`, `status`) VALUES
(10, 'asdf', 'asdfasdfasdf@adf.com', '1234123413', 0, NULL, 1, 1),
(12, 'sadfasdf', 'asdfsadf@afsd.com', '2341234', 0, NULL, 1, 1),
(13, 'asdfasdf', 'asdfasdf@asdfas.com', '12341234', 0, NULL, 1, 1),
(14, 'mordo', 'mordo@asdf.com', '1234', 0, NULL, 1, 1),
(15, 'asdffsadfsad', 'asdfsad@asdfasd.com', '123412', 0, NULL, 1, 1),
(16, 'isengard', 'isengard@icub.com.br', '2134123123', 0, NULL, 1, 1),
(17, 'maria', 'maria@sadf.com', '12134213', 0, NULL, 1, 1),
(18, 'maria', 'mari11a@sadf.com', '12134213', 0, NULL, 1, 1),
(21, 'maria', 'mari11a@sadf.com1234', '12134213', 0, NULL, 1, 1),
(22, 'maria', 'm1ari11a@sadf.com12341212', '12134213', 0, NULL, 1, 1),
(23, 'maria', 'm1ari11a@sadf.141234132123', '12134213', 0, NULL, 1, 1),
(24, 'maria', 'm1ari11a@sadf.1412341321231234123', '12134213', 1, NULL, 1, 1),
(25, 'maria', 'm1ari11a@sadf.141234132123123412312', '12134213', 0, NULL, 1, 1),
(26, 'maria', 'm1ari11a@sadf.1412341321231234123121234123', '12134213', 0, NULL, 1, 1),
(27, 'maria', 'm1ari11a@sadf.14123413212312341231212341231234123', '12134213', 0, NULL, 1, 1),
(28, 'maria', 'm1ari11a@sadf.141234132123212341231212341231234123', '12134213', 0, NULL, 1, 1),
(29, 'maria', 'm1ari11a@sadf.1141234132123212341231212341231234123', '12134213', 0, NULL, 1, 1),
(30, 'maria', 'm1ari11a@sadf.11412342132123212341231212341231234123', '12134213', 0, NULL, 1, 1),
(31, 'maria123', 'm1ari11a@sadf.114123421321232123421231212341231234123', '12134213', 0, NULL, 1, 1),
(32, 'maria123', 'm1ari11a@sadf.1141234213212321234212312122341231234123', '12134213', 0, NULL, 1, 1),
(33, 'maria123', 'm1ari11a@sadf.11412342132123211234212312122341231234123', '12134213', 0, NULL, 1, 1),
(34, 'maria123', 'm1ari211a@sadf.114123421321', '12134213', 0, NULL, 1, 1),
(35, 'asdfasdf1234123 ', '2222222222@asdfas.com', '23', 1, NULL, 1, 1),
(36, 'gandalf@icub.com.br', 'gandalf@icub.com.br', '12134213', 1, NULL, 1, 1),
(37, 'sauron', 'sauron@icub.com.br', '21234', 1, NULL, 1, 1),
(38, 'ana@icub.com.brteodhen@icub.com.br', 'ana@icub.com.br', '2332123441233141234 123422 1234', 1, NULL, 1, 1),
(39, 'lizard', 'lizard@icub.com.br', '123456', 1, NULL, 1, 1),
(40, 'teste', 'teste3@icub.com.br', '1234566', 0, NULL, 1, 1),
(41, 'teste', 'teste@teste.com.br', '123456', 0, NULL, 1, 1),
(42, 'teste', 'teste5@icub.com.br', '123456', 0, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuarios`
--

CREATE TABLE IF NOT EXISTS `ack_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(199) NOT NULL,
  `nome_tratamento` varchar(199) NOT NULL,
  `email` varchar(199) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cnpj` varchar(50) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL,
  `primeira_senha` set('0','1') NOT NULL DEFAULT '1',
  `ultimo_acesso` datetime DEFAULT NULL,
  `dt_inc` datetime NOT NULL,
  `main_group_id` int(11) NOT NULL DEFAULT '4',
  `acessoack` set('0','1') NOT NULL DEFAULT '0',
  `acessofront` tinyint(1) NOT NULL DEFAULT '0',
  `status` set('0','1','9') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Cadastro de Usuários do ACK' AUTO_INCREMENT=88 ;

--
-- Dumping data for table `ack_usuarios`
--

INSERT INTO `ack_usuarios` (`id`, `nome`, `nome_tratamento`, `email`, `senha`, `cnpj`, `endereco`, `telefone`, `fax`, `responsavel`, `primeira_senha`, `ultimo_acesso`, `dt_inc`, `main_group_id`, `acessoack`, `acessofront`, `status`) VALUES
(1, 'root', 'root', 'root', '30c711433f3e36aace54abfc6a874e4f', '', '', '', '', 'responsavel 34235243', '0', '2013-10-04 15:04:33', '2013-05-28 23:38:51', 1, '1', 1, '1'),
(32, 'Jean Carlo Machado', 'Jean', 'jean@icub.com.br', 'c68561981d90a860ecc80f908770ea56', '', 'Rua Pedro Guerra, 412, Ponte Seca', '(54) 9643-7384', '', NULL, '0', '2013-10-04 13:18:52', '2013-06-12 09:37:51', 1, '1', 1, '1'),
(84, 'Elefran - Eletro Peças Ltda.', 'Elefran', 'pedro_jhuji@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', NULL, '1', NULL, '2013-10-01 16:23:25', 4, '0', 0, '1'),
(85, 'Airton Júnior', 'Tonton', 'airton@icub.com.br', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', NULL, '1', '2013-10-02 09:34:19', '2013-10-01 16:32:43', 4, '1', 0, '1'),
(86, 'teste', 'teste', 'teste@icub.com.br', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', NULL, '0', '2013-10-02 11:57:22', '2013-10-01 16:34:27', 4, '1', 1, '1'),
(87, 'teste2', 'teste2', 'teste2@icub.com.br', 'e10adc3949ba59abbe56e057f20f883e', '123456', '', '', '', NULL, '1', NULL, '2013-10-01 16:36:54', 4, '0', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuarios_grupos`
--

CREATE TABLE IF NOT EXISTS `ack_usuarios_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(199) NOT NULL,
  `descricao_pt` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL,
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='grupos de usuários no banco tabela real (não relacao)' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ack_usuarios_grupos`
--

INSERT INTO `ack_usuarios_grupos` (`id`, `nome`, `descricao_pt`, `ordem`, `visivel`, `status`) VALUES
(1, 'Admin', 'Administrador do sistema, em geral pode fazer tudo que os usuário normais podem, além de acesar páginas exclusivas à ele.', 1, 1, 1),
(2, 'Empresa', 'Empresas no sistema, este grupo fornece usuários contatenados, etc', 2, 1, 0),
(3, 'Funcionário de empresa', 'este usuário quando tem sua empresa deletada também é deletado.', 3, 1, 0),
(4, 'Usuário do Ack', 'Um usuário do ack tem a visualização padrão do sistema sem receber filtros (este usuário vem por default se nenhum outro grupo vier passado).', 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuarios_grupos_hierarquia`
--

CREATE TABLE IF NOT EXISTS `ack_usuarios_grupos_hierarquia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `slave_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ack_usuarios_grupos_hierarquia`
--

INSERT INTO `ack_usuarios_grupos_hierarquia` (`id`, `master_id`, `slave_id`) VALUES
(8, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuarios_grupos_permissoes`
--

CREATE TABLE IF NOT EXISTS `ack_usuarios_grupos_permissoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuarios_hierarquia`
--

CREATE TABLE IF NOT EXISTS `ack_usuarios_hierarquia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `slave_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ack_usuario_grupo`
--

CREATE TABLE IF NOT EXISTS `ack_usuario_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabela de relação entre os grupos de usuários e os usuários' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ack_usuario_grupo`
--

INSERT INTO `ack_usuario_grupo` (`id`, `grupo_id`, `usuario_id`) VALUES
(1, 1, 1),
(3, 2, 76),
(4, 3, 78);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
