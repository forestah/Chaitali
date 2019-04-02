<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class PurchaseOrder_DetailView_Model extends Inventory_DetailView_Model {

	public function getDetailViewLinks($linkParams) {
	global $current_user;

		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();
		
		$postatus = $recordModel->entity->column_fields['postatus'];
		$is_admin = $current_user->column_fields['is_admin'];
		$moduleName = $recordModel->getmoduleName();

		if(Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordModel->getId())) {
		
		
			//if($is_admin == "on" && $postatus == "Approved"){
			$detailViewLinks = array( 
                                        'linklabel' => vtranslate('LBL_EXPORT_TO_PDF', $moduleName), 
                                        'linkurl' => $recordModel->getExportPDFURL(), 
                                        'linkicon' => '' 
                        ); 
                       // $linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($detailViewLinks); 
						

                        $sendEmailLink = array( 
                                        'linklabel' => vtranslate('LBL_SEND_MAIL_PDF', $moduleName), 
                                        'linkurl' => 'javascript:Inventory_Detail_Js.sendEmailPDFClickHandler(\''.$recordModel->getSendEmailPDFUrl().'\')', 
                                        'linkicon' => '' 
                        ); 

                        $linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($sendEmailLink); 
		}
		
		foreach($linkModelList['DETAILVIEW'] as $key=>$val){
			// echo $val->linklabel; echo "<br>";
			 $link_lable = vtranslate('LBL_EXPORT_TO_PDF', $moduleName);
			 if($val->linklabel == $link_lable){
			 	if($is_admin != "on" && $postatus != "Approved" && $postatus != "Delivered"){
					unset($linkModelList['DETAILVIEW'][$key]);
				}
			 }
		}
		unset($linkModelList['DETAILVIEW'][count($linkModelList['DETAILVIEW'])-1]);
//echo "<pre>"; print_r($linkModelList);
//$linkModelList = array_unique($linkModelList);
		return $linkModelList;
	}
}
