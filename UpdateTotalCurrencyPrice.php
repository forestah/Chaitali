<?php 
ini_set('display_errors','On');
# Migration of Comments with Attachments
require_once('include/utils/utils.php');
require("modules/Emails/mail.php");
require_once('modules/Calendar/Activity.php');
require_once('include/logging.php');
require_once("config.php");
require_once('include/database/PearDatabase.php');
require_once('modules/Calendar/CalendarCommon.php');
require_once('modules/Vtiger/CRMEntity.php');


require_once ('includes/Loader.php');



global $current_user,$adb,$root_directory;
$current_user = Users::getActiveAdminUser();

 $sql = "SELECT * FROM vtiger_crmentity where setype in('Quotes','Invoice','SalesOrder','PurchaseOrder')";
$rs = $adb->pquery($sql,array());


while($result = $adb->fetch_array($rs)){


	$module = $result['setype'];
	$record = $result['crmid'];
	
	$PM = CRMEntity::getInstance($module);
    $PM->retrieve_entity_info($record, $module); 

	
	$grand_total = $PM->column_fields['hdnGrandTotal'];
	$currencyId = $PM->column_fields['currency_id'];
	
	if($currencyId == '2'){
		$eur_price =$grand_total;			
		
		$currency =  file_get_contents('http://free.currencyconverterapi.com/api/v5/convert?q=EUR_USD&compact=ultra');
		$currency_arr = json_decode($currency);
		$usd_price = $currency_arr->EUR_USD * $eur_price;
	
	
	}else{
		$eur_price =$grand_total;
		
		$currency =  file_get_contents('http://free.currencyconverterapi.com/api/v5/convert?q=USD_EUR&compact=ultra');
		
		$currency_arr = json_decode($currency);
		$usd_price = $currency_arr->USD_EUR * $eur_price;
	
	
	
	}
	
	//print_r($PM->column_fields);
	if ($module === 'Invoice' && ($PM->column_fields['cf_866'] == '' || $PM->column_fields['cf_866'] == 0)){
		
		$adb->pquery("UPDATE vtiger_invoicecf SET cf_866=? WHERE invoiceid=?", array($usd_price, $record));
		}
	if ($module === 'Quotes' && ($PM->column_fields['cf_870'] == '' || $PM->column_fields['cf_870'] == 0)){
		$adb->pquery("UPDATE vtiger_quotescf SET cf_870=? WHERE quoteid=?", array($usd_price, $record));	
	}	
	if ($module === 'SalesOrder' && ($PM->column_fields['cf_872'] == '' || $PM->column_fields['cf_872'] == 0)){
		$adb->pquery("UPDATE vtiger_salesordercf SET cf_872=? WHERE salesorderid=?", array($usd_price, $record));
		
	}if (trim($module) =='PurchaseOrder' && ($PM->column_fields['cf_868'] == '' || $PM->column_fields['cf_868'] == 0)){
	echo $usd_price."<br>";
		$adb->pquery("UPDATE vtiger_purchaseordercf SET cf_868=? WHERE purchaseorderid=?", array($usd_price, $record));
		}

}



?>