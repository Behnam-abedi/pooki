# Pooki Theme Architecture

## Frontend
- Build Tool: Vite
- CSS Framework: Tailwind CSS
- JS Framework: Alpine.js

## Backend
- Language: PHP 8.4
- Platform: Native WordPress (WooCommerce compatible)
- Architecture: SOLID principles, Component-based design

## Status
- Step 1 (Scaffolding): Complete
- Step 2 (Core Templates & Header/Footer Components): Complete
- Step 3: Implemented SOLID Asset Management (`Pooki_Assets`) in `inc/core/` to enqueue Vite-compiled CSS and JS with ES Module support.
- Step 4: Created front-page.php and a reusable, niche-agnostic Hero UI component using Tailwind CSS and semantic HTML.
- Step 5: Implemented SOLID Native Customizer API (Pooki_Customizer) to dynamically manage niche-agnostic Hero content, ensuring LCP image receives fetchpriority='high'.
- Step 6: Implemented SOLID WooCommerce Core Support (`Pooki_WooCommerce`) to enable native WooCommerce integration and product gallery features.
- Step 7: Configured WooCommerce layout wrappers natively using hooks to enforce Tailwind CSS container structures and semantic <main> tags, bypassing default WC wrappers.
- Step 8: Implemented SOLID Navigation system (Pooki_Menus) and integrated dynamic wp_nav_menu into the Tailwind/Alpine navbar component.
- Step 9: Implemented Alpine.js Global Store (`Alpine.store('cart')`) and a frictionless Slide-out Cart Drawer UI component for optimized UX.
- Step 10: Implemented SOLID WooCommerce AJAX cart fragments (Pooki_Cart_Ajax) and configured Alpine.js to auto-open the sliding drawer upon 'added_to_cart' events.
- Step 11: Implemented SOLID WooCommerce Loop modifications (`Pooki_WooCommerce_Loop`) using filters to enforce a Tailwind CSS Grid structure for product archives without template overrides.
- Step 12: Implemented SOLID WooCommerce Single Product layout wrappers (`Pooki_WooCommerce_Single`) using native hooks (priority injection) to create a responsive Tailwind CSS grid for the gallery and summary areas.
- Step 13: Implemented Single Product AJAX Add-to-Cart logic in Vite to prevent page reloads and trigger the Alpine.js sliding drawer automatically.
- Step 14: Implemented Structural SEO by globally injecting Rank Math Breadcrumbs into WooCommerce wrappers and optimized Category Archive Descriptions with readable Tailwind utility classes.
- Step 15: Polished Product Card UI internally using WooCommerce hooks in Pooki_WooCommerce_Loop to inject Tailwind padding wrappers, typography, and button styles without template overrides.
- Step 16: Configured local typography architecture for Vazirmatn font and global RTL support in Tailwind CSS, maintaining our zero-CDN policy.
- Step 17: Implemented 'Featured Products' component on the Front Page utilizing native WooCommerce shortcodes, automatically inheriting our globally injected Tailwind CSS loop wrappers.
- Step 18: Created page.php template to render standard WordPress pages (including WooCommerce Cart and Checkout shortcode pages) with a centralized Tailwind CSS layout.
- Step 19: Created single.php (with fetchpriority for LCP) and 404.php to complete core WordPress templates, applying semantic HTML and Tailwind CSS.
- Step 20: Implemented global Footer component utilizing registered WP menus and native Customizer API for dynamic copyright text.
- Step 21: Created search.php template with a responsive Tailwind CSS grid to display search results uniformly, completing the core WordPress template hierarchy.
- Step 22: Implemented SOLID WooCommerce Forms optimization (`Pooki_WooCommerce_Forms`) via native filters to remove checkout friction and globally inject Tailwind CSS input styles.
- Step 23: Implemented Pooki_Performance class to aggressively dequeue default WooCommerce CSS bloat (including block styles), relying entirely on our local Vite/Tailwind build for maximum Core Web Vitals.
- Step 24: Implemented WooCommerce notice template overrides (success, error, notice) to restore and modernize alert UI using Tailwind CSS after dequeueing default styles, optimized for RTL.
- Step 25: Implemented a dedicated WooCommerce Product Search form component and integrated it seamlessly into the global Navbar using Tailwind CSS.
- Step 26: Implemented modern 2-column sticky checkout layout (Pooki_WooCommerce_Checkout) strictly utilizing native WooCommerce actions to inject Tailwind CSS grid wrappers.
- Step 27: Implemented modern hook-based layouts (Pooki_WooCommerce_Account) for the WooCommerce My Account dashboard and Login/Register pages utilizing Tailwind CSS.
- Step 28: Implemented a Native Custom Theme Options Panel (Pooki_Theme_Options) using the WordPress Settings API to manage global store variables without ACF.
- Step 29: Created a dynamic frontend Top Bar component (`top-bar.php`) that securely consumes data from the native Theme Options API to display global announcements and support info.
- Step 30: Enabled WooCommerce native product gallery features (Zoom, Lightbox, Slider) and successfully overrode the global quantity input template using Alpine.js and Tailwind CSS for a frictionless UI.
- Step 31: Finalized asset pipeline and executed `npm run build` via Vite to compile Tailwind CSS and Alpine.js, successfully resolving 404 asset errors and applying the global UI design.
- Step 32: Configured Vite Rollup options to disable filename hashing and implemented native PHP filemtime() cache-busting in theme init to resolve 404 asset errors.
- Fixed enqueue paths in Pooki_Assets to correctly target assets/dist/style.css and assets/dist/main.js.
- Step 33: Fixed Tailwind CSS content paths in tailwind.config.js to correctly scan all PHP template files and re-ran build to populate the final stylesheet.
- Step 34: Migrated Tailwind configuration to v4 CSS-driven architecture (@source and @theme) and deleted tailwind.config.js, successfully generating fully populated stylesheets.
- Step 35: Implemented Pooki_Security class to harden WordPress by removing version generators and `<head>` bloat (RSD, WLW, OEmbed), improving both security and Core Web Vitals.
- Step 36: Implemented Pooki_SEO class to seamlessly override default WooCommerce breadcrumbs with Rank Math SEO breadcrumbs and removed WooCommerce generator tags for enhanced security and schema integrity.
- Step 37: Implemented advanced security (disabled XML-RPC, blocked User Enumeration) and deep performance fixes (dequeued WC Cart Fragments on non-shop pages, set up preconnects) in their respective SOLID classes.
- Step 39: Refined WordPress lifecycle hook for user enumeration security (template_redirect) and injected custom brand colors for Pooki into Tailwind v4 configuration.
- Resolved font 404 pathing errors and successfully integrated Vazirmatn base typography with Tailwind v4, ensuring fonts are processed and bundled into `assets/dist/`.
- Configured Vite with `base: './'` to enforce relative URL paths for compiled assets in CSS, resolving WordPress subdirectory routing issues.
- Built a semantic, RTL-compliant global Header containing the brand logo, center navigation, and left-aligned actions (Search, Cart, Login).
- Implemented an off-canvas Cart Drawer sliding from the left (RTL) powered natively by an Alpine.js global store (`$store.cart.isOpen`) and styled with Tailwind CSS.
- Refined the header UI spacing (`gap-x-10`) and styled the minimalist Search input and User/Cart action icons according to the mockup design using Tailwind CSS.
- Scaffolded a professional, OOP native Theme Options panel using the Singleton design pattern in `inc/admin/class-pooki-theme-options.php` (no ACF bloat).
- Registered AJAX persistence (`wp_ajax_pooki_save_theme_options`) for the Theme Options panel with a seamless `fetch()` submission to save the Sticky Header, Logo Width, and Colors securely via nonces.
- Re-engineered the header (`navbar.php`) layout to centrally position a max-width responsive search bar, migrating it into an Alpine.js component (`pookiSearch`).
- Hooked up live product searching via the `wp_ajax_nopriv_pooki_live_search` endpoint in `inc/core/class-pooki-woocommerce.php`, returning JSON arrays to dynamically render product titles, prices, and thumbnails within the header dropdown.
- Fixed the AJAX persistence within the native Theme Options panel by properly scoping field sanitization and ensuring accurate nonce verification during `fetch()` submissions.
- Integrated the native WordPress Media Uploader (`wp.media`) into the Theme Options panel to manage custom logo selection alongside a live preview.
- Extended the `wp_head` CSS injection to output advanced CSS variables for sticky header interactions (heights, background colors, and border colors).
- Added comprehensive live search input customizations (height, typography, backgrounds, borders, text color, placeholder color, and focus states) to the Theme Options panel, injected as root CSS variables and applied dynamically via `.pooki-search-input` class in Tailwind's `@layer components`.
- Added a "Header Actions" repeater field in Theme Options powered by a pure vanilla JS builder, allowing unlimited dynamic header buttons (Cart, Account, Custom) with custom SVGs, sizes, colors, and borders securely injected into the frontend.
- Created `pooki_to_persian_num()` helper in `functions.php` to securely convert integers like the WooCommerce Cart badge into Persian digits.
- Implemented Alpine.js `@scroll.window` tracking on `navbar.php` to dynamically swap variables and utility classes (like `shadow-md`), creating a buttery smooth sticky navigation state transition natively via Tailwind.
