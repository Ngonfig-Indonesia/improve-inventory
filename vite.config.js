import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import FullReload from "vite-plugin-full-reload";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
        FullReload(["resources/views/**", "routes/**"]),
    ],
});
