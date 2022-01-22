<?php 
/**
 * @package    Evangelische Termine Liste
 *
 * @author     Daniel Städtler - github_herrpfarrer@posteo.de
 * @copyright  Copyright 2022 Daniel Städtler. – All rights reserved.
 * @license    GNU General Public License version 3
 * @link       https://github.com/herrpfarrer/Evangelische-Termine-Liste
 */

// No direct access
defined('_JEXEC') or die; 

// CSS-Datei in Header der Joomla-Seite einfügen
JHtml::_('stylesheet', JUri::root() . 'media/mod_etliste/css/etliste.css');
echo $liste; ?>