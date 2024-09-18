<?php
function dis_eduX_course_card_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'ids' => '',
            'category' => '',
        ),
        $atts
    );

    ob_start();

    $dis_course_ids = $atts['ids'];
    $category = $atts['category'];

    $args = array(
        'post_type' => 'course',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    if (!empty($dis_course_ids)) {
        $dis_course_ids_array = explode(",", $dis_course_ids);
        $args['post__in'] = $dis_course_ids_array;
    }

    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'course-cat',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
?>
        <div class="dis-eduX-course-cards">
            <?php
            while ($loop->have_posts()) {
                $loop->the_post();

                $the_course_ID = get_the_ID();
                $course_title = get_the_title($the_course_ID);
                $course_img = get_the_post_thumbnail_url($the_course_ID, "large");
                $course_link = get_the_permalink($the_course_ID);

                $units = bp_course_get_curriculum_units($the_course_ID);
                $total_duration = 0;

                foreach ($units as $unit) {
                    $duration = get_post_meta($unit, 'vibe_duration', true);
                    $duration = empty($duration) ? 0 : $duration;
                    $unit_duration_parameter = (get_post_type($unit) == 'unit') ? 60 : 60;
                    $total_duration += $duration * $unit_duration_parameter;
                }

                if (!function_exists('convert_seconds_to_hours_minutes')) {
                    function convert_seconds_to_hours_minutes($seconds)
                    {
                        $hours = floor($seconds / 3600);
                        $minutes = floor(($seconds % 3600) / 60);
                        return sprintf('%dh %02dm', $hours, $minutes);
                    }
                }
                $course_duration = convert_seconds_to_hours_minutes($total_duration);
            ?>

                <div class="r4h-edux-course-card">
                    <div class="image-duration">
                        <div class="image">
                            <a href="<?php echo esc_url($course_link); ?>">
                                <img decoding="async" src="<?php echo esc_url($course_img); ?>" alt="The Course Thumbnail">
                            </a>
                        </div>
                        <span><?php echo esc_html($course_duration); ?></span>
                    </div>

                    <div class="details">
                        <h3 class="tag">Course</h3>
                        <h1 class="title">
                            <a href="<?php echo esc_url($course_link); ?>">
                                <?php echo esc_html($course_title); ?>
                            </a>
                        </h1>
                        <h6 class="viewers">
                            <?php echo esc_html(number_format(get_post_meta($the_course_ID, 'vibe_students', true))); ?> viewers
                        </h6>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
<?php
        wp_reset_postdata();
    } else {
        echo "No courses found.";
    }

    return ob_get_clean();
}
add_shortcode("course_cards", "dis_eduX_course_card_shortcode");
?>