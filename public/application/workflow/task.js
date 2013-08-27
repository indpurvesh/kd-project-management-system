var Default_Task = {

    init: function() {
        var self = Default_Task;
        jQuery( "#project_name" ).autocomplete({
            source: function( request, response ) {
                jQuery.ajax({
                    url: application_url + "/workflow/project/get-json-list",
                    data: {
                        name_startsWith: request.term
                    },
                    success: function( data ) {
                        data = jQuery.parseJSON(data);
                        response( jQuery.map( data.project_list, function( item ) {
                            return {
                                label: item.project_name,
                                value: item.project_name,
                                real_id : item.id
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            select: function( event, ui ) {
                jQuery('#project_id').val(ui.item.real_id);
            }
        });
        
    }
}
jQuery(window).ready(Default_Task.init);
