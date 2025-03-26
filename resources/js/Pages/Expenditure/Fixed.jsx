import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCirclePlus } from "@fortawesome/free-solid-svg-icons";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import React, { useEffect, useState } from "react";
import { useRef } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import {
    createColumnHelper,
    useReactTable,
    getCoreRowModel,
    getSortedRowModel,
} from "@tanstack/react-table";

export default function Fixed({
    auth,
    expenditure_info_list,
    expenditure_category_info_list,
}) {
    const [expenditureInfoList, setExpenditureInfoList] = useState(
        expenditure_info_list
    );

    const [expenditureId, setExpenditureId] = useState(0);
    const [expenditureName, setExpenditureName] = useState("");
    const [expenditureCategoryId, setExpenditureCategoryId] = useState(0);
    const [expenditureAmount, setExpenditureAmount] = useState(0);

    const changeExpenditureName = (event) => {
        setExpenditureName(event.target.value);
    };

    const changeExpenditureCategoryId = (event) => {
        setExpenditureCategoryId(event.target.value);
    };

    const changeExpenditureAmount = (event) => {
        setExpenditureAmount(parseInt(event.target.value));
    };

    const addExpenditureRef = useRef(null);
    const updateExpenditureRef = useRef(null);

    const openAddModal = () => {
        addExpenditureRef.current.classList.remove("hidden");
    };

    const openUpdateModal = (
        expenditureId,
        expenditureName,
        expenditureCategoryId,
        expenditureAmount
    ) => {
        setExpenditureId(expenditureId);
        setExpenditureName(expenditureName);
        setExpenditureCategoryId(expenditureCategoryId);
        setExpenditureAmount(expenditureAmount);
        updateExpenditureRef.current.classList.remove("hidden");
    };

    const closeModal = () => {
        addExpenditureRef.current.classList.add("hidden");
        updateExpenditureRef.current.classList.add("hidden");
    };

    const getInfo = () => {
        axios
            .get("/expenditure/fixed/get")
            .then((response) => {
                setExpenditureInfoList(response.data.expenditure_info_list);
            })
            .catch((error) => {});
    };

    const addExpenditure = () => {
        axios
            .post("/expenditure/fixed/add", {
                expenditure_name: expenditureName,
                expenditure_category_id: expenditureCategoryId,
                expenditure_amount: expenditureAmount,
            })
            .then((response) => {
                getInfo();
                closeModal();
            });

        setExpenditureName("");
        setExpenditureCategoryId(0);
        setExpenditureAmount(0);
    };

    const updateExpenditure = () => {
        axios
            .put(`/expenditure/fixed/update/${expenditureId}`, {
                expenditure_name: expenditureName,
                expenditure_category_id: expenditureCategoryId,
                expenditure_amount: expenditureAmount,
            })
            .then((response) => {
                getInfo();
                closeModal();
            });

        setExpenditureId(0);
        setExpenditureName("");
        setExpenditureCategoryId(0);
        setExpenditureAmount(0);
    };

    const deleteExpenditure = (expenditureId) => {
        if (!confirm("本当にこの固定支出を削除しますか？")) {
            return;
        }

        axios
            .post("/expenditure/fixed/delete", {
                id: expenditureId,
                expenditure_name: expenditureName,
                expenditure_amount: expenditureAmount,
            })
            .then((response) => {
                getInfo();
            });
    };

    const [expenditureCategoryInfoList, setExpenditureCategoryInfoList] =
        useState(expenditure_category_info_list);

    const columnHelper = createColumnHelper();

    const data = React.useMemo(
        () => expenditureInfoList,
        [expenditureInfoList]
    );

    const columns = React.useMemo(
        () => [
            columnHelper.accessor("name", {
                header: "支出名",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("amount", {
                header: "金額",
                cell: (info) => info.getValue(),
                sortingFn: "basic",
            }),
            columnHelper.accessor("category_name", {
                header: "カテゴリー",
                cell: (info) => info.getValue(),
                sortingFn: "basic",
            }),
        ],
        []
    );

    const [sorting, setSorting] = React.useState([]);

    const table = useReactTable({
        data,
        columns,
        state: {
            sorting,
        },
        onSortingChange: setSorting,
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
    });

    return (
        <>
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
                                            {table
                                                .getHeaderGroups()
                                                .map((headerGroup) => (
                                                    <tr key={headerGroup.id}>
                                                        {headerGroup.headers.map(
                                                            (header) => (
                                                                <th
                                                                    key={
                                                                        header.id
                                                                    }
                                                                    onClick={header.column.getToggleSortingHandler()}
                                                                    className="cursor-pointer border px-4 py-2"
                                                                >
                                                                    {header.isPlaceholder
                                                                        ? null
                                                                        : header
                                                                              .column
                                                                              .columnDef
                                                                              .header}
                                                                    {{
                                                                        asc: " ↑",
                                                                        desc: " ↓",
                                                                    }[
                                                                        header.column.getIsSorted()
                                                                    ] ?? null}
                                                                </th>
                                                            )
                                                        )}
                                                        <th className="w-10">
                                                            <div className="flex justify-center items-center">
                                                                <button
                                                                    onClick={
                                                                        openAddModal
                                                                    }
                                                                >
                                                                    <FontAwesomeIcon
                                                                        icon={
                                                                            faCirclePlus
                                                                        }
                                                                        size="lg"
                                                                    />
                                                                </button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                ))}
                                        </thead>
                                        <tbody>
                                            {table
                                                .getRowModel()
                                                .rows.map((row) => (
                                                    <tr
                                                        key={row.id}
                                                        className="bg-white border-b hover:bg-gray-50"
                                                    >
                                                        {row
                                                            .getVisibleCells()
                                                            .map((cell) => (
                                                                <td
                                                                    key={
                                                                        cell.id
                                                                    }
                                                                    className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                                >
                                                                    {cell.getValue()}
                                                                </td>
                                                            ))}
                                                        <td>
                                                            <div className="flex justify-center items-center gap-1">
                                                                <button
                                                                    className="mx-auto"
                                                                    onClick={() =>
                                                                        openUpdateModal(
                                                                            row
                                                                                .original
                                                                                .id,
                                                                            row.getValue(
                                                                                "name"
                                                                            ),
                                                                            row
                                                                                .original
                                                                                .category_id,
                                                                            row.getValue(
                                                                                "amount"
                                                                            )
                                                                        )
                                                                    }
                                                                >
                                                                    <FontAwesomeIcon
                                                                        icon={
                                                                            faPenToSquare
                                                                        }
                                                                    />
                                                                </button>
                                                                <button
                                                                    className="mx-auto"
                                                                    onClick={() =>
                                                                        deleteExpenditure(
                                                                            row.id
                                                                        )
                                                                    }
                                                                >
                                                                    <FontAwesomeIcon
                                                                        icon={
                                                                            faCircleXmark
                                                                        }
                                                                    />
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>

            <div
                ref={addExpenditureRef}
                className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden"
            >
                <div
                    onClick={closeModal}
                    className="absolute w-full h-full bg-gray-900 opacity-50"
                ></div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 className="text-lg font-semibold text-gray-900">
                            固定支出を登録する
                        </h3>
                        <button
                            type="button"
                            onClick={closeModal}
                            className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="addTaskModal"
                        >
                            <svg
                                className="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                支出名
                            </label>
                            <input
                                type="text"
                                name="expenditure_name"
                                value={expenditureName}
                                onChange={changeExpenditureName}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="例) 家賃"
                            />
                        </div>
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                カテゴリー
                            </label>

                            <select
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                                onChange={changeExpenditureCategoryId}
                            >
                                <option value="">選択してください</option>
                                {expenditureCategoryInfoList.map(
                                    (item, index) => (
                                        <React.Fragment key={index}>
                                            <option value={item.id}>
                                                {item.name}
                                            </option>
                                        </React.Fragment>
                                    )
                                )}
                            </select>
                        </div>
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                金額
                            </label>
                            <input
                                type="number"
                                name="amount"
                                value={expenditureAmount}
                                onChange={changeExpenditureAmount}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                min="1"
                            />
                        </div>
                    </div>
                    <button
                        onClick={addExpenditure}
                        type="submit"
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        <svg
                            className="me-1 -ms-1 w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clipRule="evenodd"
                            ></path>
                        </svg>
                        固定支出を登録する
                    </button>
                </div>
            </div>

            <div
                ref={updateExpenditureRef}
                className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden"
            >
                <div
                    onClick={closeModal}
                    className="absolute w-full h-full bg-gray-900 opacity-50"
                ></div>
                <div className="z-10 bg-white p-6 rounded shadow-lg w-1/2">
                    <div className="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 className="text-lg font-semibold text-gray-900">
                            固定支出を編集する
                        </h3>
                        <button
                            type="button"
                            onClick={closeModal}
                            className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="addTaskModal"
                        >
                            <svg
                                className="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                    <div className="grid gap-4 mb-4 grid-cols-2">
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                支出名
                            </label>
                            <input
                                type="text"
                                name="expenditure_name"
                                value={expenditureName}
                                onChange={changeExpenditureName}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="例) 家賃"
                            />
                        </div>
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                カテゴリー
                            </label>

                            <select
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                                value={expenditureCategoryId}
                                onChange={changeExpenditureCategoryId}
                            >
                                <option value="">選択してください</option>
                                {expenditureCategoryInfoList.map(
                                    (item, index) => (
                                        <React.Fragment key={index}>
                                            <option value={item.id}>
                                                {item.name}
                                            </option>
                                        </React.Fragment>
                                    )
                                )}
                            </select>
                        </div>
                        <div className="col-span-2">
                            <label
                                htmlFor="name"
                                className="block mb-2 text-sm font-medium text-gray-900"
                            >
                                金額
                            </label>
                            <input
                                type="number"
                                name="amount"
                                value={expenditureAmount}
                                onChange={changeExpenditureAmount}
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                min="1"
                            />
                        </div>
                    </div>
                    <button
                        onClick={updateExpenditure}
                        type="submit"
                        className="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        <svg
                            className="me-1 -ms-1 w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clipRule="evenodd"
                            ></path>
                        </svg>
                        固定支出を更新する
                    </button>
                </div>
            </div>
        </>
    );
}
