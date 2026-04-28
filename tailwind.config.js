import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                fitar: {
                    black: '#000000',
                    purple: '#702670',
                    dark: '#0a0a0f',
                    surface: '#1a1a2e',
                    card: '#16213e',
                    accent: '#F47920',
                    'accent-hover': '#e06d1b',
                },
                severity: {
                    low: '#10b981',
                    medium: '#f59e0b',
                    high: '#f97316',
                    critical: '#ef4444',
                },
            },
            backgroundImage: {
                'fitar-gradient': 'linear-gradient(180deg, #ffffff 0%, #f0f0f0 100%)',
                'fitar-gradient-dark': 'linear-gradient(180deg, #000000 0%, #702670 100%)',
            },
        },
    },
    plugins: [forms],
};