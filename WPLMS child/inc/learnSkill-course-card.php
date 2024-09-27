<?php
function dis_learnSkill_course_card_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'category' => '',
            'limit'    => -1,
            'ids'      => '',
        ),
        $atts,
        'course_cards'
    );

    $args = array(
        'post_type'      => 'course',
        'posts_per_page' => intval($atts['limit']),
        'post__in'       => !empty($atts['ids']) ? explode(',', $atts['ids']) : array(),
        'tax_query'      => array(),
    );

    // Filter by category if it's set in the shortcode
    if (!empty($atts['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'course-cat',
            'field'    => 'slug',
            'terms'    => $atts['category'],
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
?>

        <div class="dis-all-course-card">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $course_id = get_the_ID();
                $course_title = get_the_title();
                $course_link = get_permalink();
                $course_thumb = get_the_post_thumbnail_url($course_id, 'full');

                $course_category = wp_get_post_terms($course_id, 'course-cat', array('fields' => 'all'));
                $category_link = !empty($course_category) ? get_term_link($course_category[0]) : '#';

                $product_ID = get_post_meta(get_the_ID(), 'vibe_product', true);
                $regular_price = get_post_meta($product_ID, '_regular_price', true);
                $sale_price = get_post_meta($product_ID, '_sale_price', true);
                $current_currency = get_woocommerce_currency_symbol();

                $course_lessons = get_post_meta($course_id, 'vibe_course_curriculum', true);
                $course_lessons_count = is_array($course_lessons) ? count($course_lessons) : 0;

                $units = bp_course_get_curriculum_units($course_id);
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
                if (!function_exists('convert_seconds_to_hours')) {
                    function convert_seconds_to_hours($seconds)
                    {
                        $hours = round($seconds / 3600, 1);
                        return sprintf('%02.1f Hours', $hours);
                    }
                }
                $course_duration = convert_seconds_to_hours($total_duration);

                $average_rating = get_post_meta($course_id, 'average_rating', true);
                $course_reviews_count = get_post_meta($course_id, 'rating_count', true);
            ?>

                <div class="dis-course-card">
                    <div class="dis-course-card-normal-contents">
                        <a href="<?php echo esc_url($course_link); ?>" class="dis-course-img">
                            <img decoding="async" src="<?php echo esc_url($course_thumb); ?>" alt="Course Thumbnail">
                        </a>

                        <h6 class="dis-course-category">
                            <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html(!empty($course_category) ? $course_category[0]->name : ''); ?></a>
                        </h6>

                        <h3 class="dis-course-title">
                            <a href="<?php echo esc_url($course_link); ?>"><?php echo esc_html($course_title); ?></a>
                        </h3>

                        <ul class="dis-course-features">
                            <li>
                                <i aria-hidden="true" class="fas fa-file-excel"></i>
                                <span class="dis-course-no-count"><?php echo esc_html($course_lessons_count); ?></span> Lessons
                            </li>

                            <li>
                                <i aria-hidden="true" class="fas fa-briefcase"></i>
                                Online Class
                            </li>
                        </ul>

                        <div class="dis-course-card-footer">
                            <p class="dis-course-fee">
                                <?php
                                if (!empty($product_ID)) {
                                    if ($sale_price !== "") {
                                        $m_price =   '<span>' . $current_currency . $sale_price . '</span>';
                                    } elseif ($regular_price !== "") {
                                        $m_price = '<span>' . $current_currency . $regular_price . '</span>';
                                    } else {
                                        $m_price = 'Free';
                                    }
                                    echo $m_price;
                                } else {
                                    echo 'Free';
                                }
                                ?>
                            </p>

                            <ul class="dis-course-ratings">
                                <li class="dis-course-ratings-stars">
                                    <?php
                                    if (is_numeric($average_rating)) {
                                        $percentage = ($average_rating / 5) * 100;
                                        echo '<div class="star-ratings">

                                            <div class="fill-ratings" style="width:' . $percentage . '%;">
                                                <span>★★★★★</span>
                                            </div>

                                            <div class="empty-ratings">
                                                <span>★★★★★</span>
                                            </div>

                                            </div>';
                                    }
                                    ?>
                                </li>

                                <li class="dis-course-ratings-count">
                                    (<?php echo esc_html($course_reviews_count); ?>)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="dis-course-card-hover-contents">
                        <div class="dis-course-card-hover-contents-inner">
                            <div class="dis-course-wishlist">
                                <a href="javascript:void(0);">
                                    <i aria-hidden="true" class="far fa-heart"></i>
                                </a>
                            </div>

                            <h6 class="dis-course-category">
                                <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html(!empty($course_category) ? $course_category[0]->name : ''); ?></a>
                            </h6>

                            <h3 class="dis-course-title">
                                <a href="<?php echo esc_url($course_link); ?>"><?php echo esc_html($course_title); ?></a>
                            </h3>

                            <ul class="dis-course-author-and-ratings">
                                <li class="dis-course-ratings">
                                    <?php
                                    if (is_numeric($average_rating)) {
                                        $percentage = ($average_rating / 5) * 100;
                                        echo '<div class="star-ratings">

                                            <div class="fill-ratings" style="width:' . $percentage . '%;">
                                                <span>★★★★★</span>
                                            </div>

                                            <div class="empty-ratings">
                                                <span>★★★★★</span>
                                            </div>

                                            </div>';
                                    }
                                    ?>
                                </li>

                                <li class="dis-course-ratings-count">
                                    (<?php echo esc_html($course_reviews_count); ?>)
                                </li>
                            </ul>

                            <ul class="dis-course-features">
                                <li>
                                    <i class="fas fa-grip-vertical"></i> All Levels
                                </li>

                                <li>
                                    <i class="fas fa-bars"></i>
                                    <span class="dis-course-no-count"><?php echo esc_html($course_lessons_count); ?></span> Lessons
                                </li>

                                <li>
                                    <i class="far fa-clock"></i>
                                    <span class="dis-course-duration-count"><?php echo esc_html($course_duration); ?></span>
                                </li>
                            </ul>

                            <div class="dis-course-card-footer">
                                <a href="<?php echo esc_url($course_link); ?>" class="dis-course-btn">See Details</a>
                                <p class="dis-course-fee">
                                    <?php
                                    if (!empty($product_ID)) {
                                        if ($sale_price !== "") {
                                            $m_price =   '<span>' . $current_currency . $sale_price . '</span>';
                                        } elseif ($regular_price !== "") {
                                            $m_price = '<span>' . $current_currency . $regular_price . '</span>';
                                        } else {
                                            $m_price = 'Free';
                                        }
                                        echo $m_price;
                                    } else {
                                        echo 'Free';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="dis-course-all-course-card">
                <h2>
                    The World's Largest Selection of Online Courses
                </h2>

                <a href="#">
                    Browse All Course
                </a>
            </div>
        </div>

<?php
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return '<p>No courses found.</p>';
    }
}
add_shortcode('course_cards', 'dis_learnSkill_course_card_shortcode');
?>