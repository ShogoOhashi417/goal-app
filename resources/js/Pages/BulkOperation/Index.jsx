import React from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton'

export default function BulkOperation({ auth }) {

    const exportSampleCsv = () => {
        axios.get('/expenditure/export', {
            responseType: 'blob'
        })
        .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'export.csv');
            document.body.appendChild(link);
            link.click();
            link.remove();
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
                            <PrimaryButton
                                onClick={exportSampleCsv}
                            >
                                サンプルCSVダウンロード
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
