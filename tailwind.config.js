const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans:    ['DM Sans', ...defaultTheme.fontFamily.sans],
                display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                body:    ['"DM Sans"', 'system-ui', 'sans-serif'],
            },
            colors: {
                gold:      '#C9A96E',
                'gold-dk': '#A88948',
                accent:    '#1A1A1A',
            },
            aspectRatio: {
                fashion: '3 / 4',
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
