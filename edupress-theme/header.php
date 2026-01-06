<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <!-- Header -->
    <header class="site-header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="header-contact">
                    <span><i class="fas fa-phone"></i> +966 50 123 4567</span>
                    <span><i class="fas fa-envelope"></i> info@edupress.com</span>
                </div>
                <div class="header-social">
                    <a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <!-- Logo -->
                <div class="site-logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
                        <?php
                    }
                    ?>
                </div>

                <!-- Navigation -->
                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-label="القائمة">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mobile-nav-menu',
                'fallback_cb'    => false,
            ));
            ?>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main" class="site-main">
