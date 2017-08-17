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
class Sunovisio_QuotePdfPrinter_Model_Quote extends Mage_Core_Model_Abstract {

    public $y;
    protected $_renderers = array();

    public function getPdf($quote) {
        $pdf = new Zend_Pdf();
        $style = new Zend_Pdf_Style();
        $this->_setFontBold($style, 10);

        Mage::app()->getLocale()->emulate($quote->getStoreId());
        Mage::app()->setCurrentStore($quote->getStoreId());

        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);

        $pdf->pages[] = $page;

        $this->insertLogo($page, $quote->getStore());

        $this->insertAddress($page, $quote->getStore());

        $top = $this->y;
        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/quote_background_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/quote_background_color')) : '737373')));
        $page->setLineColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/quote_border_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/quote_border_color')) : '737373')));
        $page->drawRectangle(25, $top, 570, $top - 35);
        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/quote_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/quote_color')) : 'FFFFFF')));

        $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/quote_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/quote_font_size')*0.75 : 12*0.75));
        $this->y -= 12;
        $page->drawText(Mage::helper('sales')->__('Quote # ') . Mage::helper('quotepdfprinter')->generateLabel($quote->getId()), 35, $this->y, 'UTF-8');
        $this->y -= 15;
        $page->drawText(Mage::helper('sales')->__('Quote Date: ') . Mage::helper('core')->formatDate($quote->getUpdatedAt(), 'medium', false), 35, $this->y, 'UTF-8');

        $page->setFillColor(new Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
        $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);

        $this->y -= 30;

        $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size')*0.75 : 12*0.75));
        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color')) : 'EDEBEB')));
        $page->setLineColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B')));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $this->y, 570, $this->y - 15);
        $this->y -= 11;
        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color')) : '000000')));
        //$this->y -=10;

        /* Add table head */
        //$page->setFillColor(new Zend_Pdf_Color_Rgb(0.4, 0.4, 0.4));
        $page->drawText('', 35, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('sales')->__('Product Name'), 100, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('sales')->__('SKU'), 290, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('sales')->__('Unit Price'), 380, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('sales')->__('Qty'), 470, $this->y, 'UTF-8');
        $page->drawText(Mage::helper('sales')->__('Subtotal'), 535, $this->y, 'UTF-8');

        $this->y -=15;

        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_color')) : '000000')));
        $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/cart_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_font_size')*0.75 : 12*0.75));
        
        foreach ($quote->getAllItems() as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            if ($this->y < 15) {
                $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $page;
                $this->y = 800;
                $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size')*0.75 : 12*0.75));
                $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_background_color')) : 'EDEBEB')));
                $page->setLineColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_border_color')) : '8B8B8B')));
                $page->setLineWidth(0.5);
                $page->drawRectangle(25, $this->y, 570, $this->y - 15);
                $this->y -=10;

                $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/cart_header_color')) : '000000')));
                $page->drawText('', 35, $this->y, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Product Name'), 100, $this->y, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('SKU'), 290, $this->y, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Unit Price'), 380, $this->y, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Qty'), 470, $this->y, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Subtotal'), 535, $this->y, 'UTF-8');

                $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
                $this->y -=20;
            }

            /* Draw item */
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $path = str_replace(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA), Mage::getStoreConfig('system/filesystem/media', $quote->getStore()) . '/', Mage::helper('catalog/image')->init($product, 'thumbnail')->resize(100)->__toString());
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $tmpName = uniqid('img') . '.' . $extension;
            file_put_contents(Mage::getBaseDir('media') . '/' . $tmpName, file_get_contents(Mage::helper('catalog/image')->init($product, 'thumbnail')->resize(100)->__toString()));

            $image = Zend_Pdf_Image::imageWithPath(Mage::getBaseDir('media') . '/' . $tmpName);
            $page->drawImage($image, 35, $this->y - 50, 85, $this->y);
            unlink(Mage::getBaseDir('media') . '/' . $tmpName);
            $page->drawText($product->getName(), 100, $this->y, 'UTF-8');

            $options = $item->getOptionsByCode();

            if (isset($options['attributes'])) {

                $oldY = $this->y;
                $attributes = unserialize($options['attributes']->getValue());
                foreach ($attributes as $attributeId => $value) {
                    $this->y -= 10;
                    $_attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeId);
                    $this->_setFontItalic($page, (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size')*0.75 : 12*0.75));
                    $page->drawText($_attribute->getFrontendLabel(), 100, $this->y, 'UTF-8');

                    $attributeOptions = $_attribute->getSource()->getAllOptions(false);
                    $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/cart_header_font_size')*0.75 : 12*0.75));
                    $this->y -= 10;
                    foreach ($attributeOptions as $option) {
                        if ($option['value'] == $value) {
                            $page->drawText($option['label'], 110, $this->y, 'UTF-8');
                        }
                    }
                }
                $this->y = $oldY;
            }

            $page->drawText($product->getSku(), 290, $this->y, 'UTF-8');

            $price = Mage::helper('core')->currency($item->getPrice(), true, false);
            $page->drawText($price, 380, $this->y, 'UTF-8');
            $page->drawText($item->getQty(), 470, $this->y, 'UTF-8');

            $subtotal = Mage::helper('core')->currency($item->getRowTotal(), true, false);
            $page->drawText($subtotal, $this->getAlignRight($subtotal, 535, 30, Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertineC_Re-2.8.0.ttf'), 7, 7), $this->y, 'UTF-8');
            $this->y -= 60;
        }
        $this->y -= 10;

        if ($this->y < 15) {
            $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $page;
            $this->y = 800;
        }
        
        $page->setFillColor(new Zend_Pdf_Color_Html('#'.(Mage::getStoreConfig('quotepdfprinter/layout/total_color') ? str_replace('#','', Mage::getStoreConfig('quotepdfprinter/layout/total_color')) : '000000')));

        $this->_setFontBold($page, (Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size')*0.75 : 12*0.75));
        $size = (Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/subtotal_font_size')*0.75 : 12*0.75);

        foreach ($quote->getTotals() as $key => $total) {
            if ($key == 'grand_total') {
                $size = (Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/total_font_size')*0.75 : 14*0.75);
                $this->_setFontBold($page, (Mage::getStoreConfig('quotepdfprinter/layout/total_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/total_font_size')*0.75 : 14*0.75));
            }

            $page->drawText($total->getTitle() . ':', $this->getAlignRight($total->getTitle(), 30, 450, Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_Bd-2.8.1.ttf'), $size, 2), $this->y, 'UTF-8');
            $value = Mage::helper('core')->currency($total->getValue(), true, false);
            $page->drawText($value, $this->getAlignRight($value, 480, 85, Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_Bd-2.8.1.ttf'), $size, 2), $this->y, 'UTF-8');

            $this->y -= 15;
        }

        return $pdf;
    }

    public function getAlignCenter($string, $x, $columnWidth, Zend_Pdf_Resource_Font $font, $fontSize) {
        $width = $this->widthForStringUsingFontSize($string, $font, $fontSize);
        return $x + round(($columnWidth - $width) / 2);
    }

    public function getAlignRight($string, $x, $columnWidth, Zend_Pdf_Resource_Font $font, $fontSize, $padding = 5) {
        $width = $this->widthForStringUsingFontSize($string, $font, $fontSize);
        return $x + $columnWidth - $width - $padding;
    }

    public function widthForStringUsingFontSize($string, $font, $fontSize) {
        $drawingString = '"libiconv"' == ICONV_IMPL ? iconv('UTF-8', 'UTF-16BE//IGNORE', $string) : @iconv('UTF-8', 'UTF-16BE', $string);

        $characters = array();
        for ($i = 0; $i < strlen($drawingString); $i++) {
            $characters[] = (ord($drawingString[$i++]) << 8) | ord($drawingString[$i]);
        }
        $glyphs = $font->glyphNumbersForCharacters($characters);
        $widths = $font->widthsForGlyphs($glyphs);
        $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
        return $stringWidth;
    }

    protected function _setFontItalic($object, $size = 7) {
        $font = Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_It-2.8.2.ttf');
        $object->setFont($font, $size);
        return $font;
    }

    protected function _setFontRegular($object, $size = 7) {
        $font = Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_Re-4.4.1.ttf');
        $object->setFont($font, $size);
        return $font;
    }

    protected function _setFontBold($object, $size = 7) {
        $font = Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_Bd-2.8.1.ttf');
        $object->setFont($font, $size);
        return $font;
    }

    protected function insertLogo(&$page, $store = null) {
        $this->y = $this->y ? $this->y : 815;
        $image = Mage::getStoreConfig('sales/identity/logo', $store);
        if ($image) {
            $image = Mage::getBaseDir('media') . '/sales/store/logo/' . $image;
            if (is_file($image)) {
                $mime = getimagesize($image);
                if ($mime['mime'] != 'image/png') {
                    $image = Zend_Pdf_Image::imageWithPath($image);
                    $top = 830; //top border of the page
                    $widthLimit = 270; //half of the page width
                    $heightLimit = 270; //assuming the image is not a "skyscraper"
                    $width = $image->getPixelWidth();
                    $height = $image->getPixelHeight();

                    //preserving aspect ratio (proportions)
                    $ratio = $width / $height;
                    if ($ratio > 1 && $width > $widthLimit) {
                        $width = $widthLimit;
                        $height = $width / $ratio;
                    } elseif ($ratio < 1 && $height > $heightLimit) {
                        $height = $heightLimit;
                        $width = $height * $ratio;
                    } elseif ($ratio == 1 && $height > $heightLimit) {
                        $height = $heightLimit;
                        $width = $widthLimit;
                    }

                    $y1 = $top - $height;
                    $y2 = $top;
                    if (!Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') || Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') == 'L') {
                        $x1 = 25;
                        $x2 = $x1 + $width;
                    }
                    else {
                        $x1 = 580 - $width;
                        $x2 = 580;
                    }

                    //coordinates after transformation are rounded by Zend
                    $page->drawImage($image, $x1, $y1, $x2, $y2);

                    $this->y = $y1 - 10;
                }
            }
        }
    }

    protected function png2jpg($originalFile, $outputFile, $quality) {
        $image = imagecreatefrompng($originalFile);
        imagejpeg($image, $outputFile, $quality);
        imagedestroy($image);
    }

    protected function insertAddress(&$page, $store = null) {
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $font = $this->_setFontRegular($page, (Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') : 12));
        $page->setLineWidth(0);
        $this->y = $this->y ? $this->y : 815;
        $top = 815;
        foreach (explode("\n", Mage::getStoreConfig('sales/identity/address', $store)) as $value) {
            if ($value !== '') {
                $value = preg_replace('/<br[^>]*>/i', "\n", $value);
                foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                    if (!Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') || Mage::getStoreConfig('quotepdfprinter/layout/logo_address_position') == 'L') {
                        $page->drawText(trim(strip_tags($_value)), $this->getAlignRight($_value, 130, 440, $font, 10), $top, 'UTF-8');
                    }
                    else {
                        $page->drawText(trim(strip_tags($_value)), 25, $top, 'UTF-8');
                    }
                    $top -= (Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') ? Mage::getStoreConfig('quotepdfprinter/layout/address_font_size') : 12);
                }
            }
        }
        $this->y = ($this->y > $top) ? $top : $this->y;
    }

    /**
     * Create new page and assign to PDF object
     *
     * @param array $settings
     * @return Zend_Pdf_Page
     */
    public function newPage(array $settings = array()) {
        /* Add new table head */
        $page = $this->_getPdf()->newPage(Zend_Pdf_Page::SIZE_A4);
        $this->_getPdf()->pages[] = $page;
        $this->y = 800;

        if (!empty($settings['table_header'])) {
            $this->_setFontRegular($page);
            $page->setFillColor(new Zend_Pdf_Color_RGB(0.93, 0.92, 0.92));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 570, $this->y - 15);
            $this->y -=10;

            $page->setFillColor(new Zend_Pdf_Color_RGB(0.4, 0.4, 0.4));
            $page->drawText(Mage::helper('sales')->__('Product'), 35, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('SKU'), 255, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Price'), 380, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Qty'), 430, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Tax'), 480, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Subtotal'), 535, $this->y, 'UTF-8');

            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $this->y -=20;
        }

        return $page;
    }

}
