<?php
function b2b_cards_shortcode($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'category' => '',
            'filter' => '',
            'limit' => '',
            'id' => ''
        ),
        $atts
    );
    $course_id = $atts['id'];
    if (!empty($atts['category'])) {
        $terms = get_terms(array(
            'taxonomy' => 'course-cat',
            'slug' => $atts['category']
        ));

        if (!empty($terms)) {
            $arg = array(
                'post_type' => 'course',
                'posts_per_page' => $atts['limit'] ?: 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'course-cat',
                        'field' => 'slug',
                        'terms' => $atts['category']
                    )
                ),
            );
        }
    } elseif (!empty($atts['filter'])) {
        if ($atts['filter'] == 'toprated') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 4,
                "meta_key" => 'rating_count',
                "orderby" => 'meta_value_num',
                "order" => 'DESC',
                "post_status" => "publish",
            );
        } elseif ($atts['filter'] == 'mostenrolled') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 4,
                "post_status" => "publish",
                "meta_key" => "vibe_students",
                "orderby" => "meta_value_num",
                "order" => "DESC",
            );
        }
    } elseif (!empty($course_id)) {
        $course_ids = $course_id;
        $course_ids = (explode(",", $course_ids));
        $cid = array();
        if ($course_ids) {
            foreach ($course_ids as $course_id) {
                $cid[] = $course_id;
            }
        }
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => $atts['limit'] ?: 4,
            "post__in" => $cid,
            "post_status" => "published",
        );
    } else {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => $atts['limit'] ?: 4,
            "post_status" => "publish",
            "orderby" => "date",
            "order" => "DESC"
        );
    }
?>




    <style>
        /* css  */
    </style>

    <?php

    $loop = new WP_Query($arg);



    ?>

    <div class="tsco-rh-grid-items">



        <!-- Loops Starts here -->
        <?php
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $course_ID = get_the_ID();
                $average_rating = get_post_meta($course_ID, 'average_rating', true);
                $course_img = get_the_post_thumbnail_url($course_ID, "medium");
                $course_title = get_the_title($course_ID);
                $courseLink = get_the_permalink($course_ID);
                $courseStudents = get_post_meta($course_ID, 'vibe_students', true);
                $units = bp_course_get_curriculum_units($course_ID);
                $duration = $total_duration = 0;
                $product_ID = get_post_meta(get_the_ID(), 'vibe_product', true);
                $regular_price = get_post_meta($product_ID, '_regular_price', true);
                $sale_price = get_post_meta($product_ID, '_sale_price', true);
                $current_currency = get_woocommerce_currency_symbol();
                $taxonomy = 'course-cat';
                $terms = wp_get_post_terms($course_ID, $taxonomy, array('fields' => 'all'));
                $countRating = get_post_meta($course_ID, 'rating_count', true);

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
                        return sprintf('%02dh', $hours);
                    }
                }
                $course_duration = convert_seconds_to_hours_minutes($total_duration);
        ?>
                <div class="r-tsco-course-4-card-h">
                    <div class="thumb-floating-image-r4h">
                        <img src="<?php echo $course_img; ?>" alt="thumb-rh">
                        <div class="floating-image-rh">
                            <img src="https://tsco.org.uk/wp-content/uploads/2024/01/1492ef7b-ddc7-4b0f-89a2-be77f0127a34.svg"
                                alt="float-rh">
                        </div>
                    </div>
                    <div class="course-detail-r4h">
                        <div class="category-rh">
                            <span>
                                <?php
                                foreach (array_slice($terms, 0, 1) as $term_single) {
                                    echo esc_html($term_single->name);
                                }
                                ?>
                            </span>
                        </div>
                        <a href="#" class="course-title-rh">
                            <?php echo $course_title ?>
                        </a>
                        <div class="course-excert-rh">
                            <span>
                                Gain career-ready skills in public health with a flexible online master's degree from Brunel
                                University London. Build up your expertise in all areas of public health to boost your employability
                                across the healthcare sector.
                            </span>
                        </div>
                        <a href="<?php echo $courseLink; ?>" class="course-button-rh">
                            <span>
                                Start Course
                            </span>
                        </a>
                    </div>
                </div>
        <?php
            }
            wp_reset_query();
        } else {
            echo "No Course Found";
        }
        ?>

        <!-- Loops Ends here -->

    </div>


<?php

    return ob_get_clean();
}

add_shortcode('b2b_cards_shortcode', 'b2b_cards_shortcode');
?>