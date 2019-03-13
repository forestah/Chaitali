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


echo "ok";

$query_update="UPDATE vtiger_tab SET parent='Inventory' where tabid='59' ";
//$result_update = $adb->pquery($query_update, array());




$sql = "INSERT INTO vtiger_app2tab
									SET
									tabid='59',
									appname='INVENTORY',
									sequence='10',
									visible='1'";
						// $sql_insert=$adb->pquery($sql,array());

//To send email notification before a week
$query="select * from vtiger_field where tabid='59' ";
$result = $adb->pquery($query, array());


if($adb->num_rows($result) >= 1)
{
	while($result_set = $adb->fetch_array($result))
	{	
	
		echo "<pre>";
		print_r($result_set);

	}

}
echo "ok";




?>
