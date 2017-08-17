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
class Sunovisio_QuotePdfPrinter_Adminhtml_QuotepdfprinterController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('sunovisio/quotepdfprinter')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Quote PDF'), Mage::helper('adminhtml')->__('Quote PDF'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function massDeleteAction() {
        $faqIds = $this->getRequest()->getParam('quotepdfprinter');
        if (!is_array($faqIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($faqIds as $faqId) {
                    $faq = Mage::getModel('quotepdfprinter/quotepdf')->load($faqId);
                    $faq->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($faqIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function downloadAction () {
        $id = $this->getRequest()->getParam('id');
        
        if ($id) {
            $quotepdf = Mage::getModel('quotepdfprinter/quotepdf')->load($id);
            
            $this->_prepareDownloadResponse($quotepdf->getFilename(), file_get_contents($quotepdf->getPath()), 'application/x-pdf');
        }
    }
    
    protected function _prepareDownloadResponse($fileName, $content, $contentType = 'application/octet-stream', $contentLength = null) {
        $session = Mage::getSingleton('admin/session');
        if ($session->isFirstPageAfterLogin()) {
            $this->_redirect($session->getUser()->getStartupPageUrl());
            return $this;
        }
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