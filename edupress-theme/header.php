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
    <?php if (!edupress_elementor_header()) : ?>
    <!-- Header -->
    <header class="site-header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="header-contact">
                    <?php
                    $phone = get_option('edupress_phone', '+966 50 123 4567');
                    $email = get_option('edupress_email', 'info@edupress.com');
                    if ($phone) : ?>
                        <span><i class="fas fa-phone"></i> <?php echo esc_html($phone); ?></span>
                    <?php endif;
                    if ($email) : ?>
                        <span><i class="fas fa-envelope"></i> <?php echo esc_html($email); ?></span>
                    <?php endif; ?>
                </div>
                <div class="header-social">
                    <?php
                    $facebook = get_option('edupress_facebook');
                    $twitter = get_option('edupress_twitter');
                    $instagram = get_option('edupress_instagram');
                    $linkedin = get_option('edupress_linkedin');

                    if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <?php endif;
                    if ($twitter) : ?>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <?php endif;
                    if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <?php endif;
                    if ($linkedin) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
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
    <?php endif; ?>

    <!-- Main Content -->
    <main id="main" class="site-main">
