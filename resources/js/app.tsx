import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = 'Capitalise';

createInertiaApp({
    title: () => `${appName}`,
    resolve: (name) => resolvePageComponent(`./${name}.tsx`, import.meta.glob('./**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

// Horrible hack for the sake of removing dark mode. And I'm sorry.
document.documentElement.classList.toggle('dark', false);
