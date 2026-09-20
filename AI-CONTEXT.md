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
