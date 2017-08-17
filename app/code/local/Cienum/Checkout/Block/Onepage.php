<?php

class Cienum_Checkout_Block_Onepage extends Mage_Checkout_Block_Onepage
{
    public function getSteps()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::getSteps();

        $steps = array();
 
        if (!$this->isCustomerLoggedIn()) {
            $steps['login'] = $this->getCheckout()->getStepData('login');
        }
 
        $stepCodes = array('shipping','billing', 'shipping_method', 'payment', 'review');
 
        foreach ($stepCodes as $step) {
            $steps[$step] = $this->getCheckout()->getStepData($step);
        }
        return $steps;
    }
 
    public function getActiveStep()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::getActiveStep();

        return $this->isCustomerLoggedIn() ? 'shipping' : 'login';
    }
}