import React, { useEffect, useState } from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import YearSelectBox from "@/Components/YearSelectBox";

export default function Report({ auth }) {
    const [seriesList, setSeriesList] = useState([]);

    const thisDate = new Date();
    const thisYear = thisDate.getFullYear();
    const thisMonth = thisDate.getMonth() + 1;

    const [dateList, setDateList] = useState(
        [
            thisYear + '-01',
            thisYear + '-02',
            thisYear + '-03',
            thisYear + '-04',
            thisYear + '-05',
            thisYear + '-06',
            thisYear + '-07',
            thisYear + '-08',
            thisYear + '-09',
            thisYear + '-10',
            thisYear + '-11',
            thisYear + '-12',
        ]
    );

    const changeYear = (event) => {
        const year = event.target.value;

        const YearMonthList = [];
        let month = 1;
        while (month <= 12) {
            YearMonthList.push(year + "-" + month)
            month++;
        }

        setDateList(YearMonthList);
    }

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
                getMonth(thisYear, thisMonth, 12),
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
    }

    const getMonth = (year, month, period) => {
        const MONTHS_PER_YEAR = 12;

        const resultMonth = month - period;
        
        if (resultMonth > 0) {
            return year + "-" + String(resultMonth).padStart(2, '0');
        }

        return (year - 1) + "-" + String(resultMonth + MONTHS_PER_YEAR).padStart(2, '0');
    }

    const [expenditureInfoList, setExpenditureInfoList] = useState([]);

    const getIncomeCategory = async () => {
        const response = await axios.get('/expenditure/get_by_category');
        setExpenditureInfoList(response.data.category_to_amount_list);
    }

    useEffect(() => {
        getIncomeCategory();
    }, []);

    useEffect(() => {
        const data = [];
        Object.entries(expenditureInfoList).forEach(([categoryName, dateToAmountList]) => {
            const amountList = [];
            dateList.forEach((date) => {
                const amount = dateToAmountList[date] ?? 0;
                amountList.push(amount);
            });

            data.push({
                name: categoryName,
                data: amountList
            });
        });
        setSeriesList(data);
    }, [expenditureInfoList, dateList]); 

    const chartOptions = {
        chart: {
            type: 'column'
        },
        title: {
            text: '月別支出額'
        },
        xAxis: {
            categories: dateList
        },
        yAxis: {
            title: {
                text: '支出額 (万)'
            },
            labels: {
                formatter: function() {
                    return this.value / 10000 + '万';
                }
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: seriesList
    };

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">レポート</h2>}
            >
                <Head title="レポート" />

                <div className='flex flex-col min-h-screen'>
                    <div className="w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                        <div className='container'>
                            <div className="flex">
                                <YearSelectBox
                                    onChange={changeYear}
                                >
                                </YearSelectBox>
                                <select
                                    className="w-1/6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ml-3"
                                    onChange={changeRelativePeriod}
                                >
                                    {Array.from(relativePeriodList.entries()).map(([value, period], index) => (
                                        <React.Fragment key={value}>
                                            <option value={value}>{ period }</option>
                                        </React.Fragment>
                                    ))}
                                </select>
                            </div>
                            <div className="mx-auto mt-3">
                                <HighchartsReact
                                    highcharts={Highcharts}
                                    options={chartOptions}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
