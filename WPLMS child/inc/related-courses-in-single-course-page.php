<?php
function courseCards($atts)
{
    ob_start();

    $course_id = isset($atts['courseid']) ? $atts['courseid'] : '';
    $currentID = get_queried_object_id(); // Get current course ID

    // Get course categories for the current course
    $current_course_terms = get_the_terms($currentID, 'course-cat');
    $current_course_term_ids = array();

    if ($current_course_terms) {
        foreach ($current_course_terms as $term) {
            $current_course_term_ids[] = $term->term_id;
        }
    }

    // If specific course IDs are provided, display them
    if (!empty($course_id)) {
        $course_ids = explode(",", $course_id);
        $args = array(
            'post_type'      => 'course',
            'posts_per_page' => 3, // Limit to 3 courses
            'post__in'       => $course_ids
        );
    } else {
        // If no course IDs, display related courses based on shared categories
        $args = array(
            'post_type'      => 'course',
            'posts_per_page' => 3, // Show 3 related courses
            'post__not_in'   => array(get_the_ID()), // Exclude current course
            'tax_query'      => array(
                array(
                    'taxonomy' => 'course-cat',
                    'field'    => 'term_id',
                    'terms'    => $current_course_term_ids, // Match current course categories
                ),
            ),
        );
    }

    $related_courses_query = new WP_Query($args);

    if ($related_courses_query->have_posts()) {
        echo '<div class="dis-course-cards-wrapper">';
        while ($related_courses_query->have_posts()) {
            $related_courses_query->the_post();
            $courseID = get_the_ID();
            $courseImage = get_the_post_thumbnail_url($courseID, 'medium');
            $courseLink = get_the_permalink($courseID);
            $courseName = get_the_title();
            $courseStudents = get_post_meta($courseID, 'vibe_students', true);
            $average_rating = get_post_meta($courseID, 'average_rating', true);
            $author_id = get_post_field('post_author', $courseID);
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_link = get_author_posts_url($author_id);
            $authorDP = get_avatar($author_id, 96); // Get author avatar

            // Get course categories
            $terms = get_the_terms($courseID, 'course-cat');
?>

            <div class="dis-course-card">
                <!-- Course card Thumbnail -->
                <a href="<?php echo esc_url($courseLink); ?>">
                    <div class="dis-course-card-thumbnail">
                        <img src="<?php echo esc_url($courseImage); ?>" alt="Course Thumbnail">
                    </div>
                </a>

                <!-- Course categories -->
                <div class="dis-course-card-categories">
                    <ul>
                        <?php
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term_single) {
                        ?>
                                <li><a href="<?php echo esc_url(get_term_link($term_single)); ?>"><?php echo esc_html($term_single->name); ?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

                <!-- Course details -->
                <div class="dis-course-card-details">
                    <div class="dis-course-card-info">
                        <!-- Course details Mentor part -->
                        <div class="dis-course-card-mentor">
                            <a href="<?php echo esc_url($author_link); ?>">
                                <?php echo $authorDP; ?>
                            </a>
                        </div>
                        <h4 class="dis-course-mentor-name"><a href="<?php echo esc_url($author_link); ?>"><?php echo esc_html($author_name); ?></a></h4>

                        <!-- Course Title -->
                        <h3 class="dis-course-card-title">
                            <a href="<?php echo esc_url($courseLink); ?>">
                                <?php echo esc_html($courseName); ?>
                            </a>
                        </h3>
                    </div>

                    <div class="dis-course-card-meta">
                        <h6 class="dis-course-meta-students">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?php echo esc_html($courseStudents); ?>
                        </h6>

                        <h6 class="dis-course-meta-reviews">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <?php echo esc_html($average_rating); ?>
                        </h6>

                        <button>
                            <?php bp_course_credits(); ?>
                        </button>
                    </div>
                </div>
            </div>

<?php
        }
        echo '</div>'; // Close the wrapper div
        wp_reset_postdata(); // Properly reset post data
    } else {
        echo 'No related courses found';
    }

    $output = ob_get_clean();
    return $output;
}
add_shortcode('courseCards', 'courseCards');
?>