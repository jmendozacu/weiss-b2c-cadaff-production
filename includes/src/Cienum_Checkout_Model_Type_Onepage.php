<?php
class Cienum_Checkout_Model_Type_Onepage extends Mage_Checkout_Model_Type_Onepage
{
	public function saveShipping($data, $customerAddressId)
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro') {
            return parent::saveShipping($data, $customerAddressId);
        }

        if (empty($data)) {
            return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid data.'));
        }
        $address = $this->getQuote()->getShippingAddress();

        /* @var $addressForm Mage_Customer_Model_Form */
        $addressForm    = Mage::getModel('customer/form');
        $addressForm->setFormCode('customer_address_edit')
            ->setEntityType('customer_address')
            ->setIsAjaxRequest(Mage::app()->getRequest()->isAjax());

        if (!empty($customerAddressId)) {
            $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
            if ($customerAddress->getId()) {
                if ($customerAddress->getCustomerId() != $this->getQuote()->getCustomerId()) {
                    return array('error' => 1,
                        'message' => Mage::helper('checkout')->__('Customer Address is not valid.')
                    );
                }

                $address->importCustomerAddress($customerAddress)->setSaveInAddressBook(0);
                $addressForm->setEntity($address);
                $addressErrors  = $addressForm->validateData($address->getData());
                if ($addressErrors !== true) {
                    return array('error' => 1, 'message' => $addressErrors);
                }
            }
        } else {
            $addressForm->setEntity($address);
            // emulate request object
            $addressData    = $addressForm->extractData($addressForm->prepareRequest($data));
            $addressErrors  = $addressForm->validateData($addressData);
            if ($addressErrors !== true) {
                return array('error' => 1, 'message' => $addressErrors);
            }
            $addressForm->compactData($addressData);
            // unset shipping address attributes which were not shown in form
            foreach ($addressForm->getAttributes() as $attribute) {
                if (!isset($data[$attribute->getAttributeCode()])) {
                    $address->setData($attribute->getAttributeCode(), NULL);
                }
            }

            $address->setCustomerAddressId(null);
            // Additional form data, not fetched by extractData (as it fetches only attributes)
            $address->setSaveInAddressBook(empty($data['save_in_address_book']) ? 0 : 1);
            $address->setSameAsBilling(empty($data['same_as_billing']) ? 0 : 1);
        }

        $address->implodeStreetAddress();
        $address->setCollectShippingRates(true);

        if (($validateRes = $address->validate())!==true) {
            return array('error' => 1, 'message' => $validateRes);
        }

		if (!$this->getQuote()->isVirtual()) {
			/**
			 * Shipping address using otions
			 */
			$usingCase = isset($data['use_for_billing']) ? (int)$data['use_for_billing'] : 0;

			switch ($usingCase) {
				case 0:
					$billing = $this->getQuote()->getBillingAddress();
					$billing->setSameAsShipping(0);
					break;
				case 1:
					$shipping = clone $address;
					$shipping->unsAddressId()->unsAddressType();
					$billing = $this->getQuote()->getBillingAddress();
					$shippingMethod = $shipping->getShippingMethod();

					// Shipping address properties that must be always copied to billing address
					$requiredShippingAttributes = array('customer_address_id');

					// don't reset original billing data, if it was not changed by customer
					foreach ($billing->getData() as $billingKey => $billingValue) {
						if (!is_null($billingValue) && !is_null($shipping->getData($billingKey))
							&& !isset($data[$billingKey]) && !in_array($billingKey, $requiredShippingAttributes)
						) {
							$shipping->unsetData($billingKey);
						}
					}
					$billing->addData($shipping->getData())
						->setSameAsShipping(1)
						->setSaveInAddressBook(0)
						->setShippingMethod($shippingMethod)
						->setCollectBillingRates(true);
					$this->getCheckout()->setStepData('billing', 'complete', true);
					break;
			}
		}
		
        $this->getQuote()->collectTotals()->save();

        $this->getCheckout()
            ->setStepData('shipping', 'allow', true)
            ->setStepData('shipping', 'complete', true)
            ->setStepData('billing', 'allow', true);
            // ->setStepData('shipping_method', 'allow', true);

        return array();
    }
}