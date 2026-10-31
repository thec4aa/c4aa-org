// Wrapped so nothing here leaks into the global scope (clipPaths.js declares
// its own prefersReducedMotion, and two top-level consts would collide).
(function () {
    // Respect the OS/browser reduced-motion setting instead of forcing smooth scrolling
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const scrollBehavior = prefersReducedMotion ? 'auto' : 'smooth';

    // Smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        const href = anchor.getAttribute('href');
        if (href === '#') {
            return;
        }

        anchor.addEventListener('click', function (e) {
            const target = document.getElementById(decodeURIComponent(href.slice(1)));
            if (!target) {
                return;
            }

            e.preventDefault();
            target.scrollIntoView({
                behavior: scrollBehavior
            });
            history.pushState(null, '', href);

            if (!target.hasAttribute('tabindex')) {
                target.setAttribute('tabindex', '-1');
            }
            target.focus({ preventScroll: true });
        });
    });

    // watches for clicks on either `.site-featured-image` and `.entry-content > :first-child.wp-block-pullquote` elements, and includes an exception for clicks on an anchor tag link within those elements. Once a click is detected, the function will scroll to the title of the page.
    // written by github copilot and modified by me.
    document.addEventListener('click', function (event) {
        if (event.target.closest('.site-featured-image, .entry-content > :first-child.wp-block-pullquote') && !event.target.closest('a')) {
            const title = document.querySelector('.entry-header .entry-title');
            if (!title) {
                return;
            }
            title.scrollIntoView({
                behavior: scrollBehavior
            });
        }
    });
})();
