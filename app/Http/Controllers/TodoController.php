<?php

namespace App\Http\Controllers;
use App\Todo;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('todos.index');     //inside todos directiory file named index.blade.php
    }

    public function create()
    {
        return view('todos.create');    //inside todos directiory file named create.blade.php
    }
    public function store(Request $request)
    {
        // dd($request->all());
        Todo::create($request->all());
        return redirect()->back()->with('message', 'Todo created successfully!');
    }

    public function edit()
    {
        return view('todos.edit');    //inside todos directiory file named edit.blade.php
    }
}
