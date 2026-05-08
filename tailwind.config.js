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
                sans: ['ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'deep-charcoal': '#111827',
                'slate-btn': '#475569',
                'medium-gray': '#6B7280',
                'dark-gray': '#1F2937',
                'success-green': '#16A34A',
                'error-red': '#DC2626',
                'light-border': '#E5E7EB',
                'very-light-gray': '#F3F4F6',
                'off-white': '#FAFAFA',
                'light-gray': '#A3A3A3',
                'zinc-text': '#71717A',
                'warning-red': '#F83015',
            },
            spacing: {
                '112': '112px',
            },
            borderRadius: {
                '6': '6px',
                '8': '8px',
            },
            boxShadow: {
                'l1': '0px 1px 3px rgba(0, 0, 0, 0.1)',
                'l2': '0px 2px 8px rgba(0, 0, 0, 0.15)',
                'l3': '0px 4px 12px rgba(0, 0, 0, 0.15)',
                'l4': '0px 2px 16px rgba(34, 22, 22, 0.08)',
            },
            fontWeight: {
                'normal': '400',
                'semibold': '600',
            },
        },
    },

    plugins: [forms],
};
