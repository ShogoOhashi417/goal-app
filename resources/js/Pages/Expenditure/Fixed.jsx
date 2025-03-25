import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Fixed({
    auth,
    expenditure_info_list,
    expenditure_category_info_list,
}) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    固定支出管理
                </h2>
            }
        >
            <Head title="固定支出管理" />
            <div className="flex flex-col min-h-screen">
                <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 selection:text-white">
                    <div className="container">
                        <div className="mx-auto mt-3">
                            <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3">
                                                支出名
                                            </th>
                                            <th className="px-6 py-3">金額</th>
                                            <th className="px-6 py-3">
                                                カテゴリー
                                            </th>
                                            <th className="px-6 py-3">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {/* ここに固定支出の一覧を表示する予定 */}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
