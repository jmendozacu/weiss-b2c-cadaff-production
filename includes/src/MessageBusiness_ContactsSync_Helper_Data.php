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
class MessageBusiness_ContactsSync_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Section prefix
	 *
	 */
	const XML_PATH_PREFIX = 'mb_contactssync';
	
	/**
	 * Account Number
	 *
	 */
	const XML_PATH_ACCOUNT_NUMBER = 'mb_contactssync/account/account_number';
	
	/**
	 * Apikey
	 *
	 */
	const XML_PATH_ACCOUNT_APIKEY = 'mb_contactssync/account/apikey';
	
	/**
	 * Access Key
	 *
	 */
	const XML_PATH_ACCOUNT_ACCESSKEY = 'mb_contactssync/accesskey';
	
	/**
	 * Accept interface level
	 *
	 */
	const XML_PATH_SYNC_ACCEPT_INTERFACE_LEVEL = 'mb_contactssync/sync/accept_interface_level';
	
	/**
	 * Type de synchronisation
	 *
	 */
	const XML_PATH_SYNC_FULL_EXTRACT = 'mb_contactssync/sync/full_extract';
	
	/**
	 * Accept interface option
	 *
	 */
	const XML_PATH_SYNC_ACCEPT_INTERFACE_OPTION = 'mb_contactssync/sync/accept_interface_option';
	
	/**
	 * Run Sync
	 *
	 */
	const XML_PATH_SYNC_RUN_SYNC = 'mb_contactssync/sync/run_sync';
	
	/**
	 * Newsletter synchronisation
	 *
	 */
	const XML_PATH_NEWSLETTER_SUBSCRIPTION = 'mb_contactssync/newsletter/subscription';
	
	/**
	 * Optinid
	 *
	 */
	const XML_PATH_SYNC_FIELDS_OPTINID = 'mb_contactssync/fields/optinid';
	
	/**
	 * optinid yes
	 *
	 */
	const XML_PATH_SYNC_FIELDS_OPTINIDYES = 'mb_contactssync/fields/optinidyes';
	
	/**
	 * optinid no
	 *
	 */
	const XML_PATH_SYNC_FIELDS_OPTINIDNO = 'mb_contactssync/fields/optinidno';
	
	/**
	 * Customer ID
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_CUSTOMERID = 'mb_contactssync/fields/magento_customerid';
	
	/**
	 * ORders total
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSTOTAL = 'mb_contactssync/fields/magento_orderstotal';
	
	/**
	 * Orders count
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_ORDERSCOUNT = 'mb_contactssync/fields/magento_orderscount';
	
	/**
	 * Last canceled cart date
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_LASTCANCELLEDCARTDATE = 'mb_contactssync/fields/magento_lastcancelledcartdate';
	
	/**
	 * Last connection
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_LASTCONNECTION = 'mb_contactssync/fields/magento_lastconnection';
	
	/**
	 * Last order date
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_LASTORDERDATE = 'mb_contactssync/fields/magento_lastorderdate';
	
	/**
	 * Last delivery date
	 *
	 */
	const XML_PATH_SYNC_FIELDS_MAGENTO_LASTDELIVERYDATE = 'mb_contactssync/fields/magento_lastdeliverydate';
	
	/**
	 * last command
	 *
	 */
	const XML_PATH_SYNC_LASTCMD = 'mb_contactssync/fields/lastcmd';
}