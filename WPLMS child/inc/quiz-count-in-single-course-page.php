<?php
// Custom shortcode to display quiz count for the current course without any text
function display_course_quiz_count()
{
    global $post;

    // Ensure we're on a course page by checking the WPLMS 'course' post type
    if (is_singular('course') && $post) {
        $course_id = $post->ID;

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

        // Return only the quiz count
        return $quiz_count;
    } else {
        return '';
    }
}
add_shortcode('quiz_count', 'display_course_quiz_count');
