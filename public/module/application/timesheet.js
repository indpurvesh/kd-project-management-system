/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var timesheet =  {
    init: function() {
        var self =  timesheet;
        jQuery('.addlink a').click(self.addRowOnClick);
        
    },
    addRowOnClick: function(e) {
        e.preventDefault();
        jQuery.ajax({
            url: application_url + "application/timesheet/get-timesheet-row",
            type:'post',
            success: function(response) {
                console.info(response);
                jQuery('.addlink').before(response);
            }
        })
    }
}
jQuery(document).ready(timesheet.init)