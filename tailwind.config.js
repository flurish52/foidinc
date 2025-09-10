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
                sans: ['Nunito', 'ui-sans-serif', 'system-ui'],
                heading: ['Poppins', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
                primary: {
                    light: '#60A5FA',
                    DEFAULT: '#2563EB',
                    dark: '#1E40AF',
                },
                secondary: {
                    light: '#9CA3AF',
                    DEFAULT: '#374151',
                    dark: '#111827',
                },
                tertiary: {
                    light: '#F9FAFB',
                    DEFAULT: '#F3F4F6',
                    dark: '#E5E7EB',
                },
            },
        },
    },

    plugins: [forms],
};
