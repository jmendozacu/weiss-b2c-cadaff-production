<?php

/**
 * Product:       Xtento_OrderStatusImport (1.3.5)
 * ID:            7+8GyGPLxVb3aaft2kN1w3zyMtqYo9t8GpL/co99esc=
 * Packaged:      2014-10-29T19:12:32+00:00
 * Last Modified: 2012-10-03T10:38:05+02:00
 * File:          app/code/local/Xtento/OrderStatusImport/Model/System/Config/Backend/Import/Enabled.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderStatusImport_Model_System_Config_Backend_Import_Enabled extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        Mage::register('osi_modify_event', true, true);
        parent::_beforeSave();
    }

    public function has_value_for_configuration_changed($observer)
    {
        if (Mage::registry('osi_modify_event') == true) {
            Mage::unregister('osi_modify_event');
            Xtento_OrderStatusImport_Model_System_Config_Source_Order_Status::isEnabled();
        }
    }
}
