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

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$liste = modETListeHelper::getListe($params);

// Modulklassen-Suffix
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_etliste');