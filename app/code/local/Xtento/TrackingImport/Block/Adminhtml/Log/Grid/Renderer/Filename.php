<?php

/**
 * Product:       Xtento_TrackingImport (2.0.8)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-08-10T15:37:56+00:00
 * Last Modified: 2013-11-03T16:33:42+01:00
 * File:          app/code/local/Xtento/TrackingImport/Block/Adminhtml/Log/Grid/Renderer/Filename.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Block_Adminhtml_Log_Grid_Renderer_Filename extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $rowFiles = $row->getFiles();
        if (empty($rowFiles)) {
            return Mage::helper('xtento_trackingimport')->__('No files saved.');
        }
        $filenames = explode("|", $rowFiles);
        $baseFilenames = array();
        foreach ($filenames as $filename) {
            array_push($baseFilenames, basename($filename));
        }
        $baseFilenames = array_unique($baseFilenames);
        $rowText = "";
        foreach ($baseFilenames as $filename) {
            $rowText .= $filename."<br>";
        }
        return $rowText;
    }
}