<?php
wp_nav_menu(array(
        'menu' => 'footer_menu',
        'theme_location' => 'footer_menu',
        'depth' => 1,
        'container' => 'nav',
        'container_class' => 'menu-footer-plane',
        'menu_class' => 'menu-footer-list',
        'fallback_cb' => false,
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
    )
);
?>