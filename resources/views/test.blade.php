@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>ここが本文</p>
    @foreach ($data as $item)
    <p>名前は{{ $item['name'] }}でメアドは{{ $item['mail'] }}</p>
    @endforeach
@endsection

@section('footer')
hellll<br>llloooooo
@endsection