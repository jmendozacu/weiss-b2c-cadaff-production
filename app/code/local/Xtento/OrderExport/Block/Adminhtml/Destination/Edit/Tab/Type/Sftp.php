<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2012-12-09T19:18:14+01:00
 * File:          app/code/local/Xtento/OrderExport/Block/Adminhtml/Destination/Edit/Tab/Type/Sftp.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Block_Adminhtml_Destination_Edit_Tab_Type_Sftp extends Xtento_OrderExport_Block_Adminhtml_Destination_Edit_Tab_Type_Ftp
{
    // SFTP Configuration
    public function getFields($form, $type = 'FTP')
    {
        parent::getFields($form, 'SFTP');
    }
}