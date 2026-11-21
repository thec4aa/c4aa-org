// Prunes the Twenty Nineteen parent stylesheet down to what the C4AA site uses
// and writes it to src/css/_twentynineteen.css, which main.scss imports first.
//
// Usage: node bin/trim-parent-css.mjs path/to/twentynineteen/style.css
import postcss from 'postcss';
import { readFileSync, writeFileSync } from 'fs';
import { gzipSync } from 'zlib';
import { fileURLToPath } from 'url';

const input = process.argv[2];
if (!input) {
  console.error('Usage: node bin/trim-parent-css.mjs path/to/twentynineteen/style.css');
  process.exit(1);
}

const out = fileURLToPath(new URL('../src/css/_twentynineteen.css', import.meta.url));
const css = readFileSync(input, 'utf8');
const version = (css.match(/^\s*Version:\s*(.+?)\s*$/m) || [])[1];
if (!version) {
  console.error('No "Version:" line found in ' + input);
  process.exit(1);
}

// First match wins, so a comment selector inside :lang() counts as lang.
const categories = [
  ['lang', /:lang\(/],
  // Comments area, pingbacks, discussion meta in the post header, latest-comments block.
  ['comments', /comment|discussion|#respond|pingback|trackback|bypostauthor|\.says(?![\w-])|logged-in-as|post-author-badge/],
  ['widgets', /widget/],
  // Classic (pre-block) galleries and captions. Does not match .wp-block-gallery or .blocks-gallery-*.
  // .gallery-caption stays: Jetpack's slideshow block puts that class on its figcaptions.
  ['classic gallery/caption', /(?<![\w-])\.gallery(?![\w-])|\.gallery-(?!caption)|\.wp-caption/],
];

const root = postcss.parse(css);
const removed = Object.fromEntries(categories.map(([name]) => [name, { selectors: 0, rules: 0 }]));
const inKeyframes = (rule) => rule.parent && rule.parent.type === 'atrule' && /keyframes$/i.test(rule.parent.name);

root.walkRules((rule) => {
  if (inKeyframes(rule)) return;
  const keep = [];
  for (const sel of rule.selectors) {
    const cat = categories.find(([, re]) => re.test(sel));
    if (cat) removed[cat[0]].selectors++;
    else keep.push(sel);
  }
  if (keep.length === rule.selectors.length) return;
  if (keep.length === 0) {
    // Attribute the whole rule to the category of its first selector.
    removed[categories.find(([, re]) => re.test(rule.selectors[0]))[0]].rules++;
    rule.remove();
  } else {
    rule.selectors = keep;
  }
});

root.walkComments((c) => c.remove());

// Drop @media/@supports blocks left empty, innermost first.
const walkEmpty = () => {
  let n = 0;
  root.walkAtRules(/^(media|supports)$/i, (at) => {
    if (at.nodes && at.nodes.length === 0) { at.remove(); n++; }
  });
  return n;
};
let emptied = 0;
for (let n = walkEmpty(); n; n = walkEmpty()) emptied += n;

const header = `/*
 * Generated file, do not edit by hand.
 * Twenty Nineteen ${version} style.css with these removed: selectors containing :lang(),
 * comments area (comment, discussion, #respond, pingback, trackback, bypostauthor, ...),
 * widgets, and classic gallery/caption (.gallery, .gallery-item..., .wp-caption*; .gallery-caption
 * is kept for Jetpack slideshows). Comments are stripped.
 * Regenerate: node bin/trim-parent-css.mjs path/to/twentynineteen/style.css
 */
`;
const result = header + root.toString().replace(/\n{3,}/g, '\n\n').trim() + '\n';
writeFileSync(out, result);

const gz = (s) => gzipSync(Buffer.from(s), { level: 9 }).length;
const sels = Object.values(removed).reduce((a, r) => a + r.selectors, 0);
const rules = Object.values(removed).reduce((a, r) => a + r.rules, 0);
console.log(
  `Twenty Nineteen ${version}: removed ${sels} selectors, ${rules} rules, ${emptied} empty at-rules ` +
  `(${Object.entries(removed).map(([k, v]) => `${k} ${v.selectors}/${v.rules}`).join(', ')}); ` +
  `${css.length} raw / ${gz(css)} gz -> ${result.length} raw / ${gz(result)} gz`
);
