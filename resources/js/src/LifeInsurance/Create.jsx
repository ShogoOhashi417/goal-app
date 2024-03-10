import React from "react";
import PrimaryButton from '@/Components/PrimaryButton';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import { useRef, useState } from 'react';

function LifeInsuranceCard() {
    const propsData = document.getElementById('life_insurance_page').getAttribute('data-props');
    const data = JSON.parse(propsData);

    const [totalFee, setTotalFee] = useState(
        document.getElementById('life_insurance_page').getAttribute('data-total-fee')
    );

    const [lifeInsuranceInfoList, setLifeInsuranceInfoList] = useState(data);

    const lifeInsuranceCreateModal = useRef(null);

    const openCreateModal = () => {
        lifeInsuranceCreateModal.current.classList.remove('hidden');
    }

    const closeModal = () => {
        clearModalFields();
        lifeInsuranceCreateModal.current.classList.add('hidden');
    };

    const fetchLifeInsuranceList = async () => {
        const response = await axios.get('/life_insurance/get');
        setLifeInsuranceInfoList(response.data.life_insurance_info_list);
        setTotalFee(response.data.total_fee);
    };

    const [lifeInsuranceId, setLifeInsuranceId] = useState(0);
    const [lifeInsuranceName, setLifeInsuranceName] = useState('');
    const [fee, setFee] = useState(0);
    const [paymentType, setPaymentType] = useState(0);
    const [insuranceType, setInsuranceType] = useState(0);

    const lifeInsuranceNameChange = (event) => {
        setLifeInsuranceName(event.target.value);
    }
    
    const feeChange = (event) => {
        setFee(event.target.value);
    }

    const paymentTypeChange = (event) => {
        setPaymentType(event.target.value);
    }
    
    const insuranceTypeChange = (event) => {
        setInsuranceType(event.target.value);
    }

    const openEditModal = (lifeInsuranceInfoList) => {
        lifeInsuranceCreateModal.current.classList.remove('hidden');
        setLifeInsuranceId(lifeInsuranceInfoList.id);
        setLifeInsuranceName(lifeInsuranceInfoList.name);
        setFee(lifeInsuranceInfoList.fee);
        setPaymentType(lifeInsuranceInfoList.payment_type);
        setInsuranceType(lifeInsuranceInfoList.type);
    }

    const clearModalFields = () => {
        setLifeInsuranceId(0);
        setLifeInsuranceName('');
        setFee(0);
        setPaymentType(0);
        setInsuranceType(0);
    }

    const [isActioned, setIsActioned] = useState(false);

    const [messageClass, setMessageClass] = useState("bg-green-300 p-8 mb-4");

    const [actionMessage, setActionMessage] = useState('');

    const createLifeInsurance = () => {
        setIsActioned(true);
        closeModal();

        axios.post('/life_insurance/create', {
            'id' : lifeInsuranceId,
            'life_insurance_name' : lifeInsuranceName,
            'fee' : fee,
            'payment_type' : paymentType,
            'insurance_type' : insuranceType
        })
        .then(response => {
            if (response.data.result_status == "error") {
                setActionMessage(response.data.message);
                setMessageClass("bg-red-300 p-8 mb-4")
            } else {
                setActionMessage('新しい保険商品を登録しました。');
                setMessageClass("bg-green-300 p-8 mb-4")
            }
            fetchLifeInsuranceList();
        })
        .catch (error => {
            setActionMessage('処理が失敗しました。お手数ですが再度実行してください。');
            setMessageClass("bg-red-300 p-8 mb-4")
        })
    }

    const deleteLifeInsurance = (lifeInsuranceId) => {
        if (confirm('本当にこの生命保険を削除しますか？')) {
            axios.post('/life_insurance/delete', {
                'id' : lifeInsuranceId,
            })
            .then(response => {
                fetchLifeInsuranceList();
            });
        };
    }

    return (
        <>
        <div className='flex flex-col min-h-screen'>
            <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                <div className='container'>
                    <div className="mx-auto mt-3">
                        {
                            (() => {
                                if (isActioned) {
                                    return(
                                        <div className={messageClass}>
                                            <p>{actionMessage}</p>
                                        </div>
                                    )
                                }
                            })()
                        }
                        <div className="mb-3 flex justify-between">
                            <PrimaryButton className="ms-4 mb-4" onClick={openCreateModal}>
                                保険を新規登録する
                            </PrimaryButton>
                            <div className="flex w-1/4 justify-center items-center">
                                <p><b>年間合計保険料</b></p>
                                <div className="rounded-full bg-sky-100 text-lg ml-3 w-1/2 bg-white h-full justify-center flex items-center">
                                    {totalFee}円
                                </div>
                            </div>
                        </div>
                        
                        <div className="grid grid-cols-4 gap-4">
                        {lifeInsuranceInfoList.map((item) => (
                            <React.Fragment key={item.id}>
                                <div className="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <div className="flex justify-between">
                                        <svg className="mb-2 w-7 h-7 text-gray-500 dark:text-gray-400 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 5h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C8.4.842 6.949 0 5.5 0A3.5 3.5 0 0 0 2 3.5c.003.52.123 1.033.351 1.5H2a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V7a2 2 0 0 0-2-2ZM8.058 5H5.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM11 13H9v7h2v-7Zm-4 0H2v5a2 2 0 0 0 2 2h3v-7Zm6 0v7h3a2 2 0 0 0 2-2v-5h-5Z"/>
                                        </svg>
                                        <div>
                                            <button className="mr-2" onClick={() => openEditModal(item)}>
                                                <FontAwesomeIcon icon={faPenToSquare} />
                                            </button>
                                            <button onClick={() => deleteLifeInsurance(item.id)}>
                                                <FontAwesomeIcon icon={faCircleXmark} />
                                            </button>
                                        </div>
                                    </div>
                                
                                    <h5 className="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {item.name}
                                    </h5>
                                    <p className="mb-3 font-normal text-gray-500 dark:text-gray-400">
                                        保険料 : {item.fee}円
                                    </p>

                                    <p className="mb-3 font-normal text-gray-500 dark:text-gray-400">
                                        払込方法 : {item.payment_type}
                                    </p>

                                    <p className="mb-3 font-normal text-gray-500 dark:text-gray-400">
                                        保険タイプ : {item.type}
                                    </p>
                                </div>
                            </React.Fragment>
                        ))}
                        </div>

                        <div ref={lifeInsuranceCreateModal} tabIndex="-1" aria-hidden="true" className="hidden overflow-y-auto overflow-x-hidden fixed top-0 flex right-0 left-0 z-50 items-center justify-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div onClick={closeModal} className="absolute w-full h-full bg-gray-900 opacity-50">
                                    
                            </div>
                            
                            <div className="relative p-4 w-full max-w-md max-h-full">
                                <div className="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                                            保険の新規登録
                                        </h3>
                                        <button type="button" onClick={closeModal} className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span className="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div className="p-4 md:p-5">
                                        <div className="grid gap-4 mb-4 grid-cols-2">
                                            <div className="col-span-2">
                                                <label htmlFor="name" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">商品名</label>
                                                <input type="text" name="name" id="name" value={lifeInsuranceName} onChange={lifeInsuranceNameChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="商品名" required="" />
                                            </div>
                                            <div className="col-span-2 sm:col-span-1">
                                                <label htmlFor="price" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">保険料</label>
                                                <input type="number" name="price" id="price" value={fee} onChange={feeChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1,000" required="" />
                                            </div>
                                            <div className="col-span-2 sm:col-span-1">
                                                <label htmlFor="category" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">払込方法</label>
                                                <select id="category" value={paymentType} onChange={paymentTypeChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option>選択してください</option>
                                                    <option value="月払い">月払い</option>
                                                    <option value="半年払い">半年払い</option>
                                                    <option value="年払い">年払い</option>
                                                    <option value="一時払い">一時払い</option>
                                                </select>
                                            </div>
                                            <div className="col-span-2">
                                                <label htmlFor="description" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">保険種類</label>
                                                <select id="category" value={insuranceType} onChange={insuranceTypeChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option>選択してください</option>
                                                    <option value="定期保険">定期保険</option>
                                                    <option value="終身保険">終身保険</option>
                                                    <option value="養老保険">養老保険</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" onClick={createLifeInsurance} className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg className="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path></svg>
                                            保存する
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        </>
    )
}

export default LifeInsuranceCard