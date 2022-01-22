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

use Joomla\CMS\Helper\ModuleHelper;
use EvangelischeTermine\Module\EvangelischeTermineListe\Site\Helper\GetListeHelper;

$liste = GetListeHelper::getListe($params);

require ModuleHelper::getLayoutPath('mod_etliste', $params->get('layout', 'default'));