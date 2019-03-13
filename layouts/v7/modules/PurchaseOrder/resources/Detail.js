/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Detail_Js("PurchaseOrder_Detail_Js", {
    triggerRecordPreview: function(recordId){
        var thisInstance = app.controller();
        thisInstance.showRecordPreview(recordId);
    },
    
    sendEmailPDFClickHandler: function(url) {
        var params = app.convertUrlToDataParams(url);
        
        app.helper.showProgress();
                app.request.post({data:params}).then(function(err,response){
                    var callback = function() {
                        var emailEditInstance = new Emails_MassEdit_Js();
                        emailEditInstance.registerEvents();                      
                    };
                    var data = {};
                    data['cb'] = callback;
                    app.helper.hideProgress();
                    app.helper.showModal(response,data);
                });
    },
},
{
    showRecordPreview: function(recordId, templateId) {
        var thisInstance = this;
        var params = {};
        var moduleName = app.getModuleName();
        params['module'] = moduleName;
        params['record'] = recordId;
        params['view'] = 'InventoryQuickPreview';
        params['navigation'] = 'false';
        params['mode']='Detail';

        if (templateId) {
            params['templateid'] = templateId;
        }
        app.helper.showProgress();
        app.request.get({data: params}).then(function(err, response) {
            app.helper.hideProgress();

            if (templateId) {
                jQuery('#pdfViewer').html(response);
                return;
            }
            app.helper.showModal(response, {'cb': function(modal) {
                    jQuery('.modal-dialog').css({"width": "870px"});
                    thisInstance.registerChangeTemplateEvent(modal, recordId);
                }
            });
        });
    },
     registerChangeTemplateEvent: function(container, recordId) {
         var thisInstance = this;
        var select = container.find('#fieldList');
        select.on("change", function() {
            var templateId = select.val();
            thisInstance.showRecordPreview(recordId, templateId);
        });

    },
    
    
    
    registerEvents: function() {
		var self = this;
        this._super();
		
		
		var is_admin = jQuery('#is_admin').val();
		//alert(is_admin);
		if(is_admin != 'on'){
			
		 /*var listItems =jQuery("select[name='postatus']").next().find('ul.chzn-results li'); 
		 //alert(listItems.html());
		 listItems.each(function(idx, li) {
				var items = jQuery(li);
				//alert(items.html());
				if(items.html()!='Created'){
					items.remove();
				}
			});*/
			
		var selectItems = jQuery("select[name='postatus'] option");
			selectItems.each(function(idx, li) {
				var items = jQuery(li);
				if(items.val()!='Created'){
					items.remove();
					//alert("k");
				}
			});
		}
		
		
		
        this.getDetailViewContainer().find('.inventoryLineItemDetails').popover({html: true});
		app.event.on("post.relatedListLoad.click", function() {
			self.getDetailViewContainer().find('.inventoryLineItemDetails').popover({html: true});
		});
    },

});