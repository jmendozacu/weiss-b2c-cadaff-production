<?php

/**
 * Product:       Xtento_OrderExport (1.8.5)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-07-30T07:28:55+00:00
 * Last Modified: 2013-02-10T16:57:50+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/System/Config/Source/Destination/Type.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_System_Config_Source_Destination_Type
{
    public function toOptionArray()
    {
        return Mage::getSingleton('xtento_orderexport/destination')->getTypes();
    }

    public function getName($type) {
        foreach ($this->toOptionArray() as $optionType => $name) {
            if ($optionType == $type) {
                return $name;
            }
        }
        return '';
    }
}