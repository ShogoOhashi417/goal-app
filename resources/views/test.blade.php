{{-- レイアウトの継承設定 --}}
@extends('layouts.helloapp')

@section('title', 'わっっっしょい')

@section('menubar')
    @parent
    インデックスページ
@endsection

{{-- @section('content')
<p>{{ $message }}</p>
@error('mail')
<p>{{ $message }}</p>
@enderror
    <form action="/test" method="post">
        @csrf
        <input type="text" name="name" value="{{old('name')}}">
        <input type="text" name="mail">
        <input type="text" name="age">
        <button type="submit" value="send">送信</button>
    </form>
@endsection --}}

@section('wasshoi', 'ワッショイ！！！！')

{{-- @section('content')
    <p>コンポーネントですよ</p> --}}
    {{-- @component('components.message')
        @slot('name')
            わっしょいコンポーネント
        @endslot
    @endcomponent --}}
    {{-- @include('components.message', ['name' => 'インクルードわっしょい'])
@endsection --}}

@section('content')
<p>繰り返しますよ</p>
@each('components.message', $loopDataList, 'loopData')
@endsection


@section('footer')
<p>フッターですよ</p>
@endsection

@php
    echo $view_message;
@endphp