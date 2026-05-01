import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'from-purple-700',
        'via-red-600',
        'to-yellow-400',
        'from-violet-600',
        'via-fuchsia-500',
        'to-blue-500',
        'from-amber-500',
        'via-yellow-300',
        'to-orange-500',
        'from-teal-400',
        'via-cyan-400',
        'to-emerald-500',
        'from-slate-500',
        'via-zinc-400',
        'to-stone-500',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
