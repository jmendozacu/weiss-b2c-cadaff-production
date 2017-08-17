<?php

class Sunovisio_QuotePdfPrinter_Model_Logoposition {

    public function toOptionArray() {
        return array(
            array('label' => Mage::helper('adminhtml')->__('Logo on left - Address on right'), 'value'=>'L'),
            array('label' => Mage::helper('adminhtml')->__('Logo on right - Address on left'), 'value'=>'R'),
        );
    }

}

?>
