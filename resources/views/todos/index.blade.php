@extends('todos.layout')
@section('content')
<div class="flex justify-center border-b pb-4 px-4">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-2 text-blue-400 cursor-pointer text-white">
    <span class="fas fa-plus-circle"></span>
    </a>
</div>
<x-alert/>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-between px-2 py-2">
        @include('todos.complete-button')

        @if($todo->completed)
        <p class="line-through">{{$todo->title}}</p>
        @else
        <p>{{$todo->title}}</p>
        @endif
        <div>
        <a href="{{'/todos/'.$todo->id.'/edit'}}" class="text-orange-400 cursor-pointer text-white">
        <span class="fas fa-edit px-2"></span>
        </a>

        <span class="fas fa-trash text-red-500 px-2 cursor-pointer"
                        onclick="event.preventDefault();
                        if(confirm('Are you sure to delete?'))
                        {
                            document.getElementById('form-delete-{{$todo->id}}')
                            .submit()
                        }"></span>
        
        <form style="display:none" id="{{'form-delete-'.$todo->id}}" method="post" action="{{ route('todo.delete', $todo->id) }}">
        @csrf
        @method('delete')
        </form> 
        </div>
    </li>
    @endforeach    
</ul> 
@endsection

