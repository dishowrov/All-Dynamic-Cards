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
            <img src="" alt="Hero image">
        </div>
    </div>
</div>
<!-- Hero - section ended -->

<!-- Navbar - section started -->
<div class="dis-blog-navbar">
    <div class="blog-navbar-inner">
        <div class="dis-blog-navbar-tags">
            <?php
            $categories = get_categories(
                array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'number' => 4,
                )
            );

            foreach ($categories as $category) {
            ?>
                <a
                    href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a>
            <?php
            }
            ?>
        </div>

        <div class="dis-blog-navbar-searchbox">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" placeholder="Search..." name="s">

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <input type="hidden" name="post_type" value="post">
            </form>
        </div>
    </div>
</div>
<!-- Navbar - section ended -->

<!-- Popular blog post - section started -->
<h2 class="dis-blog-sec-title">Popular Posts</h2>

<div class="dis-all-blog-posts">

    <?php
    $args = array(
        'posts_per_page' => '6',
        'orderby' => 'comment_count',
        'order' => 'DESC'
    );

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
                        else :
                        ?>
                            <img src="#" alt="The Blog Thumbnail">
                        <?php endif ?>
                    </a>
                </div>

                <div class="blog-card-details">
                    <h3 class="blog-card-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <div class="blog-card-meta">
                        <span> <?php the_time('F j, Y') ?> </span>
                        &nbsp; | &nbsp; By &nbsp;
                        <span> <?php the_author(); ?></span>
                    </div>

                    <p class="blog-card-exerpt">
                        <?php the_excerpt(); ?>
                    </p>
                </div>

            </div>

        <?php
        endwhile;
        wp_reset_postdata();

    else :
        ?>
        No popular posts found.
    <?php

    endif;
    ?>

</div>
<!-- Popular blog post - section ended -->

<!-- Free Trial - section started -->
<div class="dis-blog-trial-sec">
    <h2 class="trial-sec-title">Empowering Minds, Transforming Lives</h2>

    <p class="trial-sec-desc">Enrol in any of the 3500+ high quality online training courses handpicked by our team
        of experts and start learning today!</p>

    <a href="#" class="trial-sec-btn">Get Free Trial</a>
</div>
<!-- Free Trial - section ended -->

<!-- Latest blog post - section started -->
<h2 class="dis-blog-sec-title">Latest Posts</h2>

<div class="dis-all-blog-posts">

    <?php
    $args = array(
        'posts_per_page' => '6',
        'orderby' => 'date',
        'order' => 'DESC'
    );

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
                        else :
                        ?>
                            <img src="#" alt="The Blog Thumbnail">
                        <?php endif ?>
                    </a>
                </div>

                <div class="blog-card-details">
                    <h3 class="blog-card-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <div class="blog-card-meta">
                        <span> <?php the_time('F j, Y') ?> </span>
                        &nbsp; | &nbsp; By &nbsp;
                        <span> <?php the_author(); ?></span>
                    </div>

                    <p class="blog-card-exerpt">
                        <?php the_excerpt(); ?>
                    </p>
                </div>

            </div>

        <?php
        endwhile;
        wp_reset_postdata();

    else :
        ?>
        No latest posts found.
    <?php

    endif;
    ?>

</div>

<div class="dis-blog-page-btn">
    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
        View More
    </a>
</div>
<!-- Latest blog post - section ended -->



<?php
get_footer(vibe_get_footer());
?>