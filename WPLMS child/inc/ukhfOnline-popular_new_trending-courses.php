<?php
// Function to display courses based on category, filter, or ID using a shortcode
function ukhf_4t_courses_shortcode($atts)
{
    // Start output buffering to capture HTML output
    ob_start();

    // Define the shortcode attributes and their default values
    $atts = shortcode_atts(
        array(
            'category' => '', // Filter by course category (optional)
            'filter' => '',   // Filter by toprated or most enrolled courses (optional)
            'limit' => '',    // Limit the number of courses displayed (optional)
            'id' => ''        // Display specific courses by ID (optional)
        ),
        $atts
    );

    // Store the 'id' attribute in a variable
    $course_id = $atts['id'];

    // Check if the 'category' attribute is set
    if (!empty($atts['category'])) {

        // Get the category term details using the category slug
        $terms = get_terms(array(
            'taxonomy' => 'course-cat', // Taxonomy for course categories
            'slug' => $atts['category'] // Category slug passed in the shortcode
        ));

        // If category term exists, prepare the query arguments
        if (!empty($terms)) {
            $arg = array(
                'post_type' => 'course',   // Post type 'course'
                'posts_per_page' => $atts['limit'] ?: 4,  // Limit to the specified number of courses or default to 4
                'tax_query' => array(
                    array(
                        'taxonomy' => 'course-cat', // Filter by course category
                        'field' => 'slug',          // Using the category slug
                        'terms' => $atts['category'] // The category passed in the shortcode
                    )
                ),
            );
        }
    }
    // Check if 'filter' attribute is set for filtering courses
    elseif (!empty($atts['filter'])) {

        // If filter is set to 'toprated', sort courses by the 'rating_count' meta key
        if ($atts['filter'] == 'toprated') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 4, // Limit number of courses
                "meta_key" => 'rating_count',            // Meta key for ratings
                "orderby" => 'meta_value_num',           // Sort by numeric value of meta key
                "order" => 'DESC',                       // Order in descending order
                "post_status" => "publish",              // Only display published courses
            );
        }

        // If filter is set to 'mostenrolled', sort courses by the 'vibe_students' meta key (number of students)
        elseif ($atts['filter'] == 'mostenrolled') {
            $arg = array(
                "post_type" => "course",
                "posts_per_page" => $atts['limit'] ?: 4,
                "post_status" => "publish",
                "meta_key" => "vibe_students",           // Meta key for number of students
                "orderby" => "meta_value_num",           // Sort by the number of students
                "order" => "DESC",                       // Order in descending order
            );
        }
    }

    // Check if 'id' attribute is set to display specific courses
    elseif (!empty($course_id)) {
        $course_ids = $course_id;             // Get the course IDs passed as a comma-separated string
        $course_ids = (explode(",", $course_ids)); // Convert the string into an array of IDs

        // Initialize an empty array to store course IDs
        $cid = array();
        if ($course_ids) {
            foreach ($course_ids as $course_id) {
                $cid[] = $course_id; // Add each course ID to the array
            }
        }

        // Prepare query arguments to fetch the courses by ID
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => $atts['limit'] ?: 4, // Limit the number of courses
            "post__in" => $cid,                      // Use the course IDs
            "post_status" => "published",            // Display only published courses
        );
    }
    
    // Default case: Display the most recent courses if no category, filter, or ID is provided
    else {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => $atts['limit'] ?: 4, // Default to 4 courses
            "post_status" => "publish",              // Only display published courses
            "orderby" => "date",                     // Order by the date of publication
            "order" => "DESC"                        // Display the newest courses first
        );
    }
?>

    <!-- HTML for the course card container -->
    <div class="dis-course-cards-wrapper dis-course-slider">

        <?php
        // Execute the query to fetch the courses based on the prepared arguments
        $loop = new WP_Query($arg);

        // Loop through each course and display its details
        while ($loop->have_posts()) {
            $loop->the_post();

            // Get course details: ID, title, thumbnail, link, average rating, and number of students
            $course_ID = get_the_ID();
            $course_title = get_the_title($course_ID);
            $course_img = get_the_post_thumbnail_url($course_ID, "large") ?: 'https://uk.hfonline.org/wp-content/uploads/2024/09/dummy-imageforfreecourse.webp'; // Default image if no thumbnail
            $course_link = get_the_permalink($course_ID);
            $average_rating = get_post_meta($course_ID, 'average_rating', true) ?: '0'; // Get average rating, default to 0
            $students = get_post_meta($course_ID, 'vibe_students', true) ?: '0'; // Get number of students, default to 0

            // Calculate the rating percentage for displaying star ratings
            $rating_percentage = ($average_rating / 5) * 100;
        ?>

            <!-- HTML structure for a single course card -->
            <div class="dis-course-card">
                <!-- Course thumbnail -->
                <a href="<?php echo esc_attr($course_link); ?>" class="dis-course-thumbnail">
                    <img decoding="async" src="<?php echo esc_attr($course_img); ?>" alt="The Course Thumbnail">
                </a>

                <!-- Course title -->
                <a href="<?php echo esc_attr($course_link); ?>">
                    <h4><?php echo esc_html($course_title); ?></h4>
                </a>

                <!-- Course information (students and ratings) -->
                <div class="dis-course-info">
                    <p>
                        <img decoding="async" src="https://uk.hfonline.org/wp-content/uploads/2024/02/students.png" alt="students">
                        <span><?php echo esc_html($students); ?></span> Students
                    </p>

                    <!-- Star rating display -->
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

                <!-- Course price and button -->
                <div class="dis-course-bottom">
                    <!-- Display course price with a discount -->
                    <h6>
                        <strong><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">£</span>415</bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">£</span>25</bdi></span></ins> <small class="woocommerce-price-suffix">ex VAT</small></strong>
                    </h6>

                    <!-- 'View More' button linking to the course -->
                    <h5 class="dis-course-btn">
                        <a href="https://uk.hfonline.org/course/mental-health-nursing-level-3-cpd-accredited/">View More</a>
                    </h5>
                </div>
            </div>

        <?php
        } // End of course loop
        ?>
    </div>

<?php
    // Return the captured HTML content
    return ob_get_clean();
}

// Register the shortcode so it can be used in WordPress
add_shortcode('dis_4t_courses', 'ukhf_4t_courses_shortcode');
?>