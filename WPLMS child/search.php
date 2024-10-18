<?php
if (isset($_GET["post_type"]) && $_GET["post_type"] == 'course') {
    if (file_exists(get_stylesheet_directory() . '/search-incourse.php')) {
        load_template(get_stylesheet_directory() . '/search-incourse.php');
        exit();
    }
    if (file_exists(get_template_directory() . '/search-incourse.php')) {
        load_template(get_template_directory() . '/search-incourse.php');
        exit();
    }
}

if (!defined('ABSPATH'))
    exit;
get_header(vibe_get_header());
?>

<!-- Search info - section started -->
<div class="dis-search-result-hero">
    <h1>Search Results for "<?php echo get_search_query(); ?>"</h1>

    <p>
        <?php
        $total_result = $wp_query->found_posts;
        echo 'Total ' . $total_result . ' result' . ($total_result == 1 ? '' : 's') . ' found';
        ?>
    </p>
</div>
<!-- Search info - section ended -->


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


<?php
get_footer(vibe_get_footer());
?>