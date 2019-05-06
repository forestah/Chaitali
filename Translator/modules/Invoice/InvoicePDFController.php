<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'include/InventoryPDFController.php';

class Vtiger_InvoicePDFController extends Vtiger_InventoryPDFController{
	function buildHeaderModelTitle() {
		$singularModuleNameKey = 'SINGLE_'.$this->moduleName;
		$translatedSingularModuleLabel = getTranslatedString($singularModuleNameKey, $this->moduleName);
		if($translatedSingularModuleLabel == $singularModuleNameKey) {
			$translatedSingularModuleLabel = getTranslatedString($this->moduleName, $this->moduleName);
		}
		return sprintf("%s: %s", $translatedSingularModuleLabel, $this->focusColumnValue('invoice_no'));
	}

	function buildHeaderModelColumnCenter() {
		$customerName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');
		$contactName = $this->resolveReferenceLabel($this->focusColumnValue('contact_id'), 'Contacts');
		$purchaseOrder = $this->focusColumnValue('vtiger_purchaseorder');
		$salesOrder	= $this->resolveReferenceLabel($this->focusColumnValue('salesorder_id'));

		$customerNameLabel = getTranslatedString('Customer Name', $this->moduleName);
		$contactNameLabel = getTranslatedString('Contact Name', $this->moduleName);
		$purchaseOrderLabel = getTranslatedString('Purchase Order', $this->moduleName);
		$salesOrderLabel = getTranslatedString('Sales Order', $this->moduleName);

		$modelColumnCenter = array(
				$customerNameLabel	=>	$customerName,
				$purchaseOrderLabel =>	$purchaseOrder,
				$contactNameLabel	=>	$contactName,
				$salesOrderLabel	=>	$salesOrder
			);
		return $modelColumnCenter;
	}

	function buildHeaderModelColumnRight() {
	
		global $adb;
		$module = $this->moduleName;
		if($module == "Invoice"){	
			$query_inv="select  *  from vtiger_invoicecf where invoiceid=?";
			$result_inv = $adb->pquery($query_inv, array($this->focusColumnValue("record_id")));
			$rec_inv = $adb->fetch_array($result_inv);	
			$vid = $rec_inv['cf_898'];
			
		}else{
			$vid = '';
		}
		
		$issueDateLabel = getTranslatedString('Issued Date', $this->moduleName);
		$validDateLabel = getTranslatedString('Due Date', $this->moduleName);
		$billingAddressLabel = getTranslatedString('Billing Address', $this->moduleName);
		$shippingAddressLabel = getTranslatedString('Shipping Address', $this->moduleName);
		
		
		if($module == "Invoice" && $vid!=''){
			$modelColumnRight = array(
					'dates' => array(
							$issueDateLabel  => $this->formatDate(date("Y-m-d")),
							$validDateLabel  => $this->formatDate($this->focusColumnValue('validtill')),
					),
					$billingAddressLabel  => $this->buildHeaderModelColumnRightCustom()
					
			);
		
		}else{
		$modelColumnRight = array(
				'dates' => array(
					$issueDateLabel  => $this->formatDate(date("Y-m-d")),
					$validDateLabel => $this->formatDate($this->focusColumnValue('duedate')),
				),
				$billingAddressLabel  => $this->buildHeaderBillingAddress(),
				$shippingAddressLabel => $this->buildHeaderShippingAddress()
			);
		}	
		return $modelColumnRight;
	}

	function getWatermarkContent() {
		return $this->focusColumnValue('invoicestatus');
	}
	
	function buildHeaderModelColumnRightCustom() {
		global $adb;
		$module = $this->moduleName;
		if($module == "Invoice")
			$document_issue_office = $this->focusColumnValue('cf_894'); 
		
		
		$officeId = 0;	 
			
		if($document_issue_office == "Russian office"){
			$officeId = '2675';
		}
		
		if($document_issue_office == "German office"){
			$officeId = '2676';
		}
		
		if($document_issue_office == "Lithuanian office"){
			$officeId = '2681';
		}	
		
		
		if($module == "Invoice" && $officeId =='')
			$officeId = '2676';
		
	
		
		if($officeId !='0'){
		
		
			$result_address = $adb->pquery("SELECT * FROM vtiger_companyaddress where companyaddressid=?", array($officeId));
			$num_rows_address = $adb->num_rows($result_address);
			if($num_rows_address){
				$resultrow = $adb->fetch_array($result_address);
				$result = $adb->pquery("SELECT * FROM vtiger_organizationdetails", array());
				 $num_rows = $adb->num_rows($result);
				$logoname = '';
				$organizationname = '';
			
				
				if($num_rows) {
					$resultrow1 = $adb->fetch_array($result); 
					$logoname = $resultrow1['logoname'];
					$organizationname = $resultrow1['organizationname'];
				}
				
				
				$addressValues = array();
				$addressValues[] = $resultrow['address'];
				if(!empty($resultrow['city'])) $addressValues[]= "\n".$resultrow['city'];
				if(!empty($resultrow['state'])) $addressValues[]= ", ".$resultrow['state'];
				if(!empty($resultrow['code'])) $addressValues[]= $resultrow['code'];
				if(!empty($resultrow['country'])) $addressValues[]= "\n".$resultrow['country'];
	
				$additionalCompanyInfo = array();
				if(!empty($resultrow['phone']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Phone: ", $this->moduleName). $resultrow['phone'];
				if(!empty($resultrow['fax']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Fax: ", $this->moduleName). $resultrow['fax'];
				if(!empty($resultrow['website']))	$additionalCompanyInfo[]= "\n".getTranslatedString("Website: ", $this->moduleName). $resultrow['website'];
							if(!empty($resultrow['vatid']))         $additionalCompanyInfo[]= "\n".getTranslatedString("VAT ID: ", $this->moduleName). $resultrow['vatid']; 
	
				$modelColumnLeft = array(
						'logo' => "test/logo/".$logoname,
						'summary' => decode_html($organizationname),
						'content' => decode_html($this->joinValues($addressValues, ' '). $this->joinValues($additionalCompanyInfo, ' '))
				);
			
			}else{
			
				// Company information
		$result = $adb->pquery("SELECT * FROM vtiger_organizationdetails", array());
		$num_rows = $adb->num_rows($result);
		if($num_rows) {
			$resultrow = $adb->fetch_array($result);

			$addressValues = array();
			$addressValues[] = $resultrow['address'];
			if(!empty($resultrow['city'])) $addressValues[]= "\n".$resultrow['city'];
			if(!empty($resultrow['state'])) $addressValues[]= ",".$resultrow['state'];
			if(!empty($resultrow['code'])) $addressValues[]= $resultrow['code'];
			if(!empty($resultrow['country'])) $addressValues[]= "\n".$resultrow['country'];

			$additionalCompanyInfo = array();
			if(!empty($resultrow['phone']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Phone: ", $this->moduleName). $resultrow['phone'];
			if(!empty($resultrow['fax']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Fax: ", $this->moduleName). $resultrow['fax'];
			if(!empty($resultrow['website']))	$additionalCompanyInfo[]= "\n".getTranslatedString("Website: ", $this->moduleName). $resultrow['website'];
                        if(!empty($resultrow['vatid']))         $additionalCompanyInfo[]= "\n".getTranslatedString("VAT ID: ", $this->moduleName). $resultrow['vatid']; 

			$modelColumnLeft = array(
					'logo' => "test/logo/".$resultrow['logoname'],
					'summary' => decode_html($resultrow['organizationname']),
					'content' => decode_html($this->joinValues($addressValues, ' '). $this->joinValues($additionalCompanyInfo, ' '))
			);
		}
			
			
			}
			
		
		
		
		}else{
			// Company information
		$result = $adb->pquery("SELECT * FROM vtiger_organizationdetails", array());
		$num_rows = $adb->num_rows($result);
		if($num_rows) {
			$resultrow = $adb->fetch_array($result);

			$addressValues = array();
			$addressValues[] = $resultrow['address'];
			if(!empty($resultrow['city'])) $addressValues[]= "\n".$resultrow['city'];
			if(!empty($resultrow['state'])) $addressValues[]= ",".$resultrow['state'];
			if(!empty($resultrow['code'])) $addressValues[]= $resultrow['code'];
			if(!empty($resultrow['country'])) $addressValues[]= "\n".$resultrow['country'];

			$additionalCompanyInfo = array();
			if(!empty($resultrow['phone']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Phone: ", $this->moduleName). $resultrow['phone'];
			if(!empty($resultrow['fax']))		$additionalCompanyInfo[]= "\n".getTranslatedString("Fax: ", $this->moduleName). $resultrow['fax'];
			if(!empty($resultrow['website']))	$additionalCompanyInfo[]= "\n".getTranslatedString("Website: ", $this->moduleName). $resultrow['website'];
                        if(!empty($resultrow['vatid']))         $additionalCompanyInfo[]= "\n".getTranslatedString("VAT ID: ", $this->moduleName). $resultrow['vatid']; 

			$modelColumnLeft = array(
					'logo' => "test/logo/".$resultrow['logoname'],
					'summary' => decode_html($resultrow['organizationname']),
					'content' => decode_html($this->joinValues($addressValues, ' '). $this->joinValues($additionalCompanyInfo, ' '))
			);
		}
		
		}
		
					

		$contentRight = '';
		$contentRight = $modelColumnLeft['summary']."\n\n". $modelColumnLeft['content'];
		return $contentRight;
	}
}
?>
