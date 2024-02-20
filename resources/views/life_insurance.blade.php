<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LifeInsurance') }}
        </h2>
    </x-slot>

    <div id="life_insurance_page" data-props="{{ json_encode($life_insurance_info_list) }}">

    </div>
</x-app-layout>