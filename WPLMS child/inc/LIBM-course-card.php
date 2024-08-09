<?php

function dis_libm_course_card_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'ids' => ''
        ),
        $atts
    );

    ob_start();

    $dis_course_id = $atts['ids'];

    if (!empty($dis_course_id)) {
        $dis_course_ids = $dis_course_id;
        $dis_course_ids = (explode(",", $dis_course_ids));
        $course_id = array();
        if ($dis_course_ids) {
            foreach ($dis_course_ids as $dis_course_id) {
                $course_id[] = $dis_course_id;
            }
        }

        $args = array(
            'post_type' => 'course',
            'posts_per_page' => 3,
            'post__in' => $course_id,
            'post_status' => 'published'
        );
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
?>
        <div class="dis-libm-course-card-wrapper">
            <?php

            while ($loop->have_posts()) {
                $loop->the_post();

                $the_course_ID = get_the_ID();
                $course_title = get_the_title($the_course_ID);
                $course_img = get_the_post_thumbnail_url($the_course_ID, "large");
                $course_link = get_the_permalink($the_course_ID);

                $average_rating = get_post_meta($the_course_ID, 'average_rating', true);
                $count_rating = get_post_meta($the_course_ID, 'rating_count', true);

                $course_student = get_post_meta($the_course_ID, 'vibe_students', true);

            ?>

                <!-- Course card -->
                <div class="dis-course-card">

                    <!-- Course thumbnail -->
                    <a href="<?php echo esc_attr($course_link); ?>">
                        <div class="course-thumbnail">
                            <img src="<?php echo $course_img; ?>" alt="The Course Thumbnail">
                        </div>
                    </a>

                    <!-- Course price -->
                    <h5 class="course-price">
                        <?php bp_course_credits(); ?>
                    </h5>

                    <!-- Course bottom info -->
                    <div class="course-details">

                        <!-- Course title -->
                        <a href="<?php echo esc_attr($course_link) ?>">
                            <h2 class="course-title">
                                <?php echo esc_html($course_title) ?>
                            </h2>
                        </a>

                        <!-- Course's students & reviews -->
                        <h6 class="course-bottom">
                            <span class="students">
                                <img src="http://www.libm.co.uk/wp-content/uploads/2024/05/student-simple.png" alt="Students">
                                <?php echo $course_student; ?>
                                Students
                            </span>`

                            <span class="reviews">
                                <b>
                                    <img src="http://www.libm.co.uk/wp-content/uploads/2024/05/Star-2.png" alt="Star">
                                    <?php echo $average_rating; ?>
                                </b>
                                <span>
                                    (<?php echo $count_rating; ?>)
                                </span>
                            </span>
                        </h6>

                    </div>

                </div>

            <?php
            }
            ?>
        </div>
<?php
        wp_reset_query();
    } else {
        echo "There are no courses found";
    }
    return ob_get_clean();
}
add_shortcode("dis_libm_courses", "dis_libm_course_card_shortcode");
