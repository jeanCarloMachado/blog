<?php

/**
 * ###################################################################################
 * Este aruivo irá conter um script de instlação ara o módulo ainda não implementado
 *###################################################################################
 * @author Jean Carlo Machado <j34nc4rl0@gmail.com>
 */


ALTER TABLE `ack_conteudos_controllers` ADD INDEX ( `controller` ) ;

-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2013 at 02:16 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elefran-2013-08-05`
--

-- --------------------------------------------------------

--
-- Table structure for table `ack_conteudos_controllers`
--

CREATE TABLE IF NOT EXISTS `ack_conteudos_controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conteudo_id` int(11) NOT NULL,
  `controller` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ack_conteudos_controllers_ack_conteudos_idx` (`conteudo_id`),
  KEY `controller` (`controller`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=381 ;

--
-- Dumping data for table `ack_conteudos_controllers`
--

INSERT INTO `ack_conteudos_controllers` (`id`, `conteudo_id`, `controller`) VALUES
(3, 2, '\\Elefran\\Controller\\ProdutosController'),
(5, 3, '\\Elefran\\Controller\\IndexController'),
(6, 4, '\\Elefran\\Controller\\IndexController'),
(7, 4, '\\Elefran\\Controller\\ContatosController'),
(8, 4, '\\Elefran\\Controller\\InstitucionalController'),
(9, 4, '\\Elefran\\Controller\\OrcamentosController'),
(10, 4, '\\Elefran\\Controller\\PedidosController'),
(11, 4, '\\Elefran\\Controller\\ProdutosController'),
(12, 4, '\\Elefran\\Controller\\ServicosController'),
(13, 4, '\\Elefran\\Controller\\UsuariosController'),
(15, 5, '\\Elefran\\Controller\\OrcamentosController'),
(16, 6, '\\Elefran\\Controller\\OrcamentosController'),
(17, 7, '\\Elefran\\Controller\\OrcamentosController'),
(18, 8, '\\AckContent\\Controller\\InstitucionalController'),
(21, 9, '\\AckContent\\Controller\\InstitucionalController'),
(23, 10, '\\AckContent\\Controller\\InstitucionalController'),
(24, 11, '\\AckContent\\Controller\\InstitucionalController'),
(38, 17, '\\AckCore\\Controller\\DashboardController'),
(39, 18, '\\AckProducts\\Controller\\ServicosController'),
(40, 19, '\\AckProducts\\Controller\\ServicosController'),
(43, 16, '\\AckContent\\Controller\\InstitucionalController'),
(44, 16, '\\AckProducts\\Controller\\ServicosController'),
(45, 15, '\\AckContent\\Controller\\InstitucionalController'),
(46, 15, '\\AckProducts\\Controller\\ServicosController'),
(47, 13, '\\AckContent\\Controller\\InstitucionalController'),
(48, 13, '\\AckProducts\\Controller\\ServicosController'),
(54, 20, '\\AckProducts\\Controller\\ServicosController'),
(55, 21, '\\AckProducts\\Controller\\ServicosController'),
(58, 22, '\\AckContent\\Controller\\TextosController'),
(59, 23, '\\AckContact\\Controller\\ContatosController'),
(62, 25, '\\AckContact\\Controller\\ContatosController'),
(65, 26, '\\AckContact\\Controller\\ContatosController'),
(67, 28, '\\AckLocale\\Controller\\EnderecosController'),
(68, 29, '\\AckLocale\\Controller\\EnderecosController'),
(71, 24, '\\AckContact\\Controller\\ContatosController'),
(72, 30, '\\AckLocale\\Controller\\EnderecosController'),
(73, 31, '\\AckContact\\Controller\\CurriculosController'),
(76, 32, '\\AckContact\\Controller\\CurriculosController'),
(79, 33, '\\AckContact\\Controller\\CurriculosController'),
(80, 34, '\\AckContact\\Controller\\CurriculosController'),
(83, 36, '\\AckContent\\Controller\\ConteudosController'),
(87, 38, '\\AckContent\\Controller\\ConteudosController'),
(89, 39, '\\AckCore\\Controller\\ModulosController'),
(90, 40, '\\AckCore\\Controller\\ModulosController'),
(95, 42, '\\AckCore\\Controller\\ModulosController'),
(97, 43, '\\AckCore\\Controller\\ModulosController'),
(99, 44, '\\AckCore\\Controller\\ModulosController'),
(101, 41, '\\AckCore\\Controller\\ModulosController'),
(104, 46, '\\Elefran\\Controller\\ProdutosController'),
(108, 47, '\\Elefran\\Controller\\ProdutosController'),
(132, 50, '\\Elefran\\Controller\\ProdutosController'),
(133, 51, '\\Elefran\\Controller\\ProdutosController'),
(134, 52, '\\Elefran\\Controller\\ProdutosController'),
(135, 53, '\\Elefran\\Controller\\ProdutosController'),
(137, 54, '\\Elefran\\Controller\\ProdutosController'),
(139, 55, '\\Elefran\\Controller\\ProdutosController'),
(141, 45, '\\Elefran\\Controller\\ProdutosController'),
(142, 48, '\\Elefran\\Controller\\ProdutosController'),
(144, 56, '\\AckProducts\\Controller\\CategoriasdeprodutosController'),
(146, 57, '\\AckProducts\\Controller\\CategoriasdeprodutosController'),
(149, 59, '\\AckProducts\\Controller\\CategoriasdeprodutosController'),
(150, 58, '\\AckProducts\\Controller\\CategoriasdeprodutosController'),
(154, 60, '\\AckCore\\Controller\\DashboardController'),
(155, 61, '\\Elefran\\Controller\\MarcasController'),
(156, 62, '\\Elefran\\Controller\\MarcasController'),
(158, 64, '\\Elefran\\Controller\\MarcasController'),
(161, 65, '\\Elefran\\Controller\\ModelosController'),
(162, 66, '\\Elefran\\Controller\\ModelosController'),
(165, 68, '\\Elefran\\Controller\\ModelosController'),
(168, 63, '\\Elefran\\Controller\\MarcasController'),
(169, 67, '\\Elefran\\Controller\\ModelosController'),
(171, 69, '\\Elefran\\Controller\\VeiculosController'),
(172, 70, '\\Elefran\\Controller\\VeiculosController'),
(173, 37, '\\AckContent\\Controller\\ConteudosController'),
(174, 71, '\\Elefran\\Controller\\VeiculosController'),
(175, 72, '\\Elefran\\Controller\\VeiculosController'),
(176, 73, '\\AckSales\\Controller\\OrcamentosController'),
(179, 75, '\\AckSales\\Controller\\OrcamentosController'),
(181, 76, '\\AckSales\\Controller\\OrcamentosController'),
(183, 77, '\\AckSales\\Controller\\OrcamentosController'),
(185, 78, '\\AckProducts\\Controller\\CategoriasdeprodutosController'),
(187, 49, '\\Elefran\\Controller\\ProdutosController'),
(188, 79, '\\AckContent\\Controller\\DestaquesController'),
(189, 80, '\\AckContent\\Controller\\DestaquesController'),
(190, 12, '\\AckContent\\Controller\\InstitucionalController'),
(191, 12, '\\Elefran\\Controller\\ProdutosController'),
(192, 12, '\\AckProducts\\Controller\\ServicosController'),
(193, 12, '\\AckContent\\Controller\\DestaquesController'),
(194, 14, '\\AckContent\\Controller\\InstitucionalController'),
(195, 14, '\\Elefran\\Controller\\ProdutosController'),
(196, 14, '\\AckProducts\\Controller\\ServicosController'),
(197, 14, '\\AckContent\\Controller\\DestaquesController'),
(198, 14, '\\Elefran\\Controller\\ProdutosController'),
(200, 81, '\\AckContent\\Controller\\DestaquesController'),
(201, 35, '\\AckContent\\Controller\\ConteudosController'),
(202, 82, '\\AckContent\\Controller\\DestaquesController'),
(204, 27, '\\AckLocale\\Controller\\EnderecosController'),
(205, 74, '\\AckSales\\Controller\\OrcamentosController'),
(210, 83, '\\AckContact\\Controller\\CurriculosController'),
(211, 84, '\\AckSales\\Controller\\StatusorcamentosController'),
(212, 85, '\\AckSales\\Controller\\StatusorcamentosController'),
(216, 86, '\\AckSales\\Controller\\StatusorcamentosController'),
(217, 86, '\\AckSales\\Controller\\StatusorcamentosController'),
(218, 87, '\\AckSales\\Controller\\StatusorcamentosController'),
(219, 88, '\\AckContent\\Controller\\TextosController'),
(220, 89, '\\AckUsers\\Controller\\UsuariosController'),
(221, 90, '\\AckUsers\\Controller\\UsuariosController'),
(224, 91, '\\AckUsers\\Controller\\UsuariosController'),
(225, 92, '\\AckUsers\\Controller\\UsuariosController'),
(226, 93, '\\AckUsers\\Controller\\UsuariosController'),
(232, 97, '\\AckCore\\Controller\\DadosGeraisController'),
(233, 96, '\\AckCore\\Controller\\DadosGeraisController'),
(234, 95, '\\AckCore\\Controller\\DadosGeraisController'),
(235, 94, '\\AckCore\\Controller\\DadosGeraisController'),
(238, 99, '\\AckContent\\Controller\\TextosController'),
(239, 99, '\\AckContent\\Controller\\TextosController'),
(276, 101, '\\AckContent\\Controller\\TextosController'),
(277, 101, '\\AckContent\\Controller\\TextosController'),
(289, 102, '\\AckContent\\Controller\\TextosController'),
(290, 102, '\\AckContent\\Controller\\TextosController'),
(291, 103, '\\AckCore\\Controller\\LogsController'),
(292, 104, '\\AckCore\\Controller\\LogsController'),
(293, 105, '\\AckCore\\Controller\\LogsController'),
(294, 106, '\\AckCore\\Controller\\LogsController'),
(309, 98, '\\AckContent\\Controller\\TextosController'),
(310, 98, '\\AckContent\\Controller\\TextosController'),
(315, 100, '\\AckContent\\Controller\\TextosController'),
(316, 100, '\\AckContent\\Controller\\TextosController'),
(318, 107, '\\AckContent\\Controller\\TextosController'),
(319, 107, '\\AckContent\\Controller\\TextosController'),
(338, 108, '\\AckContent\\Controller\\TextosController'),
(339, 108, '\\AckContent\\Controller\\TextosController'),
(350, 115, '\\AckContent\\Controller\\TextosController'),
(351, 115, '\\AckContent\\Controller\\TextosController'),
(352, 114, '\\AckContent\\Controller\\TextosController'),
(353, 114, '\\AckContent\\Controller\\TextosController'),
(354, 112, '\\AckContent\\Controller\\TextosController'),
(355, 112, '\\AckContent\\Controller\\TextosController'),
(356, 109, '\\AckContent\\Controller\\TextosController'),
(357, 109, '\\AckContent\\Controller\\TextosController'),
(358, 110, '\\AckContent\\Controller\\TextosController'),
(359, 110, '\\AckContent\\Controller\\TextosController'),
(360, 111, '\\AckContent\\Controller\\TextosController'),
(361, 111, '\\AckContent\\Controller\\TextosController'),
(362, 113, '\\AckContent\\Controller\\TextosController'),
(363, 113, '\\AckContent\\Controller\\TextosController'),
(364, 116, '\\AckContent\\Controller\\TextosController'),
(366, 117, '\\AckContent\\Controller\\TextosController'),
(367, 117, '\\AckContent\\Controller\\TextosController'),
(368, 118, '\\AckContent\\Controller\\TextosController'),
(369, 119, '\\AckContent\\Controller\\TextosController'),
(370, 120, '\\AckContent\\Controller\\TextosController'),
(371, 121, '\\AckContent\\Controller\\TextosController'),
(372, 122, '\\AckContent\\Controller\\TextosController'),
(376, 123, '\\AckContent\\Controller\\TextosController'),
(377, 123, '\\AckContent\\Controller\\TextosController'),
(379, 124, '\\AckContent\\Controller\\TextosController'),
(380, 124, '\\AckContent\\Controller\\TextosController');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ack_conteudos_controllers`
--
ALTER TABLE `ack_conteudos_controllers`
  ADD CONSTRAINT `fk_ack_conteudos_controllers_ack_conteudos` FOREIGN KEY (`conteudo_id`) REFERENCES `ack_conteudos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;