<?php
function dis_blog_cards_shortcode($atts)
{
    ob_start();


    $atts = shortcode_atts(
        array(
            'category' => '',
            'limit' => 4,
            'id' => '',
            'orderby' => 'date',
            'order' => 'DESC'
        ),
        $atts
    );

    if (!empty($atts['category'])) {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $atts['limit'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $atts['category']
                )
            ),
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'post_status' => 'publish'
        );
    } elseif (!empty($atts['id'])) {
        $post_ids = explode(',', $atts['id']);
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $atts['limit'],
            'post__in' => $post_ids,
            'orderby' => 'post__in',
            'post_status' => 'publish'
        );
    } else {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $atts['limit'],
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'post_status' => 'publish'
        );
    }


    $loop = new WP_Query($args);

    // HTML structure of the blog cards
    if ($loop->have_posts()) {
        echo '<div class="dis-blog-cards-wrapper">';
        while ($loop->have_posts()) {
            $loop->the_post(); ?>

            <div class="dis-blog-card">
                <div class="dis-blog-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>
                    </a>
                </div>

                <div class="dis-blog-other-info">
                    <h6 class="dis-blog-date">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25" fill="none">
                                <path
                                    d="M15.5621 0.570312C15.9905 0.570312 16.3445 0.885275 16.4005 1.29392L16.4082 1.40752L16.4083 2.35383C19.8832 2.58777 22.011 4.79297 22 8.35326V18.5396C22 22.3134 19.6109 24.5703 15.7711 24.5703H6.22876C2.39353 24.5703 0 22.275 0 18.4552V8.35326C0 4.79426 2.13463 2.58844 5.60198 2.35393L5.60209 1.40752C5.60209 0.945144 5.98092 0.570312 6.44824 0.570312C6.87661 0.570312 7.23064 0.885275 7.28667 1.29392L7.29439 1.40752L7.29422 2.33311H14.7156L14.7159 1.40752C14.7159 0.945144 15.0948 0.570312 15.5621 0.570312ZM20.3072 10.5099H1.69156L1.6923 18.4552C1.6923 21.2453 3.21342 22.794 5.95096 22.891L6.22876 22.8959H15.7711C18.6934 22.8959 20.3077 21.3709 20.3077 18.5396L20.3072 10.5099ZM16.022 17.5335C16.4893 17.5335 16.8681 17.9084 16.8681 18.3707C16.8681 18.7946 16.5498 19.1449 16.1368 19.2003L16.022 19.208C15.5442 19.208 15.1654 18.8331 15.1654 18.3707C15.1654 17.9469 15.4837 17.5966 15.8967 17.5412L16.022 17.5335ZM11.0156 17.5335C11.4829 17.5335 11.8618 17.9084 11.8618 18.3707C11.8618 18.7946 11.5434 19.1449 11.1304 19.2003L11.0156 19.208C10.5378 19.208 10.159 18.8331 10.159 18.3707C10.159 17.9469 10.4773 17.5966 10.8903 17.5412L11.0156 17.5335ZM5.99882 17.5335C6.46613 17.5335 6.84497 17.9084 6.84497 18.3707C6.84497 18.7946 6.52664 19.1449 6.11364 19.2003L5.98837 19.208C5.52105 19.208 5.14222 18.8331 5.14222 18.3707C5.14222 17.9469 5.46054 17.5966 5.87355 17.5412L5.99882 17.5335ZM16.022 13.1951C16.4893 13.1951 16.8681 13.5699 16.8681 14.0323C16.8681 14.4561 16.5498 14.8064 16.1368 14.8619L16.022 14.8695C15.5442 14.8695 15.1654 14.4947 15.1654 14.0323C15.1654 13.6084 15.4837 13.2582 15.8967 13.2027L16.022 13.1951ZM11.0156 13.1951C11.4829 13.1951 11.8618 13.5699 11.8618 14.0323C11.8618 14.4561 11.5434 14.8064 11.1304 14.8619L11.0156 14.8695C10.5378 14.8695 10.159 14.4947 10.159 14.0323C10.159 13.6084 10.4773 13.2582 10.8903 13.2027L11.0156 13.1951ZM5.99882 13.1951C6.46613 13.1951 6.84497 13.5699 6.84497 14.0323C6.84497 14.4561 6.52664 14.8064 6.11364 14.8619L5.98837 14.8695C5.52105 14.8695 5.14222 14.4947 5.14222 14.0323C5.14222 13.6084 5.46054 13.2582 5.87355 13.2027L5.99882 13.1951ZM14.7156 4.00711H7.29422L7.29439 5.08095C7.29439 5.54333 6.91556 5.91816 6.44824 5.91816C6.01987 5.91816 5.66584 5.6032 5.60981 5.19456L5.60209 5.08095L5.60089 4.03257C3.07865 4.24036 1.6923 5.73824 1.6923 8.35326L1.69156 8.83471H20.3072L20.3077 8.35069C20.3157 5.73361 18.9365 4.23884 16.4083 4.0323L16.4082 5.08095C16.4082 5.54333 16.0294 5.91816 15.5621 5.91816C15.1337 5.91816 14.7797 5.6032 14.7237 5.19456L14.7159 5.08095L14.7156 4.00711Z"
                                    fill="#8782DF" />
                            </svg>
                        </span>
                        <span><?php echo get_the_date(); ?></span>
                    </h6>

                    <h3 class="dis-blog-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <p class="dis-blog-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>" class="dis-blog-btn">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                            <path
                                d="M0 7.07022C0 6.70591 0.273604 6.40483 0.628586 6.35718L0.727273 6.35061L13.512 6.35098L8.8931 1.79986C8.60848 1.51944 8.60748 1.06381 8.89089 0.782178C9.14853 0.526151 9.55252 0.502065 9.83768 0.710485L9.91941 0.779986L15.7861 6.5599L15.8005 6.57505C15.8153 6.59059 15.8296 6.60679 15.843 6.62359L15.7861 6.5599C15.8143 6.58774 15.8398 6.61732 15.8625 6.64827C15.8762 6.66772 15.8895 6.68791 15.9017 6.70877C15.9295 6.75519 15.9509 6.80377 15.9668 6.85371C15.9721 6.87131 15.9771 6.88929 15.9813 6.90754C15.9848 6.92147 15.9877 6.93562 15.9901 6.94984C15.9925 6.96524 15.9946 6.98065 15.9962 6.99621C15.998 7.01182 15.9991 7.02778 15.9997 7.04376C15.9998 7.05262 16 7.0614 16 7.07022L15.9998 7.09411C15.9992 7.11183 15.9979 7.12954 15.996 7.14719L16 7.07022C16 7.11131 15.9965 7.1516 15.9898 7.19081C15.9868 7.20867 15.9831 7.22661 15.9786 7.24442C15.975 7.25857 15.971 7.27246 15.9667 7.28617C15.9615 7.30247 15.9557 7.31888 15.9492 7.33512C15.9424 7.35187 15.9351 7.36825 15.9273 7.38429C15.9213 7.39657 15.9146 7.40923 15.9075 7.42173C15.8942 7.44518 15.88 7.46718 15.8647 7.48832C15.8623 7.49163 15.8596 7.49528 15.8569 7.49891C15.8326 7.53104 15.8075 7.55937 15.7803 7.58561L9.91945 13.3606C9.63484 13.641 9.17436 13.6401 8.89093 13.3585C8.63327 13.1025 8.61063 12.7027 8.82247 12.4214L8.89306 12.3408L13.5111 7.79051L0.727273 7.78983C0.325611 7.78983 0 7.46765 0 7.07022Z"
                                fill="#542D88" />
                        </svg>
                    </a>
                </div>
            </div>

        <?php }
        echo '</div>';
    } else {
        echo '<p>No blog posts found.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('dis_blog_cards', 'dis_blog_cards_shortcode');



function dis_course_cards_shortcode($atts)
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
                'posts_per_page' => $atts['limit'] ?: 9,
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
        if ($atts['filter'] == 'top_rated') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 9,
                "meta_key" => 'rating_count',
                "orderby" => 'meta_value_num',
                "order" => 'DESC',
                "post_status" => "publish",
            );
        } elseif ($atts['filter'] == 'Bestseller') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 9,
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
            "posts_per_page" => $atts['limit'] ?: 9,
            "post__in" => $cid,
            "post_status" => "published",
        );
    } else {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => $atts['limit'] ?: 9,
            "post_status" => "publish",
            "orderby" => "date",
            "order" => "DESC"
        );
    }

    $loop = new WP_Query($arg);

    if ($loop->have_posts()) {

        ?>
        <div class="dis-all-courses">
            <?php

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

                <div class="srs_course_card_pr">
                    <div class="srs_img_wrapper">
                        <a href="<?php echo $courseLink; ?>">
                            <img src="<?php echo $course_img; ?>" alt="The Course Thumbnail" />
                        </a>
                        <?php
                        if (!empty($regular_price) && !empty($sale_price) && $regular_price > $sale_price) {
                            $discount_percentage = (($regular_price - $sale_price) / $regular_price) * 100;
                        ?>
                            <div class="srs_discount_count"><?php echo round($discount_percentage); ?>% OFF</div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="srs_rating_pr">
                        <div class="dis-course-rating-stars">
                            <span><?php echo $average_rating; ?></span>

                            <div>
                                <?php
                                if (is_numeric($average_rating)) {
                                    $percentage = ($average_rating / 5) * 100;
                                ?>
                                    <strong class="course-star-rating">
                                        <small class="bp_blank_stars">
                                            <small style="width: <?php echo $percentage ?>%;" class="bp_filled_stars"></small>
                                        </small>
                                    </strong>
                                <?php
                                }
                                ?>
                            </div>


                        </div>
                    </div>

                    <a class="srs_title" href="<?php echo $courseLink; ?>">
                        <?php echo $course_title; ?>
                    </a>

                    <div class="srs_meta_pr">
                        <div class="srs_module">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2.625 9.05969V3.55969C2.625 1.55969 3.125 1.05969 5.125 1.05969H8.625C10.625 1.05969 11.125 1.55969 11.125 3.55969V8.55969C11.125 8.62969 11.125 8.69969 11.12 8.76969"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M4.05 7.55969H11.125V9.30969C11.125 10.2747 10.34 11.0597 9.375 11.0597H4.375C3.41 11.0597 2.625 10.2747 2.625 9.30969V8.98469C2.625 8.19969 3.265 7.55969 4.05 7.55969Z"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.875 3.55969H8.875" stroke="#7C7E91" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M4.875 5.30969H7.375" stroke="#7C7E91" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span> Modules <?php echo count($units); ?> </span>
                        </div>
                        <div class="srs_time">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.5 6.05969C11.5 8.81969 9.26 11.0597 6.5 11.0597C3.74 11.0597 1.5 8.81969 1.5 6.05969C1.5 3.29969 3.74 1.05969 6.5 1.05969C9.26 1.05969 11.5 3.29969 11.5 6.05969Z"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.35494 7.6497L6.80494 6.7247C6.53494 6.5647 6.31494 6.1797 6.31494 5.8647V3.8147"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <span>
                                <?php echo $course_duration; ?>
                            </span>
                        </div>
                        <div class="srs_student">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.125 6.05969C7.50571 6.05969 8.625 4.9404 8.625 3.55969C8.625 2.17898 7.50571 1.05969 6.125 1.05969C4.74429 1.05969 3.625 2.17898 3.625 3.55969C3.625 4.9404 4.74429 6.05969 6.125 6.05969Z"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M10.4201 11.0597C10.4201 9.12469 8.49508 7.55969 6.12508 7.55969C3.75508 7.55969 1.83008 9.12469 1.83008 11.0597"
                                    stroke="#7C7E91" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span?><?php echo $courseStudents ?> Students </span>
                        </div>
                    </div>

                    <div class="srs_price_pr">
                        <div>
                            <?php
                            if (!empty($product_ID)) {
                                if ($sale_price !== "") {
                                    $m_price = '<span>' . $current_currency . $sale_price . '</span>' . ' ' . '<del>' . $current_currency . $regular_price . '</del>';
                                } elseif ($regular_price !== "") {
                                    $m_price = '<span>' . $current_currency . $regular_price . '</span>';
                                } else {
                                    $m_price = '';
                                }
                                echo $m_price;
                            } else {
                                echo "Free";
                            }

                            ?>
                        </div>
                        <a class="dis_course_btn" href="<?php echo $courseLink; ?>">View Course</a>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>

    <?php

        wp_reset_query();
    } else {
    ?>
        <p>No Courses Found</p>
<?php
    }
    return ob_get_clean();
}
add_shortcode('dis_course_cards', 'dis_course_cards_shortcode');
