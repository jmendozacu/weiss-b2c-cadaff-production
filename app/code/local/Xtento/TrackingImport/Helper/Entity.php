<?php

/**
 * Product:       Xtento_TrackingImport (2.0.8)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-08-10T15:37:56+00:00
 * Last Modified: 2014-06-15T14:00:10+02:00
 * File:          app/code/local/Xtento/TrackingImport/Helper/Entity.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Helper_Entity extends Mage_Core_Helper_Abstract
{
    public function getPluralEntityName($entity) {
        return $entity;
    }

    public function getEntityName($entity) {
        $entities = Mage::getModel('xtento_trackingimport/import')->getEntities();
        if (isset($entities[$entity])) {
            return $entities[$entity];
        }
        return "";
    }
}