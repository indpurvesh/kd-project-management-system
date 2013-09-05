var Application = {
    init:function() {
        var self = Application;
        self.initApp();
        
        jQuery('.role_access select').change(self.roleChanged);
    },
    initApp: function() {
        application_url = "http://www.localhost.com/kdstep/"
    },
    roleChanged: function(e) {
        
        console.info('test');
        jQuery.ajax({
            url: application_url + "admin/user-access/get-role-access-html",
            success: function(response) {
                console.info(response);
                jQuery('.roleaccess_html').append(response);
            }
               
        });
    }
   
}
jQuery(document).ready(Application.init);