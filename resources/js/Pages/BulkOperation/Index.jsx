import React from "react";
import { useRef, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCircleXmark } from "@fortawesome/free-solid-svg-icons";
import { faUpload } from "@fortawesome/free-solid-svg-icons";
import { faDownload } from "@fortawesome/free-solid-svg-icons";
import Datepicker from "react-tailwindcss-datepicker";

export default function BulkOperation({ auth }) {
    const [activeTab, setActiveTab] = useState("upload");
    const [dateRange, setDateRange] = useState({
        startDate: new Date(),
        endDate: new Date(),
    });
    const [exportFormat, setExportFormat] = useState("detailed");
    const [isDownloading, setIsDownloading] = useState(false);

    const exportSampleCsv = () => {
        const fileInput = document.querySelector('input[name="csv"]');
        const formData = new FormData();

        if (fileInput && fileInput.files.length > 0) {
            formData.append("csv", fileInput.files[0]); // ファイルをFormDataに追加
        }
        axios.get("/expenditure/export", {}).then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "sample.csv");
            document.body.appendChild(link);
            link.click();
            link.remove();
        });
    };

    const downloadExpenditureCsv = () => {
        setIsDownloading(true);
        axios
            .get("/expenditure/export_data", {
                params: {
                    start_date: dateRange.startDate,
                    end_date: dateRange.endDate,
                    format: exportFormat,
                },
                responseType: "blob",
            })
            .then((response) => {
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                const fileName = `expenditure_${formatDate(
                    dateRange.startDate
                )}_${formatDate(dateRange.endDate)}.csv`;
                link.setAttribute("download", fileName);
                document.body.appendChild(link);
                link.click();
                link.remove();
            })
            .catch((error) => {
                console.error("Download error:", error);
            })
            .finally(() => {
                setIsDownloading(false);
            });
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toISOString().split("T")[0].replace(/-/g, "");
    };

    const [csvPreviewList, setCsvPreviewList] = useState([]);

    const [fileName, setFileName] = useState("ファイルを選択してください");
    const [isUploading, setIsUploading] = useState(false);
    const [uploadMode, setUploadMode] = useState("add");

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setFileName(file ? file.name : "ファイルを選択してください");
        setIsUploading(true);
    };

    const uploadCsv = () => {
        const fileInput = document.querySelector('input[name="csv"]');
        const formData = new FormData();

        if (fileInput.files.length > 0) {
            formData.append("csv", fileInput.files[0]);
            formData.append("mode", uploadMode);
        }
        axios
            .post("/expenditure/import_csv", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then((response) => {
                getExpenditureCategory();
                setCsvPreviewList(JSON.parse(response.data.uploadDataList));
                openModal();
            });
    };

    const [expenditureCategoryInfoList, setExpenditureCategoryInfoList] =
        useState([]);

    const getExpenditureCategory = async () => {
        const response = await axios.get("/expenditure_category/get");
        setExpenditureCategoryInfoList(
            response.data.expenditure_category_info_list
        );
    };

    const deleteExpenditureCategory = (itemIndex) => {
        setCsvPreviewList(
            Object.fromEntries(
                Object.entries(csvPreviewList).filter(
                    ([index, value]) => index !== itemIndex
                )
            )
        );
    };

    const saveCategoryMap = () => {
        const formData = new FormData();

        const table = document.querySelector("table");
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach((row, index) => {
            const itemName = row.querySelector(
                'input[name="category_name"]'
            ).value;
            const categorySelect = row.querySelector(
                'select[name="category_id"]'
            );
            const selectedCategory =
                categorySelect.options[categorySelect.selectedIndex].value;
            const amount = row.querySelector('input[name="amount"]').value;
            const calendarDate = row.querySelector(
                'input[name="calendar_date"]'
            ).value;

            formData.append(`items[${index}][name]`, itemName);
            formData.append(`items[${index}][category_id]`, selectedCategory);
            formData.append(`items[${index}][amount]`, amount);
            formData.append(`items[${index}][calendar_date]`, calendarDate);
        });

        axios
            .post("/expenditure/bulk_create", formData, {
                headers: {
                    "Content-Type": "multipart/form-data", // ヘッダーを設定
                },
            })
            .then((response) => {
                closeModal();
            });
    };

    const addExpenditureRef = useRef(null);

    const openModal = () => {
        addExpenditureRef.current.classList.remove("hidden");
    };

    const closeModal = () => {
        addExpenditureRef.current.classList.add("hidden");
    };

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        CSV一括処理
                    </h2>
                }
            >
                <Head title="一括処理" />
                <div className="flex flex-col min-h-screen">
                    <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                        <div className="container">
                            {/* Tab Navigation */}
                            <div className="mb-4 border-b border-gray-200">
                                <ul className="flex flex-wrap -mb-px text-sm font-medium text-center">
                                    <li className="mr-2">
                                        <button
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${
                                                activeTab === "upload"
                                                    ? "text-blue-600 border-blue-600"
                                                    : "border-transparent hover:text-gray-600 hover:border-gray-300"
                                            }`}
                                            onClick={() =>
                                                setActiveTab("upload")
                                            }
                                        >
                                            <FontAwesomeIcon
                                                icon={faUpload}
                                                className="mr-2"
                                            />
                                            アップロード
                                        </button>
                                    </li>
                                    <li className="mr-2">
                                        <button
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${
                                                activeTab === "download"
                                                    ? "text-blue-600 border-blue-600"
                                                    : "border-transparent hover:text-gray-600 hover:border-gray-300"
                                            }`}
                                            onClick={() =>
                                                setActiveTab("download")
                                            }
                                        >
                                            <FontAwesomeIcon
                                                icon={faDownload}
                                                className="mr-2"
                                            />
                                            ダウンロード
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            {/* Upload Tab Content */}
                            {activeTab === "upload" && (
                                <div className="bg-white p-3 rounded-lg">
                                    <h3 className="text-lg font-semibold text-gray-900 mb-3">
                                        STEP.1
                                        サンプルCSVファイルをダウンロードする
                                    </h3>

                                    <p className="text-gray-600 text-sm mb-2">
                                        サンプルCSVをダウンロードする
                                    </p>

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

                                    <h3 className="text-lg font-semibold text-gray-900 mb-3">
                                        STEP.2 アップロード方式の選択
                                    </h3>

                                    <p className="text-gray-600 text-sm mb-2">
                                        処理方式を選択してください。
                                    </p>

                                    <div className="my-3 mb-4">
                                        <table className="w-full border-collapse rounded-lg overflow-hidden">
                                            <thead className="bg-gray-100">
                                                <tr>
                                                    <th className="w-16 p-2 border border-gray-200"></th>
                                                    <th className="p-2 border border-gray-200 text-left">
                                                        処理方式
                                                    </th>
                                                    <th className="p-2 border border-gray-200 text-left">
                                                        説明
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr className="bg-gray-50 border border-gray-200">
                                                    <td
                                                        className="p-3 border border-gray-200 w-16 text-center cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode("add")
                                                        }
                                                    >
                                                        <input
                                                            id="upload-mode-add"
                                                            type="radio"
                                                            name="upload-mode"
                                                            value="add"
                                                            checked={
                                                                uploadMode ===
                                                                "add"
                                                            }
                                                            onChange={() =>
                                                                setUploadMode(
                                                                    "add"
                                                                )
                                                            }
                                                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                                        />
                                                    </td>
                                                    <td
                                                        className="p-3 border border-gray-200 cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode("add")
                                                        }
                                                    >
                                                        <label
                                                            htmlFor="upload-mode-add"
                                                            className="text-sm font-medium text-gray-900 cursor-pointer block"
                                                        >
                                                            新規追加
                                                        </label>
                                                    </td>
                                                    <td
                                                        className="p-3 border border-gray-200 cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode("add")
                                                        }
                                                    >
                                                        <span className="text-sm text-gray-600">
                                                            既存データを残したまま、新しいデータを追加します
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr className="bg-white border border-gray-200">
                                                    <td
                                                        className="p-3 border border-gray-200 w-16 text-center cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode(
                                                                "overwrite"
                                                            )
                                                        }
                                                    >
                                                        <input
                                                            id="upload-mode-overwrite"
                                                            type="radio"
                                                            name="upload-mode"
                                                            value="overwrite"
                                                            checked={
                                                                uploadMode ===
                                                                "overwrite"
                                                            }
                                                            onChange={() =>
                                                                setUploadMode(
                                                                    "overwrite"
                                                                )
                                                            }
                                                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                                        />
                                                    </td>
                                                    <td
                                                        className="p-3 border border-gray-200 cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode(
                                                                "overwrite"
                                                            )
                                                        }
                                                    >
                                                        <label
                                                            htmlFor="upload-mode-overwrite"
                                                            className="text-sm font-medium text-gray-900 cursor-pointer block"
                                                        >
                                                            上書き
                                                        </label>
                                                    </td>
                                                    <td
                                                        className="p-3 border border-gray-200 cursor-pointer"
                                                        onClick={() =>
                                                            setUploadMode(
                                                                "overwrite"
                                                            )
                                                        }
                                                    >
                                                        <span className="text-sm text-gray-600">
                                                            既存データを削除し、アップロードデータで置き換えます
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div className="my-3 flex items-center">
                                        <label
                                            className="block mb-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg py-2 px-4 cursor-pointer"
                                            htmlFor="csv-upload"
                                        >
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
                                        <span
                                            id="file-name"
                                            className="w-48 ml-3 text-sm text-gray-600"
                                        >
                                            {fileName}
                                        </span>

                                        <PrimaryButton
                                            onClick={uploadCsv}
                                            disabled={
                                                isUploading ? false : true
                                            }
                                            className="ml-3"
                                        >
                                            <FontAwesomeIcon
                                                icon={faUpload}
                                                className="mr-3"
                                            />
                                            アップロード
                                        </PrimaryButton>
                                    </div>
                                </div>
                            )}

                            {/* Download Tab Content */}
                            {activeTab === "download" && (
                                <div className="bg-white p-3 rounded-lg">
                                    <h3 className="text-lg font-semibold text-gray-900 mb-3">
                                        CSV出力
                                    </h3>
                                    <p className="text-gray-600 text-sm mb-4">
                                        期間を指定して支出データをCSVで出力します
                                    </p>

                                    <div className="grid md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label className="block mb-2 text-sm font-medium text-gray-900">
                                                期間選択
                                            </label>
                                            <Datepicker
                                                inputClassName="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5"
                                                placeholder="開始〜終了日を選択してください"
                                                displayFormat="YYYY/MM/DD"
                                                value={dateRange}
                                                onChange={(value) => {
                                                    setDateRange(value);
                                                }}
                                            />
                                        </div>
                                        <div>
                                            <label className="block mb-2 text-sm font-medium text-gray-900">
                                                出力形式
                                            </label>
                                            <select
                                                value={exportFormat}
                                                onChange={(e) =>
                                                    setExportFormat(
                                                        e.target.value
                                                    )
                                                }
                                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            >
                                                <option value="detailed">
                                                    詳細（日付・項目名・金額・カテゴリー）
                                                </option>
                                                <option value="summary">
                                                    サマリー（カテゴリー別集計）
                                                </option>
                                                <option value="monthly">
                                                    月別集計
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div className="mt-6">
                                        <PrimaryButton
                                            onClick={downloadExpenditureCsv}
                                            disabled={isDownloading}
                                        >
                                            {isDownloading ? (
                                                <>
                                                    <svg
                                                        className="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <circle
                                                            className="opacity-25"
                                                            cx="12"
                                                            cy="12"
                                                            r="10"
                                                            stroke="currentColor"
                                                            strokeWidth="4"
                                                        ></circle>
                                                        <path
                                                            className="opacity-75"
                                                            fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                        ></path>
                                                    </svg>
                                                    生成中...
                                                </>
                                            ) : (
                                                <>
                                                    <FontAwesomeIcon
                                                        icon={faDownload}
                                                        className="mr-3"
                                                    />
                                                    CSVダウンロード
                                                </>
                                            )}
                                        </PrimaryButton>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div
                    ref={addExpenditureRef}
                    className="fixed top-0 left-0 w-full h-full flex items-center justify-center hidden"
                >
                    <div
                        onClick={closeModal}
                        className="absolute w-full h-full bg-gray-900 opacity-50"
                    ></div>
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
                        <div className="flex items-center justify-between p-4 md:p-5 rounded-t">
                            <div
                                className="w-full"
                                style={{
                                    maxHeight: "400px",
                                    overflowY: "auto",
                                }}
                            >
                                <table
                                    id="preset_table"
                                    className="w-full text-sm rtl:text-right text-gray-500"
                                >
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="px-3 py-3 w-5/12"
                                            >
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
                                        {Object.keys(csvPreviewList).map(
                                            (index) => (
                                                <tr
                                                    key={index}
                                                    className="bg-white border-b hover:bg-gray-50"
                                                >
                                                    <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        <input
                                                            type="text"
                                                            name="category_name"
                                                            value={
                                                                csvPreviewList[
                                                                    index
                                                                ].name
                                                            }
                                                            className="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                            onChange={(e) => {
                                                                setCsvPreviewList(
                                                                    (prev) => ({
                                                                        ...prev,
                                                                        [index]:
                                                                            {
                                                                                ...prev[
                                                                                    index
                                                                                ],
                                                                                name: e
                                                                                    .target
                                                                                    .value,
                                                                            },
                                                                    })
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                    <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        <input
                                                            type="text"
                                                            name="amount"
                                                            value={
                                                                csvPreviewList[
                                                                    index
                                                                ].amount
                                                            }
                                                            className="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                            onChange={(e) => {
                                                                setCsvPreviewList(
                                                                    (prev) => ({
                                                                        ...prev,
                                                                        [index]:
                                                                            {
                                                                                ...prev[
                                                                                    index
                                                                                ],
                                                                                amount: e
                                                                                    .target
                                                                                    .value,
                                                                            },
                                                                    })
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                    <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        <select
                                                            name="category_id"
                                                            id=""
                                                            value={
                                                                csvPreviewList[
                                                                    index
                                                                ].category_id
                                                            }
                                                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                            onChange={(e) => {
                                                                setCsvPreviewList(
                                                                    (prev) => ({
                                                                        ...prev,
                                                                        [index]:
                                                                            {
                                                                                ...prev[
                                                                                    index
                                                                                ],
                                                                                category_id:
                                                                                    e
                                                                                        .target
                                                                                        .value,
                                                                            },
                                                                    })
                                                                );
                                                            }}
                                                        >
                                                            {expenditureCategoryInfoList.map(
                                                                (
                                                                    categoryInfo,
                                                                    index
                                                                ) => (
                                                                    <React.Fragment
                                                                        key={
                                                                            index
                                                                        }
                                                                    >
                                                                        <option
                                                                            key={
                                                                                categoryInfo.id
                                                                            }
                                                                            value={
                                                                                categoryInfo.id
                                                                            }
                                                                        >
                                                                            {
                                                                                categoryInfo.name
                                                                            }
                                                                        </option>
                                                                    </React.Fragment>
                                                                )
                                                            )}
                                                        </select>
                                                    </td>
                                                    <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        <Datepicker
                                                            inputClassName="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5"
                                                            inputName="calendar_date"
                                                            asSingle={true}
                                                            value={{
                                                                startDate:
                                                                    csvPreviewList[
                                                                        index
                                                                    ].date,
                                                                endDate:
                                                                    csvPreviewList[
                                                                        index
                                                                    ].date,
                                                            }}
                                                            onChange={(e) => {
                                                                const localCalendarDate =
                                                                    new Date(
                                                                        e.startDate
                                                                    ).toLocaleString(
                                                                        "sv-SE",
                                                                        {
                                                                            timeZone:
                                                                                "Asia/Tokyo",
                                                                        }
                                                                    );
                                                                setCsvPreviewList(
                                                                    (prev) => ({
                                                                        ...prev,
                                                                        [index]:
                                                                            {
                                                                                ...prev[
                                                                                    index
                                                                                ],
                                                                                date: localCalendarDate,
                                                                            },
                                                                    })
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                    <td className="px-3 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        <button
                                                            className="mx-auto"
                                                            onClick={() =>
                                                                deleteExpenditureCategory(
                                                                    index
                                                                )
                                                            }
                                                        >
                                                            <FontAwesomeIcon
                                                                icon={
                                                                    faCircleXmark
                                                                }
                                                            />
                                                        </button>
                                                    </td>
                                                </tr>
                                            )
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <PrimaryButton onClick={saveCategoryMap}>
                            保存
                        </PrimaryButton>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
