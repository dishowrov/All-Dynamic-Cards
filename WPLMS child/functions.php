<?php

function child_theme_assets()
{
    //  wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/my-cards.css");
    // wp_enqueue_style("libm-cards", get_stylesheet_directory_uri() . "/assets/css/LIBM-course-card.css");
    // wp_enqueue_style("compliance-cards", get_stylesheet_directory_uri() . "/assets/css/compliace-central-card.css");
    // wp_enqueue_style("iStudy-cards", get_stylesheet_directory_uri() . "/assets/css/iStudy-course-card.css");
    wp_enqueue_style("ukfhOnline-cards", get_stylesheet_directory_uri() . "/assets/css/ukhfOnline-free-course-card.css");
}
add_action("wp_enqueue_scripts", "child_theme_assets");

//  include get_stylesheet_directory() . '/inc/cards.php';
// include get_stylesheet_directory() . '/inc/LIBM-course-card.php';
// include get_stylesheet_directory() . "/inc/complianceCentral-course-card.php";
// include get_stylesheet_directory() . "/inc/iStudy-course.php";
include get_stylesheet_directory() . "/inc/ukhfOnline-free-course-card.php";




// Custom shortcode to display quiz count for the current course
function display_course_quiz_count() {
    global $post;

    // Check if the current post is a course
    if ($post && get_post_type($post->ID) == 'course') {
        $course_id = $post->ID;
    } else {
        return 'This shortcode can only be used on course pages.';
    }

    // Get the quizzes associated with the course
    $quizzes = bp_course_get_curriculum($course_id);
    $quiz_count = 0;

    // Count quizzes from the curriculum
    if (!empty($quizzes)) {
        foreach ($quizzes as $item) {
            if (get_post_type($item) == 'quiz') {
                $quiz_count++;
            }
        }
    }

    return "Total Quizzes: " . $quiz_count;
}
add_shortcode('dis_quiz_count', 'display_course_quiz_count');
