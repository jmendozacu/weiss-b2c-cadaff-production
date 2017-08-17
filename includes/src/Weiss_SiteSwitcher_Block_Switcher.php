<?php

/**
 * Weiss SiteSwitcher module Switcher block class
 *
 * @category   Weiss
 * @package    Weiss_SiteSwitcher
 * @author     Jérôme Carrot <jecar@smile.fr>
 * @copyright  Smile 2015
 */
class Weiss_SiteSwitcher_Block_Switcher extends Mage_Core_Block_Template
{
    const XML_PATH_MAX_VIEWS        = 'design/site_switcher/max_views';
    const XML_PATH_MAX_DELAY        = 'design/site_switcher/max_delay';
    const XML_PATH_TITLE            = 'design/site_switcher/title';
    const XML_PATH_CMS_LINK_PAGE    = 'design/site_switcher/cms_link_page';
    const XML_PATH_CMS_LINK_LABEL   = 'design/site_switcher/cms_link_label';
    const XML_PATH_SELECTOR_LABEL   = 'design/site_switcher/selector_label';
    const XML_PATH_SELECTOR_OPTIONS = 'design/site_switcher/selector_options';
    const XML_PATH_FOOTER_TEXT      = 'design/site_switcher/footer_text';

    const CACHE_TAG = 'SITE_SWITCHER';

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->setCacheLifetime(24*3600);
        $this->setCacheTags(array(self::CACHE_TAG));
    }

    /**
     * Retrieve specific cache key info
     * Override parent method to include block visibility in cache key info
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $cacheInfo   = parent::getCacheKeyInfo();
        $cacheInfo[] = $this->isVisible() ? 'visible' : 'hidden';

        return $cacheInfo;
    }

    /**
     * Tells if the block should be visible or not
     */
    public function isVisible()
    {
        if (!$this->hasIsVisible()) {
            /** @var Mage_Customer_Model_Session $session */
            $session   = Mage::getSingleton('customer/session');
            $isVisible = true;

            if (!$session->hasSiteSwitcherFirstViewStamp()) {
                $session->setSiteSwitcherFirstViewStamp(time());
                $minutesCount = 0;
                $viewsCount   = 1;
            } else {
                $minutesCount = (time() - $session->getSiteSwitcherFirstViewStamp()) / 60;
                $viewsCount   = $session->getSiteSwitcherViewsCount() + 1;
            }

            $session->setSiteSwitcherViewsCount($viewsCount);

            if ($session->isLoggedIn()) {
                $isVisible = false;
            } else {
                $maxViews = (int) Mage::getStoreConfig(self::XML_PATH_MAX_VIEWS);
                $maxDelay = (int) Mage::getStoreConfig(self::XML_PATH_MAX_DELAY);

                if ($maxViews XOR $maxDelay) {
                    $isVisible = $viewsCount <= $maxViews || $minutesCount <= $maxDelay;
                } else if ($maxViews && $maxDelay) {
                    $isVisible = $viewsCount <= $maxViews && $minutesCount <= $maxDelay;
                }
            }

            $this->setIsVisible($isVisible);
        }

        return $this->getIsVisible();
    }

    /**
     * Retrieve store configuration for block title
     *
     * @return string
     */
    public function getTitle()
    {
        return Mage::getStoreConfig(self::XML_PATH_TITLE);
    }

    /**
     * Retrieve store configuration for block CMS link label
     *
     * @return string
     */
    public function getCmsLinkLabel()
    {
        return Mage::getStoreConfig(self::XML_PATH_CMS_LINK_LABEL);
    }

    /**
     * Retrieve store configuration for block CMS link label
     *
     * @return string
     */
    public function getCmsLinkPageUrl()
    {
        $pageIdentifier = Mage::getStoreConfig(self::XML_PATH_CMS_LINK_PAGE);
        return Mage::getUrl(null, array('_direct' => $pageIdentifier));
    }

    /**
     * Retrieve store configuration for block selector label
     *
     * @return string
     */
    public function getSelectorLabel()
    {
        return Mage::getStoreConfig(self::XML_PATH_SELECTOR_LABEL);
    }

    /**
     * Retrieve store configuration for block selector options
     * Parse textarea content to return a clean associative array
     *
     * @return array
     */
    public function getSelectorOptions()
    {
        $rawConfig = Mage::getStoreConfig(self::XML_PATH_SELECTOR_OPTIONS);
        $options   = array();
        $matches   = array();

        foreach (explode("\n", $rawConfig) as $rawOption) {
            //$rawOption = preg_replace('/\s/', '', $rawOption);
            $aOption = explode('(',$rawOption);
            $label = $aOption[0];
            $value = str_replace(')','',$aOption[1]);
            /*
            preg_match_all('/([^(]*)\((.*)\)$/', $rawOption, $matches, PREG_SET_ORDER);

            if (count($matches) && count($matches[0]) > 2) {
                $label = $matches[0][1];
                $value = $matches[0][2];
            } else {
                $label = $rawOption;
                $value = $this->getUrl();
            }
            */
            if (strlen($label)) {
                $options[] = array('label' => $label, 'value' => $value);
            }
        }

        return $options;
    }

    /**
     * Retrieve store configuration for footer text
     *
     * @return string
     */
    public function getFooterText()
    {
        return Mage::getStoreConfig(self::XML_PATH_FOOTER_TEXT);
    }
}
