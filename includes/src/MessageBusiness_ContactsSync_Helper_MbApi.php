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
class MessageBusiness_ContactsSync_Helper_MbApi extends Mage_Core_Helper_Abstract
{
	/**
	 * URL du WSDL de Message Business
	 *
	 */
	const MB_WSDL = 'https://services.message-business.com/v3/api/PublicInterface.svc/wsdl';
	
	/**
	 * Numéro du compte
	 *
	 * @var string
	 */
	private $accountNumber;
	
	/**
	 * ApiKey
	 *
	 * @var string
	 */
	private $apikey;
	
	/**
	 * __construct
	 *
	 */
	public function __construct()
	{
		$this->accountNumber = Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_ACCOUNT_NUMBER);
		$this->apikey = Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_ACCOUNT_APIKEY);
	}
	
	/**
	 * Sauvegarde des paramètres d'authentification
	 *
	 * @return mixed
	 */
	public function saveAuthConfig()
	{
		if ($this->setPrivateKey()) {
			$this->setBaseUrl();
		}
	}
	
	/**
	 * Import / configuration de Message Business
	 *
	 * @return mixed
	 */
	public function runImport()
	{
		try {
			
			$this->setResultFields();
			
			// Création des champs optin
			$this->createOptinFields();
			
			// Création des champs personnalisés
			$this->createAdditionalFields();
			$this->createSegments();
			
			// Version synchro complète
			if(Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_ACCEPT_INTERFACE_LEVEL) == MessageBusiness_ContactsSync_Model_System_Config_Source_Synchro_Type::SYNC_COMPLETE) {
				$this->createAdditionalFieldsFull();
				$this->createSegmentsFull();
			}
			
			// Synchro des contacts
			$this->syncContacts();

		} catch (Exception $e) {
			//Mage::getSingleton('core/session')->addError($e->getMessage());
		}

		return $result;
	}
	
	
	/**
	 * Import / configuration de Message Business
	 *
	 * @return mixed
	 */
	public function stopImport()
	{
		try {
			$this->getSoapClient()->SetAccountDataAttribute(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'dataId' => 2,
				'dataValue' => 'stop extract'
			));
			sleep(3);
		} catch (Exception $e) {
			//Mage::getSingleton('core/session')->addError($e->getMessage());
		}
	}
	
	
	/**
	 * Paramétrage et envoi de la commande d'import Message Business
	 *
	 */
	private function syncContacts()
	{
		try {
			$fullExtract = (Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FULL_EXTRACT)) ? ' full' : '';
			$withOptinSync = (Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_ACCEPT_INTERFACE_OPTION)) ? '  withoptinsync' : '';
			$offset = new DateTime('now');
			$offset = $offset->format('Z');
			$cmd = 'start extract'.$withOptinSync.''.$fullExtract.' offset='.$offset.' culture=' . Mage::getStoreConfig('general/country/default') . '-' . Mage::getStoreConfig('general/locale/code');
			Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_LASTCMD, $cmd);
			
			$this->getSoapClient()->SetAccountDataAttribute(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'dataId' => 2,
				'dataValue' => $cmd));
			sleep(3);
		} catch (Exception $e) {
			//Mage::getSingleton('core/session')->addError($e->getMessage());
		}
	}

	/**
	 * Récupération et set des champs personnalisés
	 *
	 */
	private function setResultFields()
	{
		$this->resultFields = $this->getSoapClient()->GetAccountContactAttributes(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey))
			->GetAccountContactAttributesResult;
	}
	
	/**
	 * Création des champs personnalisés d'optin
	 *
	 * @return true
	 */
	private function createOptinFields()
	{
		// if (is_null(Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINID))) {
		$doc = new DOMDocument();
		$doc->loadXML($this->resultFields);
		$xpath = new DOMXPath($doc);
		$entries = $xpath->query("//Fields/Field[@Description='magento_optin']");
		if ($entries->length == 0) {
			// Champ principal optin
			$optinid = $this->getSoapClient()->AddAccountContactAttribute(array(
					'accountId' => $this->accountNumber,
					'apiKey' => $this->apikey,
					'name' => Mage::helper('core')->__('[MG] Newsletter subscriber'),
					'format' => 'SingleSelection|magento_optin'))
				->AddAccountContactAttributeResult;
			
			// Optinidno
			$optinidno = $this->getSoapClient()->AddAccountContactAttributeValue(array(
					'accountId' => $this->accountNumber,
					'apiKey' => $this->apikey,
					'attributeId' => $optinid,
					'value' => Mage::helper('core')->__('No'),
					'index' => '0'))
				->AddAccountContactAttributeValueResult;
			
			// Optinidyes
			$optinidyes = $this->getSoapClient()->AddAccountContactAttributeValue(array(
					'accountId' => $this->accountNumber,
					'apiKey' => $this->apikey,
					'attributeId' => $optinid,
					'value' => Mage::helper('core')->__('Yes'),
					'index' => '1'))
				->AddAccountContactAttributeValueResult;
				
			Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINID, $optinid);
			Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINIDYES, $optinidyes);
			Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINIDNO, $optinidno);
			Mage::getConfig()->reinit();
		}
		return true;
	}
	
	/**
	 * Création des champs personnalisés dans Message Business
	 *
	 */
	private function createAdditionalFields()
	{
		$doc = new DOMDocument();
		$doc->loadXML($this->resultFields);
		$xpath = new DOMXPath($doc);
		
		$fields = array(
				array('magento_dateadd', '[MG] Date of Registration', 'DateTime'),
				array('magento_customerid', '[MG] Customer ID in Magento', 'ShortText'));
		
		if (Mage::getStoreConfig('customer/address/dob_show') == 'opt' || Mage::getStoreConfig('customer/address/dob_show') == 'req') {
				$fields[] = array('magento_birthday', '[MG] Date of Birth', 'DateTime');
		}

		foreach($fields as $field) {
			$query = "//Fields/Field[@Description='".$field[0]."']";
			$entries = $xpath->query($query);
			if ($entries->length == 0) {
				Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_PREFIX . '/fields/' . $field[0],
						$this->getSoapClient()->AddAccountContactAttribute(array(
						'accountId' => $this->accountNumber,
						'apiKey' => $this->apikey,
						'name' => Mage::helper('core')->__($field[1]),
						'format' => $field[2].'|'.$field[0]))
					->AddAccountContactAttributeResult);
			}
		}
		Mage::getConfig()->reinit();
		return true;
	}
	
	/**
	 * Création des champs personnalisés dans Message Business (version Full)
	 *
	 */
	private function createAdditionalFieldsFull()
	{
		$doc = new DOMDocument();
		$doc->loadXML($this->resultFields);
		$xpath = new DOMXPath($doc);
		
		$fields = array(
			array('magento_lastconnection', '[MG] Date of Last Customer Login', 'DateTime'),
			array('magento_lastcancelledcartdate', '[MG] Last Date of Abandoned Shopping cart', 'DateTime'),
			array('magento_lastdeliverydate', '[MG] Date of Last Delivery', 'DateTime'),
			array('magento_lastorderdate', '[MG] Date of Last Order', 'DateTime'),
			array('magento_lastordertotal', '[MG] Amount of Last Order', 'Number'),
			array('magento_firstorderdate', '[MG] Date of First Order', 'DateTime'),
			array('magento_ordersfrequency', '[MG] Average frequency between Orders (days)', 'Number'),
			array('magento_orderstotal', '[MG] Total Orders Amount', 'Number'),
			array('magento_orderscount', '[MG] Total Orders', 'Number')
		);

		foreach($fields as $field) {
			$query = "//Fields/Field[@Description='".$field[0]."']";
			$entries = $xpath->query($query);
			if ($entries->length == 0) {
				Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_PREFIX . '/fields/' . $field[0],
						$this->getSoapClient()->AddAccountContactAttribute(array(
						'accountId' => $this->accountNumber,
						'apiKey' => $this->apikey,
						'name' => Mage::helper('core')->__($field[1]),
						'format' => $field[2].'|'.$field[0]))
					->AddAccountContactAttributeResult);
			}
		}
		Mage::getConfig()->reinit();
		return true;
	}
	
	/**
	 * Création des segments
	 *
	 * @return true
	 */
	private function createSegments()
	{
		$result = $this->getSoapClient()->GetAccountSegments(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey))
			->GetAccountSegmentsResult;
		$doc = new DOMDocument();
		$doc->loadXML($result);
		$xpath = new DOMXPath($doc);

		$segments = array(
			array(
				'name' => 'Newsletter Subcribers [MG]',
				'mode' => 'Intersection',
				'id' => 'magento_subscribers',
				'details' => '<Criterias><Criteria guid="f8bd77f7-800b-4425-bc05-93e409533636" reference="selection-equals-list" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINID) . '" op="selection-equals-list" is="true" value1="0,' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINIDYES) . ',0" value2="" /></Criterias>'
			)
		);

		foreach($segments as $segment) {
			$query = "//Segments/Segment[@Description='".$segment['id']."']";
			$entries = $xpath->query($query);
			if ($entries->length == 0) {
				$res = $this->getSoapClient()->AddAccountSegment(array(
					'accountId' => $this->accountNumber,
					'apiKey' => $this->apikey,
					'name' => Mage::helper('core')->__($segment['name']),
					'mode' => $segment['mode'].'|'.$segment['id'],
					'details' => $segment['details']));
			}
		}
		return true;
	}
	
	/**
	 * Création des segments (version full)
	 *
	 */
	private function createSegmentsFull()
	{
		$result = $this->getSoapClient()->GetAccountSegments(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey))
			->GetAccountSegmentsResult;
		$doc = new DOMDocument();
		$doc->loadXML($result);
		$xpath = new DOMXPath($doc);

		$segments = array(
			array(
				'name' => 'Customers - All [MG]',
				'mode' => 'Intersection',
				'id' => 'magento_customers',
				'details' => '<Criterias><Criteria guid="e2eced35-0a19-4d35-8fa4-a377e6cd15f1" reference="str-containssomething" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_CUSTOMERID) . '" op="str-containssomething" is="true" value1="" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers - Without Revenue [MG]',
				'mode' => 'Intersection',
				'id' => 'magento_customerswithoutpurchases',
				'details' => '<Criterias><Criteria guid="28c30297-4706-48af-8afb-b1216c9a394a" reference="num-equals" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSTOTAL) . '" op="num-equals" is="true" value1="0" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers - With Revenue [MG]',
				'mode' => 'Intersection',
				'id' => 'magento_customerswithpurchases',
				'details' => '<Criterias><Criteria guid="28c30297-4706-48af-8afb-b1216c9a394a" reference="num-higher-strict" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSTOTAL) . '" op="num-higher-strict" is="true" value1="0" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] First purchase',
				'mode' => 'Intersection',
				'id' => 'magento_customersnew',
				'details' => '<Criterias><Criteria guid="383dcf98-82af-4962-a73f-30c0fda09c46" reference="num-equals" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSCOUNT) . '" op="num-equals" is="true" value1="1" value2="" /><Criteria guid="28c30297-4706-48af-8afb-b1216c9a394a" reference="num-higher-strict" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSTOTAL) . '" op="num-higher-strict" is="true" value1="0" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] 2 Purchases and More',
				'mode' => 'Intersection',
				'id' => 'magento_customersnotnew',
				'details' => '<Criterias><Criteria guid="7f508a38-1426-4f7b-bacd-7c6fd5186ead" reference="num-higher" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSCOUNT) . '" op="num-higher" is="true" value1="2" value2="" /><Criteria guid="28c30297-4706-48af-8afb-b1216c9a394a" reference="num-higher-strict" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSTOTAL) . '" op="num-higher-strict" is="true" value1="0" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] with cancelled carts (over 2 days)',
				'mode' => 'Intersection',
				'id' => 'magento_customerscancelled',
				'details' => '<Criterias><Criteria guid="68e3188d-29d7-4bda-9755-cc47d6078f1f" reference="num-higher" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSCOUNT) . '" op="num-higher" is="true" value1="1" value2="" /><Criteria guid="2f0a2931-754c-4082-8bb5-268772669906" reference="date-containssomething" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_LASTCANCELLEDCARTDATE) . '" op="date-containssomething" is="true" value1="" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] Motivated (30 days)',
				'mode' => 'Intersection',
				'id' => 'magento_contactsmotivated',
				'details' => '<Criterias><Criteria guid="458a4bfe-7706-4fb6-bde1-8f2d56ff8f26" reference="date-before-less-absnow" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_LASTCONNECTION) . '" op="date-before-less-absnow" is="true" value1="30" value2="" /><Criteria guid="d1917c79-8fc6-45d5-bfb2-a4256a881dff" reference="date-before-more-absnow" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_LASTORDERDATE) . '" op="date-before-more-absnow" is="true" value1="30" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] Delivered (last 7 days)',
				'mode' => 'Intersection',
				'id' => 'magento_customersdelivered',
				'details' => '<Criterias><Criteria guid="44cf1ecd-8126-49ff-af2e-675743c78f37" reference="date-before-more-absnow" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_LASTDELIVERYDATE) . '" op="date-before-more-absnow" is="true" value1="7" value2="" /></Criterias>'
			),
			array(
				'name' => 'Customers [MG] 90 days without order',
				'mode' => 'Intersection',
				'id' => 'magento_customersnorecentorder',
				'details' => '<Criterias><Criteria guid="79f1bb64-46d7-436a-a24f-1ebd9a5eafab" reference="num-higher" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSCOUNT) . '" op="num-higher" is="true" value1="1" value2="" /><Criteria guid="974fd0b9-cea2-4045-bf1e-5f09a5b21610" reference="date-before-more-absnow" type="ContactAttribute" id="' . Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_MAGENTO_LASTDELIVERYDATE) . '" op="date-before-more-absnow" is="true" value1="90" value2="" /></Criterias>'
			)
		);

		foreach($segments as $segment) {
			$query = "//Segments/Segment[@Description='".$segment['id']."']";
			$entries = $xpath->query($query);
			if ($entries->length == 0) {
				$res = $this->getSoapClient()->AddAccountSegment(array(
					'accountId' => $this->accountNumber,
					'apiKey' => $this->apikey,
					'name' => Mage::helper('core')->__($segment['name']),
					'mode' => $segment['mode'].'|'.$segment['id'],
					'details' => $segment['details']));
			}
		}
		return true;
	}
	
	/**
	 * Génération de l'accessKey
	 *
	 * @return mixed
	 */
	public function generateAccesskey($length = 32)
	{
		$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0, $passwd = ''; $i < $length; $i++) {
        	$passwd .= substr($str, mt_rand(0, strlen($str) - 1), 1);
        }
        Mage::getModel('core/config')->saveConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_ACCOUNT_ACCESSKEY, $passwd); 
        return $passwd;
	}
	
	/**
	 * Récupération de l'accesskey
	 *
	 * @return mixed|null
	 */
	public function getAccessKey()
	{
		$accessKey = Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_ACCOUNT_ACCESSKEY);
		if (is_null($accessKey)) {
			$accessKey = $this->generateAccesskey();
		}
		return $accessKey;
	}
	
	
	/**
	 * Récupération d'une valeur MB par son dataId
	 *
	 * @return mixed
	 */
	public function getDataValue($dataId)
	{
		return $this->callApi('GetAccountDataAttribute', array(
			'accountId' => $this->accountNumber,
			'apiKey' => $this->apikey,
			'dataId' => $dataId
		));
	}
	
	/**
	 * Enregistrement de l'URL de l'instance Magento dans Message Business
	 *
	 * @return mixed
	 */
	public function setBaseUrl()
	{
		try {
			return $this->getSoapClient()->SetAccountDataAttribute(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'dataId' => 0,
				'dataValue' => Mage::getBaseUrl() . '[MAGENTO]'
			));
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError(Mage::helper('core')->__("An error has occurred"));
		}
	}
	
	/**
	 * Enregistrement de l'apiKey dans Message Business
	 *
	 * @return mixed
	 */
	public function setPrivateKey()
	{
		try {
			return $this->getSoapClient()->SetAccountDataAttribute(array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'dataId' => 1,
				'dataValue' => $this->getAccessKey()
			));
		} catch (Exception $e) {
			$message = "An error has occurred";
			if (strpos($e->getMessage(), 'Account not existing') !== false) {
				$message = "The specified Message Business account number is not known. This may be an error in typing the account number or this account is no longer existing.";
			} else if (strpos($e->getMessage(), 'Account not activated or validated') !== false) {
				$message = "The specified Message Business account is not yet activated. Please login, and activate the specified account before continuing the configuration of the module.";
			} else if (strpos($e->getMessage(), 'Account hasn\'t any API key') !== false ||
					strpos($e->getMessage(), 'Account has an empty API key') !== false) {
				$message = "There's no API key currently set for this Message Business account. Please login, then go the the section More > Your Settings > Language and Interface and generate a new API key Note: The new API key will be available one hour after its generation.";
			} else if (strpos($e->getMessage(), 'Account does not have the specified API key') !== false) {
				$message = "The API key you have typed does not match one the keys of the specified Message Business account. Please login, then go to the section More > Your Settings > Language and Interface and copy an already existing API key or generate a new one. Note: The new API key will be available one hour after its generation.";
			}
			Mage::getSingleton('core/session')->addError(Mage::helper('core')->__($message));
			return false;
		}
		
	}
	
	
	/**
	 * Push d'un email optin dans Message Business
	 *
	 * @return mixed
	 */
	public function pushOptin($email, $status)
	{
		$contactDatas = $this->getSoapClient()->SetContactData(
			array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'contactKey' => $email, 
				'attributeId' => Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINID), 
				'data' => ($status === true) ? Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINIDYES) : Mage::getStoreConfig(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_SYNC_FIELDS_OPTINIDNO), 
				'createIfKeyNotExisting'=>'true'
			)
		);

		$contactDatas = $this->getSoapClient()->SetContactData(
			array(
				'accountId' => $this->accountNumber,
				'apiKey' => $this->apikey,
				'contactKey' => $email, 
				'attributeId' => 'emailoptin', 
				'data' => 'yes1', 
				'createIfKeyNotExisting'=>'true'
			)
		);
		
		return true;
	}
	
	/**
	 * Appel de l'API Message Business
	 *
	 * @param string $action
	 * @param array $args
	 * @return mixed
	 */
	public function callApi($action, array $args = array())
	{
		try {
			$result = $this->getSoapClient()->$action($args);
		} catch (Exception $e) {
			//Mage::getSingleton('core/session')->addError($e->getMessage());
		}
		
		return $result;
	}
	
	/**
	 * Retourne l'objet SoapClient de Message Business
	 *
	 * @return SoapClient
	 */
	public function getSoapClient()
	{
		return new SoapClient(self::MB_WSDL);
	}
}
