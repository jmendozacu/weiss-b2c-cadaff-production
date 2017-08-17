<?php

$installer = $this;
$installer->startSetup();

if(MessageBusiness_ContactsSync_Helper_Data::XML_PATH_PREFIX != '') {
	$installer->run("
		DELETE FROM {$this->getTable('core_config_data')} 
			WHERE path LIKE '".MessageBusiness_ContactsSync_Helper_Data::XML_PATH_PREFIX."%';
	");
}

$installer->endSetup();