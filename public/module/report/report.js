var report =  {
    init: function() {
        var self =  report;
        
        jQuery('#from_date,#to_date').datepicker({dateFormat:'dd-mm-yy'});
        
    },
  
}
jQuery(document).ready(report.init)