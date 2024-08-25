import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import React from "react"
import { useRef, useState } from 'react';

function Expenditure() {
    let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    const propsData = document.getElementById('expenditure_page').getAttribute('data-props');
    const data = JSON.parse(propsData);

    const [expenditureInfoList, setExpenditureInfoList] = useState(data);

    const [expenditureId, setExpenditureId] = useState(0);
    const [expenditureName, setExpenditureName] = useState('');
    const [expenditureAmount, setExpenditureAmount] = useState(0);

    const changeExpenditureName = (event) => {
        setExpenditureName(event.target.value);
    }

    const changeExpenditureAmount = (event) => {
        setExpenditureAmount(parseInt(event.target.value));
    }

    const addExpenditureRef = useRef(null);
    const updateExpenditureRef = useRef(null);

    const openAddModal = () => {
        addExpenditureRef.current.classList.remove('hidden');
    }

    const openUpdateModal = (expenditureId, expenditureName, expenditureAmount) => {
        setExpenditureId(expenditureId);
        setExpenditureName(expenditureName);
        setExpenditureAmount(expenditureAmount);
        updateExpenditureRef.current.classList.remove('hidden');
    }

    const closeModal = () => {
        addExpenditureRef.current.classList.add('hidden');
        updateExpenditureRef.current.classList.add('hidden');
    }

    const getInfo = async () => {
        const response = await axios.get('/expenditure/get');
        setExpenditureInfoList(response.data.expenditure_info_list);
    }

    const addExpenditure = () => {
        axios.post('/expenditure/add', {
            'expenditure_name' : expenditureName,
            'expenditure_amount': expenditureAmount,
            '_token' : csrfToken
        })
        .then(response => {
            getInfo();
            closeModal();
        });

        setExpenditureName('');
        setExpenditureAmount(0);
    }

    const updateExpenditure = () => {
        axios.post('/expenditure/update', {
            'id' : expenditureId,
            'expenditure_name' : expenditureName,
            'expenditure_amount': expenditureAmount,
            '_token' : csrfToken
        })
        .then(response => {
            getInfo();
            closeModal();
        });

        setExpenditureId(0);
        setExpenditureName('');
        setExpenditureAmount(0);
    }

    const deleteExpenditure = (expenditureId) => {
        if (!confirm('本当にこの支出を削除しますか？')) {
            return;
        }
        
        axios.post('/expenditure/delete', {
            'id' : expenditureId,
            'expenditure_name' : expenditureName,
            'expenditure_amount': expenditureAmount,
            '_token' : csrfToken
        })
        .then(response => {
            getInfo();
        });
    }

    return (
        <>
            <div className='flex flex-col min-h-screen'>
                <div className=" w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                    <div className='container'>
                        <div className="mx-auto mt-3">
                            <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="px-6 py-3">
                                                支出名
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                金額
                                            </th>
                                            <th className='w-10'>
                                                <div className="flex justify-center items-center">
                                                    <button onClick={openAddModal}>
                                                        <FontAwesomeIcon icon={faCirclePlus} size="lg" />
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {expenditureInfoList.map((item, index) => (
                                            <React.Fragment key={index}>
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {item.name}
                                                </th>
                                                <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {item.amount}
                                                </td>
                                                
                                                <td>
                                                    <div className="flex justify-center items-center gap-1">
                                                        <button className='mx-auto' onClick={() => openUpdateModal(item.id, item.name, item.amount)}>
                                                            <FontAwesomeIcon icon={faPenToSquare} />
                                                        </button>
                                                        <button className='mx-auto' onClick={() => deleteExpenditure(item.id)}>
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

            <div ref={addExpenditureRef} className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden">
                <div
                    onClick={closeModal}
                    className="absolute w-full h-full bg-gray-900 opacity-50"
                >
                </div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                            支出を登録する
                        </h3>
                        <button
                            type="button"
                            onClick={closeModal}
                            className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="addTaskModal"
                        >
                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                支出名
                            </label>
                            <input
                                type="text"
                                name="expenditure_name"
                                value={expenditureName}
                                onChange={changeExpenditureName}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="例) 給料"
                            />
                        </div>
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                金額
                            </label>
                            <input
                                type="number"
                                name="amount"
                                value={expenditureAmount}
                                onChange={changeExpenditureAmount}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                min="1"
                            />
                        </div>
                    </div>
                    <button
                        onClick={addExpenditure}
                        type="submit"
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg className="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path></svg>
                        支出を登録する
                    </button>
                </div>
            </div>

            <div ref={updateExpenditureRef} className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden">
                <div
                    onClick={closeModal}
                    className="absolute w-full h-full bg-gray-900 opacity-50"
                >
                </div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                            支出を編集する
                        </h3>
                        <button
                            type="button"
                            onClick={closeModal}
                            className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="addTaskModal"
                        >
                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                支出名
                            </label>
                            <input
                                type="text"
                                name="expenditure_name"
                                value={expenditureName}
                                onChange={changeExpenditureName}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="例) 給料"
                            />
                        </div>
                        <div className="col-span-2">
                            <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                金額
                            </label>
                            <input
                                type="number"
                                name="amount"
                                value={expenditureAmount}
                                onChange={changeExpenditureAmount}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                min="1"
                            />
                        </div>
                    </div>
                    <button
                        onClick={updateExpenditure}
                        type="submit"
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg className="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path></svg>
                        支出を登録する
                    </button>
                </div>
            </div>
        </>
    )
}

export default Expenditure