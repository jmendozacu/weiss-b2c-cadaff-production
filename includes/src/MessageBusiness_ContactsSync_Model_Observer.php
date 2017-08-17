<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    MessageBusiness
 * @package     MessageBusiness_ContactsSync
 * @author 		Sinabs - http://www.sinabs.fr
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class MessageBusiness_ContactsSync_Model_Observer
{
	
	/**
	 * Vérification des identifiants Message Business
	 *
	 * @param Varien_Event_Observer $observer
	 * @return MessageBusiness_ContactsSync_Model_Observer
	 */
	public function saveConfig($observer)
	{
		Mage::helper('contactssync/mbApi')->saveAuthConfig();
		return $this;
	}

	/**
	 * Souscription ou désabonnement à la Newsletter
	 *
	 * @param Varien_Event_Observer $observer
	 * @return MessageBusiness_ContactsSync_Model_Observer
	 */
	public function newsletterSubscriberChange($observer)
	{
		$subscriber = $observer->getEvent()->getSubscriber();

		if (Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_NEWSLETTER_SUBSCRIPTION) == MessageBusiness_ContactsSync_Model_System_Config_Source_Newsletter_Subscription::SUBSCRIBE_YES) {
			switch ($subscriber->getStatus()) {
				case Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED: // souscription à la newsletter
					Mage::helper('contactssync/mbApi')->pushOptin($subscriber->getEmail(), true);
					break;
				case Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED: // désinscription à la newsletter (non géré)
					Mage::helper('contactssync/mbApi')->pushOptin($subscriber->getEmail(), false);
					break;
				default:
					break;
			}
		}

		return $this;
	}
}