<?php

class Magebright_Multicoupons_Model_Sales_Quote extends Mage_Sales_Model_Quote
{
    public function setCouponCode($coupon)
    {  
         
        $resultingCoupons = $coupon;
        if (!is_array($coupon)) {
             $resultingCoupons = explode(',', $coupon);
        }
                
        if (is_array($coupon)){          
            $couponCode = implode(',', $coupon); 
        } 
        elseif ($coupon){ 
            $appliedCoupons = explode(',', $this->getCouponCode(true));
            if (!in_array($coupon, $appliedCoupons)){
                $appliedCoupons[] = $coupon;
            }        
            $couponCode = implode(',', $appliedCoupons);
        } 
        else {
            $couponCode = '';
        }
             
     
        $allCoupons = explode(',', $couponCode);
        $hash = array();
        $newCoupons = array();
        foreach ($allCoupons as $singleCode) {
             $modelCoupon = Mage::getModel('salesrule/coupon')->load($singleCode, 'code'); 
             if ($modelCoupon->getRuleId()){
                $hash[$singleCode] = $modelCoupon->getRuleId() ;
                $newCoupons[] =  $singleCode;      
             }   
        }
        
         if (Mage::getStoreConfig('multicoupons/codes/enable_same_rule')) {
              $allCoupons = array_values($newCoupons);
        }  
        else {
                $hash = array_flip($hash);
                $allCoupons = array_values($hash);
        }

       /* $hash = array_flip($hash);
        $allCoupons = array_values($hash);*/


        $allCoupons = array_unique($allCoupons);          
        $specialCoupons = explode(",", str_replace(array(' ',';'), '', Mage::getStoreConfig('multicoupons/codes/code', $this->getStoreId())));
        $specialCoupons = array_unique($specialCoupons);
        $result = array_intersect($specialCoupons, $allCoupons); 
        $result = array_values($result);

        if (!empty($result)) {
            $allCoupons = array(current($result)); 
        } 
         
        foreach ($allCoupons as $singleCode){
            if (in_array($singleCode, $resultingCoupons) && (count($resultingCoupons) > 1)){
                $msg = Mage::helper('checkout')->__('Coupon code "%s" was applied.', Mage::helper('core')->htmlEscape($singleCode));
                Mage::getSingleton('checkout/session')->addSuccess($msg);
                Mage::getSingleton('adminhtml/session_quote')->addSuccess($msg);                
            }
         }

        $couponCode = implode(',', $allCoupons);
        $this->setData('coupon_code', $couponCode);
        
        return $this;
    }
    
    public function getCouponCode($all = false)
    {
        if (in_array(Mage::app()->getRequest()->getActionName(), array('couponPost', 'add_coupon'))){
            if ($all){
                return parent::getData('coupon_code');
            }
            $coupons = explode(',', parent::getData('coupon_code'));
            if (count($coupons)){
               
                return $coupons[count($coupons) - 1];
            }
        }
        return parent::getData('coupon_code');
    }
    
    public function getAppliedCoupons()
    {
        $coupons    = array();
        $couponCode = $this->getCouponCode();
        if ($couponCode) {
            $coupons = explode(',', $couponCode);
        }
        
        foreach ($coupons as $i => $coupon) {
            if (!$coupon) {
                unset($coupons[$i]);
            }
        }
        
        return $coupons;
    }
    
    protected function _validateCouponCode()
    {
        $codes = $this->getAppliedCoupons();
        if ($codes) {
            $addressHasCoupon = false;
            $addresses = $this->getAllAddresses();
            if (count($addresses)>0) {
                foreach ($addresses as $address) {
                    if ($address->hasCouponCode()) {
                        $addressHasCoupon = true;
                    }
                }
                if (!$addressHasCoupon) {
                    $coupons = explode(',', $this->getCouponCode(true));
                    if (count($coupons)){
                        array_pop($coupons);
                        $coupons = implode(',', $coupons);
                        $this->setData('coupon_code', $coupons);
                    }
                    else {
                        $this->setData('coupon_code', '');
                    }
                }
            }
        }
        return $this;
    }
}