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
