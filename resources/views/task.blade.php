<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    </head>
    <body>
        <div class='flex flex-col min-h-screen'>
            <header class='font-bold bg-slate-800 text-white text-center p-2'>
                ヘッダー
            </header>
            <div id="task-page" data-props="{{ json_encode($task_list) }}">

            </div>
            {{-- <footer class='fixed bottom-0 font-bold bg-slate-800 text-white text-center p-2'> --}}
            <footer class='font-bold bg-slate-800 text-white text-center p-2'>
                フッター
            </footer>
        </div>
    </body>
</html>