/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function(){

    
    jQuery('.steps .step_name a').click(function(e) {
        e.preventDefault();
        jQuery('#step_form').dialog({'width': 'auto','title':'Add Step'});
        return false;
        //jQuery( "#step_form" ).dialog({'title' : 'step Form','width': 'auto'});
    });
    

});