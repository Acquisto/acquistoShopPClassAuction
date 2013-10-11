<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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

class acquistoPClassAuktion extends AcquistoShop\acquistoShopProduktController
{
    var $produkt_id          = 0;
    var $produktArray        = array();
    var $default_image       = '';
    var $image_properties    = array();
    var $strTemplate         = 'acquisto_produkt_default';
    var $hasAttributes       = false;
    var $subTable            = 'tl_shop_produkte_bidding';
    private $attribute       = null;

    public function __construct($id, $attributes = null)
    {
        parent::__construct();
        $this->Import('Database');

        $this->intId         = $id;
        $this->arrAttributes = unserialize(str_replace("'", "\"", $attributes));

        #$this->produkt_id = $id;
        #$this->produkt_attributes = unserialize(str_replace("'", "\"", $attributes));

        $objLoad = $this->Database->prepare("SELECT * FROM tl_shop_produkte WHERE id = ?")->limit(1)->execute($this->intId);
        $arrLoad = $objLoad->row();

        if(is_array($arrLoad)) {
            foreach($arrLoad as $key => $value) {
                $this->__set($key, $value);
            }
        }

        $this->buildCss();

        switch($this->type) {
            case 'auktion':
                $this->sortCosts();
                break;;
        }

        if($this->template) {
            $this->strTemplate = $this->template;
        }

	if($this->mengeneinheit) {
	    $objMengeneinheit = $this->Database->prepare("SELECT * FROM tl_shop_mengeneinheit WHERE id=?")->execute($this->mengeneinheit);
	    $this->mengeneinheit = $objMengeneinheit->einheit;
	}
    }

    public function __set($name, $value) {
        switch($name) {
            case "url":
                $this->formatUrl($value);
                break;;
            case "default_image":
                if(!$this->preview_image) {
                    $this->preview_image = $value;
                }
                break;;
            default:
                $this->$name = $value;
                break;;
        }
    }

    #public function __get($name) {
    #    return $this->$name;
    #}

    private function formatUrl($url) {
        $this->url = sprintf($url, $this->alias);
    }
}

?>