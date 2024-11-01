(function(window, document, $, undefined) {

    'use strict';

    var scope = {

      // Initializes all functions.

        init: function() {

            scope.onChangeStylingTemplate();
            scope.wpUseColorPicker();
            scope.saveTemplateStylingAjax();
            scope.initTemplateStyleRender();

        },

        initTemplateStyleRender: function() {

            var template_content = $('.template__content');

            if( template_content.length ) {

                var fontSize        = $('input.wcndcontent_dynamic_data').val(),
                    fontColor       = $('#fontcolor-hidden-value').val(),
                    bgColor         = $('#bgcolor-hidden-value').val(),
                    btnbgcolor      = $('#btnbgcolor-hidden-value').val(),
                    btnTextSize     = $('#btn-font-size').val(),
                    btnFontColor    = $('#btntext-color-hidden-value').val();

                $('.template_1_the_style span.wcndcontent_dynamic_data').css('font-size',fontSize + 'px');
                $('.template_1_the_style span.wcndcontent_dynamic_data').css('color',fontColor);
                $('.template_1_the_style .start_styling').css('background-color',bgColor);
                $('.template_1_the_style a.wcndcontent_dynamic_data').css('background-color',btnbgcolor);
                $('.template_1_the_style a.btn-first-template').css('font-size',btnTextSize + 'px');
                $('.template_1_the_style a.btn-first-template').css('color',btnFontColor);

                $('.font-color-wrapper button').css('background-color',fontColor);
                $('.background-color-wrapper button').css('background-color',bgColor);
                $('.button-background-color-wrapper button').css('background-color',btnbgcolor);
                $('.button-text-color-wrapper button').css('background-color',btnFontColor);

            }

        },

        saveTemplateStylingAjax: function() {

            var save_settings = $('#save_style_settings');

            if( save_settings.length ) {

                save_settings.on('click', function(e) { 

                    e.preventDefault();

                    var fontsize     = $('.templates-list-wrapper input.wcndcontent_dynamic_data').val(),
                        fontColor    = $('#fontcolor-hidden-value').val(),
                        bgColor      = $('#bgcolor-hidden-value').val(),
                        btnBgColor   = $('#btnbgcolor-hidden-value').val(),
                        btnTextSize  = $('#btn-font-size').val(),
                        btnFontColor = $('#btntext-color-hidden-value').val();
                    
                    var data = {
                        'action'        : 'save_template_settings_wcnd',
                        'fontsize'      : fontsize,
                        'fontcolor'     : fontColor,
                        'bgcolor'       : bgColor,
                        'btnbgcolor'    : btnBgColor,
                        'btntextsize'   : btnTextSize,
                        'btnFontColor'  : btnFontColor,
                        'nonce'         : wcnd_ajax_obj.nonce_code
                    };

                    $.ajax({

                        url : wcnd_ajax_obj.ajax_url,
                        data : data,
                        type : 'POST',
                        dataType : 'JSON',
                        beforeSend : function ( xhr ){
                            $('.save__template_styling .loader-icon').removeClass('hide-ncwd');
                        },
                        success : function ( result ) {
                            
                            $('.save__template_styling .loader-icon').addClass('hide-ncwd');

                            if( result.data == 1 && result.data !== false ) {
                               
                                location.reload();
                           
                            }else{
                                
                                alert('Opps Error has Occured');

                            }                         

                        }

                    });

                } );

            }

        },

        wpUseColorPicker: function() {

            var colorpicker_wcnd = $('.wcnd_color_picker');
            
            if( colorpicker_wcnd.length ) {

                $('.wcnd_color_picker').wpColorPicker( {
                    change : function (event, ui ) {
                        var ColorDynamic = ui.color.toString();
                        var $this = $(this).parents()[4].firstElementChild.className;
                        
                        if( $this == 'font-color-wrapper' ) {
                            $('.template_1_the_style .start_styling .wcndcontent_dynamic_data').css( 'color', ColorDynamic);
                            $('#fontcolor-hidden-value').val(ColorDynamic);
                        }

                        if( $this == 'background-color-wrapper' ) {
                            $('.template_1_the_style .start_styling').css( 'background-color', ColorDynamic);
                            $('#bgcolor-hidden-value').val(ColorDynamic);
                        }

                        if( $this == 'button-background-color-wrapper' ) {
                            $('.template_1_the_style .start_styling a.wcndcontent_dynamic_data').css('background-color',ColorDynamic);
                            $('#btnbgcolor-hidden-value').val(ColorDynamic);
                        }

                        if( $this == 'button-text-color-wrapper' ) {
                            $('.template_1_the_style .start_styling a.btn-first-template').css('color',ColorDynamic);
                            $('#btntext-color-hidden-value').val(ColorDynamic);
                        }
                        
                    }
                });
            
            }
            
        },

        onChangeStylingTemplate: function() {

            var wcnd_template_list  = $('.templates-list-wrapper .template__content'),
                style_fields        = $('.templates-list-wrapper .css-style-fields'),
                drag_picker         = $('.templates-list-wrapper .iris-picker-inner .ui-draggable'),
                color_picker        = $('.templates-list-wrapper .wp-color-result');

                if( wcnd_template_list.length ) {

                    style_fields.on('input', function() {
                        
                        var $this       = $(this),
                            $this_value = $(this).val(),
                            $this_class = $(this).attr('data-classBtn');

                            if( $this.hasClass('wcndcontent_dynamic_data') ) {
                                var fontsize = $this_value + 'px';
                                $('.start_styling span.wcndcontent_dynamic_data').css( 'font-size', fontsize);
                            }

                            if( $this_class == 'btn-first-template' ) {
                                var fontsize = $this_value + 'px';
                                $('.start_styling a.btn-first-template').css('font-size',fontsize);
                            }

                    } );

                }

        }

    };


scope.init();



window.onresize = function() {

};



})(window, document, jQuery);