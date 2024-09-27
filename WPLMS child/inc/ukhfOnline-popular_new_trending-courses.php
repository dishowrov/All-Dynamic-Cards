<?php
function ukhf_4t_courses_shortcode($atts)
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

    <div class="dis-course-cards-wrapper dis-course-slider">

        <?php

        $loop = new WP_Query($arg);

        while ($loop->have_posts()) {
            $loop->the_post();

            $course_ID = get_the_ID();
            $course_title = get_the_title($course_ID);
            $course_img = get_the_post_thumbnail_url($course_ID, "large") ?: 'https://uk.hfonline.org/wp-content/uploads/2024/09/dummy-imageforfreecourse.webp';
            $course_link = get_the_permalink($course_ID);
            $average_rating = get_post_meta($course_ID, 'average_rating', true) ?: '0';
            $students = get_post_meta($course_ID, 'vibe_students', true) ?: '0';

            $rating_percentage = ($average_rating / 5) * 100;
        ?>

            <div class="dis-course-card">
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

                <div class="dis-course-bottom">
                    <h6>
                        <strong><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">£</span>415</bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">£</span>25</bdi></span></ins> <small class="woocommerce-price-suffix">ex VAT</small></strong>
                    </h6>

                    <h5 class="dis-course-btn">
                        <a href="https://uk.hfonline.org/course/mental-health-nursing-level-3-cpd-accredited/">View More</a>
                    </h5>
                </div>
            </div>

        <?php
        }
        ?>
    </div>
<?php

    return ob_get_clean();
}

add_shortcode('dis_4t_courses', 'ukhf_4t_courses_shortcode');
?>