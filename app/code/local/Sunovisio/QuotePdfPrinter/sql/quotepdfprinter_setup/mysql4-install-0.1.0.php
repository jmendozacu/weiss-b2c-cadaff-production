<?php
$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS {$this->getTable('quote_pdf')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `items_count` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");


$installer->endSetup(); 
            