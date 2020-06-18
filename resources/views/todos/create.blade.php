@extends('todos.layout')

@section('content')
    <h1 class="text-2xl border-b pb-4">What next you need To-Do</h1>
    <x-alert/>
    <form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection