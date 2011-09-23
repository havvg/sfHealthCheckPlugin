<?php

require_once dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php';

// initialize configuration
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));