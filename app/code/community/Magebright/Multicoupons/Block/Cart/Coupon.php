<?php
class Magebright_Multicoupons_Block_Cart_Coupon extends Mage_Checkout_Block_Cart_Coupon
{
       
    public function getUtilizedCoupons()
    {
        return $this->getQuote()->getAppliedCoupons();
    }
}