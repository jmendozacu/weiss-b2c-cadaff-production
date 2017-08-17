<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2012-11-18T20:56:11+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Export/Data/Interface.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

interface Xtento_OrderExport_Model_Export_Data_Interface {
    public function getExportData($entityType, $collectionItem);
    public function getConfiguration();
}