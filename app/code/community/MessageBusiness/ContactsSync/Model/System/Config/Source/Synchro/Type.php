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
class MessageBusiness_ContactsSync_Model_System_Config_Source_Synchro_Type
{
	/**
	 * Synchronisation simple
	 *
	 * @var int
	 */
	const SYNC_SIMPLE = 1;
	
	/**
	 * Synchronisation complète
	 *
	 * @var int
	 */
	const SYNC_COMPLETE = 2;
	
	/**
	 * Retourne les différents type de synchronisation
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			array(
				'label' => Mage::helper('core')->__('Import includes contact (email, name, ...), as well as customer data (Revenue, frequency)'),
				'value' => self::SYNC_COMPLETE 
			),
			array(
				'label' => Mage::helper('core')->__('Import only contact details (email, name, ...)'),
				'value' => self::SYNC_SIMPLE 
			)
		);
	}
}