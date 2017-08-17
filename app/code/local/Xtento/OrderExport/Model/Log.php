<?php

/**
 * Product:       Xtento_OrderExport (1.9.14)
 * ID:            y6uNEl4HsQLUABrrmJM07sbxsVMnuo8EF0v1pN1FuKs=
 * Packaged:      2017-06-07T12:47:33+00:00
 * Last Modified: 2012-12-02T17:54:35+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Log.php
 * Copyright:     Copyright (c) 2017 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Log extends Mage_Core_Model_Abstract
{
    /*
     * Log model which keeps track of successful/failed export attempts
     */
    protected $_resultMessages = array();

    // Log result types
    const RESULT_NORESULT = 0;
    const RESULT_SUCCESSFUL = 1;
    const RESULT_WARNING = 2;
    const RESULT_FAILED = 3;

    protected function _construct()
    {
        parent::_construct();
        $this->_init('xtento_orderexport/log');
    }

    public function setResult($resultLevel)
    {
        if ($this->getResult() === NULL) {
            $this->setData('result', $resultLevel);
        } else if ($resultLevel > $this->getResult()) { // If result is failed, do not reset to warning for example.
            $this->setData('result', $resultLevel);
        }
    }

    public function addResultMessage($message)
    {
        array_push($this->_resultMessages, $message);
    }

    public function getResultMessages()
    {
        if (empty($this->_resultMessages)) {
            return false;
        }
        return (count($this->_resultMessages) > 1) ? implode("\n", $this->_resultMessages) : $this->_resultMessages[0];
    }
}