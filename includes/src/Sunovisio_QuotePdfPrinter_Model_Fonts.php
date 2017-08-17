<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fonts
 *
 * @author Administrator
 */
class Sunovisio_QuotePdfPrinter_Model_Fonts extends Varien_Object {

    public function toOptionArray() {
        $list = array('default' => 'LinLibertineFont');
        
        $list ['courier'] = 'Courier';
        $list ['helvetica'] = 'Helvetica';
        $list ['times'] = 'Times New Roman';

        $folder = Mage::getBaseDir('media') . '/fonts';
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    $list [$entry] = $entry;
                }
            }

            closedir($handle);
        }

        return $list;
    }

}

?>
