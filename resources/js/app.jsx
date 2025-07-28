import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { Toaster } from 'sonner';
import { ThemeProvider } from './Components/Dark/ThemeProvider';

// Nama default aplikasi
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Inisialisasi aplikasi Inertia
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),

    setup({ el, App, props }) {
        const root = createRoot(el);

        // Membungkus komponen utama dengan ThemeProvider dan Toaster
        root.render(
            <ThemeProvider defaultTheme="light" storageKey="current-theme">
                <App {...props} />
                <Toaster position="top-center" richColors />
            </ThemeProvider>
        );
    },

    progress: {
        color: '#4B5563', // Tailwind gray-600
    },
});
