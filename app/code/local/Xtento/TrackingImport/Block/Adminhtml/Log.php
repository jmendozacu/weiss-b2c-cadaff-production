<?php

/**
 * Product:       Xtento_TrackingImport (2.0.8)
 * ID:            LwDd+3liDc8wRnxpSMaPzTUYMCo+xh6/uCvsmyF3uk0=
 * Packaged:      2015-08-10T15:37:56+00:00
 * Last Modified: 2013-11-06T18:19:07+01:00
 * File:          app/code/local/Xtento/TrackingImport/Block/Adminhtml/Log.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Block_Adminhtml_Log extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'xtento_trackingimport';
        $this->_controller = 'adminhtml_log';
        $this->_headerText = Mage::helper('xtento_trackingimport')->__('Tracking Import - Execution Log');
        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _toHtml()
    {
        return $this->getLayout()->createBlock('xtento_trackingimport/adminhtml_widget_menu')->toHtml() . parent::_toHtml();
    }
}