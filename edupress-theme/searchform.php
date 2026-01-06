<!-- Search Form -->
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('البحث عن:', 'edupress'); ?></span>
        <input type="search"
               class="search-field"
               placeholder="<?php esc_attr_e('ابحث...', 'edupress'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               required>
    </label>
    <button type="submit" class="search-submit">
        <i class="fas fa-search"></i>
        <span class="screen-reader-text"><?php _e('بحث', 'edupress'); ?></span>
    </button>
</form>
