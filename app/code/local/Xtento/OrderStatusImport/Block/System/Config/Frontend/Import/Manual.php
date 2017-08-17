<?php

/**
 * Product:       Xtento_OrderStatusImport (1.3.5)
 * ID:            7+8GyGPLxVb3aaft2kN1w3zyMtqYo9t8GpL/co99esc=
 * Packaged:      2014-10-29T19:12:32+00:00
 * Last Modified: 2011-11-13T18:35:41+01:00
 * File:          app/code/local/Xtento/OrderStatusImport/Block/System/Config/Frontend/Import/Manual.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderStatusImport_Block_System_Config_Frontend_Import_Manual extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $this->setElement($element);
        return $this->_getAddRowButtonHtml($this->__('Upload file and run import now'));
    }

    protected function _getAddRowButtonHtml($title) {
        return $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setType('button')
                        ->setLabel($this->__($title))
                        ->setOnClick("configForm.submit()")
                        ->toHtml();
    }

}
