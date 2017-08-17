<?php

/**
 * Weiss SiteSwitcher module Observer model class
 *
 * @category   Weiss
 * @package    Weiss_SiteSwitcher
 * @author     Jérôme Carrot <jecar@smile.fr>
 * @copyright  Smile 2015
 */
class Weiss_SiteSwitcher_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * Listen to 'controller_action_postdispatch_adminhtml_system_config_save' event (backend)
     * - Trigger a cache tag event to invalid site switcher block cache
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterAdminhtmlSystemConfigSave($observer)
    {
        /** @var Mage_Adminhtml_System_ConfigController $controller */
        $controller = $observer->getControllerAction();

        if ('design' == $controller->getRequest()->getParam('section')) {
            Mage::app()->getCache()->clean(
                Zend_Cache::CLEANING_MODE_MATCHING_TAG,
                array(Weiss_SiteSwitcher_Block_Switcher::CACHE_TAG)
            );
        }
    }
}
