<?php
function dis_course_card_shortcode($atrbts)
{
    ob_start();

    $attributes = shortcode_atts(
        array(
            'category' => '',
            'filter' => '',
            'limit' => '',
            'id' => '',
            'tag' => ''
        ),
        $atrbts
    );

    $course_id = $atrbts['id'];

?>
    <div class="dis-course-card">
        <div class="dis-card-thumbnail">
            <a href="#">
                <img src="https://www.alphaacademy.org/wp-content/uploads/2024/10/thumbnail.webp" alt="The Course Thumbnail">
            </a>
        </div>

        <div class="dis-course-card-info">
            <h3 class="dis-course-title">
                <a href="#">
                    Psychotherapy and Counselling Course Level 3
                </a>
            </h3>

            <div class="dis-course-meta">
                <div class="dis-course-price">
                    <p class="dis-price-in-pound">£300</p>
                    <p class="dis-price-in-dollar">$800</p>
                </div>

                <div class="dis-course-module">
                    <i class="fa-solid fa-book"></i>
                    Modules 14
                </div>
            </div>

            <div class="dis-course-card-btn">
                <a href="#">
                    <i class="fa-solid fa-bag-shopping"></i>
                    ADD TO CART
                </a>
            </div>
        </div>
    </div>
<?php

    return ob_get_clean();
}
add_shortcode('dis_courses', 'dis_course_card_shortcode');
?>