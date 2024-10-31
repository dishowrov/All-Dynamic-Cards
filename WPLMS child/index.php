<?php
if (!defined('ABSPATH'))
    exit;
get_header(vibe_get_header());
?>

<!-- Hero - section started -->
<div class="dis-blog-hero">
    <div class="hero-inner">
        <div class="dis-blog-hero-left">
            <h1>Where <br> <span>possibilities</span> <br> begin</h1>

            <p>We're a leading marketplace platform for learning and teaching online. Explore some of our most
                popular
                content and learn something new.</p>
        </div>

        <div class="dis-blog-hero-right">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/woman-working-on-computer.webp" alt="Hero image">
        </div>
    </div>
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


<!-- Functionlities for Popular and Latest posts - started -->
<?php
function display_blog_posts($type = 'latest', $posts_per_page = 6, $paged = 1)
{
    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $type === 'popular' ? 'meta_value_num' : 'date',
        'order' => 'DESC',
    );

    if ($type === 'popular') {
        $args['meta_key'] = 'post_views_count';
        $args['meta_query'] = array(
            array(
                'key' => 'post_views_count',
                'compare' => 'EXISTS',
            )
        );
    }

    $blog_posts_query = new WP_Query($args);

    if ($blog_posts_query->have_posts()) :
        while ($blog_posts_query->have_posts()) : $blog_posts_query->the_post();
?>

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

<?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'No posts found.';
    endif;
}
?>
<!-- Functionlities for Popular and Latest posts - ended -->


<!-- Popular blog post - section started -->
<h2 class="dis-blog-sec-title">Popular Posts</h2>

<div class="dis-all-blog-posts">

    <?php
    display_blog_posts('popular');
    ?>

</div>
<!-- Popular blog post - section ended -->


<!-- Free Trial - section started -->
<div class="dis-blog-trial-sec">
    <h2 class="trial-sec-title">On-Demand Accredited Courses</h2>

    <p class="trial-sec-desc">Enrol in any of the 5000+ high quality online training courses handpicked by our team of experts and start learning today!</p>

    <a href="<?php site_url() ?>/free-courses/" class="trial-sec-btn">Claim Your Free CPD Course</a>
</div>
<!-- Free Trial - section ended -->


<!-- Latest blog post - section started -->
<h2 class="dis-blog-sec-title">Latest Posts</h2>

<div class="dis-all-blog-posts">
    <?php
    // Display the first 6 posts by default (on the first page only)
    if (is_home() && !is_paged()) {
        display_blog_posts('latest', 6); // 6 posts on the first page
    } else {
        display_blog_posts('latest', get_option('posts_per_page'), get_query_var('paged')); // Posts according to pagination
    }
    ?>
</div>

<div class="dis-blog-pagination" style="<?php echo (is_home() && !is_paged()) ? 'display: none;' : ''; ?>">
    <?php
    // Display pagination for the blog page
    the_posts_pagination(array(
        'mid_size' => 2,
        'prev_text' => __('« Previous', 'textdomain'),
        'next_text' => __('Next »', 'textdomain'),
    ));
    ?>
</div>

<div class="dis-blog-page-btn">
    <?php if (is_home() && !is_paged()) : ?>
        <button id="load-more-posts">View More</button>
    <?php endif; ?>
</div>
<!-- Latest blog post - section ended -->



<?php
get_footer(vibe_get_footer());
?>