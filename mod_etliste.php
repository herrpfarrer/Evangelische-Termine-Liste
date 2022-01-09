<?php
/**
 * Modul Evangelische Termine Liste
 * 
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use EvangelischeTermine\Module\EvangelischeTermineListe\Site\Helper\GetListeHelper;

$liste = GetListeHelper::getListe($params);

require ModuleHelper::getLayoutPath('mod_etliste', $params->get('layout', 'default'));