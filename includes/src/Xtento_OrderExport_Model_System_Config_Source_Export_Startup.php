<?php

/**
 * Product:       Xtento_OrderExport (1.8.5)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-07-30T07:28:55+00:00
 * Last Modified: 2012-12-03T21:38:02+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/System/Config/Source/Export/Startup.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_System_Config_Source_Export_Startup
{

    public function toOptionArray()
    {
        $pages = array();
        foreach (Mage::getBlockSingleton('xtento_orderexport/adminhtml_widget_menu')->getMenu() as $controllerName => $entryConfig) {
            if (!$entryConfig['is_link']) {
                continue;
            }
            $pages[] = array('value' => $controllerName, 'label' => Mage::helper('xtento_orderexport')->__($entryConfig['name']));
        }
        return $pages;
    }

}