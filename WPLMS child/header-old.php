<?php
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="global" class="global">
        <?php
        get_template_part('mobile', 'sidebar');
        ?>
        <div class="pusher">
            <?php
            $fix = vibe_get_option('header_fix');
            ?>
            <header>
                <div class="dis-header">

                    <!-- Logo -->
                    <h2 class="dis-header-logo">
                        <?php
                        $logo_url = apply_filters('wplms_logo_url', VIBE_URL . '/assets/images/logo.png', 'header');

                        if (!empty($logo_url)) {
                        ?>
                            <a href="<?php echo vibe_site_url('', 'logo'); ?>" title="<?php bloginfo('name') ?>">
                                <img src="<?php echo vibe_sanitizer($logo_url) ?>" alt="<?php echo get_bloginfo('name'); ?>">
                            </a>
                        <?php
                        }
                        ?>
                    </h2>

                    <!-- Long List Hover -->
                    <div class="dis-long-list">

                        <div class="dis-has-list">
                            Explore Courses
                            <i class="fa-solid fa-angle-down"></i>

                            <div class="dis-long-list-items">

                                <?php
                                function dis_get_course_details($course_id)
                                {
                                    if (empty($course_id) || !is_numeric($course_id)) {
                                        return [];
                                    }

                                    $title = get_the_title($course_id);
                                    $url = get_permalink($course_id);
                                    $students = get_post_meta($course_id, 'vibe_students', true);
                                    $categories = get_the_terms($course_id, 'course-cat');
                                    $category_names = [];

                                    if (!empty($categories) && !is_wp_error($categories)) {
                                        foreach ($categories as $category) {
                                            $category_names[] = $category->name;
                                        }
                                    }

                                    return [
                                        'title' => $title,
                                        'url' => !empty($url) ? esc_url($url) : '',
                                        'students' => !empty($students) ? intval($students) : 0,
                                        'categories' => $category_names,
                                    ];
                                }
                                ?>

                                <ul class="dis-category-list">
                                    <?php
                                    $category_ids = [33, 174, 32];

                                    $args = [
                                        'taxonomy' => 'course-cat',
                                        'include'  => $category_ids,
                                        'hide_empty' => false,
                                    ];
                                    $course_categories = get_terms($args);

                                    if (!empty($course_categories) && !is_wp_error($course_categories)) {
                                        foreach ($course_categories as $category) {
                                            $category_image_url = get_term_meta($category->term_id, 'category_image', true);
                                            $category_courses_count = $category->count;
                                    ?>
                                            <li class="dis-course-cat">
                                                <h4>
                                                    <!-- Display the category image -->
                                                    <img src="<?php echo $category_image_url; ?>" alt="<?php echo esc_attr($category->name); ?>">

                                                    <p><?php echo esc_html($category->name); ?></p>

                                                    <span>(<?php echo esc_html($category_courses_count); ?> courses)</span>
                                                </h4>

                                                <?php
                                                $args = [
                                                    'post_type' => 'course',
                                                    'tax_query' => [
                                                        [
                                                            'taxonomy' => 'course-cat',
                                                            'field'    => 'term_id',
                                                            'terms'    => $category->term_id,
                                                        ],
                                                    ],
                                                ];
                                                $query = new WP_Query($args);

                                                if ($query->have_posts()) {
                                                ?>
                                                    <ul class="dis-courses-under-the-category">
                                                        <?php
                                                        while ($query->have_posts()) {
                                                            $query->the_post();
                                                            $course_id = get_the_ID();
                                                            $course_details = dis_get_course_details($course_id);
                                                        ?>
                                                            <li>
                                                                <a href="<?php echo $course_details['url']; ?>">
                                                                    <?php echo $course_details['title']; ?>
                                                                </a>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                <?php
                                                }
                                                wp_reset_postdata();
                                                ?>

                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                
                            </div>

                        </div>

                    </div>

                </div>
            </header>