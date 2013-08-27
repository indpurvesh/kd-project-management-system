(function($) {  
    $.widget("ui.timeslider", {
        getTime: function(value, format){
			
            if (format == 'undefined')
                format = 12;
			
            var time = null,
            minutes,
            hours;
				
            hours = Math.floor(value / 60);
            minutes = value - (hours * 60);

            if (format == 12)
            {
                if (hours === 0) {
                    hours = 12;
                }
			
                if (hours > 12) {
                    hours = hours - 12;
                    time = "PM";
                }
                else {
                    time = "AM";   
                }
			
                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
			
                return hours + ":" + minutes + " " + time;
            }
            else
            {

                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
			
                return hours + ":" + minutes;
            }
        },
        _slideTime: function (event, ui){
            var that = $(this),
            startTime = null,
            endTime = null;
            
            if(that.slider( "option", "range" )){
                startTime = that.timeslider('getTime',that.slider("values", 0), that.timeslider('option', 'clockFormat'));
                endTime = that.timeslider('getTime', that.slider("values", 1), that.timeslider('option', 'clockFormat'));
            
                that.timeslider('option', 'timeDisplay').text(startTime + ' - ' + endTime);
				
                if(that.timeslider('option', 'addInputs'))
                {
                    that.timeslider('option', 'inputsContainer').find('input.start_time').val(startTime);
                    that.timeslider('option', 'inputsContainer').find('input.end_time').val(endTime);
                }
            }
            else {
                startTime = that.timeslider('getTime', that.slider("value"), that.timeslider('option', 'clockFormat'));
    
                that.timeslider('option', 'timeDisplay').text(startTime);
				
                if(that.timeslider('option', 'addInputs'))
                {
                    that.timeslider('option', 'inputsContainer').find('input.start_time').val(startTime);
                }
            }
        },
        _checkMax: function(event, ui) {
            var that = $(this);
        
            if(that.slider( "option", "range" )){
                var div = that.find('div'),
                size = that.slider("values", 1) - that.slider("values", 0);
                if( size >= 1435) {
                    div.addClass("ui-state-error");
                    that.timeslider('option', 'submitButton').attr("disabled","disabled").addClass("ui-state-disabled");
                    that.timeslider('option', 'errorMessage').text("Cannot be more than 24 hours");
                }
                else {	
                    div.removeClass("ui-state-error");
                    that.timeslider('option', 'submitButton').attr("disabled",null).removeClass("ui-state-disabled");
                    that.timeslider('option', 'errorMessage').text("");
                } 
            }
        },
        options: {
            sliderOptions: {},
            errorMessage: null,
            timeDisplay: null,
            submitButton: null,
            clickSubmit: null,
            inputsContainer: '.timesliderInputsContainer',
            addInputs: false,
            clockFormat: 12,
            startTime: null,
            endTime: null
        },
        _create: function() {
            var that = this,
            o = that.options,
            el = that.element;
                
            o.sliderOptions.slide = that._slideTime;
            o.sliderOptions.change = that._checkMax;
            o.sliderOptions.stop = that._slideTime;
                
                
            o.errorMessage = $(o.errorMessage);
            o.timeDisplay = $(o.timeDisplay);
            o.submitButton = $(o.submitButton).click(o.clickSubmit);
                
            if(o.addInputs)
            {
                var container = o.inputsContainer;
					
                if(container.indexOf(".") != -1)
                    var inputsContainer_html = '<div class="'+container.split(".").join("")+'"></div>';
                else
                    var inputsContainer_html = '<div id="'+container.split("#").join("")+'"></div>';
					
                if (!$(o.inputsContainer).size())
                {
                    el.append(inputsContainer_html);
                }
					
                if (!$("input.start_time",o.inputsContainer).size())
                    $(o.inputsContainer).append('<input type="hidden" name="start_time" value="" class="start_time" />');
						
                if (!$("input.end_time",o.inputsContainer).size())
                    $(o.inputsContainer).append('<input type="hidden" name="end_time" value="" class="end_time" />');
						
                o.inputsContainer = $(o.inputsContainer);
            }
				
            if (o.startTime != null && o.endTime != null)
            {
                var time_parts = o.startTime.split(":");
                var timeslider_start_time = ((time_parts[0]) * 60) + time_parts[1]*1;
		
                time_parts = o.endTime.split(":");
                var timeslider_end_time = ((time_parts[0]) * 60) + time_parts[1]*1;

                o.sliderOptions.values = [timeslider_start_time, timeslider_end_time];

            }
				
            el.slider(o.sliderOptions);
            that._slideTime.call(el);
        },
        _destroy: function() {
            this.element.remove();
        }
    });
})(jQuery);
    
/*
* jQuery UI Slider Access
* By: Trent Richardson [http://trentrichardson.com]
* Version 0.3
* Last Modified: 10/20/2012
*
* Copyright 2011 Trent Richardson
* Dual licensed under the MIT and GPL licenses.
* http://trentrichardson.com/Impromptu/GPL-LICENSE.txt
* http://trentrichardson.com/Impromptu/MIT-LICENSE.txt
*
*/
(function($){

    $.fn.extend({
        sliderAccess: function(options){
            options = options || {};
            options.touchonly = options.touchonly !== undefined? options.touchonly : true; // by default only show it if touch device

            if(options.touchonly === true && !("ontouchend" in document))
                return $(this);

            return $(this).each(function(i,obj){
                var $t = $(this),
                o = $.extend({},{
                    where: 'after',
                    step: $t.slider('option','step'),
                    upIcon: 'ui-icon-plus',
                    downIcon: 'ui-icon-minus',
                    text: false,
                    upText: '+',
                    downText: '-',
                    buttonset: true,
                    buttonsetTag: 'span',
                    isRTL: false
                }, options),
                $buttons = $('<'+ o.buttonsetTag +' class="ui-slider-access">'+
                    '<button data-icon="'+ o.downIcon +'" data-step="'+ (o.isRTL? o.step : o.step*-1) +'">'+ o.downText +'</button>'+
                    '<button data-icon="'+ o.upIcon +'" data-step="'+ (o.isRTL? o.step*-1 : o.step) +'">'+ o.upText +'</button>'+
                    '</'+ o.buttonsetTag +'>');

                $buttons.children('button').each(function(j, jobj){
                    var $jt = $(this);
                    $jt.button({
                        text: o.text,
                        icons: {
                            primary: $jt.data('icon')
                        }
                    })
                    .click(function(e){
                        var step = $jt.data('step'),
                        curr = $t.slider('value'),
                        newval = curr += step*1,
                        minval = $t.slider('option','min'),
                        maxval = $t.slider('option','max'),
                        slidee = $t.slider("option", "slide") || function(){},
                        stope = $t.slider("option", "stop") || function(){};

                        e.preventDefault();

                        if(newval < minval || newval > maxval)
                            return;

                        $t.slider('value', newval);

                        slidee.call($t, null, {
                            value: newval
                        });
                        stope.call($t, null, {
                            value: newval
                        });
                    });
                });

                // before or after
                $t[o.where]($buttons);

                if(o.buttonset){
                    $buttons.removeClass('ui-corner-right').removeClass('ui-corner-left').buttonset();
                    $buttons.eq(0).addClass('ui-corner-left');
                    $buttons.eq(1).addClass('ui-corner-right');
                }

                // adjust the width so we don't break the original layout
                var bOuterWidth = $buttons.css({
                    marginLeft: ((o.where == 'after' && !o.isRTL) || (o.where == 'before' && o.isRTL)? 10:0),
                    marginRight: ((o.where == 'before' && !o.isRTL) || (o.where == 'after' && o.isRTL)? 10:0)
                }).outerWidth(true) + 5;
                var tOuterWidth = $t.outerWidth(true);
                $t.css('display','inline-block').width(tOuterWidth-bOuterWidth);
            });	
        }
    });

})(jQuery);