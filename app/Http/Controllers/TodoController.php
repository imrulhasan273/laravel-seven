<?php

namespace App\Http\Controllers;
use App\Todo;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;
use App\Http\Requests\TodoCreateRequest;

class TodoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('auth')->except('index');
        // $this->middleware('auth')->only('index');
    }

    public function index()
    {   
        // $todos = Todo::all();
        // $todos = auth()->user()->todos()->orderBy('completed')->get();
        $todos = auth()->user()->todos->sortBy('completed');
        // return $todos;

        // $todos = Todo::orderBy('completed')->get();
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

        ////way: 1
        // $userId             = auth()->id();
        // $request['user_id'] = $userId;

        // dd(auth()->user()->todos());

        auth()->user()->todos()->create($request->all());

        // Todo::create($request->all());
        // return redirect()->back()->with('message', 'Todo created successfully!');
        return redirect(route('todo.index'))->with('message', 'Todo created successfully!');
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

    public function update(TodoCreateRequest $request, Todo $todo)
    {
        // dd($request->all());
        $todo->update(['title' => $request ->title]);
        // return redirect()->back()->with('message','Updated!');
        return redirect(route('todo.index'))->with('message','Updated!');
    }

    public function complete(Todo $todo)
    {
        $todo->update(['completed'=> true]);
        return redirect()->back()->with('message','Task Marked as Completed!!!');
    }

    public function incomplete(Todo $todo)
    {
        $todo->update(['completed'=> false]);
        return redirect()->back()->with('message','Task UnMarked as Completed!!!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->back()->with('message', $todo->title.' Task Deleted!!!');
    }
}
