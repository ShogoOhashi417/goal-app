import './bootstrap';
import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Task from './src/Task';
import LifeInsuranceCard from './src/LifeInsurance/Create';
import Income from './src/Income/Index';
import Expenditure from './src/Expenditure/Index';

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

const IncomePage = () => {
    return (
        <Income />
    )
}

const ExpenditurePage = () => {
    return (
        <Expenditure />
    )
}

if (document.getElementById('task-page')){
    createRoot(document.getElementById('task-page')).render(<TaskDom />)
}

if(document.getElementById('life_insurance_page')){
    createRoot(document.getElementById('life_insurance_page')).render(<LifeInsuranceTopPage />)
}

if (document.getElementById('income_page')) {
    createRoot(document.getElementById('income_page')).render(<IncomePage />)
}

if (document.getElementById('expenditure_page')) {
    createRoot(document.getElementById('expenditure_page')).render(<ExpenditurePage />)
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
