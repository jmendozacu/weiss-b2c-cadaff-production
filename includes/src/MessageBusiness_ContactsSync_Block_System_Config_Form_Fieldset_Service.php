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
class MessageBusiness_ContactsSync_Block_System_Config_Form_Fieldset_Service extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	/**
	 * Retourne le contenu de l'onglet d'information
	 *
	 * @param Varien_Data_Form_Element_Abstract $element
	 * @return string
	 */
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		$html = $this->_getHeaderHtml($element);
		$html .= Mage::helper('core')->__(
			'Find all information regarding credentials on %s. as well as possible usages of the Message Business module for Magento. If you do not have an account on Message Business, %s.',
			'<a href="http://campus.message-business.com" target="_blank">' . Mage::helper('core')->__('Campus Business User') . '</a>', 
			'<a href="http://www.message-business.com/decouvrez_Message_Business_sans_engagement_et_gratuitement.aspx" target="_blank">' . Mage::helper('core')->__('now signup to have a free evaluation of Message Business') . '</a>'
		);
		$html.= $this->_getFooterHtml($element);
		
		return $html;
	}
}