import './bootstrap';
import '../css/app.css';
import React, { Component } from 'react';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createHeadManager } from '@inertiajs/core';

import Task from './src/Task';
import Sample from './Components/Sample';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const TaskDom = () => {
    return (
        <Task />
    )
}

const SampleDom = () => {
    return (
        <Sample />
    )
}

if(document.getElementById('app')){
    createRoot(document.getElementById('app')).render(<TaskDom />)
}

if (document.getElementById('example')) {
    createRoot(document.getElementById('example')).render(<SampleDom />)
}
// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
//     setup({ el, App, props }) {
//         const root = createRoot(el);

//         root.render(<App {...props} />);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });
