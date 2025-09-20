document.addEventListener("DOMContentLoaded", function () {
    // Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const userAddress = urlParams.get("userAddress");

    if (userAddress) {
        // Find the element with the ID or class matching the parameter
        const targetElement = document.querySelector('.csl-search-form');
        
        if (targetElement) {
            // Scroll to the target element
            targetElement.scrollIntoView({ behavior: "smooth" });
        }
    }
});