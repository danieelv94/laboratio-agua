const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'guinda-ceaa': '#691B31',
                'guinda-ceaa-hover': '#A02142',
                'dorado-ocre': '#BC955B',
                'arena-claro': '#DDC9A3',
                'gris-claro': '#98989A',
                'gris-oscuro': '#6F7271',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
