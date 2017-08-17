<?php
/**
 * This cron will run every one hour and will do:
 * - check if there are files with the txt extension in the target directory
 * - if yes then loop through these files and update the DB table
 * - after update the DB change the extension of these files
 */

class Weiss_Customcron_Model_Customcron
{
    public function customcrontask() {
        // sap folder path(Target folder)
        $sapFilesDir = Mage::getBaseDir() . DIRECTORY_SEPARATOR . 'import'. DIRECTORY_SEPARATOR . 'commandes_sap' . DIRECTORY_SEPARATOR ;
        // scan files in sap directory
        $files = scandir($sapFilesDir );
        // loop through files and check the file extension and line numbers
        foreach($files as $old_file) {
            // check if there are files with .txt extension
            if ((pathinfo($sapFilesDir.$old_file)['extension'] == 'txt') && ($old_file != '.') &&  ($old_file != '..')) {
                    $old_lines = file($sapFilesDir.$old_file, FILE_IGNORE_NEW_LINES);
                    // split big file to small files
                    if(count($old_lines) > 1000){
                        $handle = fopen($sapFilesDir.$old_file,'r');
                        //new file number
                        $f = 1;
                        while(!feof($handle)){
                            //create new file to write to with file number
                            $new_file = fopen($sapFilesDir.$old_file . $f . '.txt','w');
                            for($i = 1; $i <= 1000; $i++){
                                $file_content = fgets($handle);
                                fwrite($new_file,$file_content);
                                if(feof($handle)){
                                    //If file ends, break loop
                                    break;
                                }
                            }
                            fclose($new_file);
                            //Increment new file number
                            $f++;
                        }
                        fclose($handle);
//                        unlink($sapFilesDir.$old_file);
                        $updated_old_file = str_replace("txt", "docx", $sapFilesDir . $old_file);
                        rename($sapFilesDir . $old_file, $updated_old_file);
                    }
            }
        }
        // final loop:: hit the data base
        $all_files = scandir($sapFilesDir );
        foreach($all_files as $old_file_1) {
            // check if there are files with .txt extension
            if ((pathinfo($sapFilesDir.$old_file_1)['extension'] == 'txt') && ($old_file_1 != '.') &&  ($old_file_1 != '..')) {
                    $lines = file($sapFilesDir.$old_file_1, FILE_IGNORE_NEW_LINES);
                     //Mage::log(count($lines), null, 'cron.log');

                if(is_array($lines) && count($lines) > 0){
                        foreach ($lines as $key => $value) {
                            $arr = explode(';', $value);
                            $order_id = addslashes($arr[1]);
                            $order_sap_id = $arr[0];
                            $resource = Mage::getSingleton('core/resource');
                            $writeConnection = $resource->getConnection('core_write');
                            $table = $resource->getTableName('sales_flat_order_grid');
                            $query = "UPDATE {$table} SET sap_increment_id = '".$order_sap_id."' WHERE increment_id = '".$order_id."'";
                            $writeConnection->query($query);
                        }
                    }
                // change the files extension after DB table update
                $updated_file = str_replace("txt", "csv", $sapFilesDir . $old_file_1);
                rename($sapFilesDir . $old_file_1, $updated_file);
            }
        }
    }
}

