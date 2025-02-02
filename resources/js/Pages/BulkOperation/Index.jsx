import React from "react";
import { useRef, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton'
import SecondaryButton from '@/Components/SecondaryButton'
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faUpload } from "@fortawesome/free-solid-svg-icons";
import Datepicker from "react-tailwindcss-datepicker";

export default function BulkOperation({ auth }) {
    const exportSampleCsv = () => {
        const fileInput = document.querySelector('input[name="csv"]');
        const formData = new FormData();
        
        if (fileInput.files.length > 0) {
            formData.append('csv', fileInput.files[0]); // ファイルをFormDataに追加
        }
        axios.get('/expenditure/export', {
        })
        .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'sample.csv');
            document.body.appendChild(link);
            link.click();
            link.remove();
        });
    }

    const [csvPreviewList, setCsvPreviewList] = useState([]);

    const uploadCsv = () => {
        const fileInput = document.querySelector('input[name="csv"]');
        const formData = new FormData();

        if (fileInput.files.length > 0) {
            formData.append('csv', fileInput.files[0]); // ファイルをFormDataに追加
        }
        axios.post('/expenditure/import_csv', formData, {
            headers: {
                'Content-Type': 'multipart/form-data' // ヘッダーを設定
            }
        })
        .then(response => {
            getExpenditureCategory();
            setCsvPreviewList(JSON.parse(response.data.uploadDataList));
            openModal();
        })
    }

    const [expenditureCategoryInfoList, setExpenditureCategoryInfoList] = useState([]);

    const getExpenditureCategory = async () => {
        const response = await axios.get('/expenditure_category/get');
        setExpenditureCategoryInfoList(response.data.expenditure_category_info_list);
    }

    const deleteExpenditureCategory = (itemName) => {
        setCsvPreviewList(Object.fromEntries(
            Object.entries(csvPreviewList).filter(([name, value]) => name !== itemName)
        ));
    }

    const saveCategoryMap = () => {
        const formData = new FormData();

        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach((row, index) => {
            const itemName = row.querySelector('input[name="category_name"]').value;
            const categorySelect = row.querySelector('select[name="category_id"]');
            const selectedCategory = categorySelect.options[categorySelect.selectedIndex].value;
            const amount = row.querySelector('input[name="amount"]').value;
            const calendarDate = row.querySelector('input[name="calendar_date"]').value;

            formData.append(`items[${index}][name]`, itemName);
            formData.append(`items[${index}][category_id]`, selectedCategory);
            formData.append(`items[${index}][amount]`, amount);
            formData.append(`items[${index}][calendar_date]`, calendarDate);
        });

        axios.post('/expenditure/bulk_create', formData, {
            headers: {
                'Content-Type': 'multipart/form-data' // ヘッダーを設定
            }
        })
        .then(response => {
                closeModal();
        });
    }

    const addExpenditureRef = useRef(null);

    const openModal = () => {
        addExpenditureRef.current.classList.remove('hidden');
    }

    const closeModal = () => {
        addExpenditureRef.current.classList.add('hidden');
    }

    const [fileName, setFileName] = useState('ファイルを選択してください');
    const [isUploading, setIsUploading] = useState(false);

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setFileName(file ? file.name : 'ファイルを選択してください');
        setIsUploading(true);
    }

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">CSV一括処理</h2>}
            >
                <Head title="レポート" />
                <div className='flex flex-col min-h-screen'>
                    <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                        <div className='container'>
                            <div className="bg-white p-3 rounded-lg">
                                <h3 className="text-lg font-semibold text-gray-900 mb-3">STEP.1 サンプルCSVファイルをダウンロードする</h3>

                                <p className="text-gray-600 text-sm mb-2">サンプルCSVをダウンロードする</p>
                                
                                <div className="my-3">
                                    <div>
                                        <SecondaryButton
                                            onClick={exportSampleCsv}
                                        >
                                            サンプルCSVダウンロード
                                        </SecondaryButton>
                                    </div>
                                </div>

                                <hr className="my-5" />

                                <h3 className="text-lg font-semibold text-gray-900 mb-3">STEP.2 CSVファイルをアップロードする</h3>
                                
                                <p className="text-gray-600 text-sm mb-2">CSVファイルをアップロードする</p>
                                
                                <div className="my-3 flex items-center">
                                    <label className="block mb-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg py-2 px-4 cursor-pointer" htmlFor="csv-upload">
                                        CSVファイルを選択
                                    </label>
                                    <input 
                                        type="file"
                                        name="csv"
                                        id="csv-upload"
                                        className="hidden"
                                        accept=".csv"
                                        onChange={handleFileChange}
                                    />
                                    <span id="file-name" className="w-48 ml-3 text-sm text-gray-600">
                                        {fileName}
                                    </span>
                                    
                                    <PrimaryButton
                                        onClick={uploadCsv}
                                        disabled={isUploading ? false : true}
                                        className="ml-3"
                                    >
                                        <FontAwesomeIcon icon={faUpload} className="mr-3" />
                                        アップロード
                                    </PrimaryButton>
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
                    <div className="z-10 bg-white p-6 rounded shadow-lg w-5/6">
                        <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 className="text-lg font-semibold text-gray-900">
                                支出とカテゴリーを登録してください
                            </h3>
                            <button
                                type="button"
                                onClick={closeModal}
                                className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="addTaskModal"
                            >
                                <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <div className="flex items-center justify-between p-4 md:p-5 rounded-t">
                            <div className="w-full" style={{ maxHeight: '400px', overflowY: 'auto' }}>
                                <table id="preset_table" className="w-full text-sm rtl:text-right text-gray-500">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" className="px-3 py-3 w-5/12">
                                                支出名
                                            </th>
                                            <th className="px-3 py-3 w-2/12">
                                                金額
                                            </th>
                                            <th className="px-3 py-3 w-3/12">
                                                カテゴリー名
                                            </th>
                                            <th className="px-3 py-3 w-3/12">
                                                支払い日時
                                            </th>
                                            <th className="px-3 py-3 w-min"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {Object.keys(csvPreviewList).map(itemName => (
                                        <tr key={itemName} className="bg-white border-b hover:bg-gray-50">
                                            <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                <input
                                                    type="text"
                                                    name="category_name"
                                                    value={csvPreviewList[itemName].name}
                                                    className="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                    onChange={(e) => {
                                                        setCsvPreviewList(prev => ({
                                                            ...prev,
                                                            [itemName]: {
                                                                ...prev[itemName],
                                                                name: e.target.value
                                                            }
                                                        }));
                                                    }}
                                                />
                                            </td>
                                            <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                <input
                                                    type="text"
                                                    name="amount"
                                                    value={csvPreviewList[itemName].amount}
                                                    className="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                    onChange={(e) => {
                                                        setCsvPreviewList(prev => ({
                                                            ...prev,
                                                            [itemName]: {
                                                                ...prev[itemName],
                                                                amount: e.target.value
                                                            }
                                                        }));
                                                    }}
                                                />
                                            </td>
                                            <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                <select
                                                    name="category_id"
                                                    id=""
                                                    value={ csvPreviewList[itemName].category_id }
                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                    onChange={(e) => {
                                                        setCsvPreviewList(prev => ({
                                                            ...prev,
                                                            [itemName]: {
                                                                ...prev[itemName],
                                                                category_id: e.target.value
                                                            }
                                                        }));
                                                    }}
                                                >
                                                    {expenditureCategoryInfoList.map((categoryInfo, index) => (
                                                        <React.Fragment key={index}>
                                                            <option
                                                                key={categoryInfo.id}
                                                                value={categoryInfo.id}
                                                            >{categoryInfo.name}
                                                            </option>
                                                        </React.Fragment>
                                                    ))}
                                                </select>
                                            </td>
                                            <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                <Datepicker
                                                    inputClassName="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5"
                                                    inputName="calendar_date"
                                                    asSingle={true}
                                                    value={{
                                                        startDate: csvPreviewList[itemName].date, 
                                                        endDate: csvPreviewList[itemName].date
                                                    }}
                                                    onChange={(e) => {
                                                        const localCalendarDate = new Date(e.startDate).toLocaleString('sv-SE', { timeZone: 'Asia/Tokyo' });
                                                        setCsvPreviewList(prev => ({
                                                            ...prev,
                                                            [itemName]: {
                                                                ...prev[itemName],
                                                                date: localCalendarDate
                                                            }
                                                        }));
                                                    }}
                                                />
                                            </td>
                                            <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                <button
                                                    className='mx-auto'
                                                    onClick={() => deleteExpenditureCategory(itemName)}
                                                >
                                                    <FontAwesomeIcon icon={faCircleXmark} />
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                        <PrimaryButton
                            onClick={saveCategoryMap}
                        >
                            保存
                        </PrimaryButton>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
