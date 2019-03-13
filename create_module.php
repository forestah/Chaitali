<?php

// Just a bit of HTML formatting
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

echo '<html><head><title>vtlib Module Script</title>';
echo '<style type="text/css">@import url("themes/softed/style.css");br { display: block; margin: 2px; }</style>';
echo '</head><body class=small style="font-size: 12px; margin: 2px; padding: 2px;">';
echo '<a href="index.php"><img src="themes/softed/images/vtiger-crm.gif" alt="vtiger CRM" title="vtiger CRM" border=0></a><hr style="height: 1px">';

// Turn on debugging level
$Vtiger_Utils_Log = true;
define('VTIGER6_REL_DIR', '');
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

$module = new Vtiger_Module();




/*$module->name = 'ValidateDay';

$module->initWebservice();

$module->save();

$module->initTables();

$block1 = new Vtiger_Block();
$block1->label = 'LBL_DATE_OF_THE_DAY_VALIDATE';
$module->addBlock($block1);

$block2 = new Vtiger_Block();
$block2->label = 'LBL_MARGIN';
$module->addBlock($block2);

$block3 = new Vtiger_Block();
$block3->label = 'LBL_CALLS';
$module->addBlock($block3);

$block4 = new Vtiger_Block();
$block4->label = 'LBL_CUSTOMERS';
$module->addBlock($block4);

$block5 = new Vtiger_Block();
$block5->label = 'LBL_COMMENTS';
$module->addBlock($block5);

$field = new Vtiger_Field();
$field->name = 'Date';
$field->label = 'date';
$field->table = $module->basetable;
$field->column = 'date';
$field->columntype = 'date';
$field->uitype = 5;
$field->typeofdata = 'V~M';
$block1->addField($field);
$module->setEntityIdentifier($field);


$field1 = new Vtiger_Field();
$field1->name = 'date_no';
$field1->label = 'Date No';
$field1->table = $module->basetable;
$field1->column = 'date_no';
$field1->columntype = 'VARCHAR(100)';
$field1->uitype = 4;
$field1->typeofdata = 'V~O';
$block1->addField($field1); 

$field2 = new Vtiger_Field();
$field2->name = 'margin_day';
$field2->label = 'Margin of the day'; 
$field2->table = $module->basetable;
$field2->column = 'margin_day';
$field2->columntype = 'VARCHAR(255)';
$field2->uitype = 2;
$field2->typeofdata = 'V~M';
$block2->addField($field2);

$field3 = new Vtiger_Field();
$field3->name = 'margin_of_the_billed_month';
$field3->label = 'Margin of the billed month'; 
$field3->table = $module->basetable;
$field3->column = 'margin_of_the_billed_month';
$field3->columntype = 'VARCHAR(255)';
$field3->uitype = 2;
$field3->typeofdata = 'V~M';
$block2->addField($field3);

$field4 = new Vtiger_Field();
$field4->name = 'order_entry';
$field4->label = 'Orders Entry'; 
$field4->table = $module->basetable;
$field4->column = 'order_entry';
$field4->columntype = 'VARCHAR(255)';
$field4->uitype = 2;
$field4->typeofdata = 'V~M';
$block2->addField($field4);

$field5 = new Vtiger_Field();
$field5->name = 'weather_forcast';
$field5->label = 'Weather Forecast'; 
$field5->table = $module->basetable;
$field5->column = 'weather_forcast';
$field5->columntype = 'VARCHAR(255)';
$field5->uitype = 2;
$field5->typeofdata = 'V~O';
$block2->addField($field5);

$field6 = new Vtiger_Field();
$field6->name = 'no_of_quotes';
$field6->label = 'Number of quotes'; 
$field6->table = $module->basetable;
$field6->column = 'no_of_quotes';
$field6->columntype = 'VARCHAR(255)';
$field6->uitype = 2;
$field6->typeofdata = 'V~O';
$block2->addField($field6);

$field7 = new Vtiger_Field();
$field7->name = 'no_of_orders';
$field7->label = 'Number of orders'; 
$field7->table = $module->basetable;
$field7->column = 'no_of_orders';
$field7->columntype = 'VARCHAR(255)';
$field7->uitype = 2;
$field7->typeofdata = 'V~O';
$block2->addField($field7);

$field8 = new Vtiger_Field();
$field8->name = 'no_of_unsuccessfull_call';
$field8->label = 'Number of Unsuccessful Calls'; 
$field8->table = $module->basetable;
$field8->column = 'no_of_unsuccessfull_call';
$field8->columntype = 'VARCHAR(255)';
$field8->uitype = 2;
$field8->typeofdata = 'V~O';
$block3->addField($field8);

$field9 = new Vtiger_Field();
$field9->name = 'no_of_hunting_call';
$field9->label = 'Number of Huntings Calls'; 
$field9->table = $module->basetable;
$field9->column = 'no_of_hunting_call';
$field9->columntype = 'VARCHAR(255)';
$field9->uitype = 2;
$field9->typeofdata = 'V~O';
$block3->addField($field9);

$field10 = new Vtiger_Field();
$field10->name = 'no_of_active_call';
$field10->label = 'Number of Active Calls'; 
$field10->table = $module->basetable;
$field10->column = 'no_of_active_call';
$field10->columntype = 'VARCHAR(255)';
$field10->uitype = 2;
$field10->typeofdata = 'V~O';
$block3->addField($field10);

$field11 = new Vtiger_Field();
$field11->name = 'no_of_new_customer';
$field11->label = 'Number of new customers'; 
$field11->table = $module->basetable;
$field11->column = 'no_of_new_customer';
$field11->columntype = 'VARCHAR(255)';
$field11->uitype = 2;
$field11->typeofdata = 'V~O';
$block4->addField($field11);

$field12 = new Vtiger_Field();
$field12->name = 'comments';
$field12->label = 'Comments'; 
$field12->table = $module->basetable;
$field12->column = 'comments';
$field12->columntype = 'VARCHAR(255)';
$field12->uitype = 19;
$field12->typeofdata = 'V~O';
$block5->addField($field12);



$fieldm1 = new Vtiger_Field();
$fieldm1->name = 'assigned_user_id';
$fieldm1->label = 'Assigned To';
$fieldm1->table = 'vtiger_crmentity'; 
$fieldm1->column = 'smownerid';
$fieldm1->uitype = 53;
$fieldfieldm14->typeofdata = 'V~M';
$block1->addField($fieldm1);


$fieldm2 = new Vtiger_Field();
$fieldm2->name = 'CreatedTime';
$fieldm2->label= 'Created Time';
$fieldm2->table = 'vtiger_crmentity';
$fieldm2->column = 'createdtime';
$fieldm2->uitype = 70;
$fieldm2->typeofdata = 'T~O';
$fieldm2->displaytype= 2;
$block1->addField($fieldm2);

$fieldm3 = new Vtiger_Field();
$fieldm3->name = 'ModifiedTime';
$fieldm3->label= 'Modified Time';
$fieldm3->table = 'vtiger_crmentity';
$fieldm3->column = 'modifiedtime';
$fieldm3->uitype = 70;
$fieldm3->typeofdata = 'T~O';
$fieldm3->displaytype= 2;
$block1->addField($fieldm3);

$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);



$filter1->addField($field1)->addField($field5, 1)->addField($field6, 2)->addField($field7, 3)->addField($field8, 4)->addField($field9, 5)->addField($field10, 6);

$module->setDefaultSharing('Private'); 



$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');*/



/*******************************************************************************/


//$moduleInstance = new Vtiger_Module();
//
//$moduleInstance->name = 'cust';
//
//$moduleInstance->initWebservice();
//
//$moduleInstance->save();
//
//$moduleInstance->initTables();
//
//$block = new Vtiger_Block();
//$block->label = 'LBL_INFO_CUSTOMERS';
//$moduleInstance->addBlock($block);
//
//$field1 = new Vtiger_Field();
//$field1->name = 'commercial';
//$field1->label = 'Commercial'; 
//$field1->table = $moduleInstance->basetable;
//$field1->column = 'commercial';
//$field1->columntype = 'VARCHAR(255)';
//$field1->uitype = 16;
//$field1->typeofdata = 'V~M';
//$block->addField($field1);
//
//$field2 = new Vtiger_Field();
//$field2->name = 'customer_type';
//$field2->label = 'Customer type'; 
//$field2->table = $moduleInstance->basetable;
//$field2->column = 'customer_type';
//$field2->columntype = 'VARCHAR(255)';
//$field2->uitype = 16;
//$field2->typeofdata = 'V~M';
//$block->addField($field2);
//
//$field3 = new Vtiger_Field();
//$field3->name = 'customer_name';
//$field3->label = 'Customer Name'; 
//$field3->table = $moduleInstance->basetable;
//$field3->column = 'customer_name';
//$field3->columntype = 'VARCHAR(255)';
//$field3->uitype = 2;
//$field3->typeofdata = 'V~M';
//$block->addField($field3);
//$moduleInstance->setEntityIdentifier($field3);
//
//$field31 = new Vtiger_Field();
//$field31->name = 'client_number';
//$field31->label = 'Client number'; 
//$field31->table = $moduleInstance->basetable;
//$field31->column = 'client_number';
//$field31->columntype = 'VARCHAR(255)';
//$field31->uitype = 2;
//$field31->typeofdata = 'V~M';
//$block->addField($field31);
//
//$field32 = new Vtiger_Field();
//$field32->name = 'contact_name';
//$field32->label = 'Contact Name'; 
//$field32->table = $moduleInstance->basetable;
//$field32->column = 'contact_name';
//$field32->columntype = 'VARCHAR(255)';
//$field32->uitype = 2;
//$field32->typeofdata = 'V~M';
//$block->addField($field32);
//
//$field33 = new Vtiger_Field();
//$field33->name = 'phone';
//$field33->label = 'Phone'; 
//$field33->table = $moduleInstance->basetable;
//$field33->column = 'phone';
//$field33->columntype = 'VARCHAR(255)';
//$field33->uitype = 2;
//$field33->typeofdata = 'V~M';
//$block->addField($field33);
//
//$field34 = new Vtiger_Field();
//$field34->name = 'mail';
//$field34->label = 'Mail'; 
//$field34->table = $moduleInstance->basetable;
//$field34->column = 'mail';
//$field34->columntype = 'VARCHAR(255)';
//$field34->uitype = 2;
//$field34->typeofdata = 'V~M';
//$block->addField($field34);
//
//$field4 = new Vtiger_Field();
//$field4->name = 'qualify_park';
//$field4->label = 'Do you want to qualify the park?'; 
//$field4->table = $moduleInstance->basetable;
//$field4->column = 'qualify_park';
//$field4->columntype = 'VARCHAR(255)';
//$field4->uitype = 16;
//$field4->typeofdata = 'V~M';
//$block->addField($field4);
//
//
///*****************************************/
//$block1 = new Vtiger_Block();
//$block1->label = 'LBL_QUALIFICATION_PARK';
//$moduleInstance->addBlock($block1);
//
//
//$field5 = new Vtiger_Field();
//$field5->name = 'security_editor';
//$field5->label = 'Security Editor:'; 
//$field5->table = $moduleInstance->basetable;
//$field5->column = 'security_editor';
//$field5->columntype = 'VARCHAR(255)';
//$field5->uitype = 2;
//$field5->typeofdata = 'V~O';
//$block1->addField($field5);
//
//$field6 = new Vtiger_Field();
//$field6->name = 'renew_date';
//$field6->label = 'date of renew:'; 
//$field6->table = $moduleInstance->basetable;
//$field6->column = 'renew_date';
//$field6->columntype = 'VARCHAR(255)';
//$field6->uitype = 2;
//$field6->typeofdata = 'V~O';
//$block1->addField($field6);
//
//
//
//$field7 = new Vtiger_Field();
//$field7->name = 'fixed_pos_no';
//$field7->label = 'Number of fixed positions:'; 
//$field7->table = $moduleInstance->basetable;
//$field7->column = 'fixed_pos_no';
//$field7->columntype = 'VARCHAR(255)';
//$field7->uitype = 2;
//$field7->typeofdata = 'V~O';
//$block1->addField($field7);
//
//$field8 = new Vtiger_Field();
//$field8->name = 'no_of_laptop';
//$field8->label = 'Number of laptops:'; 
//$field8->table = $moduleInstance->basetable;
//$field8->column = 'no_of_laptop';
//$field8->columntype = 'VARCHAR(255)';
//$field8->uitype = 2;
//$field8->typeofdata = 'V~O';
//$block1->addField($field8);
//
//$field9 = new Vtiger_Field();
//$field9->name = 'favorite_brand';
//$field9->label = 'Favorite brand:'; 
//$field9->table = $moduleInstance->basetable;
//$field9->column = 'favorite_brand';
//$field9->columntype = 'VARCHAR(255)';
//$field9->uitype = 2;
//$field9->typeofdata = 'V~O';
//$block1->addField($field9);
//
//$field10 = new Vtiger_Field();
//$field10->name = 'no_of_site';
//$field10->label = 'Number of site:'; 
//$field10->table = $moduleInstance->basetable;
//$field10->column = 'no_of_site';
//$field10->columntype = 'VARCHAR(255)';
//$field10->uitype = 2;
//$field10->typeofdata = 'V~O';
//$block1->addField($field10);
//
//$field11 = new Vtiger_Field();
//$field11->name = 'cloud_solution';
//$field11->label = 'If so, what?'; 
//$field11->table = $moduleInstance->basetable;
//$field11->column = 'cloud_solution';
//$field11->columntype = 'VARCHAR(255)';
//$field11->uitype = 2;
//$field11->typeofdata = 'V~O';
//$block1->addField($field11);
//
//$field12 = new Vtiger_Field();
//$field12->name = 'mail_server_solution';
//$field12->label = 'You are quite:'; 
//$field12->table = $moduleInstance->basetable;
//$field12->column = 'mail_server_solution';
//$field12->columntype = 'VARCHAR(255)';
//$field12->uitype = 2;
//$field12->typeofdata = 'V~O';
//$block1->addField($field12);
//
//$field13 = new Vtiger_Field();
//$field13->name = 'number_of_protected_mailboxes';
//$field13->label = 'Number of protected mailboxes:'; 
//$field13->table = $moduleInstance->basetable;
//$field13->column = 'number_of_protected_mailboxes';
//$field13->columntype = 'VARCHAR(255)';
//$field13->uitype = 2;
//$field13->typeofdata = 'V~O';
//$block1->addField($field13);
//
//$field14 = new Vtiger_Field();
//$field14->name = 'number_of_physical_servers';
//$field14->label = 'Number of physical servers:'; 
//$field14->table = $moduleInstance->basetable;
//$field14->column = 'number_of_physical_servers';
//$field14->columntype = 'VARCHAR(255)';
//$field14->uitype = 2;
//$field14->typeofdata = 'V~O';
//$block1->addField($field14);
//
//$field15 = new Vtiger_Field();
//$field15->name = 'number_of_virtual_servers';
//$field15->label = 'Number of virtual servers:'; 
//$field15->table = $moduleInstance->basetable;
//$field15->column = 'number_of_virtual_servers';
//$field15->columntype = 'VARCHAR(255)';
//$field15->uitype = 2;
//$field15->typeofdata = 'V~O';
//$block1->addField($field15);
//
//$field16 = new Vtiger_Field();
//$field16->name = 'virtualization_method';
//$field16->label = 'Virtualization method:'; 
//$field16->table = $moduleInstance->basetable;
//$field16->column = 'virtualization_method';
//$field16->columntype = 'VARCHAR(255)';
//$field16->uitype = 16;
//$field16->typeofdata = 'V~O';
//$block1->addField($field16);
//
//
//$field17 = new Vtiger_Field();
//$field17->name = 'no_of_hypervisor';
//$field17->label = 'Number of hypervisor:'; 
//$field17->table = $moduleInstance->basetable;
//$field17->column = 'no_of_hypervisor';
//$field17->columntype = 'VARCHAR(255)';
//$field17->uitype = 2;
//$field17->typeofdata = 'V~O';
//$block1->addField($field17);
//
//$field18 = new Vtiger_Field();
//$field18->name = 'pra_pca';
//$field18->label = 'PRA or PCA:'; 
//$field18->table = $moduleInstance->basetable;
//$field18->column = 'pra_pca';
//$field18->columntype = 'VARCHAR(255)';
//$field18->uitype = 16;
//$field18->typeofdata = 'V~O';
//$block1->addField($field18);
//
//$field19 = new Vtiger_Field();
//$field19->name = 'backup_software';
//$field19->label = 'Backup Software:'; 
//$field19->table = $moduleInstance->basetable;
//$field19->column = 'backup_software';
//$field19->columntype = 'VARCHAR(255)';
//$field19->uitype = 2;
//$field19->typeofdata = 'V~O';
//$block1->addField($field19);
//
//$field20 = new Vtiger_Field();
//$field20->name = 'sun_model';
//$field20->label = 'Model of the SAN:'; 
//$field20->table = $moduleInstance->basetable;
//$field20->column = 'sun_model';
//$field20->columntype = 'VARCHAR(255)';
//$field20->uitype = 2;
//$field20->typeofdata = 'V~O';
//$block1->addField($field20);
//
//$field21 = new Vtiger_Field();
//$field21->name = 'nas_model';
//$field21->label = 'Model of the NAS:'; 
//$field21->table = $moduleInstance->basetable;
//$field21->column = 'nas_model';
//$field21->columntype = 'VARCHAR(255)';
//$field21->uitype = 2;
//$field21->typeofdata = 'V~O';
//$block1->addField($field21);
//
//$field22 = new Vtiger_Field();
//$field22->name = 'lto_rdx_model';
//$field22->label = 'LTO or RDX model:'; 
//$field22->table = $moduleInstance->basetable;
//$field22->column = 'LTO or RDX model:';
//$field22->columntype = 'VARCHAR(255)';
//$field22->uitype = 2;
//$field22->typeofdata = 'V~O';
//$block1->addField($field22);
//
//$field23 = new Vtiger_Field();
//$field23->name = 'firewall_model';
//$field23->label = 'Firewall model:'; 
//$field23->table = $moduleInstance->basetable;
//$field23->column = 'firewall_model';
//$field23->columntype = 'VARCHAR(255)';
//$field23->uitype = 2;
//$field23->typeofdata = 'V~O';
//$block1->addField($field23);
//
//$field24 = new Vtiger_Field();
//$field24->name = 'utm_renewal_date';
//$field24->label = 'UTM renewal date:'; 
//$field24->table = $moduleInstance->basetable;
//$field24->column = 'utm_renewal_date';
//$field24->columntype = 'date';
//$field24->uitype = 5;
//$field24->typeofdata = 'D~O';
//$block1->addField($field24);
//
//$field25 = new Vtiger_Field();
//$field25->name = 'no_of_printer';
//$field25->label = 'Number of printer:'; 
//$field25->table = $moduleInstance->basetable;
//$field25->column = 'no_of_printer';
//$field25->columntype = 'VARCHAR(255)';
//$field25->uitype = 2;
//$field25->typeofdata = 'V~O';
//$block1->addField($field25);
//
//$block2 = new Vtiger_Block();
//$block2->label = 'LBL_FURTHER_INFORMATION';
//$moduleInstance->addBlock($block2);
//
//$field26 = new Vtiger_Field();
//$field26->name = 'detected_project';
//$field26->label = 'Have you detected a project?'; 
//$field26->table = $moduleInstance->basetable;
//$field26->column = 'detected_project';
//$field26->columntype = 'VARCHAR(255)';
//$field26->uitype = 16;
//$field26->typeofdata = 'V~O';
//$block2->addField($field26);
//
//$field27 = new Vtiger_Field();
//$field27->name = 'comment';
//$field27->label = 'Comment:'; 
//$field27->table = $moduleInstance->basetable;
//$field27->column = 'comment';
//$field27->columntype = 'text';
//$field27->uitype = 19;
//$field27->typeofdata = 'V~O';
//$block2->addField($field27);
//
//
//
//$fieldm1 = new Vtiger_Field();
//$fieldm1->name = 'assigned_user_id';
//$fieldm1->label = 'Assigned To';
//$fieldm1->table = 'vtiger_crmentity'; 
//$fieldm1->column = 'smownerid';
//$fieldm1->uitype = 53;
//$fieldm1->typeofdata = 'V~M';
//$block1->addField($fieldm1);
//
//
//$fieldm2 = new Vtiger_Field();
//$fieldm2->name = 'CreatedTime';
//$fieldm2->label= 'Created Time';
//$fieldm2->table = 'vtiger_crmentity';
//$fieldm2->column = 'createdtime';
//$fieldm2->uitype = 70;
//$fieldm2->typeofdata = 'T~O';
//$fieldm2->displaytype= 2;
//$block1->addField($fieldm2);
//
//$fieldm3 = new Vtiger_Field();
//$fieldm3->name = 'ModifiedTime';
//$fieldm3->label= 'Modified Time';
//$fieldm3->table = 'vtiger_crmentity';
//$fieldm3->column = 'modifiedtime';
//$fieldm3->uitype = 70;
//$fieldm3->typeofdata = 'T~O';
//$fieldm3->displaytype= 2;
//$block1->addField($fieldm3);
//
//$filter1 = new Vtiger_Filter();
//$filter1->name = 'All';
//$filter1->isdefault = true;
//$moduleInstance->addFilter($filter1);
//
//
//
//$filter1->addField($field1)->addField($field5, 1)->addField($field6, 2)->addField($field7, 3)->addField($field8, 4)->addField($field9, 5)->addField($field10, 6);
//
//$moduleInstance->setDefaultSharing('Private'); 
//
//
//
//$moduleInstance->enableTools(Array('Import', 'Export'));
//$moduleInstance->disableTools('Merge');




/********************************************************************************/

/*$module->name = 'Recall';

$module->initWebservice();

$module->save();

$module->initTables();

$block1 = new Vtiger_Block();
$block1->label = 'LBL_RECALL_REMINDER';
$module->addBlock($block1);


$field = new Vtiger_Field();
$field->name = 'Date';
$field->label = 'date';
$field->table = $module->basetable;
$field->column = 'date';
$field->columntype = 'date';
$field->uitype = 5;
$field->typeofdata = 'V~M';
$block1->addField($field);
$module->setEntityIdentifier($field);


$field1 = new Vtiger_Field();
$field1->name = 'related_customer';
$field1->label = 'Customer';
$field1->table = $module->basetable;
$field1->column = 'related_customer';
$field1->columntype = 'VARCHAR(100)';
$field1->uitype = 10;
$field1->typeofdata = 'V~O';
$block1->addField($field1); 
$field1->setRelatedModules(array('Cust'));

$field2 = new Vtiger_Field();
$field2->name = 'reminder_comment';
$field2->label = 'Comment'; 
$field2->table = $module->basetable;
$field2->column = 'reminder_comment';
$field2->columntype = 'text';
$field2->uitype = 19;
$field2->typeofdata = 'V~M';
$block1->addField($field2);


$fieldm1 = new Vtiger_Field();
$fieldm1->name = 'assigned_user_id';
$fieldm1->label = 'Assigned To';
$fieldm1->table = 'vtiger_crmentity'; 
$fieldm1->column = 'smownerid';
$fieldm1->uitype = 53;
$fieldm1->typeofdata = 'V~M';
$block1->addField($fieldm1);


$fieldm2 = new Vtiger_Field();
$fieldm2->name = 'CreatedTime';
$fieldm2->label= 'Created Time';
$fieldm2->table = 'vtiger_crmentity';
$fieldm2->column = 'createdtime';
$fieldm2->uitype = 70;
$fieldm2->typeofdata = 'T~O';
$fieldm2->displaytype= 2;
$block1->addField($fieldm2);

$fieldm3 = new Vtiger_Field();
$fieldm3->name = 'ModifiedTime';
$fieldm3->label= 'Modified Time';
$fieldm3->table = 'vtiger_crmentity';
$fieldm3->column = 'modifiedtime';
$fieldm3->uitype = 70;
$fieldm3->typeofdata = 'T~O';
$fieldm3->displaytype= 2;
$block1->addField($fieldm3);

$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);



$filter1->addField($field);
$module->setDefaultSharing('Private'); 



$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');
*/


$module->name = 'CompanyAddress';

$module->initWebservice();

$module->save();

$module->initTables();

$block1 = new Vtiger_Block();
$block1->label = 'LBL_COMPANY_ADDRESS';
$module->addBlock($block1);


$field = new Vtiger_Field();
$field->name = 'company_name';
$field->label = 'Company Name';
$field->table = $module->basetable;
$field->column = 'company_name';
$field->columntype = 'VARCHAR(100)';
$field->uitype = 2;
$field->typeofdata = 'V~M';
$block1->addField($field);
$module->setEntityIdentifier($field);


$field1 = new Vtiger_Field();
$field1->name = 'address';
$field1->label = 'Address';
$field1->table = $module->basetable;
$field1->column = 'address';
$field1->columntype = 'VARCHAR(100)';
$field1->uitype = 2;
$field1->typeofdata = 'V~O';
$block1->addField($field1); 


$field2 = new Vtiger_Field();
$field2->name = 'city';
$field2->label = 'City'; 
$field2->table = $module->basetable;
$field2->column = 'city';
$field2->columntype = 'VARCHAR(100)';
$field2->uitype = 2;
$field2->typeofdata = 'V~O';
$block1->addField($field2);

$field3 = new Vtiger_Field();
$field3->name = 'state';
$field3->label = 'State'; 
$field3->table = $module->basetable;
$field3->column = 'state';
$field3->columntype = 'VARCHAR(100)';
$field3->uitype = 2;
$field3->typeofdata = 'V~O';
$block1->addField($field3);

$field4 = new Vtiger_Field();
$field4->name = 'postalcode';
$field4->label = 'Postal Code'; 
$field4->table = $module->basetable;
$field4->column = 'postalcode';
$field4->columntype = 'VARCHAR(100)';
$field4->uitype = 2;
$field4->typeofdata = 'V~O';
$block1->addField($field4);

$field5 = new Vtiger_Field();
$field5->name = 'country';
$field5->label = 'Country'; 
$field5->table = $module->basetable;
$field5->column = 'country';
$field5->columntype = 'VARCHAR(100)';
$field5->uitype = 2;
$field5->typeofdata = 'V~O';
$block1->addField($field5);

$field6 = new Vtiger_Field();
$field6->name = 'phone';
$field6->label = 'Phone'; 
$field6->table = $module->basetable;
$field6->column = 'phone';
$field6->columntype = 'VARCHAR(100)';
$field6->uitype = 2;
$field6->typeofdata = 'V~O';
$block1->addField($field6);

$field7 = new Vtiger_Field();
$field7->name = 'fax';
$field7->label = 'Fax'; 
$field7->table = $module->basetable;
$field7->column = 'fax';
$field7->columntype = 'VARCHAR(100)';
$field7->uitype = 2;
$field7->typeofdata = 'V~O';
$block1->addField($field7);

$field8 = new Vtiger_Field();
$field8->name = 'website';
$field8->label = 'Website'; 
$field8->table = $module->basetable;
$field8->column = 'website';
$field8->columntype = 'VARCHAR(100)';
$field8->uitype = 2;
$field8->typeofdata = 'V~O';
$block1->addField($field8);

$field9 = new Vtiger_Field();
$field9->name = 'vat';
$field9->label = 'VAT ID'; 
$field9->table = $module->basetable;
$field9->column = 'vat';
$field9->columntype = 'VARCHAR(100)';
$field9->uitype = 2;
$field9->typeofdata = 'V~O';
$block1->addField($field9);


$fieldm1 = new Vtiger_Field();
$fieldm1->name = 'assigned_user_id';
$fieldm1->label = 'Assigned To';
$fieldm1->table = 'vtiger_crmentity'; 
$fieldm1->column = 'smownerid';
$fieldm1->uitype = 53;
$fieldm1->typeofdata = 'V~M';
$block1->addField($fieldm1);


$fieldm2 = new Vtiger_Field();
$fieldm2->name = 'CreatedTime';
$fieldm2->label= 'Created Time';
$fieldm2->table = 'vtiger_crmentity';
$fieldm2->column = 'createdtime';
$fieldm2->uitype = 70;
$fieldm2->typeofdata = 'T~O';
$fieldm2->displaytype= 2;
$block1->addField($fieldm2);

$fieldm3 = new Vtiger_Field();
$fieldm3->name = 'ModifiedTime';
$fieldm3->label= 'Modified Time';
$fieldm3->table = 'vtiger_crmentity';
$fieldm3->column = 'modifiedtime';
$fieldm3->uitype = 70;
$fieldm3->typeofdata = 'T~O';
$fieldm3->displaytype= 2;
$block1->addField($fieldm3);

$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);



$filter1->addField($field);
$module->setDefaultSharing('Private'); 



$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');


?>