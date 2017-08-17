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
class MessageBusiness_ContactsSync_Adminhtml_AjaxController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Lancement de la synchronisation
	 *
	 */
	public function runSyncAction()
	{
		$response = array();
		$this->_setConfig();
		Mage::getConfig()->reinit();
		try {
			$fields = Mage::helper('contactssync/mbApi')->runImport();
			$response['result'] = $fields;
		} catch (Exception $e) {
			$response['error'] = $e->getMessage();
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($response));
	}
	
	/**
	 * Lancement de la synchronisation
	 *
	 */
	public function stopSyncAction()
	{
		$response = array();
		
		try {
			$fields = Mage::helper('contactssync/mbApi')->stopImport();
			$response['result'] = $fields;
		} catch (Exception $e) {
			$response['error'] = $e->getMessage();
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($response));
	}
	
	/**
	 * Enregistrement des valeurs courantes du formulaire de configuration de l'import
	 *
	 */
	private function _setConfig()
	{
		Mage::getConfig()->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_ACCEPT_INTERFACE_OPTION, $this->getRequest()->getParam('acceptInterfaceOption'));
		Mage::getConfig()->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_ACCEPT_INTERFACE_LEVEL, $this->getRequest()->getParam('acceptInterfaceLevel'));
		Mage::getConfig()->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FULL_EXTRACT, $this->getRequest()->getParam('fullExtract'));
		
		Mage::getConfig()->reinit();
	}
}