<?php

function dis_compliance_central_course_card($atts)
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
            'posts_per_page' => 8,
            'post__in' => $course_id,
            'post_status' => 'published'
        );
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {

?>

        <div class="dis-pCourse_wrapper">
            <?php
            while ($loop->have_posts()) {
                $loop->the_post();

                $the_course_ID = get_the_ID();
                $course_title = get_the_title($the_course_ID);
                $course_img = get_the_post_thumbnail_url($the_course_ID, "large");
                $course_link = get_the_permalink($the_course_ID);
                $product_ID = get_post_meta($the_course_ID, 'vibe_product', true);
                $add_to_cart_url = wc_get_cart_url() . '?add-to-cart=' . $product_ID;
            ?>

                <!-- Course card -->
                <div class="dis-popular_course">
                    <div class="popular_thumb">
                        <a href="<?php echo $course_link; ?>">
                            <img src="<?php echo $course_img; ?>" alt="The Course Thumbnail" />
                        </a>
                    </div>

                    <div class="popular_title">
                        <h2>
                            <a href="<?php echo $course_link; ?>"> <?php echo $course_title; ?> </a>
                        </h2>
                    </div>

                    <div class="dis-course__end">
                        <a class="dis_viewMore_btn" href="<?php echo $course_link; ?>">View More</a>
                        <a class="dis_addCart_btn" href="<?php echo $add_to_cart_url ?>">Add to cart</a>
                    </div>
                </div>

            <?php
            }

            ?>
            </div>

        <?php

        wp_reset_query();
    } else {
        echo "There are no coursessssssssssssssssssssssss found";
    }
    return ob_get_clean();
}

add_shortcode("dis_cccs", "dis_compliance_central_course_card");
