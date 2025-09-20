<?php
$primenu_menu_color =  carbon_get_theme_option('ywt_menu_text_color');
$primenu_menu_color_hover =  carbon_get_theme_option('ywt_menu_hover_text_color');

$socialicon = carbon_get_theme_option('ywt_social_color');
$socialiconHover = carbon_get_theme_option('ywt_social_hover_color');
?>
<style>
    #primary-menu li a{
        color:<?php echo $primenu_menu_color;?>
    }
    #primary-menu li a:hover, #primary-menu .current-menu-item a{
        color:<?php echo $primenu_menu_color_hover;?>
    }
    #primary-menu .current-menu-item a:after{
        border-color:<?php echo $primenu_menu_color;?>
    }
    .socialmedia-banner ul li a { color:<?php echo $socialicon; ?>; }
    .socialmedia-banner ul li a:hover { color:<?php echo $socialiconHover ;?>; }
</style>