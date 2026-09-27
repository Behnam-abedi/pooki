const fs = require('fs');
const content = fs.readFileSync('inc/admin/class-pooki-theme-options.php', 'utf8');
const formStart = content.indexOf('<form id="pooki-settings-form"');
const formEnd = content.indexOf('</form>', formStart);
const formContent = content.substring(formStart, formEnd);
const divStarts = (formContent.match(/<div/ig) || []).length;
const divEnds = (formContent.match(/<\/div>/ig) || []).length;
console.log('Divs opened:', divStarts, 'Divs closed:', divEnds);
