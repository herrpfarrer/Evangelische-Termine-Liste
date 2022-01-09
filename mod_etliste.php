<?php
/**
 * Modul Evangelische Termine Liste
 * 
 */

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/Helper/GetListeHelper.php';
$liste = modETListeHelper::getListe($params);

// Modulklassen-Suffix
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_etliste');