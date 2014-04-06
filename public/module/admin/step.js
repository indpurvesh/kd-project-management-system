/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function(){

    
    jQuery('.step_name:last').append('<p><a href="" title="add child" >add child</a></p>');
    jQuery('.steps .step_name a').click(function(e) {
        e.preventDefault();
        
        
        jQuery('#step_form #parent_step_id').val(jQuery(e.target).parents('.step_name').attr('data-step-id'));
        jQuery('#step_form #parent_step_select').val(jQuery(e.target).parents('step_name').attr('data-step-id'));
        jQuery('#step_form #parent_step_select').attr('disabled',true);
        
        
        jQuery('#step_form').dialog({'width': 'auto','title':'Add Step'});
        return false;
        //jQuery( "#step_form" ).dialog({'title' : 'step Form','width': 'auto'});
    });
    jQuery("#step_form").submit(function(e) {
        e.preventDefault();
        
        jQuery.ajax({
            url:application_url + "admin/project-type/add-step",
            type:"post",
            data:jQuery(e.target).serialize(),
            success:function(response) {
                location.reload();
            }
            
        });
        
        console.info(e);
    });
    

});