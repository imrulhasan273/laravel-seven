@extends('todos.layout')
@section('content')
    <div class="flex justify-center border-b pb-4 px-4">
        <h1 class="text-2xl pb-4">Update this Todo list</h1>
        <a href="{{route('todo.index')}}" class="mx-5 py-2 text-gray-400 cursor-pointer text-white">
        <span class="fas fa-arrow-left"></span>
        </a>
    </div>

    <x-alert/>
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
        @csrf
        @method('patch')
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
@endsection