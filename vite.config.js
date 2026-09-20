import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'assets/src/js/main.js'),
        style: resolve(__dirname, 'assets/src/css/main.css')
      }
    }
  }
});
