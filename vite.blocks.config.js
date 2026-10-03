import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'blocks/hero-slider/build',
    emptyOutDir: false,
    rollupOptions: {
      input: 'blocks/hero-slider/src/index.jsx',
      output: {
        entryFileNames: 'index.js',
        format: 'iife',
        globals: {
          '@wordpress/blocks': 'wp.blocks',
          '@wordpress/i18n': 'wp.i18n',
          '@wordpress/block-editor': 'wp.blockEditor',
          '@wordpress/components': 'wp.components',
          '@wordpress/element': 'wp.element'
        }
      },
      external: [
        '@wordpress/blocks',
        '@wordpress/i18n',
        '@wordpress/block-editor',
        '@wordpress/components',
        '@wordpress/element'
      ],
    }
  },
  esbuild: {
    jsx: 'classic',
    jsxFactory: 'wp.element.createElement',
    jsxFragment: 'wp.element.Fragment'
  }
});
