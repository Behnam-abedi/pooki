<?php
require_once 'wp-load.php';
$colors = \Pooki\Core\ColorRegistry::get_instance()->get_registered_colors();
$tw = [];
foreach($colors as $key => $c) {
    $tw[str_replace('_', '-', $key)] = 'var(' . $c['css_var'] . ')';
}

$tw_json = json_encode($tw, JSON_PRETTY_PRINT);
$tw_json = str_replace("\n", "\n                ", $tw_json);

$config = "/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './*.php',
        './inc/**/*.php',
        './template-parts/**/*.php',
        './assets/src/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                pooki: {$tw_json}
            }
        },
    },
    plugins: [],
};
";

file_put_contents('tailwind.config.js', $config);
echo "Updated tailwind.config.js";
