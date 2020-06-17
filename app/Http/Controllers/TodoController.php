<?php

namespace App\Http\Controllers;
use App\Todo;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;
use App\Http\Requests\TodoCreateRequest;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        // return $todos;   
        // return view('todos.index')->with(['todos'=> $todos]);    //inside todos directiory file named index.blade.php  
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');    //inside todos directiory file named create.blade.php
    }
    // public function store(Request $request)
    public function store(TodoCreateRequest $request)
    {
        // dd($request->all());
        // if(!$request->title)
        // {
        //     return redirect()->back()->with('error', 'Please Give Title');
        // }
        //ABove code is not a good way of validation message. Many fields may be in DB.

        ////Instead we use below lines of codes to validate
        ////this code need another errors message added in alert.blade.php
        // $request->validate([
        //     'title'=>'required|max:255',
        // ]);
        //The above code above displays  built in error message. and prevents below code to execute


        //Validation own
        // $rules =[
        //     'title'=>'required|max:255',
        // ];
        // $messages = [
        //     'title.max' => 'ToDo title should not be greater than 255 chars',
        // ];
        // $validator = Validator::make($request->all(), $rules, $messages);
        // //this code will not prevent below code code from eecuting so error will appears.
        // //so we need below segment to check
        // if ($validator->fails()) 
        // {
        //     return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        ////Now we commented the above validation methods becuase now requests are comming from
        // the TodoCreateRequests

        Todo::create($request->all());
        return redirect()->back()->with('message', 'Todo created successfully!');
    }

    // public function edit($id)
    public function edit(Todo $todo)
    {
        // dd($todo->title);
        // dd($id);
        // $todo = Todo::find($id);
        // return $todo;
        return view('todos.edit', compact('todo'));    //inside todos directiory file named edit.blade.php
    }
}
