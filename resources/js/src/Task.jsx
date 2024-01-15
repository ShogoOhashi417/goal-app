import { Link, Head } from '@inertiajs/react';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";

export default function Task({ auth, laravelVersion, phpVersion }) {
    const propsData = document.getElementById('app').getAttribute('data-props');
    const data = JSON.parse(propsData);
    const dataInfo = data.data;
    console.log(dataInfo);
    return (
        <>
            {/* <Head title="テスト" /> */}
            <div className='flex flex-col min-h-screen'>
                <header className='font-bold bg-slate-800 text-white text-center p-2'>
                    ヘッダ{dataInfo.name}
                </header>
                <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-white bg-dots-darker bg-center bg-gray-100 selection:text-white">
                    <div className='container'>
                        <div className="mx-auto mt-3">
                            <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
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
                                                <FontAwesomeIcon icon={faCirclePlus} size="xl" />
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {dataInfo.map((item, index) => (
                                        <>
                                            <tr className="bg-white border-b hover:bg-gray-50">
                                                <td className="w-4 p-4">
                                                    <div className="flex items-center">
                                                        <input id="checkbox-table-search-1" type="checkbox" className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"></input>
                                                        <label htmlFor="checkbox-table-search-1" className="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {item.name}
                                                </th>
                                                <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {item.dead_line}
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        </>
                                        // 他のデータに対する表示を適切に行う
                                    ))}
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <footer className='font-bold bg-slate-800 text-white text-center p-2'>
                    フッター
                </footer>
            </div>
            
            <style>{`
                .bg-dots-darker {
                    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
                }
                @media (prefers-color-scheme: dark) {
                    .dark\\:bg-dots-lighter {
                        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
                    }
                }
            `}</style>

        </>
    );
}