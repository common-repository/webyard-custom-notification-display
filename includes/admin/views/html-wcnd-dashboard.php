<?php 

/**
 * 
 * WCND - Admin View Dashboard
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$notification_msg = WNDD();
?>

<div class="wrap-wcnd-dashboard">
    <div class="wcnd-layout__header">
        <div class="wcnd-head-helper">
            <div class="wcnd-head__title">
                <?php esc_html_e( 'WooCommerce Custom Notification Messages', 'wc-notification-display' ); ?>
                <span>
                <?php esc_html_e( 'Shop', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Products', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Cart', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Checkout Page', 'wc-notification-display' ); ?></span>
            </div>
        </div>
    </div>
    <div class="wcnd-body-content">
        <div class="wcnd-items-tab">
            <ul>
                <li class="wcnd-tab-active">
                    <a href="#messages-list" class="wcnd-tab-item">
                        <i class="fas fa-comment-dots"></i>
                        <?php esc_html_e( 'Messages', 'wc-notification-display' ); ?>
                    </a>
                </li>
                <li>
                    <a href="#templates-list" class="wcnd-tab-item">
                        <i class="fas fa-folder-open"></i>
                        <?php esc_html_e( 'Templates', 'wc-notification-display' ); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wcnd-tab-contents">
            <div id="messages-list" class="wcnd-hide wcnd-default-show messages-list-wrapper">
                <a href="" class="wcnd-add-new-msg">
                    <?php esc_html_e( 'ADD MESSAGE', 'wc-notification-display' ); ?>
                </a>
               <table>
                   <thead>
                       <th><?php esc_html_e( 'Index', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Type', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Message', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Button Text', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Button URL', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Controls', 'wc-notification-display' ); ?></th>
                   </thead>
                   <tbody>
                    <?php 
                        if( $notification_msg->notification_messages() ){
                            $counter = 1;
                            foreach( $notification_msg->notification_messages() as $key ) { ?>
                                <tr>
                                    <td>
                                        <?php 
                                            echo esc_html( $counter ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html( wcnd_message_type( $key->messageType ) ); 
                                        ?>
                                    </td>
                                    <td class="ncwd-custom-message">
                                        <?php 
                                            echo esc_html(  $key->messages  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html(  $key->btnText  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html(  $key->btnUrl  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <div class="wcnd-block-wrapper">
                                            <a href="" class="action-wcnd-btn wcnd-action-edit" data-wcnd-id="<?php 
                                            echo esc_html( $key->id ); 
                                        ?>">
                                                <?php esc_html_e( 'Edit', 'wc-notification-display' ); ?>
                                            </a>
                                        </div>
                                        <div class="wcnd-block-wrapper">
                                            <a href="" class="action-wcnd-btn wcnd-action-delete" data-wcnd-id="<?php 
                                            echo esc_html( $key->id ); 
                                        ?>" >
                                                <?php esc_html_e( 'Delete', 'wc-notification-display' ); ?>   
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                    <?php
                            $counter++;
                            }
                        }
                    ?>
                       
                       
                   </tbody>
               </table>
            </div>
            <div id="templates-list" class="wcnd-hide templates-list-wrapper">
                <div class="left-flank-template">
                        
                    <ul>
                        
                        <?php 
                        
                            $template_list      = WNDS()->list_of_templates(true);
                            $template_1_style   = WNDD()->get_template_styles(); 
                            $css_template_1     = maybe_unserialize( $template_1_style[0]->customCSS );
                            $ctr = 0;

                            foreach( $template_list as $key => $val ) {
                                if( $ctr !== 0 ){
                        ?>
                                    <li class="wcnd-hide template_is_visible">
                                        <div class="title__template">
                                            <?php echo esc_html( $val ); ?> <i class="fas fa-caret-down"></i>
                                            <?php 
                                                if( $ctr !== 1 ) {
                                                    printf( '<div class="%1$s">%2$s</div>', esc_attr( 'pro-version-class' ), esc_html( 'Pro Version!' ) );
                                                }
                                            ?>
                                        </div>
                                        <?php 
                                            if( $ctr == 1 ) {
                                        ?>
                                                <div class="template__content" id="template_design_<?php echo esc_html($ctr); ?>" >
                                                    <div class="cssfields-group">
                                                        <label for="">
                                                            <?php esc_html_e( 'Font Size', 'wc-notification-display' ); ?>
                                                        </label>
                                                        <input type="number" name="" class="css-style-fields wcndcontent_dynamic_data" value="<?php echo esc_html($css_template_1['font_size']); ?>" >
                                                    </div>
                                                    <div class="cssfields-group">
                                                        <div class="font-color-wrapper">
                                                            <label for="">
                                                                <?php esc_html_e( 'Font Color', 'wc-notification-display' ); ?>
                                                            </label>
                                                            <input type="hidden" id="fontcolor-hidden-value" class="wcnd-hide" value="<?php echo esc_html($css_template_1['font_color']); ?>" >
                                                            <input type="text" name="" class="css-style-fields wcnd_color_picker" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="cssfields-group">
                                                        <div class="background-color-wrapper">
                                                            <label for="">
                                                                <?php esc_html_e( 'Background Color', 'wc-notification-display' ); ?>
                                                            </label>
                                                            <input type="hidden" id="bgcolor-hidden-value" class="wcnd-hide" value="<?php echo esc_html($css_template_1['bg_color']); ?>" >
                                                            <input type="text" name="" class="css-style-fields wcnd_color_picker" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="cssfields-group">
                                                        <div class="button-background-color-wrapper">
                                                            <label for="">
                                                                <?php esc_html_e( 'Button Background', 'wc-notification-display' ); ?>
                                                            </label>
                                                            <input type="hidden" id="btnbgcolor-hidden-value" class="wcnd-hide" value="<?php echo esc_html($css_template_1['btn_bgcolor']); ?>" >
                                                            <input type="text" name="" class="css-style-fields wcnd_color_picker" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="cssfields-group">
                                                        <div class="">
                                                            <label for="">
                                                                <?php esc_html_e( 'Button Font Size', 'wc-notification-display' ); ?>
                                                            </label>
                                                            <input type="number" id="btn-font-size" class="css-style-fields" data-classBtn="btn-first-template" value="<?php echo esc_html($css_template_1['btn_textsize']); ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="cssfields-group">
                                                        <div class="button-text-color-wrapper">
                                                            <label for="">
                                                                <?php esc_html_e( 'Button Text Color', 'wc-notification-display' ); ?>
                                                            </label>
                                                            <input type="hidden" id="btntext-color-hidden-value" class="wcnd-hide" value="<?php echo esc_html($css_template_1['btn_fontcolor']); ?>" >
                                                            <input type="text" name="" class="css-style-fields wcnd_color_picker" value="" >
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </li>
                        <?php
                                }
                            $ctr++;
                            }
                        ?>
                    </ul>

                </div>
                <div class="right-flank-display">
                    <div class="wrapper_box_styling_template">
                        <span class="note-wcnds"><?php esc_html_e( 'Font Family will vary on your themes.', 'wc-notification-display' ); ?></span>
                        <div class="template_1_the_style standardbox_wcnd">
                            <div class="start_styling">
                                <p><span class="wcndcontent_dynamic_data"><?php esc_html_e( 'Free Delivery for Orders of at least $30.', 'wc-notification-display' ); ?></span> <a href="#" class="wcndcontent_dynamic_data btn-first-template"><?php esc_html_e( 'Shop Now', 'wc-notification-display' ); ?></a></p>
                            </div>
                        </div>
                        <div class="template_2_the_style standardbox_wcnd">
                            <div class="start_styling">
                                <div class="icon-background-wcnd">
                                <i class="fas fa-truck"></i>
                                </div>
                                <div class="p-content-wcnd">
                                <p><?php esc_html_e( 'Order within this week and get free delivery at checkout!', 'wc-notification-display' ); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="template_3_the_style standardbox_wcnd">
                            <div class="start_styling">
                                <div class="icon-background-wcnd">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="p-content-wcnd">
                                <p><?php esc_html_e( 'WCND Special Sale - 50% OFF!', 'wc-notification-display' ); ?> <a href="#"><?php esc_html_e( 'Shop Now', 'wc-notification-display' ); ?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save__template_styling">
                    <a href="#" id="save_style_settings" class="btn-save">
                        <?php esc_html_e( 'Save Settings', 'wc-notification-display'); ?>
                    </a>
                    <div class="loader-icon hide-ncwd">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>