import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import {viteStaticCopy} from "vite-plugin-static-copy";

export default defineConfig({
    build: {
        manifest: true,
        rtl: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                assetFileNames: (css) => {
                    if (css.name.split('.').pop() == 'css') {
                        return 'css/' + `[name]` + '.css';
                    } else {
                        return 'icons/' + css.name;
                    }
                },
                entryFileNames: 'js/' + `[name]` + `.js`,
            },
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/guest/app.css",
                "resources/js/guest/app-guest.js",
                'resources/admin/scss/landing.scss',
                'resources/admin/scss/style-preset.scss',
                'resources/admin/scss/style.scss',
                'resources/admin/scss/uikit.scss',
                'resources/admin/js/certifications/index.js'
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/admin/css/plugins',
                    dest: 'css'
                },
                {
                    src: 'resources/admin/fonts',
                    dest: ''
                },
                {
                    src: 'resources/admin/images',
                    dest: ''
                },
                {
                    src: 'resources/admin/js',
                    dest: ''
                },
                {
                    src: 'resources/admin/json',
                    dest: ''
                },
                {
                    src: 'resources/admin/css',
                    dest: ''
                },
            ],
        })
    ],
});
