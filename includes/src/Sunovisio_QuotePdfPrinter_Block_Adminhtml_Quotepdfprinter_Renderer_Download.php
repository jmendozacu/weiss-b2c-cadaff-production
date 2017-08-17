<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Download
 *
 * @author Administrator
 */
class Sunovisio_QuotePdfPrinter_Block_Adminhtml_Quotepdfprinter_Renderer_Download extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render a grid cell as options
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        return '<a href="'.$this->getUrl('quotepdfprinter/adminhtml_quotepdfprinter/download').'id/'.$row->getId().'">'.$row->getFilename().'</a>';
    }
}

?>
