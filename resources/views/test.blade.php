@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>ここが本文</p>
    <p>置き換える</p>
@endsection

@section('footer')
hellll<br>llloooooo
@endsection