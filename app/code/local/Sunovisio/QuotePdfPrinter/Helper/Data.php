<?php

/**
 * Sunovisio Extensions
 * http://ecommerce.sunovisio.com
 *
 * @extension   Quote PDF Printer
 * @type        Customer Support
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Sunovisio
 * @package     Sunovisio_QuotePdfPrinter
 * @copyright   Copyright (c) 2012 Sunovisio (http://sunovisio.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Sunovisio_QuotePdfPrinter_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnabled() {
        return Mage::getStoreConfig('quotepdfprinter/parameters/enabled',Mage::app()->getStore());
    }
    
    public function getLabel () {
        return Mage::getStoreConfig('quotepdfprinter/frontend_parameters/label',Mage::app()->getStore());
    }
    
    public function generateLabel($quoteId) {
        $format = Mage::getStoreConfig('quotepdfprinter/parameters/quote_label',Mage::app()->getStore());
        
        $quoteNumber = Mage::getStoreConfig('quotepdfprinter/parameters/quote_sequence',Mage::app()->getStore()) + $quoteId;
        
        return str_replace('#',$quoteNumber, $format);
    }
    
    public function getFilenamePrefix () {
        return Mage::getStoreConfig('quotepdfprinter/parameters/filename_prefix',Mage::app()->getStore());
    }
}