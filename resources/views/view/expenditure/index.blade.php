<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('支出管理') }}
        </h2>
    </x-slot>

    <div
        id="expenditure_page"
        data-props="{{ json_encode($expenditure_info_list); }}"
    >
    </div>
</x-app-layout>