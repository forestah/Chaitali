<?php

include_once('vtlib/Vtiger/Module.php');


$moduleInstance = Vtiger_Module::getInstance('PurchaseOrder');
$moduleInstance1 = Vtiger_Module::getInstance('Quotes');
$moduleInstance2 = Vtiger_Module::getInstance('Invoice');

$block = Vtiger_Block::getInstance('LBL_CUSTOM_INFORMATION', $moduleInstance);
$block1 = Vtiger_Block::getInstance('LBL_CUSTOM_INFORMATION', $moduleInstance1);
$block2  = Vtiger_Block::getInstance('LBL_CUSTOM_INFORMATION', $moduleInstance2);


$field1 = new Vtiger_Field();
$field1->name = 'document_issue_address';
$field1->label = 'Document Issue Address';
$field1->table = $moduleInstance->basetable;
$field1->column = 'document_issue_address';
$field1->columntype = 'VARCHAR(100)';
$field1->uitype = 10;
$field1->typeofdata = 'V~M';
$block->addField($field1); 
$field1->setRelatedModules(array('CompanyAddress'));

$field2 = new Vtiger_Field();
$field2->name = 'document_issue_address';
$field2->label = 'Document Issue Address';
$field2->table = $moduleInstance1->basetable;
$field2->column = 'document_issue_address';
$field2->columntype = 'VARCHAR(100)';
$field2->uitype = 10;
$field2->typeofdata = 'V~M';
$block1->addField($field2); 
$field2->setRelatedModules(array('CompanyAddress'));


$field3 = new Vtiger_Field();
$field3->name = 'document_issue_address';
$field3->label = 'Document Issue Address';
$field3->table = $moduleInstance2->basetable;
$field3->column = 'document_issue_address';
$field3->columntype = 'VARCHAR(100)';
$field3->uitype = 10;
$field3->typeofdata = 'V~M';
$block2->addField($field3); 
$field3->setRelatedModules(array('CompanyAddress'));



echo "okkk";

?>