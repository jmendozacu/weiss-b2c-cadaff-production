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
class MessageBusiness_ContactsSync_Block_Adminhtml_sync_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	/**
	 * Set le template du bouton de lancement de l'importation
	 *
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('contactssync/system/config/sync/run.phtml');
	}
	
	/**
	 * Retourne l'élément HTML
	 *
	 * @param Varien_Data_Form_Element_Abstract $element
	 * @return string
	 */
	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
	{
		return $this->_toHtml();
	}
	
	/**
	 * Retourne le HTML du bouton
	 *
	 * @return string
	 */
	public function getButtonHtml()
	{
		$label = $this->helper('adminhtml')->__('Start import');
		$strInfos = '';
		$jsAction = 'runSync';
		
		$infos = Mage::helper('contactssync/mbApi')->getDataValue(3)->GetAccountDataAttributeResult;
		
		if (strpos($infos, 'running') !== false) {
			$label = $this->helper('adminhtml')->__('Stop the current import');
			$strInfos = $this->helper('adminhtml')->__('Import in progress');
			$jsAction = 'stopSync';
		}
		else if (intval(substr($infos, 0, 4)) > 0) {
			$label = $this->helper('adminhtml')->__('Start import');
			$strInfos = $this->helper('adminhtml')->__('Last Import Date (UTC)') . ' : ' . str_replace('running', '', $infos) ;
			$jsAction = 'runSync';
		}

		$button = $this->getLayout()->createBlock('adminhtml/widget_button')
			->setData(array(
				'id' => 'sync_button',
				'label' => $label,
				'onclick' => 'javascript:' . $jsAction . '(); return false;'
			)
		);

		return $button->toHtml() . '<br /><br />' . $strInfos;
	}
	
	
	/**
	 * Retourne le lien vers l'action du controller admin
	 *
	 * @see Sinabs_Adminhtml_AjaxController
	 * @return string
	 */
	public function getAjaxSyncUrl()
	{
		return Mage::getSingleton('adminhtml/url')->getUrl('adminmb/ajax/runSync');
	}
	
	/**
	 * Retourne le lien vers l'action du controller admin
	 *
	 * @see Sinabs_Adminhtml_AjaxController
	 * @return string
	 */
	public function getAjaxStopSyncUrl()
	{
		return Mage::getSingleton('adminhtml/url')->getUrl('adminmb/ajax/stopSync');
	}
}