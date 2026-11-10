// Fade duotone images in post content to full colour on hover (#283).
//
// Core's duotone is filter: url(#wp-duotone-…), which CSS can't interpolate, so
// on its own it can only snap. Instead, on first hover we lay an unfiltered copy
// of the image exactly over it and fade that in (styles in
// src/css/content/_images.scss). Doing it here rather than in PHP leaves the
// server HTML alone, so feeds, emails, reader modes and core's lightbox all see
// the page as it was, and at rest nothing is drawn differently.
(function () {
	// No hover, or no motion wanted: leave these to the CSS snap-on-hover rule.
	if (!window.matchMedia('(hover: hover)').matches) return;
	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

	// Blocks whose duotone class covers their images. Cover blocks are left out
	// on purpose: their image sits behind text.
	const BLOCKS = '.wp-block-image, .wp-block-gallery, .wp-block-post-featured-image, .wp-block-c4aa-org-promo-image';
	// wp-duotone-unset-* means "no filter", so there's nothing to fade.
	const HAS_DUOTONE = /(^|\s)wp-duotone-(?!unset)/;

	const copies = new WeakMap();

	function makeCopy(img) {
		const copy = document.createElement('img');
		copy.src = img.currentSrc || img.src; // already loaded, so no new request
		copy.alt = '';
		copy.setAttribute('aria-hidden', 'true');
		copy.className = 'c4aa-duotone-fade-copy';
		copy.decoding = 'async';
		// Before the image, not after: core's lightbox shows its button with
		// img:hover + button, and sizes it from the image's parent.
		img.before(copy);

		// The copy is placed using the image's offsets, which only works if both
		// measure from the same box. Not true inside a static table cell, say;
		// give up there and let the snap rule have it.
		if (copy.offsetParent !== img.offsetParent) {
			copy.remove();
			img.removeAttribute('data-duotone-fade');
			return null;
		}
		return copy;
	}

	// Measured on every hover, so resizes and lazy layout shifts don't matter.
	// offset/client sizes ignore transforms, so rotated figures are fine, and
	// client* leaves out any border on the image. Everything that decides the
	// copy's box goes inline, where theme and core image rules can't reach it.
	function place(img, copy) {
		const style = window.getComputedStyle(img);
		Object.assign(copy.style, {
			top: img.offsetTop + img.clientTop + 'px',
			left: img.offsetLeft + img.clientLeft + 'px',
			width: img.clientWidth + 'px',
			height: img.clientHeight + 'px',
			margin: '0',
			padding: '0',
			border: '0',
			boxSizing: 'border-box',
			objectFit: style.objectFit,
			objectPosition: style.objectPosition,
			borderRadius: style.borderRadius,
			filter: 'none',
		});
	}

	function show(event) {
		if (event.pointerType === 'touch') return;
		const img = event.currentTarget;
		if (!img.hasAttribute('data-duotone-fade') || !img.complete) return;

		let copy = copies.get(img);
		if (!copy) {
			copy = makeCopy(img);
			if (!copy) return;
			copies.set(img, copy);
		}
		place(img, copy);

		// Wait for the copy to be decoded so the fade doesn't start on a blank
		// image, then force a layout so a freshly inserted copy transitions from
		// opacity 0 instead of appearing at 1.
		copy.decode().catch(function () {}).then(function () {
			if (!img.matches(':hover')) return;
			void copy.offsetWidth;
			copy.classList.add('is-on');
		});
	}

	function hide(event) {
		const copy = copies.get(event.currentTarget);
		if (copy) copy.classList.remove('is-on');
	}

	document.querySelectorAll('.entry .entry-content :is(' + BLOCKS + ')').forEach(function (block) {
		if (!HAS_DUOTONE.test(block.className)) return;

		block.querySelectorAll('img').forEach(function (img) {
			if (img.closest('.u-duotone-sticky, [class*="wp-duotone-unset"]')) return;
			if (img.hasAttribute('data-duotone-fade')) return; // nested blocks

			// Marks it as ours, which also takes it out of the CSS snap rule. An
			// attribute, not a class: core's lightbox rewrites the img's whole class
			// attribute when it opens and closes, but leaves other attributes alone.
			img.setAttribute('data-duotone-fade', '');
			img.addEventListener('pointerenter', show);
			img.addEventListener('pointerleave', hide);
			// Opening the lightbox covers the image before the pointer leaves it.
			img.addEventListener('click', hide);
		});
	});
})();
