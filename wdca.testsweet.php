<?php
require_once 'app/Mage.php';
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
echo "<pre>";
$m = Mage::getModel('testsweet/test');
$m->all();
