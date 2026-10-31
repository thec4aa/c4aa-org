# The C4AA.org WordPress Theme

[C4AA.org](https://c4aa.org)

A child theme of the standard [WordPress Twenty Nineteen](https://wordpress.org/themes/twentynineteen/) theme.

Our aims include:

## 1. Create a site that aligns with the Center for Artistic Activism Design Standards

We have some design standards created by [Diane Shaw](https://www.behance.net/dianeshaw), then built upon over the years in our Center for Artistic Activism print material and by subsequent designers like [Andy Outis](https://www.andyoutis.com/).

## 2. Code as few modifications as possible.

Minimize use of plugins, javascript, and other dependencies. 

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
* Make your changes in your fork in a feature branch off of `develop`
* Submit a Pull Request against the `develop` branch of the C4AA.org repo
* Reference the Issue or Request that you're attempting to solve in the PR.
* All Pull Requests will be reviewed by site administrators and changes may be requested before a PR is accepted. 

## Branches and deployment
* `develop` is the integration branch. Every push to it is built and synced to the staging site by GitHub Actions (`.github/workflows/develop.yml`).
* `master` is production. Changes get there through a pull request from `develop`, and every push to it is built and copied to the live site (`.github/workflows/main.yml`).
* Both workflows install dependencies, run `npm run prod`, then connect to the May First shell host and transfer the theme. Hosts, users, paths and keys live in the repository's Actions secrets and environments (`Staging` and `Production`), not in the repo.
* `build/` is ignored by git on purpose. The workflows compile it on every deploy, so there is nothing to commit after a CSS change beyond the Sass source.

## Local Development
* Download a recent copy of [WordPress](https://wordpress.org/), as well as [the TwentyNineteen theme](https://wordpress.org/themes/twentynineteen/) and install them locally in a directory you're comfortable working in. 
* Start a local environment and install base WordPress. We recommend [Laravel Valet](https://laravel.com/docs/10.x/valet).
* The theme expects [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/) for its custom blocks (`blocks/`) and fields (`acf-json/`).
* Clone this repo into your wp-content/themes directory. 
* Use the Node version in `.nvmrc`, then run `npm ci` to install dependencies.
* `npm run dev` - Start the Sass watcher; it compiles `src/css` into `build/`.
* `npm run prod` - One-off minified build, the same command the deploy workflows run.

## Where things are
* `functions.php` - enqueues, ACF block registration, block editor setup and the smaller tweaks.
* `src/css/` - Sass sources. `main.scss` is the entry point.
* `js/` - small plain scripts loaded on the front end, plus `editor.js` for the block editor.
* `theme.json` - palette, duotone presets, typography and block settings.
* `blocks/` - ACF blocks (person title, person email, promo image).
* `template-parts/` and `footer.php` - the few parent theme templates this theme overrides.

## Credit:

- Lara Schenck @laras126
- Steve Lambert @slambert
- Zoraida @zoracreates
- [CSS Duotone](https://cssduotone.com/)
- [Work Sans](https://fonts.google.com/specimen/Work+Sans)
- [Zilla Slab](https://fonts.google.com/specimen/Zilla+Slab)
