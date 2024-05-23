// Smooth scrolling to anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
  
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
  });
  
  
  // scrolls down one viewport height when the user clicks on one of these two selectors `.site-featured-image` or `.entry-content > :first-child.wp-block-pullquote` 
  // this was written by github copilot. Hopefully it's good!
  document.querySelectorAll('.site-featured-image, .entry-content > :first-child.wp-block-pullquote').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
  
        window.scrollBy({
            top: window.innerHeight,
            behavior: 'smooth'
        });
    });
  });