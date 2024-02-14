import { Link, Head } from '@inertiajs/react';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import React from "react"
import { useRef, useState } from 'react';
import { createHeadManager } from '@inertiajs/core';

const changeDate = (date) => {
    const originalDate = new Date(date);

    const year = originalDate.getFullYear();
    const month = (originalDate.getMonth() + 1).toString().padStart(2, '0');
    const day = originalDate.getDate().toString().padStart(2, '0');

    const formattedDate = `${year}/${month}/${day}`;

    return formattedDate;
}

const convertDateFormat = (date) => {
    const yearPart = 0;
    const monthPart = 1;
    const dayPart = 2;

    const separatedPartList = date.split('/');
    
    const year = separatedPartList[yearPart];
    const month = separatedPartList[monthPart];
    const day = separatedPartList[dayPart];

    const convertedDate = year + '-' + month + '-' + day;

    return convertedDate;
}

function Task() {
    const propsData = document.getElementById('task-page').getAttribute('data-props');
    const data = JSON.parse(propsData);

    const [taskList, setTaskList] = useState(data.data);

    const addTaskRef = useRef(null);

    const openAddTaskModal = () => {
        addTaskRef.current.classList.remove('hidden');
    }

    const [taskId, setTaskId] = useState(0);
    const [taskName, setTaskName] = useState('');
    const [taskDeadLine, setTaskDeadLine] = useState('');

    const taskNameChange = (event) => {
        setTaskName(event.target.value);
    }

    const taskDeadLineChange = (event) => {
        setTaskDeadLine(event.target.value);
    }

    const addTask = () => {
        axios.post('/task/create', {
            'name' : taskName,
            'dead_line' : taskDeadLine
        })
        .then(response => {
            fetchTaskList();
            closeModal();
        });

        setTaskName('');
        setTaskDeadLine('');
    }

    const editTask = () => {
        console.log(taskId)
        axios.post('/task/update', {
            'id' : taskId,
            'name' : taskName,
            'dead_line' : taskDeadLine
        })
        .then(response => {
            fetchTaskList();
            closeModal();
        });
    }

    const editTaskRef = useRef(null);

    const openEditTaskModal = (
        taskId,
        taskName,
        taskDeadLine
    ) => {
        editTaskRef.current.classList.remove('hidden');

        setTaskId(taskId);
        setTaskName(taskName);
        setTaskDeadLine(taskDeadLine);
    }

    const closeModal = () => {
        setTaskName('');
        setTaskDeadLine('');
        addTaskRef.current.classList.add('hidden');
        editTaskRef.current.classList.add('hidden');
    }

    const fetchTaskList = async () => {
        const response = await axios.get('/task/get');
        setTaskList(response.data.task_list.data);
    };

    const deleteTask = (taskId) => {
        axios.post('/task/delete', {"id" : taskId})
        .then(response => {
            fetchTaskList();
        });
    }

    const isTaskInfoFilled = taskName && taskDeadLine;

    return (
        <>
        {/* <Head title="テスト" /> */}
            <div className='flex flex-col min-h-screen'>
                <div className=" w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                    <div className='container'>
                        <div className="mx-auto mt-3">
                            <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="p-4">
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                Todo
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                DeadLine
                                            </th>
                                            <th className='w-10'>
                                                <div className="flex justify-center items-center">
                                                    <button onClick={openAddTaskModal}>
                                                        <FontAwesomeIcon icon={faCirclePlus} size="lg" />
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {taskList.map((item, index) => (
                                            <React.Fragment key={index}>
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td className="w-4 p-4">
                                                    <div className="flex items-center">
                                                        <input
                                                            type="checkbox"
                                                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        </input>
                                                        <label className="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {item.name}
                                                </th>
                                                <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {changeDate(item.dead_line)}
                                                </td>
                                                <td>
                                                    <div className="flex justify-center items-center gap-1">
                                                        <button className='mx-auto' onClick={() => openEditTaskModal(item.id, item.name, item.dead_line)}>
                                                            <FontAwesomeIcon icon={faPenToSquare} />
                                                        </button>
                                                        <button className='mx-auto' onClick={() => deleteTask(item.id)}>
                                                            <FontAwesomeIcon icon={faCircleXmark} />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </React.Fragment>
                                            ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div ref={addTaskRef} className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden">
                <div onClick={closeModal} className="absolute w-full h-full bg-gray-900 opacity-50">
                        
                </div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                            Add New Task
                        </h3>
                        <button type="button" onClick={closeModal} className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addTaskModal">
                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span className="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Name</label>
                            <input type="text" name="name" value={taskName} onChange={taskNameChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="" />
                        </div>
                        <div className="col-span-2">
                            <input type="date" name="dead_line" value={taskDeadLine} onChange={taskDeadLineChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                        </div>
                    </div>
                    <button 
                        onClick={addTask}
                        type="submit"
                        style={{ opacity: isTaskInfoFilled ? 1 : 0.5 }}
                        disabled={!isTaskInfoFilled}
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg className="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path></svg>
                        Add new task
                    </button>
                </div>
            </div>

            <div ref={editTaskRef} className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden">
                <div onClick={closeModal} className="absolute w-full h-full bg-gray-900 opacity-50">
                        
                </div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Task
                        </h3>
                        <button type="button" onClick={closeModal} className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addTaskModal">
                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span className="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Name</label>
                            <input
                                type="text"
                                name="name"
                                value={taskName}
                                onChange={taskNameChange}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required=""
                            />
                        </div>
                        <div className="col-span-2">
                            <input
                                type="date"
                                name="dead_line"
                                value={convertDateFormat(changeDate(taskDeadLine))}
                                onChange={taskDeadLineChange}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            />
                        </div>
                    </div>
                    <button
                        onClick={editTask}
                        type="submit"
                        style={{ opacity: isTaskInfoFilled ? 1 : 0.5 }}
                        disabled={!isTaskInfoFilled}
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg className="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path></svg>
                        Edit task
                    </button>
                </div>
            </div>
        </>
    )
}

export default Task