<?php

/**
 * Product:       Xtento_OrderStatusImport (1.3.5)
 * ID:            7+8GyGPLxVb3aaft2kN1w3zyMtqYo9t8GpL/co99esc=
 * Packaged:      2014-10-29T19:12:32+00:00
 * Last Modified: 2011-12-30T22:20:05+01:00
 * File:          app/code/local/Xtento/OrderStatusImport/Model/System/Config/Backend/Import/Servername.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderStatusImport_Model_System_Config_Backend_Import_Servername extends Mage_Core_Model_Config_Data
{

    public function afterLoad()
    {
        $sName1 = Mage::getModel('orderstatusimport/system_config_backend_import_server')->getFirstName();
        $sName2 = Mage::getModel('orderstatusimport/system_config_backend_import_server')->getSecondName();
        if ($sName1 !== $sName2) {
            $this->setValue(sprintf('%s (Main: %s)', $sName1, $sName2));
        } else {
            $this->setValue(sprintf('%s', $sName1));
        }
    }

}
