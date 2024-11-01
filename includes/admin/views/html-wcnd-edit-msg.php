<?php 

/**
 * 
 * WCND - Edit New Message Popup
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

    $lists = WNDS();
    $message = $message[0];
    
?>
<div class="wcnd-edit-wrapper popboxWrapper_edit wcnd-pop-active">
    <div class="wcnd-popup-edit-message">
        
        <div class="pophead__wcnd">
            <div class="label-title">
                <?php esc_html_e( 'Edit Message', 'wc-notification-display' ); ?>
            </div>
            <div class="label-msg-id">
                <div class="message-id-holder">
                    #<?php echo esc_html($message->id); ?>
                </div>
            </div>
        </div>

        <div class="popbody__wcnd">
            <div class="label-info">
                <?php esc_html_e( 'In this section you can configure your message.', 'wc-notification-display' ); ?>
            </div>
            <form class="newmessage__wcnd">
                <div class="field__group">
                    <div class="field__label">
                    <?php esc_html_e( 'Message Type', 'wc-notification-display' ); ?>
                    </div>
                    <div class="field__selection">
                        <select class="select__msg-type" name="select__msg-type" id="">
                        <?php 
                            if( $lists->list_of_message_types() ) {
                                $ctr = 0;
                                foreach( $lists->list_of_message_types() as $key => $val ) { ?>
                                    <option value="<?php echo esc_html($ctr); ?>" <?php selected($message->messageType, $ctr) ?>>
                                        <?php echo esc_html( $val ); ?>
                                    </option>
                        <?php       
                                $ctr++;
                                }
                            }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__label">
                        <?php esc_html_e( 'Where to Display?', 'wc-notification-display' ); ?>
                    </div>
                    <div class="field__selection">
                        <?php
                            if( $lists->list_of_page_types() ) {
                                
                                foreach( $lists->list_of_page_types() as $version => $val ) {  ?>
                                <div class="field__half">
                                <?php 
                                    foreach( $val as $subkey => $subval ) { 
                                ?>
                                    <input type="radio" id="pick_edit_<?php echo esc_html( $subkey ); ?>" name="wcnd_page_type" class="wcnd_page_type" value="<?php echo esc_html( $subkey ); ?>" <?php checked($message->pageType,$subkey); ?> <?php echo ( $version == 'free' ? '' : ' disabled'); ?> />
                                        <label for="pick_edit_<?php echo esc_html( $subkey ); ?>"> <?php echo esc_html( $subval ); ?> <?php echo ( $version == 'free' ? '' : '<span class="pro-version-radio"> '. esc_html('(Pro Version!)') .' </span>'); ?></label><br>
                                <?php 
                                    }
                                ?>
                                </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__label">
                        <?php esc_html_e( 'Template', 'wc-notification-display' ); ?>
                    </div>
                    <div class="field__selection">
                        <select name="select__template-id" class="select__template-id" id="">
                            <?php 
                                if( $lists->list_of_templates() ) {
                                    $ctr = 0;
                                    foreach( $lists->list_of_templates() as $list => $val ) {
                            ?>
                                        <option value="<?php echo esc_html($ctr); ?>" <?php selected($message->templateID, $ctr) ?>>
                                            <?php echo esc_html( $val ); ?>
                                        </option>
                            <?php
                                    $ctr++;
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__half">
                        <div class="field__label">
                        <?php esc_html_e( 'Start Date', 'wc-notification-display' ); ?>
                        </div>
                        <div class="field__selection">
                            <input type="text" name="wcnd-start-date" class="wcnd-start-date" value="<?php echo esc_html($message->startDate); ?>" autocomplete="off" required/>
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="field__half">
                        <div class="field__label">
                        <?php esc_html_e( 'End Date', 'wc-notification-display' ); ?>
                        </div>
                        <div class="field__selection">
                            <input type="text" name="wcnd-end-date" class="wcnd-end-date" value="<?php echo esc_html($message->endDate); ?>" autocomplete="off" required/>
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__selection">
                        <textarea class="wcnd-yourmessage" name="wcnd-yourmessage" id="" placeholder="Your Message" required><?php echo esc_html($message->messages); ?></textarea>
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__label">
                    <?php esc_html_e( 'Button Text', 'wc-notification-display' ); ?>
                    </div>
                    <div class="field__selection">
                        <input type="text" name="wcnd-btn-text" class="pop-btn-details wcnd-btn-text" value="<?php echo esc_html($message->btnText); ?>" required >
                    </div>
                </div>

                <div class="field__group">
                    <div class="field__label">
                    <?php esc_html_e( 'Button URL', 'wc-notification-display' ); ?>
                    </div>
                    <div class="field__selection">
                        <input type="text" name="wcnd-btn-url" class="pop-btn-details wcnd-btn-url" value="<?php echo esc_html($message->btnUrl); ?>">
                    </div>
                </div>

            </form>
        </div>

        <div class="popfooter__wcnd">
            <div class="loader-icon hide-ncwd">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="pop-action-save-cancel">
                <a href="" id="single_cancel_message" class="btn-cancel">
                <?php esc_html_e( 'Cancel', 'wc-notification-display' ); ?>
                </a>
                <a href="" id="single_update_message" class="btn-save" data-edit-id="<?php echo esc_html( $message->id ); ?>">
                <?php esc_html_e( 'Update', 'wc-notification-display' ); ?>
                </a>
            </div>
        </div>

    </div>
</div>