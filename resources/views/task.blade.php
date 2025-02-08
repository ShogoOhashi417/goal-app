<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    <div id="task-page" data-props="{{ json_encode($task_list) }}">
    </div>
</x-app-layout>