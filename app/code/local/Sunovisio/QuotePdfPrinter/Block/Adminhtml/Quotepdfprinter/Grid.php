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
class Sunovisio_QuotePdfPrinter_Block_Adminhtml_Quotepdfprinter_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('quotepdfprinterGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('quotepdfprinter/quotepdf')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('quotepdfprinter')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));
        
        $this->addColumn('quote_id', array(
            'header' => Mage::helper('quotepdfprinter')->__('Quote ID'),
            'align' => 'left',
            'width' => '50px',
            'index' => 'quote_id',
        ));
        
        $this->addColumn('items_count', array(
            'header' => Mage::helper('quotepdfprinter')->__('Number of Items'),
            'align' => 'left',
            'index' => 'items_count',
        ));
        
        $this->addColumn('path', array(
            'header' => Mage::helper('quotepdfprinter')->__('Download'),
            'align' => 'left',
            'index' => 'path',
            'filter' => false,
            'renderer' => 'Sunovisio_QuotePdfPrinter_Block_Adminhtml_Quotepdfprinter_Renderer_Download',
            'sortable' => false
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('quotepdfprinter')->__('Created At'),
            'align' => 'left',
            'index' => 'created_at',
            'type' => 'date'
        ));
        
        $customers = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect(array('firstname', 'lastname'));
        
        $options = array();
        
        foreach($customers as $customer) {
            $options[$customer->getId()] = $customer->getFirstname().' '.$customer->getLastname();
        }        

        $this->addColumn('customer_id', array(
            'header' => Mage::helper('quotepdfprinter')->__('Customer'),
            'align' => 'left',
            'index' => 'customer_id',
            'type' => 'options',
            'options' => $options
        ));

        //$this->addExportType('*/*/exportCsv', Mage::helper('faq')->__('CSV'));
        //$this->addExportType('*/*/exportXml', Mage::helper('faq')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('quotepdfprinter');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('quotepdfprinter')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('quotepdfprinter')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row) {
        return null;//$this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}