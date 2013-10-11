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
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // ProductClasses
	'acquistoPClassAuktion'             => 'system/modules/acquistoShopPClassAuktion/modules/product/acquistoPClassAuktion.php',
	'ModuleAcquistoAddonAuction'        => 'system/modules/acquistoShopPClassAuktion/modules/ModuleAcquistoAddonAuction.php',
  'ModuleAcquistoAddonMyBiddings'     => 'system/modules/acquistoShopPClassAuktion/modules/ModuleAcquistoAddonMyBiddings.php',  
  'AcquistoAddonManipulateProduct'    => 'system/modules/acquistoShopPClassAuktion/classes/AcquistoAddonManipulateProduct.php'
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
