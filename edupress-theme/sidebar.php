<!-- Sidebar -->
<aside id="secondary" class="widget-area sidebar">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>

        <!-- Default Widgets -->
        <div class="widget">
            <h3 class="widget-title">البحث</h3>
            <?php get_search_form(); ?>
        </div>

        <div class="widget">
            <h3 class="widget-title">التصنيفات</h3>
            <ul>
                <?php wp_list_categories(array(
                    'title_li' => '',
                    'show_count' => true,
                )); ?>
            </ul>
        </div>

        <div class="widget">
            <h3 class="widget-title">الأرشيف</h3>
            <ul>
                <?php wp_get_archives(array(
                    'type' => 'monthly',
                    'show_post_count' => true,
                )); ?>
            </ul>
        </div>

    <?php endif; ?>
</aside>
