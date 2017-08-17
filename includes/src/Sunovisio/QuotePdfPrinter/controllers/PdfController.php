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
class Sunovisio_QuotePdfPrinter_PdfController extends Mage_Core_Controller_Front_Action {

    const XML_PATH_EMAIL_RECIPIENT = 'quotepdfprinter/mail_setting/send_to';
    const XML_PATH_EMAIL_SENDER = 'quotepdfprinter/mail_setting/email_sender';
    const XML_PATH_EMAIL_TEMPLATE = 'quotepdfprinter/mail_setting/email_template';

    public function indexAction() {
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();

        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    protected function _getCart() {
        return Mage::getSingleton('checkout/cart');
    }

    public function printAction() {
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();

        if (Mage::getStoreConfig('quotepdfprinter/frontend_parameters/restrict_logged_in', Mage::app()->getStore()) && !Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        } else {
            $cart = $this->_getCart();

            if ($cart->getQuote()->getItemsCount()) {
                $quoteId = Mage::getSingleton('checkout/session')->getQuoteId();

                $quote = Mage::getModel('sales/quote')->load($quoteId);

                $quotePdf = Mage::getModel('quotepdfprinter/quote')->getPdf($quote);

                if (!file_exists(Mage::getBaseDir('var') . '\\quote')) {
                    mkdir(Mage::getBaseDir('var') . '/quote', 0777, true);
                }

                $filename = Mage::helper('quotepdfprinter')->getFilenamePrefix() . Mage::helper('quotepdfprinter')->generateLabel($quoteId) . '.pdf';

                $i = 1;
                $baseFilename = $filename;
                while (file_exists(Mage::getBaseDir('var') . '/quote/' . $filename)) {
                    $filename = str_replace('.pdf', '-' . $i . '.pdf', $baseFilename);
                    $i++;
                }

                $quotePdf->Output(Mage::getBaseDir('var') . '/quote/' . $filename, 'F');

                $pdf = Mage::getModel('quotepdfprinter/quotepdf');
                $pdf->setQuoteId($quoteId);
                $pdf->setItemsCount($cart->getQuote()->getItemsCount());
                $pdf->setPath(Mage::getBaseDir('var') . '/quote/' . $filename);
                $pdf->setFilename($filename);
                $pdf->setCreatedAt(date('Y-m-d H:i:s'));
                $pdf->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
                $pdf->save();

                if (Mage::getStoreConfig('quotepdfprinter/mail_setting/enabled', Mage::app()->getStore())) {
                    $customerName = 'Guest';
                    $customerEmail = '';
                    if (Mage::getSingleton('customer/session')->getCustomerId()) {
                        $customer = Mage::getModel('customer/customer')->load(Mage::getSingleton('customer/session')->getCustomerId());
                        $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
                        $customerEmail = $customer->getEmail();
                    }
                    $datas = array(
                        'store' => Mage::app()->getStore(),
                        'items_count' => $cart->getQuote()->getItemsCount(),
                        'quote_id' => Mage::helper('quotepdfprinter')->generateLabel($quoteId),
                        'customer_name' => $customerName,
                        'customer_email' => $customerEmail
                    );

                    $mailTemplate = Mage::getModel('core/email_template');
                    $mailTemplate->setDesignConfig(array('area' => 'frontend'));

                    if (Mage::getStoreConfig('quotepdfprinter/mail_setting/send_attachment', Mage::app()->getStore())) {
                        $mailTemplate
                                ->getMail()
                                ->createAttachment(
                                        file_get_contents(Mage::getBaseDir('var') . '/quote/' . $filename), Zend_Mime::TYPE_OCTETSTREAM, Zend_Mime::DISPOSITION_ATTACHMENT, Zend_Mime::ENCODING_BASE64, basename(Mage::getBaseDir('var') . '/quote/' . $filename)
                        );
                    }
                    
                    $mailTemplate->sendTransactional(
                            Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE), Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER), Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT), null, $datas
                    );

                    if (!$mailTemplate->getSentSuccess()) {
                        throw new Exception();
                    }
                }

                $this->_prepareDownloadResponse($filename, file_get_contents(Mage::getBaseDir('var') . '/quote/' . $filename), 'application/x-pdf');
            } else {
                $this->_redirectReferer();
            }
        }
    }

    public function downloadAction() {
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            $quotepdf = Mage::getModel('quotepdfprinter/quotepdf')->load($id);

            $this->_prepareDownloadResponse($quotepdf->getFilename(), file_get_contents($quotepdf->getPath()), 'application/x-pdf');
        }
    }

    protected function _prepareDownloadResponse($fileName, $content, $contentType = 'application/octet-stream', $contentLength = null) {
        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', is_null($contentLength) ? strlen($content) : $contentLength)
                ->setHeader('Content-Disposition', 'attachment; filename=' . $fileName)
                ->setHeader('Last-Modified', date('r'));
        if (!is_null($content)) {
            $this->getResponse()->setBody($content);
        }
        return $this;
    }

}

?>
