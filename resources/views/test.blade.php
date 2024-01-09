@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
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
@endsection

@section('footer')
hellll<br>llloooooo
@endsection