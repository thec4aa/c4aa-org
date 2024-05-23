// Smooth scrolling to anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
  
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
  });  
  
  // this script  will smoothly scroll down one view height when the user clicks on either `.site-featured-image` and `.entry-content > :first-child.wp-block-pullquote` elements, and includes an exception for clicks on an anchor tag link within those elements.
  // written by github copilot and modified by me.
  
  // select elements that will trigger the smooth scroll
  const triggerElements = document.querySelectorAll('.site-featured-image, .entry-content > :first-child.wp-block-pullquote');
  
  // add click event listeners to trigger elements
  triggerElements.forEach( element => {
    element.addEventListener('click', (e) => {
      // if the click target is an anchor tag, then do nothing
      if ( e.target.tagName === 'A' ) {
        return;
      }
      
      // prevent default behavior
      e.preventDefault();
      
      // scroll to the next view height
      window.scrollBy({
        top: window.innerHeight,
        behavior: 'smooth'
        });
    });
  });





