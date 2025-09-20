import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['poppins', 'ui-sans-serif', 'system-ui'],
                heading: ['georgia', 'poppins', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
                primary: {
                    light: '#f5af00',
                    DEFAULT: '#f5af00',
                    dark: '#f5af00',
                },
                secondary: {
                    light: '#104791',
                    DEFAULT: '#104791',
                    dark: '#104791',
                },
                tertiary: {
                    light: '#E5E7EB',
                    DEFAULT: '#F3F4F6',
                    dark: '#374151',
                },
            },
            spacing: {
                smpad: '3rem',   // 48px
                mdpad: '6rem',   // 96px
                lgpad: '11rem',  // 176px
            },
        },
    },

    plugins: [forms],
};
