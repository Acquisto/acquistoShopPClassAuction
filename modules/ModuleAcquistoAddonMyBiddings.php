<?php 

namespace AcquistoShop\Frontend;

class ModuleAcquistoAddonAuction extends Module
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

        $this->Import('acquistoShopProduktLoader', 'Produkt');
        $this->import('FrontendUser', 'Member');

        $objProdukt = $this->Database->prepare("SELECT id FROM tl_shop_produkte WHERE alias=?")->execute($this->Input->Get('produkt'));
        $objProdukt = $this->Produkt->load($objProdukt->id);        

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        if(FE_USER_LOGGED_IN) {
            $objBiddings = $this->Database->prepare("SELECT * FROM tl_shop_produkte_bidding WHERE member = ?")->execute($this->Member->id);
            
            while($objBiddings->next()) {
                $objProdukt = $this->Produkt->load($objProdukt->id);
                $objItem = (object) $objBiddings->row();
                $objItem->Produkt = $objProdukt; 

                $arrBiddings[] = $objItem;
            }
            
            $this->Template->Biddings = $arrBiddings;
        }
//         
//         if($objProdukt->endDate <= time()) {
//             $this->Template->Abgelaufen = true;
//         }
//         
//         $boolLogin = false;
//         if (FE_USER_LOGGED_IN) {
//             $this->import('FrontendUser', 'User');
//             $boolLogin = true;
//         }
// 
//         if($objProdukt->type == 'auktion') {
//             $biddingMaxSQL   = $this->Database->prepare("SELECT MAX(bidding) AS biddingMax FROM tl_shop_produkte_bidding WHERE pid=?")->execute($objProdukt->id);
//             $biddingCountSQL = $this->Database->prepare("SELECT COUNT(*) AS biddingCount FROM tl_shop_produkte_bidding WHERE pid=?")->execute($objProdukt->id);
//         }
//         
//         if($biddingMaxSQL->biddingMax) {
//             $biddingMax = $biddingMaxSQL->biddingMax;        
//         } else {
//             $biddingMax = $objProdukt->auction_price;
//         }
//         
//         if($biddingCountSQL->biddingCount) {
//             $biddingNext = $objProdukt->auction_bidding + $biddingMax;
//         } else {
//             $biddingNext = $biddingMax;
//         }
//         
//         switch($biddingCountSQL->biddingCount) {
//             case 0:
//                 $biddingCount = 'kein';
//                 break;
//             default:
//                 $biddingCount = $biddingCountSQL->biddingCount;            
//                 break; 
//         }
//         
//         $this->Template->Login = $boolLogin;
//         $this->Template->Bidding = (object) array(
//             'max'   => sprintf("%01.2f", $biddingMax),
//             'next'  => sprintf("%01.2f", $biddingNext), 
//             'count' => $biddingCount  
//         );
//         
//         $this->Template->Enddatum = date("d.m.Y", $objProdukt->endDate - 1);
// 
//         if(FE_USER_LOGGED_IN && $this->Input->Post('FORM_SUBMIT') == 'tl_shop_produkte_bidding' && $this->Input->Post('bidding') >= $biddingNext) {
//             $this->Database->prepare("INSERT INTO tl_shop_produkte_bidding (tstamp, pid, member, bidding) VALUES(" . time() . ", " . $objProdukt->id . ", " . $this->User->id . ", '" . $this->Input->Post('bidding') . "')")->execute();
//             
//             $objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->replaceInsertTags('{page:id}'));
//             $this->redirect(substr($this->Environment->requestUri, 1));
//         }
//     }            
}

?>