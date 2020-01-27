# The C4AA.org WordPress Theme

[C4AA.org](https://c4aa.org)

A child theme of the standard [WordPress Twenty Nineteen](https://wordpress.org/themes/twentynineteen/) theme.

Our aims are:

## 1. Create a site that aligns with the Center for Artistic Activism Design Standards

We have some design standards created by [Diane Shaw](https://www.behance.net/dianeshaw), then built upon over the years in our Center for Artistic Activism print material.

## 2. Code as few modifications as possible.

Minimize use of plugins, javascript, and other dependencies. Hopefully avoid front-end plugins entirely.

### Plugins we are using:

- [Our Lazy Loader](https://github.com/thec4aa/simple-lazy-loader)
- [Gutenberg](https://wordpress.org/plugins/gutenberg/) - just to get upcoming features early.
- [Akismet](https://wordpress.org/plugins/akismet/) - we don't really use comments, but why not.
- Jetpack - we use downtime monitoring, brute force protection, carousel gallery, markdown, extra widgets, post via email, social network sharing, etc.
- [Give - Donation Plugin](https://wordpress.org/plugins/give/) - we use this to process and manage donations. We're subscribers and use some of their add-ons as well; Annual Receipts, Currency Switcher, Email Reports, Fee Recovery, Form Field Manager, MailChimp, Manual Donations, PDF Receipts, Recurring Donations, and Tributes.
- [A Simple Lazy Loader](https://github.com/thec4aa/simple-lazy-loader) - especially because international and/or mobile users are a larger audience for the site.  @Lara126 wrote this based on a tutorial.
- [EWWW Image Optimizer](https://wordpress.org/plugins/ewww-image-optimizer/) - not everyone using the site knows how to optimize images or wants to bother with it.
- Advanced Custom Fields PRO
- [Blubrry PowerPress](https://wordpress.org/plugins/powerpress/) - for our podcast
- [Contact Form 7](https://wordpress.org/plugins/contact-form-7/)
- [Post SMTP](https://postmansmtp.com/)
- [Comet Cache](https://wordpress.org/plugins/comet-cache/)
- [Login Lockdown](https://wordpress.org/plugins/login-lockdown/)
- [Redirection](https://wordpress.org/plugins/redirection/)
- [Widgets Reloaded](https://wordpress.org/plugins/widgets-reloaded/)
- [WP-Matomo](https://wordpress.org/plugins/wp-piwik/) for our Matomo stats install.


## Local Development

Once the theme is cloned, run `npm install` to download dependencies.

* `npm run dev` - Start the Sass watcher for development.
* `npm run prod` – Minify CSS before opening a PR.

## Credit:

- Lara Schenck @laras126
- Steve Lambert @slambert
- Zoraida @zoracreates
- [CSS Duotone](https://cssduotone.com/)
- [Roboto Slab](https://fonts.google.com/specimen/Roboto+Slab)
- [Raleway Font](https://www.theleagueofmoveabletype.com/raleway) from the League of Moveable Type
