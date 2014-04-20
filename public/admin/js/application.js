var Application = {
    init:function() {
        var self = Application;
        self.initApp();
        
        jQuery('.role_access select').change(self.roleChanged);
        
    },
    initApp: function() {
    	var self = Application;
        application_url = "http://www.kdstep.com/"; 
        
        //setting up
        if(jQuery(".p_title .role_name").length >= 1) {
        	jQuery(".p_title .role_name").html(jQuery('#role_name').find('option:selected').text());
        }
        
        // Global Cancel button 
        jQuery('.cancel-button input').click(self.cancelButtonOnClick);
    },
    roleChanged: function(e) {
        jQuery.ajax({
            url: application_url + "admin/user-access/get-role-access-html",
            data: {role_value:jQuery('#role_name').val()},
            success: function(response) {   
                jQuery('.roleaccess_html').html(response);
                jQuery(".roleaccess_html [data-toggle='switch']").bootstrapSwitch();
            }
        });
    },
    cancelButtonOnClick: function(e) {
    	e.preventDefault();
    	location = jQuery(this).attr('data-url');
    }
   
}
jQuery(document).ready(Application.init);