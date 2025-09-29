// vite.config.js
import { defineConfig } from "file:///C:/Users/Default.DESKTOP-VOE9PJN/Desktop/lelo/Capstone-Project/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/Default.DESKTOP-VOE9PJN/Desktop/lelo/Capstone-Project/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
      ],
      refresh: true
    })
  ]
});
export {
  vite_config_default as default
};
