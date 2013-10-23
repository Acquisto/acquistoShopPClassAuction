<?php

namespace AcquistoShop\Addon;

class AcquistoAddonManipulateProduct extends \Controller
{
    public function modifyProduct($Product) {
        if($Product->type == 'auktion') {
            $this->Import('Database');
            
            if(!$Product->auction_directly_buy) {
                $Product->catalogMode = true;
                $Product->catalogMonay = false;
                
                $sqlSummary = $this->Database->prepare("SELECT MAX(bidding) AS Summary FROM tl_shop_produkte_bidding WHERE pid=?")->execute($Product->id);
                $sqlCounter = $this->Database->prepare("SELECT COUNT(*) AS Summary FROM tl_shop_produkte_bidding WHERE pid=?")->execute($Product->id);
                
                if($sqlCounter->Summary) {
                    $nowSummary = $sqlSummary->Summary; 
                } else {
                    $nowSummary = $Product->auction_price;
                }
                               
                $Product->preise = array(
                    (object) array(
                        'basecosts' => sprintf("%01.2f", 0),
                        'amount'    => 0,
                        'costs'     => sprintf("%01.2f", $nowSummary),
                        'special'   => null,
                        'group'     => 0
                    )
                );
            }
        }
        
        return $Product;
    }
}
