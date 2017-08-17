<?php
class Magebright_Multicoupons_Model_Observer 
{
    public function manageSalesOrder($observer)
    {
        $order = $observer->getEvent()->getOrder();
        if (!$order) {
            return $this;
        }
       
        if (!strpos($order->getCouponCode(), ','))
            return $this;
        $customer_id = $order->getCustomerId();

      
            $coupon = Mage::getModel('salesrule/coupon');
            foreach (explode(',', $order->getCouponCode()) as $code){
                $coupon->load($code, 'code');
                if ($coupon->getId()) {
                    $coupon->setTimesUsed($coupon->getTimesUsed() + 1);
                    $coupon->save();
                    if ($customer_id) {
                        $couponUsage = Mage::getResourceModel('salesrule/coupon_usage');
                        $couponUsage->updateCustomerCouponTimesUsed($customer_id, $coupon->getId());
                    }
                }            
            }
       
 
        return $this;
    }
    
    public function manageSalesruleValid($observer) 
    {
                  
        $coupon_codes  = $observer->getEvent()->getQuote()->getCouponCode();
        if (!$coupon_codes)
            return $this;
            
        $coupon_codes = explode(',', $coupon_codes);  

        if (count($coupon_codes) < 2 )
            return $this;
            
         if (!(Mage::getStoreConfig('multicoupons/codes/enable_same_rule')))
            return $this;
                
        $cntPerRule = $observer->getEvent()->getQuote()->getCouponPerRuleCount();
        if (!$cntPerRule){
            
            $cntPerRule = $this->_calCPRuleCount($coupon_codes);
            $observer->getEvent()->getQuote()->setCouponPerRuleCount($cntPerRule);
        }
        $ruleId = $observer->getEvent()->getRule()->getId();

        if (isset($cntPerRule[$ruleId])){
            $result = $observer->getEvent()->getResult();
            $result->setDiscountAmount($result->getDiscountAmount()*$cntPerRule[$ruleId]);
            $result->setBaseDiscountAmount($result->getBaseDiscountAmount()*$cntPerRule[$ruleId]);
        }    
        
        return $this;
    }
    
    protected function _calCPRuleCount($coupon_codes)
    {
        $coupondata = Mage::getResourceModel('salesrule/coupon_collection');
        $select = $coupondata->getSelect();
        $select
            ->reset(Zend_Db_Select::COLUMNS)
            ->from('', array('rule_id', 'cnt'=> new Zend_Db_Expr('COUNT(*)')))
            ->where('code IN(?)', $coupon_codes)
            ->group('rule_id');
            
           
        $db = Mage::getSingleton('core/resource')->getConnection('multicoupons_write');
        $rows = $db->fetchPairs($select);
        
        return $rows;
    }    
    
}

