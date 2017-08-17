<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2014-05-15T18:18:53+02:00
 * File:          app/code/local/Xtento/OrderExport/Model/Export/Entity/Awrma.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Export_Entity_Awrma extends Xtento_OrderExport_Model_Export_Entity_Abstract
{
    protected $_entityType = Xtento_OrderExport_Model_Export::ENTITY_AWRMA;

    protected function _construct()
    {
        $this->_collection = Mage::getResourceModel('awrma/entity_collection');
        parent::_construct();
    }

    public function setCollectionFilters($filters)
    {
        foreach ($filters as $filter) {
            foreach ($filter as $attribute => $filterArray) {
                if ($attribute == 'increment_id') {
                    $attribute = 'id';
                }
                if ($attribute == 'entity_id') {
                    $attribute = 'id';
                }
                $this->_collection->addFieldToFilter($attribute, $filterArray);
            }
        }
        return $this->_collection;
    }
}