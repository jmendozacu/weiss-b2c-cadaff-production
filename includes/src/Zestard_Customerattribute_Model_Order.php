<?php
class Zestard_Customerattribute_Model_Order extends  TBT_Rewards_Model_Sales_Order
{
	/**
     * Queue email with new order data
     *
     * @param bool $forceMode if true then email will be sent regardless of the fact that it was already sent previously
     *
     * @return Mage_Sales_Model_Order
     * @throws Exception
     */
    public function queueNewOrderEmail($forceMode = false)
    {
        //die('dioed');
        $storeId = $this->getStore()->getId();

        if (!Mage::helper('sales')->canSendNewOrderEmail($storeId)) {
            return $this;
        }

        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);

        // Start store emulation process
        /** @var $appEmulation Mage_Core_Model_App_Emulation */
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

        try {
            // Retrieve specified view block from appropriate design package (depends on emulated store)
            $paymentBlock = Mage::helper('payment')->getInfoBlock($this->getPayment())
                ->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();
        } catch (Exception $exception) {
            // Stop store emulation process
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            throw $exception;
        }

        // Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Retrieve corresponding email template id and customer name
        if ($this->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $this->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
            $customerName = $this->getCustomerName();
        }

        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        /** @var $emailInfo Mage_Core_Model_Email_Info */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($this->getCustomerEmail(), $customerName);
        if ($copyTo && $copyMethod == 'bcc') {
            // Add bcc to customer email
            foreach ($copyTo as $email) {
                $emailInfo->addBcc($email);
            }
        }
        $mailer->addEmailInfo($emailInfo);

        // Email copies are sent as separated emails if their copy method is 'copy'
        if ($copyTo && $copyMethod == 'copy') {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }
		
		// ----------------------- CODE for set variable in new order template---------
        	$add_in_order_confirmation = Mage::getStoreConfig('zestard_customerattribute/customerattribute_group/add_in_order_confirmation');

            $customer = Mage::getModel('customer/customer')->load($this->getCustomerId());        	
        	
        	$customerAddressAttribute = array();
			$Addressattributes = Mage::getModel('zestard_customerattribute/customerattribute')->getCollection();
			
			foreach($Addressattributes->getData() as $key => $value)
			{
				$customerAddressAttribute[] = $value['attribute_code'];
			}

			$data = array();
			$postObject = new Zestard_Customerattribute_Block_OrderData();			
			if($add_in_order_confirmation == 1) {
                foreach($customer->getData() as $key => $value) {
    				if(in_array($key,$customerAddressAttribute)) {					
    									
    					$attributeCollection = Mage::getModel('zestard_customerattribute/customerattribute')->getCollection()
    						->addFieldToFilter('attribute_code',$key);				
    					$attr = $attributeCollection->getData();																
    					if($attr[0]['send_order_email'] == 1 && $attr[0]['is_user_defined'] == 1) {				
    						$label = $attr[0]['frontend_label'];
    						$data[$label] = $value;					
    					}						
    				}
    			}
            }			
			$postObject->setData($data);			
		// ---------------- code end -----------------
        
        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
            'order'        => $this,
            'billing'      => $this->getBillingAddress(),
            'payment_html' => $paymentBlockHtml,
            'CustomerAttribute' => $postObject
        ));

        /** @var $emailQueue Mage_Core_Model_Email_Queue */
        $emailQueue = Mage::getModel('core/email_queue');
        $emailQueue->setEntityId($this->getId())
            ->setEntityType(self::ENTITY)
            ->setEventType(self::EMAIL_EVENT_NAME_NEW_ORDER)
            ->setIsForceCheck(!$forceMode);

        $mailer->setQueue($emailQueue)->send();

        $this->setEmailSent(true);
        $this->_getResource()->saveAttribute($this, 'email_sent');

        return $this;
    }
}
