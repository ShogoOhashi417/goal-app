import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import React from "react"
import { useRef, useState } from 'react';

function Income() {
    const propsData = document.getElementById('income_page').getAttribute('data-props');
    const data = JSON.parse(propsData);

    const [incomeInfoList, setincomeInfoList] = useState(data);

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
                                                収入源
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                金額
                                            </th>
                                            <th className='w-10'>
                                                <div className="flex justify-center items-center">
                                                    <button>
                                                        <FontAwesomeIcon icon={faCirclePlus} size="lg" />
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {incomeInfoList.map((item, index) => (
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
                                                        <button className='mx-auto' onClick={() => openEditTaskModal(item.id, item.name, item.dead_line)}>
                                                            <FontAwesomeIcon icon={faPenToSquare} />
                                                        </button>
                                                        <button className='mx-auto' onClick={() => deleteFamily(item.id)}>
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
        </>
    )
}

export default Income