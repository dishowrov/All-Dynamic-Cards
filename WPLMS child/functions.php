<?php

function child_theme_assets()
{
    //  wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/my-cards.css");
    // wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/LIBM-course-card.css");
    // wp_enqueue_style("compliance-cards", get_stylesheet_directory_uri() . "/assets/css/compliace-central-card.css");
    // wp_enqueue_style("iStudy-cards", get_stylesheet_directory_uri() . "/assets/css/iStudy-course-card.css");
    // wp_enqueue_style("ukhfOnline-cards", get_stylesheet_directory_uri() . "/assets/css/ukhfOnline-free-course-card.css");
    // wp_enqueue_style("eduX-cards", get_stylesheet_directory_uri() . "/assets/css/eduX-course-card.css");
    // wp_enqueue_style("learnSkill-cards", get_stylesheet_directory_uri() . "/assets/css/learnSkill-course-card.css");

    // wp_enqueue_style("bootstrap", "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");

    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');

    wp_enqueue_script('jquery-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', null, true);
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true);
}
add_action("wp_enqueue_scripts", "child_theme_assets");

// include get_stylesheet_directory() . '/inc/cards.php';
// include get_stylesheet_directory() . '/inc/LIBM-course-card.php';
// include get_stylesheet_directory() . "/inc/complianceCentral-course-card.php";
// include get_stylesheet_directory() . "/inc/iStudy-course.php";
// include get_stylesheet_directory() . "/inc/ukhfOnline-free-course-card.php";
include get_stylesheet_directory() . "/inc/ukhfOnline-popular_new_trending-courses.php";
// include get_stylesheet_directory() . "/inc/eduX-course-card.php";
// include get_stylesheet_directory() . "/inc/learnSkill-course-card.php";
