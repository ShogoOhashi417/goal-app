import React, { useState } from "react";

export default function YearSelectBox({onChange, className = ''}) {
    const currentYear = new Date().getFullYear();

    const years = Array.from({ length: 16 }, (_, i) => currentYear - 10 + i);

    const [selectedYear, setSelectedYear] = useState(currentYear);

    const handleChange = (event) => {
        setSelectedYear(event.target.value);

        if (onChange) {
            onChange(event);
        }
    };
    
    return (
        <select
            id="year-select"
            value={selectedYear}
            className={`w-1/6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ` + className}
            onChange={handleChange}
        >
            {years.map((year) => (
            <option key={year} value={year}>
                {year}
            </option>
            ))}
        </select>
    );
};