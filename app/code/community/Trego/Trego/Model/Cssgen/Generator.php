<?php 
class Trego_Trego_Model_Cssgen_Generator extends Mage_Core_Model_Abstract{ 
    public function __construct(){
        parent::__construct(); 
    } 
    public function generateCss($type, $websiteCode, $storeCode){
        if ($websiteCode){ 
            if ($storeCode) {
                $this->_generateStoreCss($type, $storeCode);
            } 
            else {
                $this->_generateWebsiteCss($type, $websiteCode); 
            }
        }else{
            $websites = Mage::app()->getWebsites(false, true);
            foreach ($websites as $code => $value) {
                $this->_generateWebsiteCss($type, $code); 
            }
        } 
    } 
    protected function _generateWebsiteCss($type, $websiteCode) {
        $website = Mage::app()->getWebsite($websiteCode);
        foreach ($website->getStoreCodes() as $code){ 
            $this->_generateStoreCss($type, $code);
        } 
    }
    protected function _generateStoreCss($type, $storeCode){
        if (!Mage::app()->getStore($storeCode)->getIsActive()) 
            return;
        $str1 = '_' . $storeCode;
        $str2 = $type . $str1 . '.css';
        $str3 = Mage::helper('trego/cssgen')->getGeneratedCssDir() . $str2;
        $str4 = 'trego/css/' . $type . '.phtml';
        Mage::register('cssgen_store', $storeCode);
        try{ 
            $block = Mage::app()->getLayout()->createBlock("core/template")->setData('area', 'frontend')->setTemplate($str4)->toHtml();
            if (empty($block)) {
                throw new Exception( Mage::helper('trego')->__("Template file is empty or doesn't exist: %s", $str4) );
            }
            $file = new Varien_Io_File(); 
            $file->setAllowCreateFolders(true); 
            $file->open(array( 'path' => Mage::helper('trego/cssgen')->getGeneratedCssDir() )); 
            $file->streamOpen($str3, 'w+'); 
            $file->streamLock(true); 
            $file->streamWrite($block); 
            $file->streamUnlock(); 
            $file->streamClose(); 
        }catch (Exception $e){ 
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('trego')->__('Failed generating CSS file: %s in %s', $x12, Mage::helper('trego/cssgen')->getGeneratedCssDir()). '<br/>Message: ' . $e->getMessage()); 
            Mage::logException($e);
        }
        Mage::unregister('cssgen_store'); 
    } 
}