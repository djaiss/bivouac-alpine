import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      valetTls: 'alpine.test',
    }),
    inject({
      htmx: 'htmx.org'
    }),
  ],
});
