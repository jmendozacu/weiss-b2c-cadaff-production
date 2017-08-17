<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Cienum_Checkout_OnepageController extends Mage_Checkout_OnepageController
{
	public function preDispatch()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro') {
            return parent::preDispatch();
        }


        parent::preDispatch();
        $this->_preDispatchValidateCustomer();

        $checkoutSessionQuote = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkoutSessionQuote->getIsMultiShipping()) {
            $checkoutSessionQuote->setIsMultiShipping(false);
            $checkoutSessionQuote->removeAllAddresses();
        }

        if (!$this->_canShowForUnregisteredUsers()) {
            $this->norouteAction();
            $this->setFlag('',self::FLAG_NO_DISPATCH,true);
            return;
        }
        return $this;
    }
	
	protected function _canShowForUnregisteredUsers()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::_canShowForUnregisteredUsers();

        return Mage::getSingleton('customer/session')->isLoggedIn()
            || $this->getRequest()->getActionName() == 'index'
            || Mage::helper('checkout')->isAllowedGuestCheckout($this->getOnepage()->getQuote())
            || !Mage::helper('checkout')->isCustomerMustBeLogged();
    }
	
	public function saveMethodAction()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            parent::saveMethodAction();

        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $method = $this->getRequest()->getPost('method');
            $result = $this->getOnepage()->saveCheckoutMethod($method);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
	
	public function saveBillingAction()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::saveBillingAction();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
            $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

            if (!isset($result['error'])) {
                $result['goto_section'] = 'shipping_method';
                $result['update_section'] = array(
                    'name' => 'shipping-method',
                    'html' => $this->_getShippingMethodsHtml()
                );
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
	
	public function saveShippingAction()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::saveShippingAction();

        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping', array());
            $customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
            $result = $this->getOnepage()->saveShipping($data, $customerAddressId);

            if (!isset($result['error'])) {
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_billing']) && $data['use_for_billing'] == 1) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

                    $result['allow_sections'] = array('billing');
                    $result['duplicateShippingInfo'] = 'true';
                } else {
                    $result['goto_section'] = 'billing';
                }
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
	
	public function saveShippingMethodAction()
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro') {
            parent::saveShippingMethodAction();
        } else {
            if ($this->_expireAjax()) {
                return;
            }
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('shipping_method', '');
                $result = $this->getOnepage()->saveShippingMethod($data);
                // $result will contain error data if shipping method is empty
                if (!$result) {
                    Mage::dispatchEvent(
                        'checkout_controller_onepage_save_shipping_method',
                        array(
                            'request' => $this->getRequest(),
                            'quote'   => $this->getOnepage()->getQuote()));
                    $this->getOnepage()->getQuote()->collectTotals();
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                }
                //enregistrement de la date de livraison
                $date = $this->getRequest()->getPost('datepicker', '');
                $date = implode('-', array_reverse(explode('/', $date)));
                $this->getOnepage()->getQuote()->setGomageDeliverydate($date);
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            }
        }
    }
	
	public function getCalendriersAction()
	{
		header('Content-type: application/json');
		echo Mage::getStoreConfig('calendriers/calendriers');
	}
}