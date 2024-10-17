// jQuery(function ($) {
//   $('.dis-course-slider').slick({
//     slidesToShow: 3,
//     slidesToScroll: 1,
//     autoplay: true,
//     autoplaySpeed: 2000,
//   });

//   $('.elementor-tab-title').click(function () {
//     setTimeout(function () {
//       $('.dis-course-slider').slick('setPosition');
//     }, 0);
//   });
// });

jQuery(document).ready(function($) {
  let page = 2; // Start loading from the second page

  $('#load-more-posts').click(function() {
      const button = $(this);
      button.text('Loading...'); // Change button text while loading

      $.ajax({
          url: ajax_params.ajax_url,
          type: 'POST',
          data: {
              action: 'load_more_posts',
              page: page,
              nonce: ajax_params.nonce,
          },
          success: function(response) {
              if (response) {
                  $('.dis-all-blog-posts').append(response); // Append new posts
                  page++; // Increment page number

                  // After loading posts, hide the "View More" button and show pagination
                  button.hide(); // Hide the button after one click
                  $('.dis-blog-pagination').show(); // Show pagination after loading more posts
              } else {
                  button.hide(); // Hide the button if no response
              }
          },
          error: function() {
              button.text('Error, try again.'); // Show error message
          }
      });
  });
});





