const fs = require('fs');
const file = 'blocks/hero-slider/build/index.js';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(/__require\("@wordpress\/blocks"\)/g, 'wp.blocks');
content = content.replace(/__require\("@wordpress\/i18n"\)/g, 'wp.i18n');
content = content.replace(/__require\("@wordpress\/block-editor"\)/g, 'wp.blockEditor');
content = content.replace(/__require\("@wordpress\/components"\)/g, 'wp.components');
content = content.replace(/__require\("@wordpress\/element"\)/g, 'wp.element');

fs.writeFileSync(file, content, 'utf8');
console.log('Fixed WP globals in build file.');
