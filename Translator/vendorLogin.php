

<?php 



ini_set('display_errors','On');
# Migration of Comments with Attachments
require_once('include/utils/utils.php');
require("modules/Emails/mail.php");
//require("modules/Users/Users.php");
require_once('modules/Calendar/Activity.php');
require_once('include/logging.php');
require_once("config.php");
require_once('include/database/PearDatabase.php');
require_once('modules/Calendar/CalendarCommon.php');
require_once('modules/Vtiger/CRMEntity.php');


require_once ('includes/Loader.php');



global $current_user,$adb,$root_directory;
$current_user = Users::getActiveAdminUser();
//echo "<pre>"; print_r($current_user);

$step = 1;
$vendorId = '';
$vendorName = '';
$vendorEmail = '';
$message = '';
$inv_id ='';

if($_REQUEST['step'] == 1){
$username = split(" ",$_REQUEST['username']);
if(count($username)==2){

 $query="select  *  from vtiger_vendor inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_vendor.vendorid
  where vtiger_crmentity.deleted=0 and (vtiger_vendor.email=? or CONCAT(vtiger_vendor.vendorname,' ') like '".$username[0]." %' 
  or CONCAT(vtiger_vendor.vendorname,' ') like '% ".$username[1]." ' or CONCAT(vtiger_vendor.vendorname,' ') like '".$username[1]." %' 
  or CONCAT(vtiger_vendor.vendorname,' ') like '% ".$username[0]." ') ";
  	$result = $adb->pquery($query, array($_REQUEST['email']));
}else{
$query="select  *  from vtiger_vendor inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_vendor.vendorid
  where vtiger_crmentity.deleted=0 and (vtiger_vendor.email=? or CONCAT(vtiger_vendor.vendorname,' ') like '".$username[0]." %'  
  or CONCAT(vtiger_vendor.vendorname,' ') like '% ".$username[0]." ') ";
  	$result = $adb->pquery($query, array($_REQUEST['email']));
}

/* $query="select  *  from vtiger_vendor inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_vendor.vendorid
  where vtiger_crmentity.deleted=0 and (vtiger_vendor.email=? or vtiger_vendor.vendorname=?) ";
	$result = $adb->pquery($query, array($_REQUEST['email'],$_REQUEST['username']));*/
	if($adb->num_rows($result) >= 1)
	{
		$result_set = $adb->fetch_array($result);
		$vendorId = $result_set['vendorid'];
		$vendorName = $result_set['vendorname'];
		$vendorEmail = $result_set['email'];
		$step = 2;
	}else{
	
		$message = "Incorrect data entered";
	}

}

if($_REQUEST['step'] == 2){

 $query="select  *  from vtiger_vendor inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_vendor.vendorid
  where vtiger_crmentity.deleted=0 and vtiger_vendor.vendorid=?";
	$result = $adb->pquery($query, array($_REQUEST['vendor_id']));
	
	$query1="select  *  from vtiger_purchaseorder 
	inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_purchaseorder.purchaseorderid
	inner join vtiger_purchaseordercf on vtiger_purchaseordercf.purchaseorderid=vtiger_purchaseorder.purchaseorderid
	inner join vtiger_pobillads on vtiger_pobillads.pobilladdressid=vtiger_purchaseorder.purchaseorderid 
	inner join vtiger_poshipads on vtiger_poshipads.poshipaddressid=vtiger_purchaseorder.purchaseorderid
	
  where vtiger_crmentity.deleted=0 and (vtiger_purchaseorder.purchaseorder_no=? or vtiger_purchaseorder.purchaseorder_no=? )   
  and ( (round(vtiger_purchaseorder.total)=? and vtiger_purchaseorder.currency_id='2') or (round(vtiger_purchaseordercf.cf_868)=? and vtiger_purchaseorder.currency_id='1')) and vtiger_purchaseorder.postatus='Approved'";
	$result1 = $adb->pquery($query1, array($_REQUEST['po_no'],'po'.$_REQUEST['po_no'],round($_REQUEST['po_amount']),round($_REQUEST['po_amount'])));
//	print_r($result1);
/*	$query1="select  *  from vtiger_purchaseorder 
	inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_purchaseorder.purchaseorderid
	inner join vtiger_purchaseordercf on vtiger_purchaseordercf.purchaseorderid=vtiger_purchaseorder.purchaseorderid
	
  where vtiger_crmentity.deleted=0   
   and vtiger_purchaseorder.postatus='Approved' and vtiger_purchaseorder.purchaseorder_no=?";
	$result1 = $adb->pquery($query1, array($_REQUEST['po_no']));*/
	
	if($adb->num_rows($result1) >= 1 && $adb->num_rows($result) >= 1)
	{
		$result_set = $adb->fetch_array($result1);
		//echo "<pre>===="; print_r($result_set);
		$purchaseorderId = $result_set['purchaseorderid'];
		$purchaseorder_no = $result_set['purchaseorder_no'];
		$issue_date = date('Y-m-d',time());
		$due_date = date('Y-m-d',time()+(30*24*3600));
		
		/*$result_set = $adb->fetch_array($result);
		$vendorId = $result_set['vendorid'];
		$vendorName = $result_set['vendorname'];
		$vendorEmail = $result_set['email'];*/
		
		
		$sql_mod_num = "SELECT * FROM vtiger_modentity_num where semodule='Invoice'";  
		$rs_mod_num = $adb->pquery($sql_mod_num,array());
		$result_mod_num = $adb->fetch_array($rs_mod_num);
		
		$cur_id = $result_mod_num['cur_id'];
		$prefix = $result_mod_num['prefix'];
		$cur_id_new = $cur_id+1;
		
		$sql_mod_num_update = "UPDATE vtiger_modentity_num SET cur_id=? where cur_id=? and active=1 AND semodule='Invoice'";  
		$rs_mod_num_update = $adb->pquery($sql_mod_num_update,array($cur_id_new,$cur_id));
		
		$adb->pquery("update vtiger_crmentity_seq set id=LAST_INSERT_ID(id+1)",array()); 
		
		$rs_crmid = $adb->pquery("select * from vtiger_crmentity_seq",array());
		$result_crmid = $adb->fetch_array($rs_crmid);
		
		$sql_insert_crmentity = "INSERT INTO  vtiger_crmentity
		 (crmid,smcreatorid,smownerid,smgroupid,setype,description,modifiedby,createdtime,modifiedtime,source) 
		 values(?,?,?,?,?,?,?,?,?,?)";
	 
			$params_insert_crmentity = array($result_crmid['id'], 1, 1, 0, 'Invoice','','1',date('Y-m-d H:i:s',time()),
			date('Y-m-d H:i:s',time()),'CRM');
			$adb->pquery($sql_insert_crmentity, $params_insert_crmentity); 
			
		$sql_insert_invoice = "INSERT INTO vtiger_invoice(invoiceid,subject,salesorderid,customerno,contactid,invoicedate,duedate,purchaseorder,
		 adjustment,salescommission,exciseduty,subtotal,total,taxtype,s_h_amount,accountid,invoicestatus,currency_id,
		conversion_rate,terms_conditions,invoice_no,pre_tax_total,received,balance,potential_id,tags) 
		values(?,?,NULL,'',0,?,?,?,?,?,?,?,?,?,?,0,'AutoCreated',?,?,?,?,?,?,?,0,?)";
	 
			$params_insert_invoice = array($result_crmid['id'], 'Invoice for '.$purchaseorder_no.' via translator', $issue_date,$due_date,$purchaseorder_no,
			$result_set['adjustment'],$result_set['salescommission'],$result_set['exciseduty'],$result_set['subtotal'],$result_set['subtotal'],$result_set['taxtype'],
			$result_set['s_h_amount'],$result_set['currency_id'],$result_set['conversion_rate'],$result_set['terms_conditions'], 
			$_REQUEST['inv_no'],$result_set['pre_tax_total'],$result_set['paid'],$result_set['balance'],$result_set['tags']);
			
			$adb->pquery($sql_insert_invoice, $params_insert_invoice);	
		
		 
		$adb->pquery("insert into vtiger_invoicecf(invoiceid,cf_896,cf_866,cf_898,cf_894) values(?,?,?,?,?)", array($result_crmid['id'],$_REQUEST['inv_no'],$result_set['cf_868'],$_REQUEST['vendor_id'],$result_set['cf_890']));
		
		
		
		$adb->pquery("insert into vtiger_crmentity_user_field(recordid,userid,starred) values(?,'1','0')", array($result_crmid['id']));
		  
		$sql_insert_invoicebilladd = "insert into 
		vtiger_invoicebillads(invoicebilladdressid,bill_street,bill_city,bill_state,bill_code,bill_country,bill_pobox) 
		values(?,?,?,?,?,?,?)";
	 
			$params_insert_invoicebilladd = array($result_crmid['id'], $result_set['bill_street'], $result_set['bill_city'],
			$result_set['bill_state'],$result_set['bill_code'], $result_set['bill_country'],$result_set['bill_pobox']);
			
			$adb->pquery($sql_insert_invoicebilladd, $params_insert_invoicebilladd);
			
			
			$sql_insert_invoiceshipadd = "insert into 
			vtiger_invoiceshipads(invoiceshipaddressid,ship_street,ship_city,ship_state,ship_code,ship_country,ship_pobox) 
			values(?,?,?,?,?,?,?)";
	 
			$params_insert_invoiceshipadd = array($result_crmid['id'], $result_set['ship_street'], $result_set['ship_city'],
			$result_set['ship_state'],$result_set['ship_code'], $result_set['ship_country'],$result_set['ship_pobox']);
			
			$adb->pquery($sql_insert_invoiceshipadd, $params_insert_invoiceshipadd);
			
			$query_pr="select  *  from  vtiger_inventoryproductrel where id=?";
			$result_pr = $adb->pquery($query_pr, array($purchaseorderId));
			if($adb->num_rows($result_pr) >= 1)
			{
				while($result_set_pr = $adb->fetch_array($result_pr)){
				
				$sql_insert_product = "INSERT INTO vtiger_inventoryproductrel (id, productid, sequence_no, quantity, listprice,
				 discount_percent, discount_amount, comment, description, incrementondel,  tax1, tax2, tax3, image,
				  purchase_cost, margin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?, ?)";
	 
			$params_insert_product = array($result_crmid['id'], $result_set_pr['productid'], $result_set_pr['sequence_no'],
			$result_set_pr['quantity'],$result_set_pr['listprice'], $result_set_pr['discount_percent'],$result_set_pr['discount_amount'],
			$result_set_pr['comment'],$result_set_pr['description'],$result_set_pr['incrementondel'],
			$result_set_pr['tax1'],$result_set_pr['tax2'],
			$result_set_pr['tax3'],$result_set_pr['image'],$result_set_pr['purchase_cost'],$result_set_pr['margin']);
			
			$adb->pquery($sql_insert_product, $params_insert_product);
				
				}
			
			}
			
			
			$sql_po_update = "UPDATE vtiger_purchaseorder SET postatus=? where purchaseorderid=? ";  
			 $adb->pquery($sql_po_update,array('Invoiced',$purchaseorderId));
		 
		$step = 3;
		$inv_id= $result_crmid['id'];
		
	}else{
	$step = 2;
		$message = "Incorrect data entered";
		$vendorId = $_REQUEST['vendor_id'];
		$vendorName = $_REQUEST['vendor_name'];
		$vendorEmail = $_REQUEST['email'];

	}

}

 //echo $message;



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V16</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="translator/images/icons/favicon.ico"/>
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="translator/css/util.css">
	<link rel="stylesheet" type="text/css" href="translator/css/main.css">
<!--===============================================================================================-->
	<script src="translator/js/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->
	<script src="translator/js/main.js"></script>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('translator/images/login-background.jpg');">
			<?php if($step == '1'){?>
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Vendor Login
				</span>
				<span class="login100-form-title p-b-41" style="color:#FF0000; font-size:12px"><?php echo $message; ?></span>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
				<input type="hidden" name="step" value="1">

					<div class="wrap-input100 validate-input" data-validate = "Enter Vendor name">
						<input class="input100" type="text" name="username" placeholder="Vendor name">
						
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter Email">
						<input class="input100" type="text" name="email" placeholder="Email">
						
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Submit
						</button>
					</div>

				</form>
			</div>
			<?php } ?>
			<?php if($step == '2'){?>
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Submit Invoice
				</span>
				<span class="login100-form-title p-b-41" style="color:#FF0000; font-size:12px"><?php echo $message; ?></span>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
				<input type="hidden" name="step" value="2">
				<input type="hidden" name="vendor_name" value="<?php echo $vendorName; ?>">
				<input type="hidden" name="vendor_id" value="<?php echo $vendorId; ?>">

					<div class="wrap-input100 validate-input" data-validate = "Enter PO number">
						<input class="input100" type="text" name="po_no" placeholder="PO number">
						
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter Vendor email">
						<input class="input100" type="text" name="email" value="<?php echo $vendorEmail; ?>" placeholder="Vendor Email">
						
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter PO amount in € ">
						<input class="input100" type="text" name="po_amount" placeholder="PO amount in €">
						
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter Invoice number">
						<input class="input100" type="text" name="inv_no" placeholder="Invoice number">
						
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Submit Invoice
						</button>
					</div>

				</form>
			</div>
			<?php } ?>
			<?php if($step == '3'){?>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="post">
				
				
				<span class="login100-form-title " style="color:#000000; font-size:16px; margin:25px; text-transform:none;">
			Invoice is successfully submitted and should be paid within 1 month (max 2 months).
			<a style="color:#000000;" href="index.php?module=Invoice&action=CustomExportPDF&record=<?php echo $inv_id; ?>&app=INVENTORY">Download a copy.</a>
			</span>
				<br> 



<script type="text/javascript">
			$( document ).ready(function() {
			
				$.ajax({
				  url: "index.php?module=Invoice&view=CustomSendEmail&mode=composeMailData&record=<?php echo $inv_id; ?>&app=INVENTORY",
				  cache: false,
				  success: function(html){
					
				  }
				});
			});
			</script>
				
				
				

				</form>
			
			
			
			
		
			<?php }?>
			
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	


</body>
</html>