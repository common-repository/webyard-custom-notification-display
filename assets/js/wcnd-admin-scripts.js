(function(window, document, $, undefined) {

    'use strict';

    var scope = {

      // Initializes all functions.

        init: function() {

            scope.toggleTabContents();
            scope.wpBodyWidthHeight();
            scope.addNewMessage();
            scope.dateUiMessage();
            scope.deleteSingleMessage();
            scope.updateSingleMessage();

        },

        toggleTabContents: function() {

            var tabTitle            = $('.wcnd-items-tab ul li a.wcnd-tab-item'),
                parentLiActive      = $('.wcnd-items-tab ul li');

            if( tabTitle.length ) {

                tabTitle.on( 'click', function(e) {

                    e.preventDefault();

                    parentLiActive.removeClass('wcnd-tab-active');

                    var parentLi        = $(this).parent(),
                        activeContent   = $(this).attr('href'),
                        tabContents     = $('.wcnd-tab-contents');

                    parentLi.addClass('wcnd-tab-active');
                    tabContents.find('.wcnd-hide').removeClass('wcnd-default-show');
                    tabContents.find(activeContent).addClass('wcnd-default-show');

                } );

            }

        },

        wpBodyWidthHeight: function() {
            
            var wpBodyWidth   = $('#wpbody').width(),
                setWidth      = $('.setWidthDynamic'),
                setHeight     = $('.setHeightDynamic'),
                wpBody        = $('#wpbody'),
                wpBodyHeight  = $('#wpbody').height();
            
            if( wpBody.length ) {

                setWidth.css('width',wpBodyWidth);
                setHeight.css('min-height',wpBodyHeight);

            }

        },

        addNewMessage: function() {

            var addNewMsgBtn    = $('.wcnd-add-new-msg'),
                cancelNewMsgBtn = $('.cancel-action-pop'),
                saveNewMsgBtn   = $('.save-action-pop');

            if( addNewMsgBtn.length ) {

                addNewMsgBtn.on('click', function(e) {
                
                    e.preventDefault();
                    $('.popboxWrapper').toggleClass('wcnd-pop-active');
                
                } );


                cancelNewMsgBtn.on('click', function(e) {
                    
                    e.preventDefault();
                    var formInput           = $('form.newmessage__wcnd input, form.newmessage__wcnd textarea, form.newmessage__wcnd select'),
                        proOptions          = $('.forProfilesOnly');

                    // formInput.val('');
                    // formInput.attr('disabled',false);
                    // proOptions.attr('disabled',true);

                    $('.popboxWrapper').toggleClass('wcnd-pop-active');

                });

                saveNewMsgBtn.on('click',function(e){

                    e.preventDefault();
    
                    var messageType         = $('.select__msg-type').val(),
                        whereToDisplay      = $('.wcnd_page_type:checked').val(),
                        templateId          = $('.select__template-id').val(),
                        startDate           = $('.wcnd-start-date').val(),
                        endDate             = $('.wcnd-end-date').val(),
                        yourMessage         = $('.wcnd-yourmessage').val(),
                        btnText             = $('.wcnd-btn-text').val(),
                        btnUrl              = $('.wcnd-btn-url').val(),
                        formInput           = $('form.newmessage__wcnd input, form.newmessage__wcnd textarea, form.newmessage__wcnd select'),
                        proOptions          = $('.forProfilesOnly'),
                        loaderIcon          = $('.loader-icon');

                   var data = {
                        'action'            : 'save_notification_wcnd',
                        'message_type'      : messageType,
                        'page_display'      : whereToDisplay,
                        'template_id'       : templateId,
                        'start_date'        : startDate,
                        'end_date'          : endDate,
                        'message_box'       : yourMessage,
                        'button_text'       : btnText,
                        'button_url'        : btnUrl,
                        'nonce'             : wcnd_ajax_object.nonce
                    };

                    $.ajax({
    
                        url : wcnd_ajax_object.ajax_url,
                        data : data,
                        type : 'post',
                        dataType : 'JSON',
                        beforeSend : function ( xhr ){
                            loaderIcon.removeClass('hide-ncwd');
                            formInput.attr('disabled',true);
                        },
                        success : function ( result ) {
                            
                            loaderIcon.addClass('hide-ncwd');

                            if( result.data == 1 && result.data !== false ) {
                               
                                location.reload();
                           
                            }else{
                                
                                alert('Opps Error has Occured');

                            }                         

                        }

                    });
    
                });

            }

        },

        dateUiMessage: function() {

            var startDate           = $('.wcnd-start-date'),
                endDate             = $('.wcnd-end-date');

                if( startDate.length && endDate.length ) {

                    startDate.datepicker({
                        changeYear: true,
                        changeMonth: true,
                        minDate:0,
                        dateFormat: "mm-dd-yy",
                        yearRange: "-100:+20",
                        onClose: function( date ) {

                            var dates = new Date( date ),
                                selectedDate = new Date(dates),
                                msecsInADay = 86400000,
                                selectedEndDate = new Date(selectedDate.getTime() + msecsInADay);
                            
                            endDate.datepicker(
                                    "change",
                                    { minDate: selectedEndDate }
                            );

                        }

                    });

                    
                    $('.wcnd-end-date').datepicker({
                        changeYear: true,
                        changeMonth: true,
                        yearRange: "-100:+20",
                        dateFormat: "mm-dd-yy",
                    });

                }

        },

        deleteSingleMessage: function() {

            var delete_action = $('.wcnd-action-delete');

            if( delete_action.length ) {

                delete_action.on( 'click' , function(e) {
                    
                    e.preventDefault();

                    var getMsgId            = $(this).attr('data-wcnd-id'),
                        parentTr            = $(this).parent().parent().parent(),
                        parentTrchildTd     = parentTr.find('td');

                    var data        = {
                            'action'        :   'delete_single_row_message_wcnd',
                            'messageID'     :   getMsgId,
                            'nonce'         :   wcnd_ajax_object.nonce
                    };
                    
                    parentTrchildTd.addClass('removeBgTd');
                    parentTr.addClass('background-red');

                    if ( confirm('Are you sure you want to delete it?') ) {

                        $.ajax({
    
                            url : wcnd_ajax_object.ajax_url,
                            data : data,
                            type : 'post',
                            dataType : 'JSON',
                            beforeSend : function ( xhr ){
                                
                            },
                            success : function ( result ) {
                                
                                if( result.data == 1 && result.data !== false ) {
                               
                                    location.reload();
                               
                                }else{
                                    
                                    alert('Opps Something went wrong!. Please check the length of your message.');

                                }

                            },
    
                        });
                    
                    } else {

                        parentTrchildTd.removeClass('removeBgTd');
                        parentTr.removeClass('background-red');

                        return false;
                    
                    }


                } );

            }

        },

        updateSingleMessage: function() {

            var edit_action     = $('.wcnd-action-edit');

            if( edit_action.length ) {

                $(document).on( 'click', '#single_cancel_message', function (e) {
                    e.preventDefault();
                    
                    $('#messages-list table td').removeClass('removeBgTd');
                    $('#messages-list table tr').removeClass('active-edit-stat');
                    
                    $('.popboxWrapper_edit').remove();

                } );

                edit_action.on( 'click', function(e) {
                    
                    e.preventDefault();

                    var parentTr            = $(this).parent().parent().parent(),
                        parentTrchildTd     = parentTr.find('td');

                    var getMsgId    = $(this).attr('data-wcnd-id');

                    var data = {
                        'action'    : 'get_row_message_wcnd',
                        'nonce'     : wcnd_ajax_object.nonce,
                        'messageID' : getMsgId  
                    };

                    $.ajax({
    
                        url : wcnd_ajax_object.ajax_url,
                        data : data,
                        type : 'post',
                        dataType : 'JSON',
                        beforeSend : function ( xhr ){
                            parentTrchildTd.addClass('removeBgTd');
                            parentTr.addClass('active-edit-stat');
                        },
                        success : function ( result ) {
                            
                            if( result.data.error == false ) {
                           
                                $('#wpbody-content').append(result.data.content);
                                scope.dateUiMessage();
                           
                            }else{
                                
                                alert('Opps Something went wrong!!.');

                            }

                        },
                        complete : function ( result ) {
                            
                            parentTrchildTd.addClass('removeClass');
                            parentTr.removeClass('active-edit-stat');
                                
                        }

                    });

                        $(document).on( 'click', '#single_update_message', function( e ) {

                            e.preventDefault();

                            var messageType     = $('.popboxWrapper_edit .select__msg-type').val(),
                            whereToDisplay      = $('.popboxWrapper_edit .wcnd_page_type:checked').val(),
                            templateId          = $('.popboxWrapper_edit .select__template-id').val(),
                            startDate           = $('.popboxWrapper_edit .wcnd-start-date').val(),
                            endDate             = $('.popboxWrapper_edit .wcnd-end-date').val(),
                            yourMessage         = $('.popboxWrapper_edit .wcnd-yourmessage').val(),
                            btnText             = $('.popboxWrapper_edit .wcnd-btn-text').val(),
                            btnUrl              = $('.popboxWrapper_edit .wcnd-btn-url').val(),
                            formInput           = $('.popboxWrapper_edit form.newmessage__wcnd input, .popboxWrapper_edit form.newmessage__wcnd textarea, .popboxWrapper_edit form.newmessage__wcnd select'),
                            proOptions          = $('.popboxWrapper_edit .forProfilesOnly'),
                            loaderIcon          = $('.popboxWrapper_edit .loader-icon'),
                            messageID           = $(this).attr('data-edit-id');
                            
                            var data = {};
                            
                            data = {
                                'action'            : 'update_row_message_wcnd',
                                'message_type'      : messageType,
                                'page_display'      : whereToDisplay,
                                'template_id'       : templateId,
                                'start_date'        : startDate,
                                'end_date'          : endDate,
                                'message_box'       : yourMessage,
                                'button_text'       : btnText,
                                'button_url'        : btnUrl,
                                'messageId'         : messageID,
                                'nonce'             : wcnd_ajax_object.nonce
                            };

                            $.ajax({
            
                                url : wcnd_ajax_object.ajax_url,
                                data : data,
                                type : 'post',
                                dataType : 'JSON',
                                beforeSend : function ( xhr ) {
                                    loaderIcon.removeClass('hide-ncwd');
                                    formInput.attr('disabled',true);
                                },
                                success : function ( result ) {

                                    if( result.data == 1 && result.data !== false ) {
                                    
                                        location.reload();
                                
                                    }else{
                                        
                                        alert('Opps Error has Occured');

                                    }                         

                                }

                            });

                    } );

                } );

            }

        }

    };


scope.init();



window.onresize = function() {

    scope.wpBodyWidthHeight();

};



})(window, document, jQuery);