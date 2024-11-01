<?php 
    defined( 'ABSPATH' ) || exit;
?>

<div class="wcnd-box-template wcnd-template-1" style="background-color:<?php echo esc_html( $template_styles['customCSS']['bg_color'] ); ?>">
    <div class="template-box-style">
        
        <p style="font-size:<?php echo esc_html( $template_styles['customCSS']['font_size'] ); ?>px;color:<?php echo esc_html( $template_styles['customCSS']['font_color'] ); ?>"><?php echo esc_html($data['message']); ?> </p>

        <a href="<?php echo esc_html( $data['btnUrl'] ); ?>" class="wcnd_anchor_template" 
        style="color:<?php echo esc_html( $template_styles['customCSS']['btn_fontcolor'] ); ?>;
        font-size:<?php echo esc_html( $template_styles['customCSS']['btn_textsize'] ); ?>px;
        background-color:<?php echo esc_html( $template_styles['customCSS']['btn_bgcolor'] ); ?>
        ">
        
        <?php echo esc_html( $data['btnText'] ); ?>
        
        </a>
    
    </div>
</div>