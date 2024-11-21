import React, { useEffect, useState } from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';

export default function Report({ auth }) {
    const [seriesList, setSeriesList] = useState([]);
    const [dateList, setDateList] = useState(['2024-11', '2024-12']);

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
    }, [expenditureInfoList]); 

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
                    <div className=" w-5/6 mx-auto my-3 flex-1 relative sm:justify-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:text-white">
                        <div className='container'>
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
