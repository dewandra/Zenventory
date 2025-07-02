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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'inter': ['Inter', 'sans-serif'], // Menambahkan font Inter
            },
            // Ini adalah struktur yang benar dan akan berfungsi
            backgroundImage: {
                'login-bg': "url('https://images.unsplash.com/photo-1586528116311-06924151d145?q=80&w=1974&auto=format&fit=crop')"
            }
        },
    },

    plugins: [forms],
};