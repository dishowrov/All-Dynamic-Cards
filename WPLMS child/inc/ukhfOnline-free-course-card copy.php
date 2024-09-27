<?php
function dis_free_courses_shortcode($atts)
{
    // Set up the shortcode attributes with default values
    $atts = shortcode_atts(
        array(
            'limit' => 6,
            'ids'   => '',
        ),
        $atts,
        'dis_free_courses'
    );

    ob_start();


    $args = array(
        'post_type' => 'course',
        'posts_per_page' => intval($atts['limit']),
        'meta_query' => array(
            array(
                'key' => 'vibe_course_free',
                'value' => 'S',
                'compare' => '='
            ),
        ),
        'post_status' => 'publish',
    );


    if (!empty($atts['ids'])) {
        $course_ids = explode(',', $atts['ids']);
        $args['post__in'] = array_map('intval', $course_ids);
    }

    $free_courses = new WP_Query($args);

    if ($free_courses->have_posts()) {
?>
        <!-- cards wrapper -->
        <div class="dis-free-course-wrap">

            <?php
            while ($free_courses->have_posts()) {
                $free_courses->the_post();

                $course_ID = get_the_ID();
                $course_title = get_the_title($course_ID);
                $course_img = get_the_post_thumbnail_url($course_ID, "large") ?: 'https://uk.hfonline.org/wp-content/uploads/2024/09/dummy-imageforfreecourse.webp';
                $course_link = get_the_permalink($course_ID);
                $average_rating = get_post_meta($course_ID, 'average_rating', true) ?: '0';
                $students = get_post_meta($course_ID, 'vibe_students', true) ?: '0';

                $rating_percentage = ($average_rating / 5) * 100;
            ?>

                <!-- course card -->
                <div class="dis-free-course-card">
                    <a href="<?php echo esc_attr($course_link); ?>" class="dis-course-thumbnail">
                        <img decoding="async" src="<?php echo esc_attr($course_img); ?>" alt="The Course Thumbnail">
                    </a>

                    <a href="<?php echo esc_attr($course_link); ?>">
                        <h4><?php echo esc_html($course_title); ?></h4>
                    </a>

                    <div class="dis-course-info">
                        <p>
                            <img decoding="async" src="https://uk.hfonline.org/wp-content/uploads/2024/02/students.png" alt="students">
                            <span><?php echo esc_html($students); ?></span> Students
                        </p>

                        <div class="dis-card-ratings">
                            <p><?php echo esc_html(number_format($average_rating, 1)); ?></p>

                            <div class="rating_sh_content">
                                <div class="sh_rating">
                                    <div class="sh_rating-upper" style="width:<?php echo esc_attr($rating_percentage); ?>%">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                    </div>
                                    <div class="sh_rating-lower">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dis-course-btn">
                        <a href="<?php echo esc_attr($course_link); ?>">Start Learning For Free</a>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
<?php
        wp_reset_postdata();
    } else {
        echo "No free courses found.";
    }

    return ob_get_clean();
}
add_shortcode('dis_free_courses', 'dis_free_courses_shortcode');

?>