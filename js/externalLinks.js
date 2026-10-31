// Append a small "external link" icon to links in post content that leave
// the site. Replaces the inline script that used to live in functions.php.
(function () {
    const ICON = '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20">' +
        '<path d="M9 3h8v8l-2-1V6.92l-5.6 5.59l-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z" fill="currentColor"/>' +
        '</svg>';

    function isExternal(link) {
        // Only http(s) links can be external. This skips mailto:, tel:, sms:,
        // javascript: and anchors with no href, whose host is empty.
        if (!/^https?:$/.test(link.protocol)) {
            return false;
        }
        return link.host !== window.location.host;
    }

    function addExternalLinkIcons() {
        document.querySelectorAll('.entry-content a[href]').forEach(function (link) {
            if (!isExternal(link)) return;
            if (link.querySelector('img')) return;
            if (link.classList.contains('wp-block-social-link-anchor')) return;
            if (link.closest('.wp-block-jetpack-slideshow')) return;
            if (link.querySelector('svg[data-external-link-icon]')) return;

            // insertAdjacentHTML keeps the link's existing children (and any
            // listeners on them) intact, unlike innerHTML +=.
            link.insertAdjacentHTML('beforeend', ICON.replace('<svg ', '<svg data-external-link-icon="" '));
        });
    }

    window.addEventListener('load', addExternalLinkIcons, false);
})();
