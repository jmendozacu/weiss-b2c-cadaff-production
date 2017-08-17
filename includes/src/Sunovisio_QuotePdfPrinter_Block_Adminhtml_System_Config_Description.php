<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Description
 *
 * @author Administrator
 */
class Sunovisio_QuotePdfPrinter_Block_Adminhtml_System_Config_Description extends Mage_Adminhtml_Block_System_Config_Form_Field {
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('quotepdfprinter/system/config/description.phtml');
        }
        return $this;
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(array(
            'text' => Mage::helper('quotepdfprinter')->__($originalData['text'])
        ));
        return $this->_toHtml();
    }
}

?>
