<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
require_once 'include/events/VTEventHandler.inc';
include_once 'include/Webservices/Revise.php';
include_once 'include/Webservices/Retrieve.php';

class Vtiger_RecordLabelUpdater_Handler extends VTEventHandler {

	function handleEvent($eventName, $data) {
		global $adb,$current_user;

		if ($eventName == 'vtiger.entity.aftersave') {
			$record = $data->getId();
			$module = $data->getModuleName();
			
			
			if ($module === 'Invoice' || $module === 'Quotes' || $module === 'SalesOrder' ||  $module === 'PurchaseOrder'){
				$wsid = vtws_getWebserviceEntityId($module, $record);
				$wsrecord = vtws_retrieve($wsid,$current_user);
				
				$grand_total = $wsrecord['hdnGrandTotal'];
				$currencyId = $wsrecord['currency_id'];
				
				
				
				
				if($currencyId == '21x2'){
					$eur_price =$grand_total;
					
								
					
					$currency =  file_get_contents('https://api.exchangeratesapi.io/latest?base=EUR');
					//echo  $currency; die;
					$currency_arr = json_decode($currency);
					$usd_price = $currency_arr->rates->USD * $eur_price;
			
					/*$currency =  file_get_contents('https://www.hajanaone.com/currency-api.php?amount='.$eur_price.'&from=EUR&to=USD');
					$currency = str_replace(' ','',$currency);
					$currency_arr = explode('=',$currency);
					$usd_price = str_replace('USD','',$currency_arr[1]);*/
				
				}else{
					$eur_price =$grand_total;
					

					$currency =  file_get_contents('https://api.exchangeratesapi.io/latest?base=USD');
					//echo  $currency; die;
					$currency_arr = json_decode($currency);
					$usd_price = $currency_arr->rates->EUR * $eur_price;
					
					
					/*$eur_price =$grand_total;
					$currency =  file_get_contents('https://www.hajanaone.com/currency-api.php?amount='.$eur_price.'&from=USD&to=EUR');
					$currency = str_replace(' ','',$currency);
					$currency_arr = explode('=',$currency);
					$usd_price = str_replace('EUR','',$currency_arr[1]);*/
				}
				
				if ($module === 'Invoice')
					$adb->pquery("UPDATE vtiger_invoicecf SET cf_866=? WHERE invoiceid=?", array($usd_price, $record));
					
				if ($module === 'Quotes')
					$adb->pquery("UPDATE vtiger_quotescf SET cf_870=? WHERE quoteid=?", array($usd_price, $record));	
					
				if ($module === 'SalesOrder')
					$adb->pquery("UPDATE vtiger_salesordercf SET cf_872=? WHERE salesorderid=?", array($usd_price, $record));
					
				if ($module === 'PurchaseOrder')
					$adb->pquery("UPDATE vtiger_purchaseordercf SET cf_868=? WHERE purchaseorderid=?", array($usd_price, $record));		
				
				
			}

			if($module === 'Users') {
				return;
			}

			$labelInfo = getEntityName($module, $record, true);

			if ($labelInfo) {
				$label = decode_html($labelInfo[$data->getId()]);
				$adb->pquery('UPDATE vtiger_crmentity SET label=? WHERE crmid=?', array($label, $record));
			}
		}
	}
}