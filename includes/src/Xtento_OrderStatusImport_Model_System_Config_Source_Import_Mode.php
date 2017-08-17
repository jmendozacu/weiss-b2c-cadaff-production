<?php

/**
 * Product:       Xtento_OrderStatusImport (1.3.5)
 * ID:            7+8GyGPLxVb3aaft2kN1w3zyMtqYo9t8GpL/co99esc=
 * Packaged:      2014-10-29T19:12:32+00:00
 * Last Modified: 2010-06-01T15:20:13+02:00
 * File:          app/code/local/Xtento/OrderStatusImport/Model/System/Config/Source/Import/Mode.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderStatusImport_Model_System_Config_Source_Import_Mode
{

    public function toOptionArray()
    {
        $modes[] = array('value' => 'XML', 'label' => Mage::helper('orderstatusimport')->__('XML'));
        $modes[] = array('value' => 'CSV', 'label' => Mage::helper('orderstatusimport')->__('CSV'));
        return $modes;
    }

}
