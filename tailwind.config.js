import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
                display: ['Clash Display', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#f59e0b',
                    dark: '#d97706',
                    light: '#fbbf24',
                    bg: '#fffbeb',
                },
                dark: '#0A0A0A',
                light: '#F8F9FA',
            }
        },
    },

    plugins: [forms],
};
