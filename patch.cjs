const fs = require('fs');
let registry = fs.readFileSync('inc/Core/ColorRegistry.php', 'utf8');

const mapping = {
    '--pooki-header-bg-color': '--pooki-header-bg',
    '--pooki-nav-hover-color': '--pooki-nav-hover', 
    '--pooki-menu-text-color': '--pooki-menu-color', 
    '--pooki-menu-hover-color': '--pooki-menu-hover-color', 
    '--pooki-header-border-color': '--pooki-header-border',
    '--pooki-sticky-bg-color': '--pooki-sticky-bg',
    '--pooki-sticky-border-color': '--pooki-sticky-border',
    '--pooki-search-bg-color': '--pooki-search-bg',
    '--pooki-search-focus-bg-color': '--pooki-search-focus-bg',
    '--pooki-search-border-color': '--pooki-search-border-c',
    '--pooki-search-focus-border-color': '--pooki-search-focus-border-c',
    '--pooki-search-text-color': '--pooki-search-color',
    '--pooki-search-placeholder-color': '--pooki-search-placeholder',
    '--pooki-header-action-icon-color': '--pooki-action-icon-c',
    '--pooki-header-action-icon-hover-color': '--pooki-action-icon-hover-c',
    '--pooki-header-action-text-color': '--pooki-action-text-c',
    '--pooki-header-action-text-hover-color': '--pooki-action-text-hover-c',
    '--pooki-header-action-bg-color': '--pooki-action-bg',
    '--pooki-header-action-bg-hover-color': '--pooki-action-bg-hover',
    '--pooki-header-action-border-color': '--pooki-action-border',
    '--pooki-topbar-bg-color': '--pooki-topbar-bg',
    '--pooki-topbar-text-color': '--pooki-topbar-color',
    '--pooki-nav-bg-color': '--pooki-nav-bg',
    '--pooki-nav-sticky-bg-color': '--pooki-nav-sticky-bg',
    '--pooki-nav-border-top-color': '--pooki-nav-border-top-c',
    '--pooki-bottom-bar-bg-color': '--pooki-bottom-bar-bg',
    '--pooki-bottom-bar-icon-color': '--pooki-bottom-bar-icon-c',
    '--pooki-bottom-bar-icon-active-color': '--pooki-bottom-bar-icon-active-c',
    '--pooki-bottom-bar-divider-color': '--pooki-bottom-bar-divider-c',
    '--pooki-search-modal-bg-color': '--pooki-drawer-bg',
    '--pooki-search-modal-input-bg-color': '--pooki-search-modal-input-bg',
    '--pooki-search-modal-input-border-color': '--pooki-search-modal-input-border',
    '--pooki-search-modal-text-color': '--pooki-drawer-text'
};

for (const [oldVar, newVar] of Object.entries(mapping)) {
    registry = registry.replace(new RegExp(`'${oldVar}'`, 'g'), `'${newVar}'`);
}

// Change hook priority from 1 to 999
registry = registry.replace(/add_action\(\s*'wp_head',\s*\[\s*\$this,\s*'render_css_variables'\s*\],\s*1\s*\);/g, "add_action( 'wp_head', [ $this, 'render_css_variables' ], 999 );");

fs.writeFileSync('inc/Core/ColorRegistry.php', registry);
console.log('Patched ColorRegistry.php');
