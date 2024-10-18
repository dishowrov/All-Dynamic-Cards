<?php
if (!defined('ABSPATH'))
    exit;

get_header(vibe_get_header());
?>


<!-- Hero - section started -->
<div class="dis-archive-hero">
    <h1 class="dis-hero-title">
        <?php the_archive_title(); ?>
    </h1>

    <h5 class="dis-hero-breadcrumb">
        <?php vibe_breadcrumbs(); ?>
    </h5>
</div>
<!-- Hero - section ended -->

<!-- Navbar - section started -->
<div class="dis-blog-navbar">
    <div class="blog-navbar-inner">
        <div class="dis-blog-navbar-tags">
            <?php
            $category_ids = array(24, 19, 25);

            $categories = get_terms(
                array(
                    'taxonomy' => 'category',
                    'orderby' => 'include',
                    'include' => $category_ids,
                    'hide_empty' => false
                )
            );

            foreach ($categories as $category) {
            ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php
            }
            ?>
        </div>

        <div class="dis-blog-navbar-searchbox">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" placeholder="Search..." name="s" value="<?php echo get_search_query(); ?>">

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <input type="hidden" name="post_type" value="post">
            </form>
        </div>
    </div>
</div>
<!-- Navbar - section ended -->

<!-- Blog posts - section started -->
<div class="dis-all-blog-posts dis-archive-posts">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <!-- Blog card -->
            <div class="dis-blog-post-card">
                <div class="blog-card-thumb">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if (has_post_thumbnail()) : the_post_thumbnail('large');
                        else : ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sass-rect.webp" alt="The Blog Thumbnail">
                        <?php endif; ?>
                    </a>
                </div>

                <div class="blog-card-details">
                    <h3 class="blog-card-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <div class="blog-card-meta">
                        <span> <?php the_time('F j, Y'); ?> </span>
                        &nbsp; | &nbsp; By &nbsp;
                        <span> <?php the_author(); ?></span>
                    </div>

                    <div class="blog-card-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e('Sorry, no posts were found.'); ?></p>
    <?php endif; ?>
</div>
<!-- Blog posts - section ended -->



<?php
get_footer(vibe_get_footer());
?>