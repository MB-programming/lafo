<?php
/**
 * Template for displaying single posts
 *
 * @package EduPress
 */

get_header();
?>

<div class="container section">
    <div class="row">
        <div class="col main-content">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail" style="margin-bottom: 2rem; border-radius: 1rem; overflow: hidden;">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header" style="margin-bottom: 2rem;">
                        <h1 class="entry-title"><?php the_title(); ?></h1>

                        <div class="entry-meta" style="display: flex; gap: 1.5rem; flex-wrap: wrap; color: #64748b; font-size: 0.875rem;">
                            <span>
                                <i class="far fa-calendar"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span>
                                <i class="far fa-user"></i>
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                            <?php if (has_category()) : ?>
                                <span>
                                    <i class="far fa-folder"></i>
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                            <span>
                                <i class="far fa-comment"></i>
                                <?php comments_number('لا تعليقات', 'تعليق واحد', '% تعليقات'); ?>
                            </span>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if (has_tag()) : ?>
                        <footer class="entry-footer" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                            <div class="tags">
                                <i class="fas fa-tags"></i>
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        </footer>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <nav class="post-navigation" style="display: flex; justify-content: space-between; margin: 2rem 0; gap: 1rem;">
                        <div class="nav-previous">
                            <?php previous_post_link('%link', '<i class="fas fa-arrow-right"></i> %title'); ?>
                        </div>
                        <div class="nav-next">
                            <?php next_post_link('%link', '%title <i class="fas fa-arrow-left"></i>'); ?>
                        </div>
                    </nav>

                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="comments-area" style="margin-top: 3rem;">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
