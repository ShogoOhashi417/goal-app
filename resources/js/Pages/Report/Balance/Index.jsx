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

    const initialDateList = [
        getMonth(thisYear, thisMonth, 2),
        getMonth(thisYear, thisMonth, 1),
        getMonth(thisYear, thisMonth, 0),
    ];
    
    const [dateList, setDateList] = useState(initialDateList);

    const INITIAL_SAVINGS = 500000;

    const THIS_MONTH_PERIOD = "1";
    const THREE_MONTHS_PERIOD = "2";
    const HALF_YEAR_PERIOD = "3";
    const THIS_YEAR_PERIOD = "4";

    const relativePeriodList = new Map();
    relativePeriodList.set(THIS_MONTH_PERIOD, "今月");
    relativePeriodList.set(THREE_MONTHS_PERIOD, "3ヶ月間");
    relativePeriodList.set(HALF_YEAR_PERIOD, "半年間");
    relativePeriodList.set(THIS_YEAR_PERIOD, "1年間");

    const createDummyIncome = () => {
        return {
            "給与": initialDateList.reduce((acc, date) => {
                acc[date] = 320000;
                return acc;
            }, {}),
            "ボーナス": initialDateList.reduce((acc, date, index) => {
                acc[date] = index === 1 ? 500000 : 0;
                return acc;
            }, {}),
            "副業": initialDateList.reduce((acc, date, index) => {
                const amounts = [50000, 30000, 45000];
                acc[date] = amounts[index] || 0;
                return acc;
            }, {})
        };
    };

    const createDummyExpenditure = () => {
        return {
            "家賃": initialDateList.reduce((acc, date) => {
                acc[date] = 80000;
                return acc;
            }, {}),
            "食費": initialDateList.reduce((acc, date, index) => {
                const amounts = [45000, 42000, 48000];
                acc[date] = amounts[index] || 0;
                return acc;
            }, {}),
            "交通費": initialDateList.reduce((acc, date, index) => {
                const amounts = [12000, 15000, 13000];
                acc[date] = amounts[index] || 0;
                return acc;
            }, {}),
            "娯楽": initialDateList.reduce((acc, date, index) => {
                const amounts = [30000, 120000, 25000];
                acc[date] = amounts[index] || 0;
                return acc;
            }, {})
        };
    };

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

    const [incomeInfoList, setIncomeInfoList] = useState(createDummyIncome());
    const [expenditureInfoList, setExpenditureInfoList] = useState(createDummyExpenditure());
    const [combinedChartOptions, setCombinedChartOptions] = useState({});

    const getIncomeByCategory = async () => {
        // try {
        //     const response = await axios.get("/income/get_by_category");
        //     setIncomeInfoList(response.data.category_to_amount_list);
        // } catch (error) {
        //     console.error("収入データの取得に失敗しました", error);
        //     // エラー時はダミーデータを維持
        // }
    };

    const getExpenditureByCategory = async () => {
        // try {
        //     const response = await axios.get("/expenditure/get_by_category");
        //     setExpenditureInfoList(response.data.category_to_amount_list);
        // } catch (error) {
        //     console.error("支出データの取得に失敗しました", error);
        //     // エラー時はダミーデータを維持
        // }
    };

    useEffect(() => {
        getIncomeByCategory();
        getExpenditureByCategory();
    }, []);

    useEffect(() => {
        const incomeData = [];
        const expenditureData = [];
        const balanceData = [];
        const savingsData = [];
        
        let currentSavings = INITIAL_SAVINGS; // 貯金額の初期値

        const sortedDateList = [...dateList].sort();

        sortedDateList.forEach((date) => {
            let totalIncome = 0;
            let totalExpenditure = 0;

            Object.values(incomeInfoList).forEach((dateToAmountList) => {
                if (dateToAmountList[date]) {
                    totalIncome += parseInt(dateToAmountList[date]) || 0;
                }
            });

            Object.values(expenditureInfoList).forEach((dateToAmountList) => {
                if (dateToAmountList[date]) {
                    totalExpenditure += parseInt(dateToAmountList[date]) || 0;
                }
            });

            incomeData.push(totalIncome);
            expenditureData.push(totalExpenditure);
            const monthlyBalance = totalIncome - totalExpenditure;
            balanceData.push(monthlyBalance);
            
            currentSavings += monthlyBalance;
            savingsData.push(currentSavings);
        });

        const maxIncomeValue = Math.max(...incomeData);
        const maxExpenditureValue = Math.max(...expenditureData);
        const maxIncomeExpenditure = Math.max(maxIncomeValue, maxExpenditureValue);
        
        const maxSavingsValue = Math.max(...savingsData);

        const incomeColor = "#2E86C1";
        const expenditureColor = "#D6EAF8";
        const savingsColor = "#3498DB";

        const incomeExpenditureAxisMax = Math.ceil(maxIncomeExpenditure * 5 / 100000) * 100000;
        const savingsAxisMax = Math.ceil(maxSavingsValue * 1.0 / 100000) * 100000;

        const combinedOptions = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: sortedDateList,
                crosshair: true
            },
            yAxis: [
                {
                    title: {
                        text: '貯金額 (円)',
                        style: {
                            color: savingsColor,
                            fontSize: '12px'
                        }
                    },
                    labels: {
                        format: '{value}円',
                        style: {
                            color: savingsColor,
                            fontSize: '11px'
                        }
                    },
                    min: 0,
                    max: savingsAxisMax,
                    tickInterval: 500000,
                    gridLineWidth: 1,
                    gridLineDashStyle: 'Dot'
                },
                {
                    title: {
                        text: '収支額 (円)',
                        style: {
                            color: Highcharts.getOptions().colors[0],
                            fontSize: '12px'
                        }
                    },
                    labels: {
                        format: '{value}円',
                        style: {
                            color: Highcharts.getOptions().colors[0],
                            fontSize: '11px'
                        }
                    },
                    min: 0,
                    max: incomeExpenditureAxisMax,
                    tickInterval: 500000,
                    opposite: true,
                    gridLineWidth: 0
                }
            ],
            tooltip: {
                shared: true,
                formatter: function() {
                    let tooltip = '<b>' + this.x + '</b><br/>';
                    
                    this.points.forEach(function(point) {
                        tooltip += '<span style="color:' + point.color + '">●</span> ' + 
                                    point.series.name + ': ' + 
                                    Highcharts.numberFormat(point.y, 0, '.', ',') + '円<br/>';
                    });
                    
                    return tooltip;
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                floating: false,
                backgroundColor: 'white',
                shadow: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                },
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },
            series: [
                {
                    name: '収入',
                    type: 'column',
                    color: incomeColor,
                    data: incomeData,
                    yAxis: 1,
                    tooltip: {
                        valueSuffix: '円'
                    },
                    pointPlacement: -0.05
                },
                {
                    name: '支出',
                    type: 'column',
                    color: expenditureColor,
                    data: expenditureData,
                    yAxis: 1,
                    tooltip: {
                        valueSuffix: '円'
                    },
                    pointPlacement: 0.05
                },
                {
                    name: '貯金額',
                    type: 'spline',
                    color: savingsColor,
                    data: savingsData,
                    yAxis: 0,
                    tooltip: {
                        valueSuffix: '円'
                    },
                    marker: {
                        enabled: true,
                        radius: 4,
                        symbol: 'circle',
                        lineColor: savingsColor,
                        lineWidth: 2,
                        fillColor: '#FFFFFF'
                    },
                    lineWidth: 2
                }
            ]
        };

        setCombinedChartOptions(combinedOptions);
    }, [incomeInfoList, expenditureInfoList, dateList]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    貯金額レポート
                </h2>
            }
        >
            <Head title="貯金額レポート" />

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
                                    defaultValue={THREE_MONTHS_PERIOD}
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
                                    options={combinedChartOptions}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
