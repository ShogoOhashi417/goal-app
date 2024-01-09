@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>ここが本文</p>
    <p>'message' = {{ $message }}</p>
    <p>'view_message' = {{ $view_message }}</p>

@endsection

@section('footer')
hellll<br>llloooooo
@endsection