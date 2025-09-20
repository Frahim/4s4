// // Select all elements with the class 'hoverItem'
// const hoverItems = document.querySelectorAll('.hoverItem');

// // Function to check if screen size is less than or equal to 768px
// function isMobile() {
//     return window.innerWidth <= 768;
// }

// // Function to handle hover behavior
// function addHoverBehavior() {
//     hoverItems.forEach((hoverItem, index) => {
//         const targetDivs = document.querySelectorAll('.targetDiv');
//         if (index >= targetDivs.length)
//             return; // Skip if the target div does not exist

//         const targetDiv = targetDivs[index]; // Get the corresponding target div

//         if (!hoverItem || !targetDiv)
//             return; // Ensure hoverItem and targetDiv are found

//         // Mouse enter on the hover item to show the target div
//         hoverItem.addEventListener('mouseenter', function () {
//             targetDiv.style.display = 'block';  // Show the corresponding target div
//         });

//         // Mouse leave on the hover item to hide the target div
//         hoverItem.addEventListener('mouseleave', function () {
//             setTimeout(() => {
//                 if (!targetDiv.matches(':hover')) {  // Only hide if the mouse is not on the target div
//                     targetDiv.style.display = 'none';
//                 }
//             }, 100);  // Delay to give time to hover over the target div itself
//         });

//         // Mouse enter on the target div to keep it visible
//         targetDiv.addEventListener('mouseenter', function () {
//             targetDiv.style.display = 'block';  // Keep the div visible when hovering over it
//         });

//         // Mouse leave on the target div to hide it again when mouse leaves
//         targetDiv.addEventListener('mouseleave', function () {
//             targetDiv.style.display = 'none';
//         });
//     });
// }

// // Function to handle click behavior (mobile)
// function addClickBehavior() {
//     hoverItems.forEach((hoverItem, index) => {
//         const targetDivs = document.querySelectorAll('.targetDiv');
//         if (index >= targetDivs.length)
//             return; // Skip if the target div does not exist

//         const targetDiv = targetDivs[index]; // Get the corresponding target div
//         const dropdownToggle = hoverItem.querySelector('.dropdown-toggle'); // Get the dropdown toggle element

//         if (!hoverItem || !targetDiv || !dropdownToggle)
//             return; // Ensure hoverItem, targetDiv, and dropdownToggle are found

//         let isVisible = false; // Flag to track visibility state of the target div

//         // Click on the dropdown toggle to toggle the target div
//         dropdownToggle.addEventListener('click', function (e) {
//             e.preventDefault(); // Prevent the default behavior of the anchor tag
//             if (isVisible) {
//                 targetDiv.style.display = 'none';  // Hide the corresponding target div
//                 isVisible = false;
//             } else {
//                 targetDiv.style.display = 'block';  // Show the corresponding target div
//                 isVisible = true;
//             }
//         });

//         // Click outside to hide the target div (for closing it when clicking anywhere else)
//         document.addEventListener('click', function (e) {
//             if (!hoverItem.contains(e.target) && !targetDiv.contains(e.target)) {
//                 targetDiv.style.display = 'none';  // Hide the target div if clicked outside
//                 isVisible = false;
//             }
//         });
//     });
// }

// // Add hover or click behavior based on screen size
// function updateMenuBehavior() {
//     if (isMobile()) {
//         // For mobile screens, use click behavior
//         addClickBehavior();
//     } else {
//         // For desktop screens, use hover behavior
//         addHoverBehavior();
//     }
// }

// // Initialize menu behavior on page load
// updateMenuBehavior();

// // Re-check screen size when the window is resized
// window.addEventListener('resize', updateMenuBehavior);

// // Add 'mega-menu-open' class to elements with class 'mega-menu-toggle'
// document.querySelectorAll('.mega-menu-toggle').forEach(element => {
//     element.classList.add('mega-menu-open');
// });






document.addEventListener("DOMContentLoaded", function () {
    // Select all elements with the class "product_caru"
    let splideElements = document.querySelectorAll(".product_caru");

    // Loop through each element and initialize Splide
    splideElements.forEach(function (element) {
        new Splide(element, {
            type: "loop",
            perPage: 6,
            gap: "30px",
            arrows: true,
            pagination: false,
            breakpoints: {
                1500: {
                    perPage: 5,
                },
                1200: {
                    perPage: 3,
                },
                768: {
                    perPage: 2,
                },
            },
        }).mount(); // Directly mount the instance
    });
});



jQuery(document).ready(function ($) {
    // Update the variation when a radio button is selected
    $(document).on('change', '.variation-radios input[type="radio"]', function () {
        const selectName = $(this).attr('name');
        const selectedValue = $(this).val();

        // Update the hidden dropdown (required for WooCommerce's variation handling)
        $(`select[name="${selectName}"]`).val(selectedValue).trigger('change');
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let splideElements = document.querySelectorAll("#partnersCarousel");

    splideElements.forEach(function (element) {
        let splide = new Splide(element, {
            type: "loop",
            perPage: 6,
            gap: "30px",
            arrows: false,
            pagination: false,
            breakpoints: {
                1200: {
                    perPage: 3,
                },
                768: {
                    perPage: 2,
                },
            },
        });

        splide.mount();
    });
});



// Showmore
document.addEventListener('DOMContentLoaded', function () {
    const contentContainers = document.querySelectorAll('.woocommerce-product-details__short-description');

    contentContainers.forEach((content, index) => {
        const showMoreButton = document.createElement('div');
        showMoreButton.classList.add('show-more');
        showMoreButton.innerHTML = 'Show more <i class="fas fa-plus"></i>'; // Use &#9650; for chevron-up
        content.parentNode.insertBefore(showMoreButton, content.nextSibling);

        showMoreButton.addEventListener('click', function () {
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                showMoreButton.innerHTML = 'Show more <i class="fas fa-plus"></i>'; // Use &#9650; for chevron-up
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                showMoreButton.innerHTML = 'Show less <i class="fas fa-minus"></i>'; // Use &#9660; for chevron-down
            }
        });
    });
});




jQuery(document).ready(function ($) {
    $('.custom-category-filter ul li a').on('click', function (e) {
        e.preventDefault(); // Prevent default link behavior
        var categoryLink = $(this).attr('href'); // Get the category link

        // Send AJAX request
        $.ajax({
            url: categoryLink,
            type: 'GET',
            success: function (response) {
                // Replace the product loop with the new content
                $('.products').html($(response).find('.products').html());
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    let splideElements = document.querySelectorAll("#catCarousel");

    splideElements.forEach(function (element) {
        let splide = new Splide(element, {
            // type: "loop",
            perPage: 7,
            gap: "10px",
            arrows: true,
            pagination: false,
            breakpoints: {
                1200: {
                    perPage: 3,
                },
                768: {
                    perPage: 2,
                },
                 480: {
                    perPage: 1,
                },
            },
        });

        splide.mount();
    });
});
