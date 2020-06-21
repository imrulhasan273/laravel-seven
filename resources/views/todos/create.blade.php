@extends('todos.layout')

@section('content')
    <div class="flex justify-center border-b pb-4 px-4">
        <h1 class="text-2xl pb-4">What next you need To-Do</h1>
        <a href="{{route('todo.index')}}" class="mx-5 py-2 text-gray-400 cursor-pointer text-white">
        <span class="fas fa-arrow-left"></span>
        </a>
    </div>

    
    <x-alert/>
    <form action="{{ route('todo.store') }}" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
@endsection