<?php

/**
 * Sunovisio Extensions
 * http://ecommerce.sunovisio.com
 *
 * @extension   Faq
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
 * @package     Sunovisio_GoogleMapPro
 * @copyright   Copyright (c) 2012 Sunovisio (http://sunovisio.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Sunovisio_QuotePdfPrinter_Block_Adminhtml_Quotepdfprinter extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_quotepdfprinter';
    $this->_blockGroup = 'quotepdfprinter';
    $this->_headerText = Mage::helper('quotepdfprinter')->__('Item Manager');

    parent::__construct();
    
    $this->removeButton('add');
  }
}