var Default_Timesheet = {

    init: function() {
        var self = Default_Timesheet;
        jQuery('.add_new_row_link a').click(self.addNewRowOnClick);
        jQuery('.savebtn').click(self.saveBtnOnClick);
        jQuery('.date_link input[name=date]').change(self.dateChange);
        self.initTimePicker();
    },
    initTimePicker: function() {
        jQuery('.date_link input[name=date]').datepicker({fornat:'dd-mm-YY'});
        jQuery('.StartTime input').timepicker();
        jQuery('.EndTime input').timepicker();
    },
    addNewRowOnClick:function(e) {
        e.preventDefault();
        jQuery.ajax({
            url:application_url +  '/user/timesheet/add-new-row',
            type:'post',
            success:function(data) {
                jQuery('.timesheet_rows .form_row').append(data);
                Default_Timesheet.initTimePicker();
            }
        });
    },
    saveBtnOnClick: function(e) {
        e.preventDefault();
        jQuery.ajax({
            url:application_url +  '/user/timesheet/save',
            type:'post',
            data:jQuery('#timesheet_row').serialize(),
            success:function(data) {
                //console.info(data);
                //data = jQuery.parseJSON(data);
                if(data.success== true) {
                    alert("Save Done")
                    location.reload();

                }
            }
        });
    },
    dateChange: function (e) {
        //console.info(e.target);
        location = application_url + "/user/timesheet?date=" + jQuery(e.target).val();
    }
}
jQuery(window).ready(Default_Timesheet.init);
