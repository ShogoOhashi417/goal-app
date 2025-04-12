import React, { useEffect, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import Highcharts from "highcharts";
import HighchartsReact from "highcharts-react-official";

export default function Balance({ auth }) {
    const getMonth = (year, month, period) => {
        const MONTHS_PER_YEAR = 12;
        const resultMonth = month - period;

        if (resultMonth > 0) {
            return year + "-" + String(resultMonth).padStart(2, "0");
        }

        return (
            year -
            1 +
            "-" +
            String(resultMonth + MONTHS_PER_YEAR).padStart(2, "0")
        );
    };

    const thisDate = new Date();
    const thisYear = thisDate.getFullYear();
    const thisMonth = thisDate.getMonth() + 1;

    const [dateList, setDateList] = useState([
        getMonth(thisYear, thisMonth, 2),
        getMonth(thisYear, thisMonth, 1),
        getMonth(thisYear, thisMonth, 0),
    ]);

    const THIS_MONTH_PERIOD = "1";
    const THREE_MONTHS_PERIOD = "2";
    const HALF_YEAR_PERIOD = "3";
    const THIS_YEAR_PERIOD = "4";

    const relativePeriodList = new Map();
    relativePeriodList.set(THIS_MONTH_PERIOD, "今月");
    relativePeriodList.set(THREE_MONTHS_PERIOD, "3ヶ月間");
    relativePeriodList.set(HALF_YEAR_PERIOD, "半年間");
    relativePeriodList.set(THIS_YEAR_PERIOD, "1年間");

    const changeRelativePeriod = (event) => {
        const period = event.target.value;

        if (period === THIS_MONTH_PERIOD) {
            setDateList([getMonth(thisYear, thisMonth, 0)]);
            return;
        }

        if (period === THREE_MONTHS_PERIOD) {
            setDateList([
                getMonth(thisYear, thisMonth, 2),
                getMonth(thisYear, thisMonth, 1),
                getMonth(thisYear, thisMonth, 0),
            ]);
            return;
        }

        if (period === HALF_YEAR_PERIOD) {
            setDateList([
                getMonth(thisYear, thisMonth, 5),
                getMonth(thisYear, thisMonth, 4),
                getMonth(thisYear, thisMonth, 3),
                getMonth(thisYear, thisMonth, 2),
                getMonth(thisYear, thisMonth, 1),
                getMonth(thisYear, thisMonth, 0),
            ]);
            return;
        }

        if (period === THIS_YEAR_PERIOD) {
            setDateList([
                getMonth(thisYear, thisMonth, 11),
                getMonth(thisYear, thisMonth, 10),
                getMonth(thisYear, thisMonth, 9),
                getMonth(thisYear, thisMonth, 8),
                getMonth(thisYear, thisMonth, 7),
                getMonth(thisYear, thisMonth, 6),
                getMonth(thisYear, thisMonth, 5),
                getMonth(thisYear, thisMonth, 4),
                getMonth(thisYear, thisMonth, 3),
                getMonth(thisYear, thisMonth, 2),
                getMonth(thisYear, thisMonth, 1),
                getMonth(thisYear, thisMonth, 0),
            ]);
            return;
        }
    };

    const [incomeInfoList, setIncomeInfoList] = useState([]);
    const [expenditureInfoList, setExpenditureInfoList] = useState([]);
    const [balanceChartOptions, setBalanceChartOptions] = useState({});
    const [monthlyBalanceOptions, setMonthlyBalanceOptions] = useState({});

    const getIncomeByCategory = async () => {
        const response = await axios.get("/income/get_by_category");
        setIncomeInfoList(response.data.category_to_amount_list);
    };

    const getExpenditureByCategory = async () => {
        const response = await axios.get("/expenditure/get_by_category");
        setExpenditureInfoList(response.data.category_to_amount_list);
    };

    useEffect(() => {
        getIncomeByCategory();
        getExpenditureByCategory();
    }, []);

    useEffect(() => {
        // 収支バランスのグラフデータを作成
        const incomeData = [];
        const expenditureData = [];
        const balanceData = [];

        dateList.forEach((date) => {
            let totalIncome = 0;
            let totalExpenditure = 0;

            Object.values(incomeInfoList).forEach((dateToAmountList) => {
                totalIncome += dateToAmountList[date] ?? 0;
            });

            Object.values(expenditureInfoList).forEach((dateToAmountList) => {
                totalExpenditure += dateToAmountList[date] ?? 0;
            });

            incomeData.push(totalIncome);
            expenditureData.push(-totalExpenditure);
            balanceData.push(totalIncome - totalExpenditure);
        });

        // 収入と支出の積み上げグラフ
        const balanceOptions = {
            chart: {
                type: "column",
            },
            title: {
                text: "収支バランス（収入・支出）",
            },
            xAxis: {
                categories: dateList,
            },
            yAxis: {
                title: {
                    text: "金額 (万)",
                },
                labels: {
                    formatter: function () {
                        return Math.abs(this.value) / 10000 + "万";
                    },
                },
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0,
                },
            },
            series: [
                {
                    name: "収入",
                    color: "#90EE90",
                    data: incomeData,
                },
                {
                    name: "支出",
                    color: "#FFB6C6",
                    data: expenditureData,
                },
            ],
        };

        // 月次収支差額のグラフ
        const monthlyOptions = {
            chart: {
                type: "line",
            },
            title: {
                text: "月次収支差額",
            },
            xAxis: {
                categories: dateList,
            },
            yAxis: {
                title: {
                    text: "金額 (万)",
                },
                labels: {
                    formatter: function () {
                        return this.value / 10000 + "万";
                    },
                },
            },
            series: [
                {
                    name: "収支差額",
                    data: balanceData,
                    color: "#4169E1",
                    marker: {
                        enabled: true,
                    },
                },
            ],
        };

        setBalanceChartOptions(balanceOptions);
        setMonthlyBalanceOptions(monthlyOptions);
    }, [incomeInfoList, expenditureInfoList, dateList]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    収支バランスレポート
                </h2>
            }
        >
            <Head title="収支バランスレポート" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    期間選択
                                </label>
                                <select
                                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    onChange={changeRelativePeriod}
                                >
                                    {Array.from(
                                        relativePeriodList.entries()
                                    ).map(([key, value]) => (
                                        <option key={key} value={key}>
                                            {value}
                                        </option>
                                    ))}
                                </select>
                            </div>

                            <div className="mb-8">
                                <HighchartsReact
                                    highcharts={Highcharts}
                                    options={balanceChartOptions}
                                />
                            </div>

                            <div className="mb-8">
                                <HighchartsReact
                                    highcharts={Highcharts}
                                    options={monthlyBalanceOptions}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
