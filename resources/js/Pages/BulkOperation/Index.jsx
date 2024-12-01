import React from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton'
import SecondaryButton from '@/Components/SecondaryButton'

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
        });
    }

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">CSV一括処理</h2>}
            >
                <Head title="レポート" />

                <div className='flex flex-col min-h-screen bg-white'>
                    <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                        <div className='container'>
                            <div>
                                <SecondaryButton
                                    onClick={exportSampleCsv}
                                >
                                    サンプルCSVダウンロード
                                </SecondaryButton>
                            </div>
                            
                            <div className="my-3">
                                <input type="file" name="csv"  />
                                <PrimaryButton
                                    onClick={uploadCsv}
                                >
                                    アップロード
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
