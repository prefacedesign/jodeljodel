-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Mar 26, 2012 as 03:57 PM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `museu_main`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cork_corktiles`
--

CREATE TABLE IF NOT EXISTS `cork_corktiles` (
  `id` varchar(255) NOT NULL,
  `type` varchar(128) DEFAULT NULL,
  `content_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `instructions` text,
  `location` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`),
  KEY `k_type` (`type`),
  KEY `k_content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `text_text_corks`
--

CREATE TABLE IF NOT EXISTS `text_text_corks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;
