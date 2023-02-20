const defaultTheme = require('tailwindcss/defaultTheme');
const { Icons } = require('tailwindcss-plugin-icons')
/**
 * @type {import('tailwindcss-plugin-icons').Options}
 */
const options = ({ theme }) => ({
    heroicons: {
        icons: {
            'plus-circle': {
                cursor: 'pointer',
                color: theme('colors.emerald.600'),
                '&:hover': {
                    color: theme('colors.emerald.800')
                }
            },
            'trash?bg': {}
        },
        includeAll: true,
        scale: iconName => (iconName.endsWith('-20-solid') ? 1.25 : 1.5),
        location: 'https://esm.sh/@iconify-json/heroicons@1.1.9/icons.json'
    }
})

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require("daisyui"),
        Icons(options)
    ],
};

