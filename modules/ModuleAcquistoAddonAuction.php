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

/**
 * Class mod_acquistoShop_AGB
 *
 * Front end module "mod_acquistoShop_AGB".
 * @copyright  Sascha Brandhoff 2011
 * @author     Sascha Brandhoff <http://www.contao-acquisto.org>
 * @package    Controller
 */

class ModuleAcquistoAddonAuction extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_acquistoaddon_auction';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ACQUISTO AUKTION ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->Import('AcquistoShop\acquistoShopProduktLoader', 'Produkt');
        $objProdukt = $this->Database->prepare("SELECT id FROM tl_shop_produkte WHERE alias=?")->execute($this->Input->Get('produkt'));
        $objProdukt = $this->Produkt->load($objProdukt->id);
        
        if($objProdukt->type != 'auktion') {
            return '';
        }

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        $this->Import('acquistoShopProduktLoader', 'Produkt');
        $objProdukt = $this->Database->prepare("SELECT id FROM tl_shop_produkte WHERE alias=?")->execute($this->Input->Get('produkt'));
        $objProdukt = $this->Produkt->load($objProdukt->id);
        
        if($objProdukt->endDate <= time()) {
            $this->Template->Abgelaufen = true;
        }
        
        $boolLogin = false;
        if (FE_USER_LOGGED_IN) {
            $this->import('FrontendUser', 'User');
            $boolLogin = true;
        }

        if($objProdukt->type == 'auktion') {
            $biddingMaxSQL   = $this->Database->prepare("SELECT MAX(bidding) AS biddingMax FROM tl_shop_produkte_bidding WHERE pid=?")->execute($objProdukt->id);
            $biddingCountSQL = $this->Database->prepare("SELECT COUNT(*) AS biddingCount FROM tl_shop_produkte_bidding WHERE pid=?")->execute($objProdukt->id);
        }
        
        if($biddingMaxSQL->biddingMax) {
            $biddingMax = $biddingMaxSQL->biddingMax;        
        } else {
            $biddingMax = $objProdukt->auction_price;
        }
        
        if($biddingCountSQL->biddingCount) {
            $biddingNext = $objProdukt->auction_bidding + $biddingMax;
        } else {
            $biddingNext = $biddingMax;
        }
        
        switch($biddingCountSQL->biddingCount) {
            case 0:
                $biddingCount = 'kein';
                break;
            default:
                $biddingCount = $biddingCountSQL->biddingCount;            
                break; 
        }
        
        $this->Template->Login = $boolLogin;
        $this->Template->Bidding = (object) array(
            'max'   => sprintf("%01.2f", $biddingMax),
            'next'  => sprintf("%01.2f", $biddingNext), 
            'count' => $biddingCount  
        );
        
        $this->Template->Enddatum = date("d.m.Y", $objProdukt->endDate - 1);

        if(FE_USER_LOGGED_IN && $this->Input->Post('FORM_SUBMIT') == 'tl_shop_produkte_bidding' && $this->Input->Post('bidding') >= $biddingNext) {
            $this->Database->prepare("INSERT INTO tl_shop_produkte_bidding (tstamp, pid, member, bidding) VALUES(" . time() . ", " . $objProdukt->id . ", " . $this->User->id . ", '" . $this->Input->Post('bidding') . "')")->execute();
            
            $objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->replaceInsertTags('{page:id}'));
            $this->redirect(substr($this->Environment->requestUri, 1));
        }
    }            
}

?>