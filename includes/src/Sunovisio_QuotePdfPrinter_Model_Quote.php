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
require_once(BP . DS . 'lib' . DS . 'Sunovisio' . DS . 'Tcpdf' . DS . 'tcpdf.php');

class Sunovisio_QuotePdfPrinter_Model_Quote extends Mage_Core_Model_Abstract {
//public $y;
//protected $_renderers = array();
// -- parameters to define in config --
    /*
     * margin-top
     * margin-left
     * margin-right
     * margin-bottom
     */

    CONST PAGE_WIDTH = 550;
    CONST COL_WIDTH_1 = '20%';
    CONST COL_WIDTH_2 = '30%';
    CONST COL_WIDTH_3 = '15%';
    CONST COL_WIDTH_4 = '15%';
    CONST COL_WIDTH_5 = '8%';
    CONST COL_WIDTH_6 = '12%';

    public function getPdf($quote) {
        $html = '';
        
// -- PDF Parameters --
        $pageOrientation = 'P';
        $unit = 'px';
        $pageFormat = 'A4';
        $marginTop = 20;
        $marginLeft = 0;
        $marginRight = 0;
        $marginBottom = 0;

        $rtl = 0;

        Mage::app()->getLocale()->emulate($quote->getStoreId());
        Mage::app()->setCurrentStore($quote->getStoreId());

        $pdf = new TCPDF($pageOrientation, $unit, $pageFormat, true, 'UTF-8', false);

        $fontname;

        $baseFonts = array('times', 'courier', 'helvetica');

        if (Mage::getStoreConfig('quotepdfprinter/layout/font') == 'default' || !Mage::getStoreConfig('quotepdfprinter/layout/font')) {
            $fontname = $pdf->addTTFfont(BP . DS . 'lib' . DS . 'LinLibertineFont' . DS . 'LinLibertineC_Re-2.8.0.ttf', 'TrueTypeUnicode', '', 96);
            //$fontname = $pdf->addTTFfont(BP . DS . 'lib' . DS . 'LinLibertineFont' . DS . 'LinLibertine_Bd-2.8.1.ttf', 'TrueTypeUnicode', '', 96);
            //$fontname = $pdf->addTTFfont(BP . DS . 'lib' . DS . 'LinLibertineFont' . DS . 'LinLibertine_It-2.8.2.ttf', 'TrueTypeUnicode', '', 96);
            //$fontname = $pdf->addTTFfont(BP . DS . 'lib' . DS . 'LinLibertineFont' . DS . 'LinLibertine_Re-4.4.1.ttf', 'TrueTypeUnicode', '', 96);
        } else if (in_array(Mage::getStoreConfig('quotepdfprinter/layout/font'), $baseFonts)) {
            $fontname = Mage::getStoreConfig('quotepdfprinter/layout/font');
        } else {
            $fontname = $pdf->addTTFfont(BP . DS . 'media' . DS . 'fonts' . DS . Mage::getStoreConfig('quotepdfprinter/layout/font'), 'TrueTypeUnicode', '', 96);
        }

        $pdf->SetFont($fontname, '', 12);

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $pdf->AddPage();

        $pdf->setJPEGQuality(100);

        $image = Mage::getStoreConfig('sales/identity/logo');
        if ($image) {
            $image = Mage::getBaseDir('media') . '/sales/store/logo/' . $image;
            if (is_file($image)) {
                $top = $marginTop; //top border of the page
                $left = $marginLeft; //half of the page width
                $size = getimagesize($image);
                $width = $size[0];
                $height = $size[1];

//$pdf->Image($image, $left, $top, $width, $height);
            }
        }

        $address = Mage::getStoreConfig('sales/identity/address');

        if ($image || $address) {
            $fontSize = (Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') : 12);
            $color = (Mage::getStoreConfig('quotepdfprinter/layout/address_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/address_color')) : '000000');
            if (!Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') || Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') == 'L') {
                $html = '<table style="padding-bottom: 20px;"><tr>' . ($image ? '<td><img src="' . $image . '" /></td>' : '') . '<td style="text-align: right; font-size: ' . $fontSize . 'px; color:#' . $color . ';">' . nl2br($address) . '</td></tr></table>';
            } else {
                $html = '<table style="padding-bottom: 20px;"><tr><td style="font-size: ' . $fontSize . 'px; color:#' . $color . ';">' . nl2br($address) . '</td>' . ($image ? '<td style="text-align: right;"><img src="' . $image . '" /></td>' : '') . '</tr></table>';
            }
        }

        $html .= '<table style="font-size: ' . (Mage::getStoreConfig('quotepdfprinter/layout/quote_font_size') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/quote_font_size')) : 12) . 'px;width: 99%; padding-top: 2px; padding-bottom: 2px; border: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/quote_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/quote_border_color')) : '808080') . '; background-color: #' . (Mage::getStoreConfig('quotepdfprinter/layout/quote_background_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/quote_background_color')) : '737373') . '; color: #' . (Mage::getStoreConfig('quotepdfprinter/layout/quote_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/quote_color')) : 'FFFFFF') . ';">
            <tr>
            <td>' . Mage::helper('quotepdfprinter')->__('Quote #') . ': ' . Mage::helper('quotepdfprinter')->generateLabel($quote->getId()) . '</td>
            </tr>
            <tr>
            <td>' . Mage::helper('quotepdfprinter')->__('Quote Date') . ': ' . Mage::helper('core')->formatDate($quote->getUpdatedAt(), 'medium', false) . '</td>
            </tr>';
            if (Mage::getStoreConfig('quotepdfprinter/layout/add_client_name') && $customer = Mage::getSingleton('customer/session')->getCustomer()) {
                $html .= '<tr><td>'.Mage::helper('quotepdfprinter')->__('Customer Name').': '.$customer->getName().'</td></tr>';
                $html .= '<tr><td>'.Mage::helper('quotepdfprinter')->__('Customer Email').': '.$customer->getEmail().'</td></tr>';
            }
        $html .= '</table>';
        $html .= '<table><tr><td>&nbsp;</td></tr></table>'; // -- Use for spacing --
        $html .= '<table style="width: 99%;">';

        $html .= '<tr style="background-color: #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color')) : 'EDEBEB') . '; color:#' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color')) : '000000') . '; font-size: ' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size')) : 12) . 'px;">
            <th style="width: ' . self::COL_WIDTH_1 . '; ' . ($rtl == 0 ? 'border-left' : 'border-right') . ': 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';"></th>
            <th style="width: ' . self::COL_WIDTH_2 . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';">' . Mage::helper('quotepdfprinter')->__('Product Name') . '</th>
            <th style="width: ' . self::COL_WIDTH_3 . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';">' . Mage::helper('quotepdfprinter')->__('SKU') . '</th>
            <th style="width: ' . self::COL_WIDTH_4 . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';">' . Mage::helper('quotepdfprinter')->__('Unit Price') . '</th>
            <th style="width: ' . self::COL_WIDTH_5 . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';">' . Mage::helper('quotepdfprinter')->__('Qty') . '</th>
            <th style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . '; width: ' . self::COL_WIDTH_6 . '; border-bottom: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; border-top: 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . '; ' . ($rtl == 0 ? 'border-right' : 'border-left') . ': 1px solid #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B') . ';">' . Mage::helper('quotepdfprinter')->__('Subtotal') . '</th>
            </tr>';
        $html .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'; // -- Use for spacing --

        $i = 0;
        foreach ($quote->getAllItems() as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            $product = Mage::getModel('catalog/product')->load($item->getProductId());

            $price = Mage::helper('core')->currency($item->getBasePrice(), true, false);
            if (Mage::getStoreConfig('tax/cart_display/price') == 2) {
                $price = Mage::helper('core')->currency($item->getBasePriceInclTax(), true, false);
            }

            $subtotal = Mage::helper('core')->currency($item->getBaseRowTotal(), true, false);
            if (Mage::getStoreConfig('tax/cart_display/subtotal') == 2) {
                $subtotal = Mage::helper('core')->currency($item->getBaseRowTotalInclTax(), true, false);
            }

            $options = $item->getOptionsByCode();

            $html .= '<tr style="font-size: ' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_font_size') : 12) . 'px; color: #' . (Mage::getStoreConfig('quotepdfprinter/layout/cart_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/cart_color')) : '000000') . '">';
            
            $image = Mage::helper('catalog/image')->init($product, 'thumbnail')->resize(100)->__toString();
            //$path = parse_url($image, PHP_URL_PATH);
            
            if ($image) {
                //$html .= '<td><img src="' . $_SERVER['DOCUMENT_ROOT'] . $path . '" /></td>';
                $html .= '<td><img src="' . $image . '" /></td>';
            }
            else {
                $html .= '<td></td>';
            }
            $html .= '<td>' . $product->getName();
            if (isset($options['attributes'])) {
                $html .= '<ul style="list-style-type: none;">';
                $attributes = unserialize($options['attributes']->getValue());
                foreach ($attributes as $attributeId => $value) {
                    $html .= '<li>';
                    $_attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeId);
                    $html .= '<span style="font-weight: bold; font-style: italic;">' . $_attribute->getFrontendLabel() . '</span><br />';
                    $attributeOptions = $_attribute->getSource()->getAllOptions(false);
                    foreach ($attributeOptions as $option) {
                        if ($option['value'] == $value) {
                            $html .= '<span style="font-style: italic;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $option['label'] . '</span>';
                        }
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
            } else {
                if (isset($options['option_ids'])) {
                    $html .= '<ul style="list-style-type: none;">';
                    $datas = $options['option_ids']->getData();
                    $productCustomOptions = $product->getOptions();
                    foreach (explode(',', $datas['value']) as $op) {
                        $html .= '<li>';
                        $values = $options['option_' . $op]->getData();
                        $value = $values['value'];
                        $itemOp = $productCustomOptions[$op];
                        $productValues = $itemOp->getValues();
                        $html .= '<span style="font-weight: bold; font-style: italic;">' . $itemOp->getTitle() . '</span><br />';
                        if ($itemOp->getType() == 'drop_down' || $itemOp->getType() == 'radio' || $itemOp->getType() == 'checkbox') {
                            $html .= '<span style="font-style: italic;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $productValues[$value]->getTitle() . '</span>';
                        } else {
                            $html .= '<span style="font-style: italic;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $value . '</span>';
                        }
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                } else {
                    if ($item->getProductType() == 'bundle') {
                        $options = Mage::helper('bundle/catalog_product_configuration')->getBundleOptions($item);

                        if (count($options)) {
                            foreach($options as $option) {
                                $html .= '<ul style="list-style-type: none;"><li>';
                                    $html .= '<span style="font-weight: bold; font-style: italic;">' . $option['label'] . '</span><br />';
                                    $html .= '<span style="font-style: italic;"><ul style="list-style-type: none;"><li>' . $option['value'][0] . '</li></ul></span>';
                                $html .= '</li></ul>';
                            }
                        }
                    }
                }
            }
            $html .= '</td>';
            $html .= '<td>' . $product->getSku() . '</td>';
            $html .= '<td>' . $price . '</td>';
            $html .= '<td>' . $item->getQty() . '</td>';
            $html .= '<td style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . ';">' . $subtotal . '</td>';
            $html .= '</tr>';
            $html .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'; // -- Use for spacing --
            $i++;
        }

        $html .= "</table>";

        $html .= '<table style=" width: 99%; color: #' . (Mage::getStoreConfig('quotepdfprinter/layout/total_color') ? str_replace('#', '', Mage::getStoreConfig('quotepdfprinter/layout/total_color')) : '000000') . ';">';
        foreach ($quote->getTotals() as $total) {
            if (Mage::getStoreConfig('quotepdfprinter/layout/remove_zero_total') && $total->getValue() != 0 || !Mage::getStoreConfig('quotepdfprinter/layout/remove_zero_total')) {
                $value = Mage::helper('core')->currency($total->getValue(), true, false);
                if ($total->getCode() !== 'grand_total') {
                    $html .= '<tr><td style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . '; width: 80%; font-weight: bold; font-size:' . (Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') : 12) . 'px">' . $total->getTitle() . '</td><td style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . '; width: 20%; font-weight: bold; font-size:' . (Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') : 12) . 'px">' . $value . '</td></tr>';
                } else {
                    $html .= '<tr><td style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . '; width: 80%; font-weight: bold; font-size:' . (Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') : 14) . 'px">' . $total->getTitle() . '</td><td style="text-align: ' . ($rtl == 0 ? 'right' : 'left') . '; width: 20%; font-weight: bold; font-size:' . (Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') : 14) . 'px">' . $value . '</td></tr>';
                }
            }
        }
        $html .= '</table>';
        
        $html .= '</table>';
        $html .= '<table><tr><td>&nbsp;</td></tr></table>'; // -- Use for spacing --
        $html .= '<table style="width: 99%;">';
        
        $html .= '</table>';
        $html .= '<table><tr><td>&nbsp;</td></tr></table>'; // -- Use for spacing --
        $html .= '<table style="width: 99%;">';
        
        if (Mage::getStoreConfig('quotepdfprinter/frontend_parameters/terms_and_conditions')) {
            $html .= '<p style="text-align: center; ">'.nl2br(Mage::getStoreConfig('quotepdfprinter/frontend_parameters/terms_and_conditions')).'</p>';
        }

        if ($rtl) {
            $pdf->setRTL(true);
        }

        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf;
    }

}