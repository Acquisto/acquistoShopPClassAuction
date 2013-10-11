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


/**
 * Table tl_cds
 */
$GLOBALS['TL_DCA']['tl_shop_produkte_bidding'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_shop_produkte',
        'enableVersioning'            => false,
        'switchToEdit'                => true,
        'closed'                      => true,
    		'sql' => array
    		(
    			'keys' => array
    			(
    				'id' => 'primary',
            'pid' => 'index'
    			)
    		)
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('bidding'),
            'headerFields'            => array('produktnummer', 'bezeichnung'),
            'flag'                    => 11,
            'panelLayout'             => 'search,limit',
            'disableGrouping'         => true,
            'child_record_callback'   => array('tl_shop_produkte_bidding', 'listItems')
        ),
        'label' => array
        (
            'fields'                  => array('bidding'),
            'format'                  => '%s <span style="color:#b3b3b3; padding-left:3px;">[]</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif',
            ),
      			'cut' => array
      			(
        				'label'               => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['cut'],
        				'href'                => 'act=paste&amp;mode=cut',
        				'icon'                => 'cut.gif',
        				'attributes'          => 'onclick="Backend.getScrollOffset()"'
      			),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},member,bidding;',
    ),


    // Fields
    'fields' => array
    (
        'id' => array
    		(
      			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
    		),
        'pid' => array
    		(
      			'sql'                     => "int(10) NOT NULL default '0'"
    		),
    		'tstamp' => array
    		(
      			'sql'                     => "int(10) unsigned NOT NULL default '0'"
    		),
        'member' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['member'],
            'inputType'               => 'select',
            'options_callback'        => array('tl_shop_produkte_bidding', 'listMember'),
            'search'                  => true,
            'eval'                    => array('mandatory'=>true, 'chosen' => true, 'includeBlankOption' => true, 'tl_class'=>'w50'),
      			'sql'                     => "int(10) NOT NULL default '0'"
        ),
        'bidding' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_shop_produkte_bidding']['bidding'],
            'inputType'               => 'text',
            'default'                 => 0,
            'exclude'                 => true,
            'search'                  => true,
            'filter'                  => false,
           	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50'), 
        		'sql'                     => "float NOT NULL default '0'"
        )
    )
);

class tl_shop_produkte_bidding extends Backend {
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    public function listItems($arrRow) {
        $objMember = $this->Database->prepare("SELECT * FROM tl_member WHERE id=?")->execute($arrRow['member']);
        
        $html  = $objMember->firstname . ' ' . $objMember->lastname . ' <span style="color:#b3b3b3; padding-left:3px;">[' . sprintf("%01.2f", $arrRow['bidding']) . ' ' . $GLOBALS['TL_CONFIG']['currency_symbol'] . ']</span>';
        $html .= '<hr>';
        $html .= 'ID: ' . $objMember->id . '<br>';
        
        if($objMember->company) {  
            $html .= 'Firma: ' . $objMember->company . '<br>';
        }
         
        $html .= 'Strasse: ' . $objMember->street . '<br>'; 
        $html .= 'PLZ, Ort: ' . $objMember->postal . ' ' . $objMember->city . '<br>'; 
        $html .= 'E-Mail: ' . $objMember->email . '<br>'; 
        return $html;    
    }
    
    public function listMember() {
        $objMember = $this->Database->prepare('SELECT id, firstname, lastname FROM tl_member')->execute();
        while($objMember->next()) {
            $arrOptions[$objMember->id] = $objMember->firstname . ' ' . $objMember->lastname;
        }
        
        return $arrOptions;    
    }
}
?>