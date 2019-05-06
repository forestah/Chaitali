<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

ini_set('display_errors','On');


require_once 'includes/Loader.php';
require_once 'include/utils/utils.php';

vimport('~~/includes/http/Request.php');
vimport('~~/includes/runtime/Globals.php');
vimport('~~/includes/runtime/BaseModel.php');
vimport ('~~/includes/runtime/Controller.php');
vimport('~~/includes/runtime/LanguageHandler.php');


global $current_user;
global $adb;
$db = PearDatabase::getInstance();
$current_user = Users::getActiveAdminUser();

vimport('~~/modules/Invoice/InvoicePDFController.php');

class Invoice_CustomExportPDF_Action extends Inventory_ExportPDF_Action {

	function loginRequired() {
		return false;
	}
	
	function checkPermission(Vtiger_Request $request) {
		return true;
	}

	public function process(Vtiger_Request $request) {

		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		
		$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
		$recordModel->getPDF();
	}
}
