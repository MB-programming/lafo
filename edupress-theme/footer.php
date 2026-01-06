    </main><!-- #main -->

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <!-- Footer Widgets -->
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. جميع الحقوق محفوظة.</p>
                <?php if (has_nav_menu('footer')) : ?>
                    <nav class="footer-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                            'depth'          => 1,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
