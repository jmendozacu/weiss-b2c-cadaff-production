<?php
$installer = $this;
$installer->startSetup();
 
$installer->addAttribute('order', 'SAP_order_id', array(
    'type'          => 'text',
    'label'         => 'Numero commande SAP',
    'default'       => '',
    'visible'       => true,
    'required'      => true,
    'user_defined'  => true,
    'searchable'    => false,
    'filterable'    => false,
    'comparable'    => false,
));
 
$installer->endSetup();