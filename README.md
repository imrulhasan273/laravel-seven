<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# Documentation of Laravel 7 Basics

## Introduction

To get php version using CMD

```cmd
~$ php artisan --version
```

To run development server:-

```cmd
~$ php artisan serve
```

**Views**

-   these are the pages, sees user

-   directory: project/resources/views

**Controllers**

-   Directory: project/app/Http/controllers
-   manipulates models
    -   example:
        ```php
        Route::get('/user', 'UserController@index');
        ```
    -   /user --> is a path after the server's home directory of project
    -   UserController --> controller name
    -   index --> function in that controller

**Models**

-   updates views
-   Database Setting: -project/vendor/.env (for xampp)
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=seven
    DB_USERNAME=root
    DB_PASSWORD=
    ```

**migration**

-   Directory of tables: project/app/database/migrations/
-   Directory of Models: project/app/User.php
-   Table name should be in plural form (example: users)
-   Model name should be in singular form (example: User)

To migrate database table

```cmd
~$ php artisan migrate
```

> Using this command all the tables in the migrations directory and in the database will be updated
> An extra table will be created in the database named migrations. This table takes care of other tables. For example if we migrate again using migrate command then the migration will not take effect if no updates avaible. How laravel know that tables are already been migrated? Because of that EXTRA TABLE called "MIGRATIONS" in database.
> how do they interact?
> Model will interact with tables for example: "User" model will interact with "users" table in DB, "Student" model will interact with "students" table in DB

Create a controller for User Model

```cmd
~$ php artisan make:controller UserController
```

## RAW Structured Query Language

Use this header in controller file to interact with Database

```php
use Illuminate\Support\Facades\DB;
```

below queries will be written inside the function of the Controller.

**Insert**

```php
DB::insert('insert into users (name, email, password) values (?, ?, ?)',
['Imrul', 'imrulhasan273@gmail.com', 'imrul']);

$users = DB::select('select * from users');
return $users;
```

**Select**

```php
$users = DB::select('select * from users');
return $users;
```

**Update**

```php
DB::update('update users set name = ? where id = ?',
['Imrul',13]);
$users = DB::select('select * from users');
return $users;
```

**Delete**

```php
DB::delete('delete from users');
$users = DB::select('select * from users');
return $users;
```

## Eloquent ORM (Object Relational Model)

**Insert**

```php
$user =  new User();
// var_dump($user); //var dumb
// dd($user); //die and dumb, so much clean
$user->name = 'Imrul Hasan';
$user->email = 'imrulhasan273@gmail.com';
$user->password = bcrypt('imrul');
$user->save();
```

**Fetch all the data from database table (select)**

```php
$user = User::all();
return $user;
```

> `all()` is a static method and not static method. Magical statement? We can see all the fields value except password. Because password is 'protected_hidden' field defined in `User.php` so that field will not come in `all()`

**Update**

```php
User::where('id',16)->update(['name' => 'Imrul Hasan']);
$user = User::all();
return $user;
```

**Delete**

```php
User::where('id',14)->delete();
```

> On the above query `id='14'` is explicitely defined which is not a process that we will working with. User model can only interact with users table.

> In **Insert Operation using ORM** We don't need to define out own function for password encryption or any authentication like `bcrypt('imrul');` We will make this through below package istallation.

**install first package laravel UI**

> make sure you close all the running file from text editor becauase It may restrict the changes to the files after importing dependencies.

-   documentation --> search --> authentication introduction

```cmd
~$ composer require laravel/ui
```

> composer.json file will updated

**Option 1**

```cmd
~$ php artisan ui vue --auth
```

**Option 2**

```php
~$ php artisan ui:auth
```

-   `auth`, `layout` directory added inside `view` sub-folder
-   `home.blade.php` will be overwrite
-   `auth` directory is added `controller` sub-folder
-   `homecontroller.php` is added
-   Added a table in databse `migration` sub-folder

> now the home page of website changes. It includes `log in` and `reg` option but the UI is ugly. To fix the UI follow link below.

[Laravel Frontend](https://laravel.com/docs/7.x/frontend)

Install the frontend scaffolding using the `ui` Artisan command

**Option 1**

```cmd
~$ php artisan ui bootstrap
```

**Option 2**

```cmd
~$ php artisan ui vue
~$ php artisan ui react
```

Install Node package manager (NPM):

```cmd
~$ npm install
```

then some dependency may need to fix

```cmd
~$ npm audit fix            [if required]
```

```cmd
~$ npm run dev
```

> The npm run dev command will process the instructions in your webpack.mix.js file. Typically, your compiled CSS will be placed in the public/css directory

## Blade Template Engine

> all the routes are in routes/web.php

**To show the all the route list using cmd**

```cmd
~$ php artisan route:list
```

> **home page** is in `home.blade.php` which extend the `app.blade.php`

```php
@extends('layouts.app')
```

> Here `layout` is directory and `app` is file name which is shoutcut name of `app.blade.php`. This code should be imported on top of file.

> Syntax: `@extends('folder1.sub-folder2.sub-folder3.app')` We can search deeper path using this kind of syntax. That's why blade is is so powerful.

> In `layouts/app.blade.php` there are **navigation** segment and the **main** segment. Inside `<main> </main>` all the contents are getting using below code:

```php
@yield('content_name')
```

> from @section('contet_name') which is in home.blade.php

\*\*\*To change name 'content' of @yield('content') from <main></main> in app.blade.php
we must change name 'content' from others files too in
-views/auth/
-viwes/layouts/
because if we don't, some segment will not display.

#\***\*\*\*\*\*\*\***\_\_\_\_\***\*\*\*\*\*\*\***laravel Configuration
->laravel projects, package and dependency have configuarations (config)
-located in project/config/ (directory)
-project/.env
->config in production and development are different
for example: in .env file

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    So there must be a file in config to get information
    from .env file for RADIS settings (setting above)
    --to search the file where its informations are included
      search a file related to database. Because REDIT is a database file
    *one important thing to note that whenever there is a change in .env file
     we must restart the dev server. Because the server take the cache the
     setting for one serve.

    *routes/web.php
    //the below code is made with a closure
    Route::get('/', function () {
    	// return env('APP_NAME');
    	// return View::make('welcome');     //using Aaliyas
    	return view('welcome');          //using helper function
    });


    * Other config
    -auth.php
    -etc.....

    #web.php
    return  config('services.ses.key');
    data flow from .env to services to web.php via config helper function

#**\*\***\*\***\*\***\_**\*\***\*\***\*\***Upload Avator/photo
uploaded image will be stored in storage/app/public directory
\*inside home.blade.php

<div class="card-body">
<form action="/upload" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="image"/>
<input type="submit" name="upload"/>
</form>
</div>

    *we give action ="/upload" means it will execute in /upload directory
    *now we need to create this route in web.php
    *csrf = cross site request forgery
    *@csrf is important to inport inside form because
     without it form will not successfully executed.
    *no one can submit the from with fake data
    *Laravel automatically generates a CSRF "token" for each active user
     session managed by the application. This token is used to verify that
     the authenticated user is the one actually making the requests to the
     application.
    *<input type="hidden" name="_token" value="BlV0DglRFa5wzyCUN88H0OBSocUdz6KKts0hhDjQ">
    https://laravel.com/docs/7.x/csrf#csrf-introduction

    *_____web.php

    //below code is using closure
    Route::post('/upload', function(){
       dd(request()->all()); //the requested form will be shown
    });
    //but above code is not secure instead use below code for injection

    Route::post('/upload', function(Request $request){
    	// dd($request->all()); //the requested form will be shown --  same as above Route
    	//dd($request->file('image'));    //it will shows null in page Why? enctype="multipart/form-data" should be used in form
    //dd($request->image); //same as above line
    dd($request->hasFile('image')); //check if form contains any file or not. (true/false)
    });


    *We have user table without avatar column.
    *we add avatar column in database/migrations/user table in schema
    *Now we have extra one column in user table in migrations.
     but user table already in database without this column.

\*\*\*migrate:
migrate:fresh Drop all tables and re-run all migrations
migrate:install Create the migration repository
migrate:refresh Reset and re-run all migrations
migrate:reset Rollback all database migrations
migrate:rollback Rollback the last database migration
migrate:status Show the status of each migration

    ~$ php artisan migrate:refresh (CMD)
    //to upload image we will use UserController

    *after uploading it doesn't get the only original name instead it contains
    all the details of images...
    So we go to depth of laravel to grab the image name only
    -vendor/laravel/framework/src/illuminate/Http/UploadedFile.php
    Search for originalname in that file. then find
    $file->getClientOriginalName(), in a function
    copy "getClientOriginalName" and use it in UserController and set
    dd($request->image->getClientOriginalName());

    public function uploadAvatar(Request $request)
    	{
        	if($request->hasFile('image'))
        	{
            		$filename = $request->image->getClientOriginalName();
           		$request->image->storeAs('images', $filename,'public');
            		User::find(1)->update(['avatar' => $filename]);
       		}

        	return redirect()->back();
    	}

    *To view avatar of user in Navigation bar
    	-add an <img> tag in the app.blade.php on approprite position
    	@if(Auth::user()->avatar)
    	<img src="{{ Auth::user()->avator }}" alt="avatar"/>
    	@endif

    	but unfortunately the image of user didn't show here.

#**\*\***\*\***\*\***\_\_**\*\***\*\***\*\***Show User Avator. (Fixed the problem of showing avator)
#fixing problem 1: (dynamically update database)
*UserController.php
*find logged user and update avatar
public function uploadAvatar(Request $request)
    {
        if($request->hasFile('image'))
{
$filename = $request->image->getClientOriginalName();
$request->image->storeAs('images', $filename,'public');
auth()->user()->update(['avatar' => $filename]); //for logged user
}

return redirect()->back();
}

#fixing problem 2:(View Avatar in Profile Dashboard from Storage Dir)
*project/storate directory is not accesable directly.
*We can access project/public dir directly
\*So We need to make a link to 'project/storage/public' to 'project/public dir'.

    ~$ php artisan storage:link (CMD)
    *after that command we can see a link of storage dir in
     the project/public dir.
    *Now we can access the public dir inside storage dir via project/public dir.
    **NOTE: we can access only public dir of storage dir, Not other dir.

    app.blade.php (now we need to correcly path the location to get the images)

 	<img src="{{ asset('/storage/images/'.Auth::user()->avatar) }}" alt="avatar" width="60px" height="60px"/>

    #Problem 3: arises. (After Updating the new avatar old image still in storage
    		     this will take space without needing)

#**\*\***\*\***\*\***\_\_**\*\***\*\***\*\***Remove OLD image before update

    *to delete the previous avatar of user before updating the avatar

\*User.php (Model)
public static function uploadAvatar($image)
    {
        $filename = $image->getClientOriginalName();
        (new self())->deleteOldImage(); //we can not use $this in static method. so use (new self()) instead of $this
        $image->storeAs('images', $filename,'public');
        auth()->user()->update(['avatar' => $filename]); //for log user
}
protected function deleteOldImage()
{
if(auth()->user()->avatar)
{
Storage::delete('/public/images/' . auth()->user()->avatar);
}
}

\*UserController.php
public function uploadAvatar(Request $request)
    {
        if($request->hasFile('image'))
{
User::uploadAvatar(\$request->image);
return redirect()->back(); //success msg
}
return redirect()->back(); //err msg
}

#**\*\***\*\*\*\***\*\***\_\_**\*\***\*\*\*\***\*\***Flash Session
\*UserController.php
session()->put('message','Avatar has been changed');

\*home.blade.php
@if(session()->has('message'))

<div class="alert alert-success">{{ session()->get('message')}} </div>
@endif

\*\*\*but the problem is message appears all time. So how we remove message after reload?
Solution: Use below code segment

\*UserController.php
public function uploadAvatar(Request $request)
    {
        if($request->hasFile('image'))
{
User::uploadAvatar($request->image);
            $request -> session()->flash('message','Image Uploaded!');
return redirect()->back(); //success msg
}
\$request -> session()->flash('error','Image Not Uploaded!');
return redirect()->back(); //err msg
}

\*home.blade.php
@if(session()->has('message'))

<div class="alert alert-success">{{ session()->get('message')}} </div>
{{ session()->forget('message') }}
@elseif(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error')}} </div>
@endif

    //But we can do that more easier way for that when we redirect to the back page.

*\*\*FINALLY**\*\*\*\***\_**\*\*\*\***
*UserController.php
public function uploadAvatar(Request $request)
    {
        if($request->hasFile('image'))
{
User::uploadAvatar(\$request->image);
return redirect()->back()->with('message','Image Uploaded!');
}
return redirect()->back()->with('error','Image Not Uploaded!');
}

\*home.blade.php (same as before)

#\***\*\*\*\*\*\*\***\_\_\_\_\***\*\*\*\*\*\*\***Blade Include Subview

\*views/layouts/flash.blade.php

@if(session()->has('message'))

<div class="alert alert-success">{{ session()->get('message')}} </div>
{{ session()->forget('message') }}
@elseif(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error')}} </div>
@endif

\*views/home.blade.php
@include('layouts.flash') <!-- @include('folderName.SubfolderName.FileName') -->

//\_\_\_\_Alternative way of doing so we will create componets using installing a library
~\$ php artisan make:component Alert (CMD)

the command will create two directory
--> app/view/componets
--> resources/views/components/alert.blade.php

\*alert.blade.php (put the code that was in flash.blade.php)

<div>
    @if(session()->has('message'))
    <div class="alert alert-success">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <div class="alert alert-danger">{{ session()->get('error')}} </div>
    @endif
</div>

\*home.blade.php
instead of using--> @include('layouts.flash')
use--> <x-alert/>

\*Advantages of components over @include
We can not pass any data inside included file. but using component we can do that

#**\*\***\*\***\*\***\_\_\_**\*\***\*\***\*\***TO DO list mini project #1

\*how to create table?
ans: using migration, need model to interact with table

need a table named 'todos'
table->'todos'
title: string
complited: boolean

need a model named todo: (which will interact with table todos)

model->'todo'

*So we need 4 things
model:todo ( $ php artisan make:model )
	migration:todos ( $ php artisan make:migration )
routes ( create a route by own )
controller ( \$ php artisan make:controller )
*How we create all these things?

\*But laravel is so smart to do these thing in easy.
\$ php artisan make:model Todo -mc (CMD) [m->migration, c->controller][here model, migration, controller is created. ]

results: table -> todos (database/migrations/)
model -> todo (view/)
controller ->TodoController (Http/Controller/)

\*Now we will create structure of todo table in migrations

-   then we need to add table to database
    ~\$ php artisan migrate (CMD) [dont use fresh or refresh, if so then
    [we will loss our table data ]

\*We have done 3 task out of 4 now we need to make routes

#**\*\***\_\_\_**\*\***TO DO list mini project #2 (Views, Store and Validation)

\*create a 'todos' dir inside the resources/views

-   make a route in web.php for index
    Route::get('/todos', 'TodoController@index'); //inside todos directiory file named index.blade.php
    \*create a file named 'index.blade.php' in the folder 'todos'

*   make another route in web.php for create todo
    Route::get('/todos/create', 'TodoController@create'); //inside todos directiory file named create.blade.php
    \*create a file named 'create.blade.php' in the folder 'todos'

*   make another route in web.php for edit todo
    Route::get('/todos/edit', 'TodoController@edit'); //inside todos directiory file named edit.blade.php
    \*create a file named 'edit.blade.php' in the folder 'todos'

------here is the controller of todo from routes.
\*\*TodoController
class TodoController extends Controller
{
public function index()
{
return view('todos.index'); //inside todos directiory file named index.blade.php
}
public function create()
{
return view('todos.create'); //inside todos directiory file named index.blade.php
}
public function edit()
{
return view('todos.edit'); //inside todos directiory file named index.blade.php
}
}

\*now create a form inside the create.blade.php

<div class="text-center pt-10">
<h1 class="text-2xl">What next you need To-Do</h1>
<form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
@csrf <!-- this @csrf token handles routes in form -->
<input type="text" name="title" class="py-2 px-2 border"/>
<input type="submit" value="Create" class="p-2 border rounded"/>
</form>
</div>

\*here form method is 'POST' so we need to create a function for storing data inside
TodoController via "Route::post" from web.php

Route::post('/todos/create','TodoController@store'); //in web.php

\*add the store function inside the TodoController.php
public function store(Request $request)
    {
        //dd($request->all());
Todo::create(\$request->all());
}

\*Now after submitting the form error
<<Add [_token] to fillable property to allow mass assignment on [App\Todo].>>

\*add below line to Todo.php (Model)
protected \$fillable = ['_token'];

\*after submitting the form another error
<<Column not found: 1054 Unknown column '\_token' in 'field list' (SQL: insert into `todos` (`_token`, `updated_at`, `created_at`) values >>

\*edit below line to Todo.php (Model)
protected \$fillable = ['title'];
again error->>>> 'completed' column is required

\*Todo table:
\$table->boolean('completed')->default(false); //it makes dafault value of completed as false,
// no need to pass the data
//default value = 0 now

    and then
    ~$ php artisan migrate:fresh (Never use in production, because it erash all the datas in table)

    ~$ php artisan serve [ refresh the page and now no error and data
    		      is saved in the database]

\*TodoController.php
public function store(Request $request)
    {
        // dd($request->all());
Todo::create(\$request->all());
return redirect()->back()->with('message', 'Todo created successfully!');
}

\*\*\*but the message is not showing.
solution: add <x-alert/> in the from segment of create.blade.php

\*After adding the <x-alert/> the message shows but the messgae is now showing
with a green background. [because we use tailwind not bootstrap]
Solution: = we need to change the alert.blade.php file

\*alart.blade.php

<div>
    @if(session()->has('message'))
    <!-- <div class="alert alert-success">{{ session()->get('message')}} </div> -->
    <div class="py-4 px-2 bg-green-400">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <!-- <div class="alert alert-danger">{{ session()->get('error')}} </div> -->
    <div class="py-4 px-2 bg-red-300">{{ session()->get('error')}} </div>
    @endif
</div>

Now it works.......

\*But another problem arises. when we Click Create button without input anything
in the text filled. then error......
We need to handle this like before we did.

#**\*\***\*\*\*\***\*\***\_**\*\***\*\*\*\***\*\***TO DO list mini project #5
Solves:
public function store(Request $request)
    {
        if(!$request->title)
{
return redirect()->back()->with('error', 'Please Give Title');
}

Todo::create(\$request->all());
return redirect()->back()->with('message', 'Todo created successfully!');
}
\*but above code is not a good way of validation message.
because many more field may have in database.
SO its bad way to to do condition for each and every field like that.

Solution:
#Writing The Validation Logic-> Laravel Documentation
#Available Validation Rules -> Laravel Documentation
\$Displaying The Validation Errors ->Laravel Documentation

\*TodoController.php
public function store(Request $request)
    {
        $request->validate([
'title'=>'required'
]);

        Todo::create($request->all());
        return redirect()->back()->with('message', 'Todo created successfully!');
    }

->But the problem is no error message apppears when submitting without message.
because we do this kind of validation the error will go inside the session as
a name of "errors" not "error"

that means when we use this kind of validation the validation autumatically
returns and shows the error message as "errors"

Solution : Put a segment of code from Documentation to alert.blade.php after
the first if-else-endif condition

\*\_\_alert.blade.php

<div>
    @if(session()->has('message'))
    <!-- <div class="alert alert-success">{{ session()->get('message')}} </div> -->
    <div class="py-4 px-2 bg-green-400">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <!-- <div class="alert alert-danger">{{ session()->get('error')}} </div> -->
    <div class="py-4 px-2 bg-red-300">{{ session()->get('error')}} </div>
    @endif

    @if ($errors->any())
    <div class="py-2 px-2 bg-red-300">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

</div>

--> another problem also stays.....
when we pass a title name more than 255 of length then another error occurs.
We need to handle this problem.

    #max:value --> Laravel Documentation

Solution:
\$request->validate([
'title'=>'required|max:255'
]);

Now the error message: "The title may not be greater than 255 characters."
But I want to display my message.... How to do that?

Solution: --> Manually Creating Validators [Laravle Documentation]
\*TodoController.php

    public function store(Request $request)
    {
        $rules =[
            'title'=>'required|max:255',
        ];
        $messages = [
            'title.max' => 'ToDo title should not be greater than 255 chars',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //this code will not prevent below code code from eecuting so error will appears.
        //so we need below segment to check
        if ($validator->fails())
        {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Todo::create($request->all());
        return redirect()->back()->with('message', 'Todo created successfully!');
    }

```

```
