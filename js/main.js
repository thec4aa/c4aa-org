// Front-end entry point. esbuild bundles these into build/main.js (see
// package.json), which functions.php enqueues as one deferred script. Order
// matters only in that menu.js and clipPaths.js both touch the header; keep
// it as the files were loaded before they were bundled.
import './menu.js';
import './scrolling.js';
import './clipPaths.js';
import './externalLinks.js';
