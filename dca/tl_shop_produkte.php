<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

$this->loadLanguageFile('tl_acquisto_pclasses');

/**
 * Table tl_cds
 */
$GLOBALS['TL_DCA']['tl_shop_produkte']['palettes']['auktion'] = '{title},type,produktnummer,bezeichnung,alias,ean,template;{extended_options},steuer,zustand,hersteller,gewicht,tags,teaser,beschreibung;{grundpreis},mengeneinheit,inhalt,berechnungsmenge;{staffelpreise},preise;{groups:hide},warengruppen;{images:hide},preview_image,galerie;{auction_legend},auction_directly_buy,auction_price,auction_bidding;{state},marked,aktiv,startDate,endDate;';


$GLOBALS['TL_DCA']['tl_shop_produkte']['fields']['auction_price'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_shop_produkte']['auction_price'],
    'inputType'               => 'text',
    'default'                 => 0,
    'exclude'                 => true,
    'search'                  => true,
    'filter'                  => false,
   	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50'), 
		'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_shop_produkte']['fields']['auction_bidding'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_shop_produkte']['auction_bidding'],
    'inputType'               => 'text',
    'default'                 => 0,
    'exclude'                 => true,
    'search'                  => true,
    'filter'                  => false,
   	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50'), 
		'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_shop_produkte']['fields']['auction_directly_buy'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_shop_produkte']['auction_directly_buy'],
    'inputType'               => 'checkbox',
    'default'                 => 0,
    'exclude'                 => true,
    'search'                  => true,
    'filter'                  => false,
    'eval'                    => array('mandatory'=>false),
		'sql'                     => "char(1) NOT NULL default ''"
);

?>