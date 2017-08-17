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
class MessageBusiness_ContactsSync_InterfaceController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Ips autorisées à accéder à l'interface Message Business
	 *
	 * @var array
	 */
	private $_ipAlloweds = array(
		'217.174.192.16',
		'217.174.192.17',
		'217.174.192.18',
		'217.174.192.19',
		'217.174.192.20',
		'217.174.192.21',
		'217.174.192.22',
		'217.174.192.23',
		'127.0.0.1'
	);
	
	/**
	 * XML Object
	 *
	 * @var DOMDocument
	 */
	private $_xml;
	
	/**
	 * Intercepte les méthodes de l'interface qui ne sont pas implémentées
	 *
	 * @param string $method
	 * @param array $args
	 */
	public function __call($method, $args)
	{
		throw new Exception("Unknown or bad parameters");
	}
	
	/**
	 * Centralise l'appel au méthodes de l'interface
	 *
	 */
	public function callAction()
	{
		$this->_xml = new DOMDocument('1.0', 'UTF-8');
		
		try {
			$this->_isAccess();
			call_user_func(array($this, '_' . strtolower($this->getRequest()->getParam('request'))));	
		} catch (Exception $e) {
			$eError = $this->_xml->createElement('error', $e->getMessage());
			$this->_xml->appendChild($eError);
		}
		
		$this->getResponse()
			->clearHeaders()
			->setHeader('Content-Type', 'text/xml')
			->setBody($this->_xml->saveXML());
	}
	
	/**
	 * Vérification de l'accès à l'interface Magento
	 *
	 */
	private function _isAccess()
	{
		if (!in_array(Mage::helper('core/http')->getRemoteAddr(), $this->_ipAlloweds)) {
			throw new Exception("Access denied for this I0 : " . Mage::helper('core/http')->getRemoteAddr());
		}
		
		if($this->getRequest()->getParam('accesskey') != Mage::helper('contactssync/mbApi')->getAccessKey()) {
			throw new Exception("Invalid accesskey");
		}
	}
	
	/**
	 * Vérifie si le client est abonné à la newsletter
	 *
	 * @param string $email
	 * @param int $idCustomer
	 * @return bool
	 */
	private function _isOptin($email, $idCustomer)
	{
		return Mage::getModel('newsletter/subscriber')->loadByEmail($email, $idCustomer)->isSubscribed() ? 1 : 0;
	}
	
	/**
	 * Mise à jour des optin
	 *
	 */
	protected function _updateOptin()
	{
		$request = $this->getRequest();
		$email = $request->getParam('email');
		$value = $request->getParam('value');
		$id = $request->getParam('id');
		
		if ($email == null || $value == null || $id == null) {
			throw new Exception("Unknown or bad parameters");
		}
		
		$newsletter = Mage::getModel('newsletter/subscriber')
			->loadByEmail($email, $id)
			->setStatus($value == 0 ? Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED : Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED)
			->save();
			
		$element = $this->_xml->createElement('result', 'update optin done for ' . $newsletter->getCustomerId() . ' with ' . $value);
		$this->_xml->appendChild($element);
	}
	
	/**
	 * Retourne l'ensemble des inscrits à la newsletter
	 * 
	 */
	protected function _allSubscribers()
	{
		$collection = Mage::getModel('newsletter/subscriber')
			->getCollection()
			->useOnlySubscribed();
			
		if ($collection->count() > 0) {
			$subscribers = $this->_xml->createElement('subscribers');
			
			foreach ($collection as $customer) {
				$subscribe = $this->_xml->createElement('subscriber');
				$email = $this->_xml->createElement('email', $customer->getEmail());
				$value = $this->_xml->createElement('value', $customer->getStatus());
				
				$subscribe->appendChild($email);
				$subscribe->appendChild($value);
				$subscribers->appendChild($subscribe);
				$this->_xml->appendChild($subscribers);
			}
		} else {
			$this->_xml->appendChild($this->_xml->createElement('subscribers'));
		}
	}
	
	/**
	 * Retourne l'identifiant Magento de tout les clients
	 * 
	 * @param string
	 */
	protected function _allCustomerIds($date = null)
	{
		$customers = Mage::getModel('customer/customer')
			->getCollection()
			->addAttributeToSelect('id');
		
		$orders = array();
		if ($date != null) {
			$customers->addAttributeToFilter(array(
				array(
			        'attribute' => 'created_at',
			        'from'      => $date
		        ),
		        array(
			        'attribute' => 'updated_at',
			        'from'      => $date
		        )
			));

			$orders = Mage::getModel('sales/order')
				->getCollection()
				->addAttributeToSelect('customer_id');
		
			$orders->addAttributeToFilter(array(
			        'attribute' => 'created_at',
			        'from'      => $date
		        ));
		}
		
		$arrCustomers = array();
		if ($customers->count() > 0) {
			$nCustomers = $this->_xml->createElement('customers');
			foreach ($customers as $customer) {
				$arrCustomers[$customer->getId()] = true;
				$nCustomer = $this->_xml->createElement('customer');
				$nId = $this->_xml->createElement('id', $customer->getId());
				$nCustomer->appendChild($nId);
				$nCustomers->appendChild($nCustomer);
				$this->_xml->appendChild($nCustomers);
			}
			foreach($orders as $order) {
				if (!isset($arrCustomers[$order->getCustomerId()])) {
					$nCustomer = $this->_xml->createElement('customer');
					$nId = $this->_xml->createElement('id', $order->getCustomerId());
					$nCustomer->appendChild($nId);
					$nCustomers->appendChild($nCustomer);
					$this->_xml->appendChild($nCustomers);
				}
			}
		} else {
			$this->_xml->appendChild($this->_xml->createElement('customers'));
		}
	}
	
	/**
	 * Retourne l'identifiant Magento de tous les clients depuis une date
	 *
	 */
	protected function _recentCustomerIds()
	{
		$this->_allCustomerIds($this->getRequest()->getParam('date', date('Y-m-d')));
	}
	
	/**
	 * Retourne les données consolidées d'un client Magento
	 *
	 */
	protected function _customerData()
	{
		$idCustomer = $this->getRequest()->getParam('customerid');
		
		if(empty($idCustomer)) {
			throw new Exception("Empty id");
		}
		
		$customer = Mage::getModel('customer/customer')->load($idCustomer);
		
		$eCustomers = $this->_xml->createElement('customers');
		$eCustomer = $this->_xml->createElement('customer');
		$eCustomers->appendChild($eCustomer);
		
		$eId = $this->_xml->createElement('id', $customer->getId());
		$eCustomer->appendChild($eId);
		
		$eGender = $this->_xml->createElement('id_gender', $customer->getGender() ? $customer->getGender() : '');
		$eCustomer->appendChild($eGender);	
		
		$eFirstname = $this->_xml->createElement('firstname', $customer->getFirstname());
		$eCustomer->appendChild($eFirstname);
		
		$eLastname = $this->_xml->createElement('lastname', $customer->getLastname());
		$eCustomer->appendChild($eLastname);
		
		$eEmail = $this->_xml->createElement('email', $customer->getEmail());
		$eCustomer->appendChild($eEmail);
		
		$eBirthday = $this->_xml->createElement('birthday', $customer->getDob() ? $customer->getDob() : '');
		$eCustomer->appendChild($eBirthday);	
		
		$eDateAdd = $this->_xml->createElement('date_add', $customer->getCreatedAt());
		$eCustomer->appendChild($eDateAdd);
		
		$eOptin = $this->_xml->createElement('optin', '0');
		$eCustomer->appendChild($eOptin);
		
		$eOptin = $this->_xml->createElement('newsletter', $this->_isOptin($customer->getEmail(), $customer->getId()));
		$eCustomer->appendChild($eOptin);
		
		$eAddresses = $this->_xml->createElement('addresses');
		
		foreach ($customer->getAddresses() as $address) {
			$eAddress = $this->_xml->createElement('address');
			
			$i = 0;
			foreach ($address->getStreet() as $street) {
				$i++;
				$eAddress->appendChild($this->_xml->createElement('address' . $i, $street));
			}
			
			if ($i < 2) {
				$eAddress->appendChild($this->_xml->createElement('address2', ''));
			}
			
			$eAddress->appendChild($this->_xml->createElement('postcode', $address->getPostcode()));
			$eAddress->appendChild($this->_xml->createElement('city', $address->getCity()));
			$eAddress->appendChild($this->_xml->createElement('country', $address->getCountryId()));
			$eAddress->appendChild($this->_xml->createElement('phone', $address->getTelephone()));
			$eAddress->appendChild($this->_xml->createElement('phone_mobile'));
			
			$eAddress->appendChild($this->_xml->createElement('company', $address->getcompany() ? $address->getcompany() : ''));
			
			$eAddresses->appendChild($eAddress);
		}
		
		$eCustomer->appendChild($eAddresses);
		
		if (Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_ACCEPT_INTERFACE_LEVEL) == MessageBusiness_ContactsSync_Model_System_Config_Source_Synchro_Type::SYNC_COMPLETE) {
			$logCustomer = Mage::getModel('log/customer')->load($idCustomer);
			$eLastConnection = $this->_xml->createElement('last_connection', $logCustomer->getLoginAt());
			$eCustomer->appendChild($eLastConnection);
			
			$eLastCancelledCartDate = $this->_xml->createElement('last_cancelledcartdate', $this->_getLastCanceledCartDate($idCustomer));
			$eCustomer->appendChild($eLastCancelledCartDate);
			
			if (count($this->_getOrders($idCustomer)) > 0) {
				$eOrders = $this->_xml->createElement('orders');
				foreach ($this->_getOrders($idCustomer) as $o) {
					$eOrder = $this->_xml->createElement('order');
					$eOrder->appendChild($this->_xml->createElement('total_paid', $o->getGrandTotal()));
					$eOrder->appendChild($this->_xml->createElement('invoice_date', $o->getCreatedAt()));
					$eOrder->appendChild($this->_xml->createElement('delivery_date', $o->getCreatedAt()));
					$eOrders->appendChild($eOrder);
				}
				$eCustomer->appendChild($eOrders);
			}
			
			
		}
		$this->_xml->appendChild($eCustomers);
	}
	
	/**
	 * Retourne la date du dernier panier abandonné d'un client
	 *
	 * @param int $idCustomer
	 * @return string
	 */
	private function _getLastCanceledCartDate($idCustomer)
	{
		$abandonedCartCollection = Mage::getResourceModel('reports/quote_collection')
			->prepareForAbandonedReport(array(1))
			->addFieldToFilter('main_table.customer_id', $idCustomer);
			
		foreach ($abandonedCartCollection as $cart) {
			return $cart->getCreatedAt();
		}
	}
	
	/**
	 * Retourne toutes les commandes d'un client
	 *
	 * @param int $idCustomer
	 * @return Mage_Sales_Model_Resource_Order_Collection
	 */
	private function _getOrders($idCustomer)
	{
		return Mage::getModel('sales/order')
			->getCollection()
			->addFieldToFilter('customer_id', array('eq' => $idCustomer));
	}
}
