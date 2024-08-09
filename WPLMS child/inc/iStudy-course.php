<?php

function dis_iStudy_course_card_shortcode($atts)
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
            'posts_per_page' => 6,
            'post__in' => $course_id,
            'post_status' => 'published'
        );
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
?>
        <div class="dis-all-course-cards">
            <?php

            while ($loop->have_posts()) {
                $loop->the_post();

                $the_course_ID = get_the_ID();
                $course_title = get_the_title($the_course_ID);
                $course_img = get_the_post_thumbnail_url($the_course_ID, "large");
                $course_link = get_the_permalink($the_course_ID);

                $average_rating = get_post_meta($the_course_ID, 'average_rating', true);
                $count_rating = get_post_meta($the_course_ID, 'rating_count', true);

                $units = bp_course_get_curriculum_units($the_course_ID);
                $duration = $total_duration = 0;
                foreach ($units as $unit) {
                    $duration = get_post_meta($unit, 'vibe_duration', true);
                    if (empty($duration)) {
                        $duration = 0;
                    }
                    if (get_post_type($unit) == 'unit') {
                        $unit_duration_parameter = apply_filters('vibe_unit_duration_parameter', 60, $unit);
                    } elseif (get_post_type($unit) == 'quiz') {
                        $unit_duration_parameter = apply_filters('vibe_quiz_duration_parameter', 60, $unit);
                    }
                    $total_duration = $total_duration + $duration * $unit_duration_parameter;
                }

                if (!function_exists('convert_seconds_to_hours_minutes')) {
                    function convert_seconds_to_hours_minutes($seconds)
                    {
                        $hours = floor($seconds / 3600);
                        $minutes = floor(($seconds % 3600) / 60);
                        return sprintf('%02dh %02dm', $hours, $minutes);
                    }
                }
                $course_duration = convert_seconds_to_hours_minutes($total_duration);

                $course_student = get_post_meta($the_course_ID, 'vibe_students', true);

                $product_ID = get_post_meta($the_course_ID, 'vibe_product', true);
                // $add_to_cart_url = wc_get_cart_url() . '?add-to-cart=' . $product_ID;
            ?>

                <!-- Course card -->
                <div class="dis-course-card">
                    <a href="<?php echo esc_attr($course_link) ?>" class="dis-course-thumb">
                        <span class="dis-thumb-shape"></span>

                        <p>
                            <img src="<?php echo esc_attr($course_img) ?>" alt="The Course Thumbnail">
                        </p>
                    </a>

                    <p class="dis-course-meta">
                        <span class="dis-course-duration">
                            <img src="https://www.istudy.org.uk/wp-content/uploads/2024/07/clock-3-1.webp" alt="Course duration">
                            <?php echo $course_duration ?>
                        </span>

                        <span class="dis-course-students">
                            <img src="https://www.istudy.org.uk/wp-content/uploads/2024/07/students-hat.webp" alt="Students">
                            <?php echo $course_student ?>
                        </span>
                    </p>

                    <a href="<?php echo esc_attr($course_link) ?>" class="dis-course-title">
                        <h3> <?php echo esc_html($course_title) ?> </h3>
                    </a>

                    <p class="dis-course-price_and_rating">
                        <span class="dis-course-price">
                            <?php bp_course_credits(); ?>
                        </span>

                        <span class="dis-course-rating">
                            <span class="dis-course-stars">
                                <!-- <i class="fa fa-star" aria-hidden="true"></i> -->
                                <?php
                                if (is_numeric($average_rating)) {
                                    $percentage = ($average_rating / 5) * 100;

                                ?>
                                    <svg viewBox="0 0 1000 200" class="rating">
                                        <defs>
                                            <polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 ">
                                            </polygon>
                                            <clipPath id="stars">
                                                <use xlink:href="#star"></use>
                                                <use xlink:href="#star" x="20%"></use>
                                                <use xlink:href="#star" x="40%"></use>
                                                <use xlink:href="#star" x="60%"></use>
                                                <use xlink:href="#star" x="80%"></use>
                                            </clipPath>
                                        </defs>
                                        <rect class="rating__background" clip-path="url(#stars)"></rect>
                                        <rect width="<?php echo $percentage ?>%" class="rating__value" clip-path="url(#stars)">
                                        </rect>
                                    </svg>

                                <?php
                                }
                                ?>
                            </span>
                            (<?php echo $count_rating; ?>)
                        </span>
                    </p>

                    <p class="dis-course-btns">
                        <a href="<?php echo esc_attr($course_link) ?>" class="dis-course-details-btn">
                            Preview
                            <span class="dis-btn-bg dis-btn-bg1"></span>
                        </a>

                        <a href="<?php // echo esc_attr($add_to_cart_url) ?>" class="dis-course-add-btn">
                            Add to cart
                            <span class="dis-btn-bg dis-btn-bg2"></span>
                        </a>
                    </p>
                </div>

            <?php
            }
            ?>
        </div>
<?php
        wp_reset_query();
    } else {
        echo "There are no courses found!";
    }
    return ob_get_clean();
}
add_shortcode("dis_iStudy_courses", "dis_iStudy_course_card_shortcode");
