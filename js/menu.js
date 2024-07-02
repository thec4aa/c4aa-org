// Hamburger
document.addEventListener('DOMContentLoaded', function() {
  var menuToggle = document.querySelector('.menu-toggle');
  var mainNavigation = document.querySelector('.main-navigation');
  var menuIsActive = false;
  var widthIsMobile = checkWidth();
  
  window.addEventListener('resize', function(){
    widthIsMobile = checkWidth();
    menuIsActive = false;
    menuToggle.classList.remove('active');
    mainNavigation.style.display = (widthIsMobile) ? 'none' : 'block';
  });
  
  if (menuToggle) {
    menuToggle.addEventListener('click', function() {
      menuIsActive = !menuIsActive;
      menuToggle.classList.toggle('active');
      mainNavigation.style.display = (menuIsActive) ? 'block' : 'none';
    });
  }
});
// Toggle red and white logos
document.addEventListener('DOMContentLoaded', function() {
  var menuToggle = document.querySelector('.menu-toggle');
  var logoC4aaMobileRed = document.querySelector('.logo-c4aa-mobile--red');
  var logoC4aaMobileWhite = document.querySelector('.logo-c4aa-mobile--white');
  var siteHeader = document.querySelector('.site-header');
  var menuIsActive = false;
  var widthIsMobile = checkWidth();
  
  window.addEventListener('resize', function(){
    widthIsMobile = checkWidth();
    if(widthIsMobile) {
      logoC4aaMobileRed.classList.add('active');
      logoC4aaMobileWhite.classList.remove('active');
      siteHeader.classList.remove('active');
    }
  });
  
  if (menuToggle) {
    menuToggle.addEventListener('click', function() {
      logoC4aaMobileRed.classList.toggle('active');
      logoC4aaMobileWhite.classList.toggle('active');
      siteHeader.classList.toggle('active');
    });
  }
});

// Check if the screen is mobile

function checkWidth() {
  return window.innerWidth < 769;
}


// Replace plain link SVG with Search Icon SVG

document.addEventListener("DOMContentLoaded", function() {
  // Select all span elements with the class screen-reader-text
  var spanElements = document.querySelectorAll('span.screen-reader-text');
  
  spanElements.forEach(function(spanElement) {
    // Check if the span element contains the text "Search"
    if (spanElement.textContent.trim() === "Search") {
      // Get the parent li element of the selected span
      var menuItem = spanElement.closest('li');
      
      // // Hide the menu item initially to prevent flashing
      // menuItem.style.visibility = 'hidden';
      
      // Path to the new SVG file
      var searchSVG = `
      <svg class="svg-icon" width="24" height="24" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
      <path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"/>
      </svg>
      `;
      
      // Find the existing SVG within the menu item
      var existingSVG = menuItem.querySelector("svg");
      
      // Replace the existing SVG with the new SVG
      if (existingSVG) {
        existingSVG.outerHTML = searchSVG;
        // Show the menu item now that the new SVG is loaded
        menuItem.classList.add('svg-loaded');
      }
    }
  });
});