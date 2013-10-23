<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package AcquistoShop
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the namespaces
 */
 
ClassLoader::addNamespaces(array
(
	'AcquistoShop\Addon',
)); 

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // ProductClasses
	'AcquistoShop\Product\acquistoPClassAuktion'              => 'system/modules/acquistoShopPClassAuction/modules/product/acquistoPClassAuktion.php',
	'AcquistoShop\Frontend\ModuleAcquistoAddonAuction'        => 'system/modules/acquistoShopPClassAuction/modules/ModuleAcquistoAddonAuction.php',
	'AcquistoShop\Frontend\ModuleAcquistoAddonMyBiddings'     => 'system/modules/acquistoShopPClassAuction/modules/ModuleAcquistoAddonMyBiddings.php',  
  'AcquistoShop\Addon\AcquistoAddonManipulateProduct'       => 'system/modules/acquistoShopPClassAuction/classes/AcquistoAddonManipulateProduct.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_acquistoaddon_auction'          => 'system/modules/acquistoShopPClassAuktion/templates/modules',
	'mod_acquistoaddon_mybiddings'       => 'system/modules/acquistoShopPClassAuktion/templates/modules'
));

?>
