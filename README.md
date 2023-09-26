# The C4AA.org WordPress Theme

[C4AA.org](https://c4aa.org)

A child theme of the standard [WordPress Twenty Nineteen](https://wordpress.org/themes/twentynineteen/) theme.

Our aims are:

## 1. Create a site that aligns with the Center for Artistic Activism Design Standards

We have some design standards created by [Diane Shaw](https://www.behance.net/dianeshaw), then built upon over the years in our Center for Artistic Activism print material and by subsequent designers like [Andy Outis](https://www.andyoutis.com/).

## 2. Code as few modifications as possible.

Minimize use of plugins, javascript, and other dependencies. Hopefully avoid front-end plugins entirely.

### Plugins we are using:

- [Gutenberg](https://wordpress.org/plugins/gutenberg/) - just to get upcoming features early.
- [Akismet](https://wordpress.org/plugins/akismet/) - we don't really use comments, but why not.
- Jetpack - we use downtime monitoring, brute force protection, carousel gallery, markdown, extra widgets, post via email, social network sharing, etc.
- [Give - Donation Plugin](https://wordpress.org/plugins/give/) - we use this to process and manage donations. We're subscribers and use some of their add-ons as well; Annual Receipts, Currency Switcher, Email Reports, Fee Recovery, Form Field Manager, MailChimp, Manual Donations, PDF Receipts, Recurring Donations, and Tributes.
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


# Contributing to this site
C4AA welcomes all contributions to the C4AA website. 

## Understanding Issues and Requests
* We use GitHub Issues to tracking problems, bugs and feature requests for the website. If you see something wrong with the site, or some change you think would be helpful, feel free to create an Issue and we'll review it. 
* Issues marked with the "request" tag have been created by the site administrators and generally reference one or more Issues. These represent "tasks" or "actions" requested by the site administrators and are a great way to push the site forward and make things better. If "issues" represent a problem, "requests" represent a proposed solution that we'd like to see actioned. 
* To make code contributions to the codebase, please follow the guidelines below. 

## Making code contributions
To participate, please follow [asmeurer's](https://github.com/asmeurer) [Open Source Git Workflow](https://www.asmeurer.com/git-workflow/).

To summarize briefly:
* Fork the repo
* Make your changes in your fork in a feature branch off of master
* Submit a Pull Request against the master branch of the C4AA.org repo
* Reference the Issue or Request that you're attempting to solve in the PR.
* All Pull Requests will be reviewed by site administrators and changes may be requested before a PR is accepted. 

## Local Development
* Download a recent copy of [WordPress](https://wordpress.org/), as well as [the TwentyNineteen theme](https://wordpress.org/themes/twentynineteen/) and install them locally in a directory you're comfortable working in. 
* Start a local environment and install base WordPress. We recommend [Laravel Valet](https://laravel.com/docs/10.x/valet).
* Clone this repo into your wp-content/themes directory. 
* Once the theme is cloned, run `npm install` to download dependencies.
* `npm run dev` - Start the Sass watcher for development.
* `npm run prod` – Minify CSS before opening a PR.

## Credit:

- Lara Schenck @laras126
- Steve Lambert @slambert
- Zoraida @zoracreates
- [CSS Duotone](https://cssduotone.com/)
- [Roboto Slab](https://fonts.google.com/specimen/Roboto+Slab)
- [Raleway Font](https://www.theleagueofmoveabletype.com/raleway) from the League of Moveable Type
