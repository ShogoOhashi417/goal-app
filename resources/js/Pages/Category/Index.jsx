import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import React from "react"
import { useRef, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Modal from '@/Components/Modal';
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from '@/Components/SecondaryButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';

export default function Income({ auth }) {
    const [activeTab, setActiveTab] = useState('income');

    const changeActiveTab = (tab) => {
        setActiveTab(tab);
    }

    const activeTabClassAttribute = "bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold cursor-pointer";
    const inactiveTabClassAttribute = "bg-white inline-block py-2 px-4 text-blue-300 hover:text-blue-800 font-semibold cursor-pointer";

    const [addCategory, setAddCategory] = useState(false);

    const showAddCategoryModal = () => {
        setAddCategory(true);
    }

    const [addExpenditureCategory, setAddExpenditureCategory] = useState(false);

    const showExpenditureCategoryModal = () => {
        setAddExpenditureCategory(true);
    }

    const closeModal = () => {
        setAddCategory(false);
        setAddExpenditureCategory(false);
    };

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">カテゴリー管理</h2>}
            >
                <Head title="カテゴリー" />

                <div className='flex flex-col min-h-screen'>
                    <div className=" w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 selection:text-white">
                        <div className='container'>
                            <div className="mx-auto mt-3">
                                <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <ul className="flex border-b">
                                        <li className="-mb-px mr-1">
                                            <a
                                                className={`${activeTab === "income" ? activeTabClassAttribute : inactiveTabClassAttribute}`}
                                                onClick={() => changeActiveTab('income')}
                                                value="income"
                                            >収入
                                            </a>
                                        </li>
                                        <li className="mr-1">
                                            <a
                                                className={`${activeTab === "expenditure" ? activeTabClassAttribute : inactiveTabClassAttribute}`}
                                                onClick={() => changeActiveTab('expenditure')}
                                            >支出
                                            </a>
                                        </li>
                                    </ul>
                                    <table id="test" className={`w-full text-sm text-left rtl:text-right text-gray-500 ${activeTab === 'expenditure' ? 'hidden' : ''}`}>
                                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" className="px-6 py-3">
                                                    収入カテゴリー名
                                                </th>
                                                <th className='w-10'>
                                                    <div className="flex justify-center items-center">
                                                        <button onClick={showAddCategoryModal}>
                                                            <FontAwesomeIcon icon={faCirclePlus} size="lg" />
                                                        </button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {/* todo ダミー */}
                                            <tr className="bg-white border-b hover:bg-gray-50">
                                                <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">給料</td>
                                                <td>
                                                    <div className="flex justify-center items-center gap-1">
                                                        <button className='mx-auto'>
                                                            <FontAwesomeIcon icon={faPenToSquare} />
                                                        </button>
                                                        <button className='mx-auto'>
                                                            <FontAwesomeIcon icon={faCircleXmark} />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table id="test2" className={`w-full text-sm text-left rtl:text-right text-gray-500 ${activeTab === 'income' ? 'hidden' : ''}`}>
                                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" className="px-6 py-3">
                                                    支出カテゴリー名
                                                </th>
                                                <th className='w-10'>
                                                    <div className="flex justify-center items-center">
                                                        <button onClick={showExpenditureCategoryModal}>
                                                            <FontAwesomeIcon icon={faCirclePlus} size="lg" />
                                                        </button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {/* todo ダミー */}
                                            <tr className="bg-white border-b hover:bg-gray-50">
                                                <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">給料</td>
                                                <td>
                                                    <div className="flex justify-center items-center gap-1">
                                                        <button className='mx-auto'>
                                                            <FontAwesomeIcon icon={faPenToSquare} />
                                                        </button>
                                                        <button className='mx-auto'>
                                                            <FontAwesomeIcon icon={faCircleXmark} />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>

            <Modal show={addCategory} onClose={closeModal}>
                <div className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        収入カテゴリーを追加
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        収入のカテゴリーを追加してください
                    </p>

                    <div className="mt-6">
                        <InputLabel htmlFor="income_category" className="sr-only" />

                        <TextInput
                            id="income_category"
                            type="text"
                            name="income_category"
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="収入カテゴリー"
                        />

                        <InputError className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>キャンセル</SecondaryButton>

                        <PrimaryButton className="ms-3">
                            収入カテゴリーを追加する
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>

            <Modal show={addExpenditureCategory} onClose={closeModal}>
                <div className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        支出カテゴリーを追加
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        支出のカテゴリーを追加してください
                    </p>

                    <div className="mt-6">
                        <InputLabel htmlFor="expenditure_category" className="sr-only" />

                        <TextInput
                            id="expenditure_category"
                            type="text"
                            name="expenditure_category"
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="収入カテゴリー"
                        />

                        <InputError className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>キャンセル</SecondaryButton>

                        <PrimaryButton className="ms-3">
                            支出カテゴリーを追加する
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </>
    )
}
