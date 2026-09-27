const fs = require('fs');
let css = fs.readFileSync('assets/src/css/main.css', 'utf8');

css = css.replace(/@import "swiper\/css";/g, '');
css = css.replace(/@import "swiper\/css\/navigation";/g, '');
css = css.replace(/@import "swiper\/css\/pagination";/g, '');
css = css.replace(/\r?\n\r?\n\r?\n/g, '\n\n');

css = `@import "swiper/css";\n@import "swiper/css/navigation";\n@import "swiper/css/pagination";\n` + css;

fs.writeFileSync('assets/src/css/main.css', css.trim() + '\n');
