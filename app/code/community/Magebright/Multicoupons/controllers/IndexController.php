<?php
class Magebright_Multicoupons_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		
		$this->loadLayout();
		$this->renderLayout();
	}
	protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }
    
    public function removeCouponCodeAction()
    {
    	
        $codeToRemove = $this->getRequest()->getParam('utilized_coupon_cancel');
        $utilizedCoupons = $this->_getQuote()->getAppliedCoupons();
        
        foreach ($utilizedCoupons as $i => $coupon)
        {
            if ($coupon == $codeToRemove)
            {
                unset($utilizedCoupons[$i]);
                try
                {
                    if ($this->_getQuote()->setCouponCode($utilizedCoupons)->save())
                    {
                        $this->_getSession()->addSuccess($this->__('Coupon code %s was canceled.', $codeToCancel));
                    }
                }
                catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
                catch (Exception $e) {
                    $this->_getSession()->addError($this->__('Cannot cancel the coupon code.'));
                }
            }
        }
        
        $this->_redirect('checkout/cart');
        return $this;
    }
}