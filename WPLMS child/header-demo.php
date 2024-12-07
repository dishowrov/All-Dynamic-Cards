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

                    <!-- logo -->
                    <h2 class="dis-header-logo">
                        <img src="http://hellomr.builder.com/wp-content/uploads/2024/12/Group-9.png" alt="Janets">
                    </h2>

                    <!-- category list -->
                    <div class="dis-long-list">
                        Explore Courses
                        <i class="fa-solid fa-angle-down"></i>

                        <div class="dis-long-list-full">

                            <!-- the item For the all courses -->
                            <a href="/all-courses" title="All Courses" class="dis-list-item">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTc9APxkj0xClmrU3PpMZglHQkx446nQPG6lA&s" alt="All Courses">

                                <p>
                                    Course Library
                                    <span>View the full range of courses</span>
                                </p>
                            </a>

                            <!-- the both items for another course categories -->
                            <p class="dis-top-categories">
                                <a href="/course-cat" title="CAtegory name">
                                    <!-- category image -->
                                    <img src="/" alt="Course category name">

                                    <p>
                                        QLS Endorsed Courses
                                        <span>Trending</span>
                                    </p>
                                </a>

                                <a href="/course-cat" title="CAtegory name">
                                    <!-- category image -->
                                    <img src="/" alt="Course category name">

                                    <p>
                                        Regulated Courses
                                    </p>
                                </a>
                            </p>

                            <!-- all are course categories with the same style -->
                            <ul class="dis-other-categories">
                                <li>
                                    <a href="http://hellomr.builder.com/course-cat/business/" title="All Courses">
                                        <img src="http://hellomr.builder.com/wp-content/uploads/2024/12/Vector.png" alt="Course category name">

                                        <p>
                                            <!-- Category name -->
                                            Business

                                            <!-- Students counting under the cat -->
                                            <span>(56 courses)</span>
                                        </p>
                                    </a>

                                    <ul class="dis-courses-under-the-cat">
                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Digital Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <!-- this item is the category link -->
                                        <li>
                                            <a href="/course-link" title="category name">
                                                View all Business courses
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="http://hellomr.builder.com/course-cat/business/" title="All Courses">
                                        <img src="http://hellomr.builder.com/wp-content/uploads/2024/12/Vector.png" alt="Course category name">

                                        <p>
                                            <!-- Category name -->
                                            Health

                                            <!-- Students counting under the cat -->
                                            <span>(56 courses)</span>
                                        </p>
                                    </a>

                                    <ul class="dis-courses-under-the-cat">
                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Digital Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <!-- this item is the category link -->
                                        <li>
                                            <a href="/course-link" title="category name">
                                                View all Business courses
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="http://hellomr.builder.com/course-cat/business/" title="All Courses" class="dis-list-item">
                                        <img src="http://hellomr.builder.com/wp-content/uploads/2024/12/Vector.png" alt="Course category name">

                                        <p>
                                            <!-- Category name -->
                                            Photography

                                            <!-- Students counting under the cat -->
                                            <span>(56 courses)</span>
                                        </p>
                                    </a>

                                    <ul class="dis-courses-under-the-cat">
                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Digital Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <!-- this item is the category link -->
                                        <li>
                                            <a href="/course-link" title="category name">
                                                View all Business courses
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="http://hellomr.builder.com/course-cat/business/" title="All Courses" class="dis-list-item">
                                        <img src="http://hellomr.builder.com/wp-content/uploads/2024/12/Vector.png" alt="Course category name">

                                        <p>
                                            <!-- Category name -->
                                            Technology

                                            <!-- Students counting under the cat -->
                                            <span>(56 courses)</span>
                                        </p>
                                    </a>

                                    <ul class="dis-courses-under-the-cat">
                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Digital Photography
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/course-link" title="course name">
                                                Basic of Nature Photography
                                            </a>
                                        </li>

                                        <!-- this item is the category link -->
                                        <li>
                                            <a href="/course-link" title="category name">
                                                View all Business courses
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <!-- search form -->
                    <form action="/">
                        <input type="text">
                        <input type="submit" value="/">
                    </form>

                    <!-- nav manu -->
                    <ul>
                        <li>
                            <a href="#">
                                Prime Membership
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Prime Membership
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Prime Membership
                            </a>
                        </li>
                    </ul>

                    <!-- cart icon -->
                    <div class="dis-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <!-- login button -->
                    <div class="dis-login">
                        <a href="#">Login Now</a>
                    </div>

                </div>
            </header>