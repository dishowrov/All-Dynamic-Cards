<?php

function child_theme_assets()
{
    //  wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/my-cards.css");
    // wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/LIBM-course-card.css");
    // wp_enqueue_style("compliance-cards", get_stylesheet_directory_uri() . "/assets/css/compliace-central-card.css");
    // wp_enqueue_style("iStudy-cards", get_stylesheet_directory_uri() . "/assets/css/iStudy-course-card.css");
    // wp_enqueue_style("ukfhOnline-cards", get_stylesheet_directory_uri() . "/assets/css/ukhfOnline-free-course-card.css");
    // wp_enqueue_style("eduX-cards", get_stylesheet_directory_uri() . "/assets/css/eduX-course-card.css");
    wp_enqueue_style("learnSkill-cards", get_stylesheet_directory_uri() . "/assets/css/learnSkill-course-card.css");
}
add_action("wp_enqueue_scripts", "child_theme_assets");

// include get_stylesheet_directory() . '/inc/cards.php';
// include get_stylesheet_directory() . '/inc/LIBM-course-card.php';
// include get_stylesheet_directory() . "/inc/complianceCentral-course-card.php";
// include get_stylesheet_directory() . "/inc/iStudy-course.php";
// include get_stylesheet_directory() . "/inc/ukhfOnline-free-course-card.php";
// include get_stylesheet_directory() . "/inc/eduX-course-card.php";
include get_stylesheet_directory() . "/inc/learnSkill-course-card.php";



