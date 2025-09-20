/**
 ** Slider -start
 */
document.addEventListener("DOMContentLoaded", function () {
    let splideElements = document.querySelectorAll("#latest_blog_post_slider");

    splideElements.forEach(function (element) {
        let splide = new Splide(element, {
            type: "loop",
            perPage: 3,
            gap: "30px",
            arrows: false,
            pagination: true,
            // breakpoints: {
            //     776: {
            //         height: "45rem",
            //     },
            // },
        });

        splide.mount();
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
            pagination: true,
            // breakpoints: {
            //     776: {
            //         height: "45rem",
            //     },
            // },
        });

        splide.mount();
    });
});

// document.addEventListener("DOMContentLoaded", function () {
//     let gamePoster = new Splide("#game_poster", {
//         type: "fade",
//         pagination: false,
//         arrows: false,
//         cover: true,
//     });

//     let thumbnails = new Splide("#gameThumbnails", {
//         rewind: false,
//         isNavigation: true,
//         gap: 0,
//         pagination: false,
//         cover: true,
//         arrows: false,
//     });

//     gamePoster.sync(thumbnails);
//     gamePoster.mount();
//     thumbnails.mount();
// });

// var splide = new Splide( '.splide' );
// splide.mount();

/*Slider -End */
