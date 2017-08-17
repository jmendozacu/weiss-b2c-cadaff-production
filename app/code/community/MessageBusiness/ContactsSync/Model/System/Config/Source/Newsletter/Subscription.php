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
class MessageBusiness_ContactsSync_Model_System_Config_Source_Newsletter_Subscription
{
	/**
	 * Synchronisation simple
	 *
	 * @var int
	 */
	const SUBSCRIBE_YES = 1;
	
	/**
	 * Synchronisation complète
	 *
	 * @var int
	 */
	const SUBSCRIBE_NO = 2;
	
	/**
	 * Retourne les différents type de synchronisation
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			array(
				'label' => Mage::helper('core')->__('Subscribe contacts in Message Business when subscribed in Magento newsletter'),
				'value' => self::SUBSCRIBE_YES
			),
			array(
				'label' => Mage::helper('core')->__('Do not subscribe contacts in Message Business'),
				'value' => self::SUBSCRIBE_NO
			)
		);
	}
}