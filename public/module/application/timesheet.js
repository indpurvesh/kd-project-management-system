/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var timesheet =  {
    init: function() {
        var self =  timesheet;
        jQuery('.addlink a').click(self.addRowOnClick);
        jQuery('.timesheet_date .timesheet_date').datepicker({
        			altFormat:'dd-mm-YY', 
        			onSelect: function(dateText) {
        				location = location.origin+ location.pathname + "?date=" + dateText;
						  
				 }});
        
        
        jQuery('.change_date').click(self.changeDateOnClick);
        
        jQuery('.timepicker').each(function(i,ele){
        	if((typeof jQuery(ele).attr('data-defaulttime') == 'undefined')) {
        		jQuery(ele).timepicker({ 'scrollDefaultNow': true, timeFormat: "G:i" ,step: 15});
        	} else {
        		jQuery(ele).timepicker({ 'scrollDefaultTime': jQuery(ele).attr('data-defaulttime'), timeFormat: "G:i",step: 15 });
        	}
        	
        });
        
    },
    addRowOnClick: function(e) {
        e.preventDefault();
        jQuery.ajax({
            url: application_url + "application/timesheet/get-timesheet-row",
            type:'post',
            success: function(response) {
                console.info(response);
                jQuery('.addlink').before(response);
                jQuery('.timepicker').timepicker({ 'scrollDefaultNow': true, timeFormat: "G:i",step: 15 });
                
            }
        })
    },
    changeDateOnClick: function(e) {
    	e.preventDefault();
    	jQuery('.timesheet_date').trigger('focus');
    	
    }
}
jQuery(document).ready(timesheet.init)