<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of History
 *
 * @author Administrator
 */
class Sunovisio_QuotePdfPrinter_Block_Quote_History extends Mage_Core_Block_Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('quotepdfprinter/quote/history.phtml');

        $quotes = Mage::getModel('quotepdfprinter/quotepdf')->getCollection()
                ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
                ->setOrder('created_at', 'desc')
        ;

        $this->setQuotes($quotes);

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('quotepdfprinter')->__('My PDF quotes'));
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'quotepdfprinter.quote.history.pager')
                ->setCollection($this->getQuotes());
        $this->setChild('pager', $pager);
        $this->getQuotes()->load();
        return $this;
    }

    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    public function getBackUrl() {
        return $this->getUrl('customer/account/');
    }

}

?>
