import './bootstrap';
import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Task from './src/Task';
import LifeInsuranceCard from './src/LifeInsurance/Create';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const TaskDom = () => {
    return (
        <Task />
    )
}

const LifeInsuranceTopPage = () => {
    return (
        <LifeInsuranceCard />
    )
}

if(document.getElementById('task-page')){
    createRoot(document.getElementById('task-page')).render(<TaskDom />)
}

if(document.getElementById('life_insurance_page')){
    createRoot(document.getElementById('life_insurance_page')).render(<LifeInsuranceTopPage />)
}

// const App = (props) => {
//     console.log(props); // ここでpropsを確認する
//     return (
//         <About taskList={props.taskList} />
//     )
// }

// if (document.getElementById('react-app')) {
//     const element = document.getElementById('react-app')
//     const props = JSON.parse(element.dataset.props)
//     console.log(props)
//     createRoot(document.getElementById('react-app')).render(<App {...props} />)
// }

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
