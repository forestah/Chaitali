<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
ini_set('display_errors','On');


require_once 'includes/Loader.php';
require_once 'include/utils/utils.php';

vimport('~~/includes/http/Request.php');
vimport('~~/includes/runtime/Globals.php');
vimport('~~/includes/runtime/BaseModel.php');
vimport ('~~/includes/runtime/Controller.php');
vimport('~~/includes/runtime/LanguageHandler.php');

require_once 'modules/Emails/Emails.php';
//require_once 'modules/Emails/mail.php';


global $current_user;
global $adb;
$db = PearDatabase::getInstance();
$current_user = Users::getActiveAdminUser();


class Invoice_CustomSendEmail_View extends Inventory_SendEmail_View {

function loginRequired() {
		return false;
	}
	
	function checkPermission(Vtiger_Request $request) {
		return true;
	}

public function composeMailData(Vtiger_Request $request) {
		
		$inventoryRecordId = $request->get('record');
        $recordModel = Vtiger_Record_Model::getInstanceById($inventoryRecordId, $request->getModule());
       
	   $pdfFileName = $recordModel->getPDFFileName();

        $fileComponents = explode('/', $pdfFileName);

        $fileName = $fileComponents[count($fileComponents)-1];
        //remove the fileName
        array_pop($fileComponents);

		$attachmentDetails = array(array(
            'attachment' =>$fileName,
            'path' => implode('/',$fileComponents),
            'size' => filesize($pdfFileName),
				'type' => 'pdf',
				'nondeletable' => true
		));

		
		
		global $upload_badext;
		$adb = PearDatabase::getInstance();
		
		$query="select  *  from vtiger_vendor inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_vendor.vendorid
				INNER JOIN vtiger_invoicecf ON vtiger_invoicecf.cf_898=vtiger_vendor.vendorid
				INNER JOIN vtiger_invoice ON vtiger_invoicecf.invoiceid=vtiger_invoice.invoiceid
 				where vtiger_crmentity.deleted=0 and vtiger_invoicecf.invoiceid=?";
		$result = $adb->pquery($query, array($inventoryRecordId));
		$result_set = $adb->fetch_array($result);

		$moduleName1 = 'Emails';
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		
		$recordModel1 = Vtiger_Record_Model::getCleanInstance($moduleName1);
		$recordModel1->set('mode', '');
		
		$existingAttachments = $attachmentDetails;

		$to = 'chaidebnath@gmail.com';
		
		$flag = 'SENT';
		$content = '<html>
<head>
	<title></title>
</head>
<body><table>
<td><p>Hi,</p>
  <p>New Invoice has been autocreated from PurchaseOrder via transformer.</p>
  <p>Thanks</p>
  <p><br />
    </p></td>
</tr>
</table>
</body>
</html>';

	$processedContent = Emails_Mailer_Model::getProcessedContent($content); // To remove script tags
	$mailerInstance = Emails_Mailer_Model::getInstance();
	$processedContentWithURLS = decode_html($mailerInstance->convertToValidURL($processedContent));
	
	
	$recordModel1->set('description', $processedContentWithURLS);
	$recordModel1->set('subject', 'Invoice '.$result_set["invoice_no"].' by '.$result_set["vendorname"]);
	//$recordModel1->set('toMailNamesList',''));
	$recordModel1->set('saved_toid', 'chaidebnath@gmail.com,invoices@alchemytranslations.com');
	//$recordModel1->set('saved_toid', 'chaidebnath@gmail.com');
	$recordModel1->set('ccmail', '');
	$recordModel1->set('bccmail', '');
	$recordModel1->set('assigned_user_id', $currentUserModel->getId());
	$recordModel1->set('email_flag', 'SENT');
	$recordModel1->set('documentids', '');
	$recordModel1->set('signature','Yes');
	
	$recordModel1->set('toemailinfo', '');
	
	$recordModel1->set('parent_id', '');
	
	
	
	$success = false;
			
	// Fix content format acceptable to be preserved in table.
	$decodedHtmlDescriptionToSend = $content;
	$recordModel1->set('description', to_html($decodedHtmlDescriptionToSend));
	$recordModel1->save();
	
	//To Handle existing attachments
			$current_user = Users_Record_Model::getCurrentUserModel();
			$ownerId = $recordModel->get('assigned_user_id');
			$date_var = date("Y-m-d H:i:s");
			if(is_array($existingAttachments)) {
				foreach ($existingAttachments as $index =>  $existingAttachInfo) {
					$file_name = $existingAttachInfo['attachment'];
					$path = $existingAttachInfo['path'];
					$fileId = $existingAttachInfo['fileid'];

					$oldFileName = $file_name;
					//SEND PDF mail will not be having file id
					if(!empty ($fileId)) {
						$oldFileName = $existingAttachInfo['fileid'].'_'.$file_name;
					}
					$oldFilePath = $path.'/'.$oldFileName;

					$binFile = sanitizeUploadFileName($file_name, $upload_badext);

					$current_id = $adb->getUniqueID("vtiger_crmentity");

					$filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
					$filetype = $existingAttachInfo['type'];
					$filesize = $existingAttachInfo['size'];

					//get the file path inwhich folder we want to upload the file
					$upload_file_path = decideFilePath();
					$newFilePath = $upload_file_path . $current_id . "_" . $binFile;

					copy($oldFilePath, $newFilePath);

					$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
					$params1 = array($current_id, 1, 1, $moduleName . " Attachment", $recordModel->get('description'), $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
					$adb->pquery($sql1, $params1);

					$sql2 = "insert into vtiger_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
					$params2 = array($current_id, $filename, $recordModel->get('description'), $filetype, $upload_file_path);
					$result = $adb->pquery($sql2, $params2);

					$sql3 = 'insert into vtiger_seattachmentsrel values(?,?)';
					$adb->pquery($sql3, array($recordModel1->getId(), $current_id));
				}
			}
			$success = true;
			
			if($flag == 'SENT') {
				$status = $recordModel1->send();
				if ($status === true) {
					// This is needed to set vtiger_email_track table as it is used in email reporting
					$recordModel1->setAccessCountValue();
				} else {
					$success = false;
					$message = $status;
				}
			}
			
			echo $status;
	
		
	}

}

?>
