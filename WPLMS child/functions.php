<?php
function child_theme_assets()
{
    // wp_enqueue_style("bootstrap", "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");

    // wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    // wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');

    wp_enqueue_style('font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');

    // wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/my-cards.css");
    // wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/LIBM-course-card.css");
    // wp_enqueue_style("compliance-cards", get_stylesheet_directory_uri() . "/assets/css/compliace-central-card.css");
    // wp_enqueue_style("iStudy-cards", get_stylesheet_directory_uri() . "/assets/css/iStudy-course-card.css");
    // wp_enqueue_style("ukhfOnline-cards", get_stylesheet_directory_uri() . "/assets/css/ukhfOnline-free-course-card.css");
    // wp_enqueue_style("eduX-cards", get_stylesheet_directory_uri() . "/assets/css/eduX-course-card.css");
    // wp_enqueue_style("learnSkill-cards", get_stylesheet_directory_uri() . "/assets/css/learnSkill-course-card.css");
    // wp_enqueue_style("alphaAcademy-course-card", get_stylesheet_directory_uri() . "/assets/css/alphaAcademy-course-card.css");
    wp_enqueue_style("oneEdu-blog-css", get_stylesheet_directory_uri() . "/assets/css/oneEducation-blog-style.css");


    /* JavaScripts files */
    // wp_enqueue_script('jquery-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', null, true);
    wp_enqueue_script('jquery');
    // wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true);
    wp_localize_script('custom-js', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('load_more_posts_nonce')
    ));
}
add_action("wp_enqueue_scripts", "child_theme_assets");



function set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function track_post_views($post_id)
{
    if (!is_single() || get_post_type($post_id) != 'post') return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    set_post_views($post_id);
}
add_action('wp_head', 'track_post_views');


function get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 Reads";
    }
    return $count . ' Reads';
}


function load_more_posts()
{
    check_ajax_referer('load_more_posts_nonce', 'nonce'); // Security check

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'posts_per_page' => 6,
        'paged' => $page, 
        'orderby' => 'date',
        'order' => 'DESC',
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
                        else : ?>
                            <img src="#" alt="The Blog Thumbnail">
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
                        <span><?php the_time('F j, Y'); ?></span>
                        &nbsp; | &nbsp; By &nbsp;
                        <span><?php the_author(); ?></span>
                    </div>

                    <div class="blog-card-exerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>
<?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'No more posts found.';
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');




// include get_stylesheet_directory() . '/inc/cards.php';
// include get_stylesheet_directory() . '/inc/LIBM-course-card.php';
// include get_stylesheet_directory() . "/inc/complianceCentral-course-card.php";
// include get_stylesheet_directory() . "/inc/iStudy-course.php";
// include get_stylesheet_directory() . "/inc/ukhfOnline-free-course-card.php";
// include get_stylesheet_directory() . "/inc/ukhfOnline-popular_new_trending-courses.php";
// include get_stylesheet_directory() . "/inc/eduX-course-card.php";
// include get_stylesheet_directory() . "/inc/learnSkill-course-card.php";
// include get_stylesheet_directory() . "/inc/alphaAcademy-course-card.php";
