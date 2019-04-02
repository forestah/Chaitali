<?php

include_once 'modules/Vtiger/CRMEntity.php';

class CompanyAddress extends Vtiger_CRMEntity {
        var $table_name = 'vtiger_companyaddress';
        var $table_index= 'companyaddressid';

        var $customFieldTable = Array('vtiger_companyaddresscf', 'companyaddressid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_companyaddress', 'vtiger_companyaddresscf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_companyaddress' => 'companyaddressid',
                'vtiger_companyaddresscf'=>'companyaddressid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Company Name' => Array('companyaddress', 'company_name'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Company Name' => 'company_name',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'company_name';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Company Name' => Array('companyaddress', 'company_name'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Company Name' => 'company_name',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('company_name');

        // For Alphabetical search
        var $def_basicsearch_col = 'company_name';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'company_name';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('company_name','assigned_user_id');

        var $default_order_by = 'company_name';
        var $default_sort_order='ASC';
}