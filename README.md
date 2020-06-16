<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# **Documentation of Laravel 7 Basics**

[Laravel Official Docx](https://laravel.com/docs/7.x)

---

## **Installation**

---

### **Install composer**

**Option 1:**

```cmd
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

**Option 2:**
[Download Composer](https://getcomposer.org/Composer-Setup.exe)

**Create new Project**

```php
laravel new NameOfProject
```

> It will take few minutes to execute

---

## **Introduction**

---

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

---

## **RAW Structured Query Language**

---

Use this header in controller file to interact with Database

```php
use Illuminate\Support\Facades\DB;
```

below queries will be written inside the function of the Controller.

**Insert**

```php

class UserController extends Controller
{

    public function index()
    {
        DB::insert('insert into users (name, email, password) values (?, ?, ?)',
        ['Imrul', 'imrulhasan273@gmail.com', 'imrul']);

        $users = DB::select('select * from users');
        return $users;
    }
}

```

**Select**

```php
class UserController extends Controller
{

    public function index()
    {
        $users = DB::select('select * from users');
        return $users;
    }
}
```

**Update**

```php
class UserController extends Controller
{

    public function index()
    {
        DB::update('update users set name = ? where id = ?',
        ['Imrul',13]);
        $users = DB::select('select * from users');
        return $users;
    }
}
```

**Delete**

```php
class UserController extends Controller
{

    public function index()
    {
        DB::delete('delete from users');
        $users = DB::select('select * from users');
        return $users;
    }
}
```

---

## **Eloquent ORM (Object Relational Model)**

---

**Insert**

```php
class UserController extends Controller
{

    public function index()
    {
        $user =  new User();
        // var_dump($user); //var dumb
        // dd($user); //die and dumb, so much clean
        $user->name = 'Imrul Hasan';
        $user->email = 'imrulhasan273@gmail.com';
        $user->password = bcrypt('imrul');
        $user->save();
    }
}
```

**Fetch all the data from database table (select)**

```php
class UserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return $user;
    }
}
```

> `all()` is a static method and not static method. Magical statement? We can see all the fields value except `password`. Because password is `protected_hidden` field defined in `User.php` so that field will not come in `all()`

**`User.php`**

```php
/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
```

> If we want to view the password too in window then we need to delete `password` column from that `$protected` variable.

**Update**

```php
class UserController extends Controller
{

    public function index()
    {
        User::where('id',16)->update(['name' => 'Imrul Hasan']);
        $user = User::all();
        return $user;
    }
}
```

**Delete**

```php
class UserController extends Controller
{

    public function index()
    {
        User::where('id',14)->delete();
    }
}
```

> On the above query `id='14'` is explicitely defined which is not a process that we will working with. User model can only interact with users table.

> We can simplify the ORM query

> **Reduced the CRUD (ORM) - using create method**

> **`UserController.php`**

```php
public function index()
{
    $data = [
            'name'      =>  'Elon',
            'email'     =>  'elon@gmail.com',
            'password'  =>  bcrypt('password'),
            'mobile'    =>  112298989,
        ];
        User::create($data);
        $user = User::all();
        return $user;
}
```

> `mobile` column will not affect the **database** nor give any error because `fillable` variable in `User.php` will define which colums to be checked or inserted. Database has no column named `mobile`.

**`User.php`**

```php
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
}
```

> So we can see there is no column named `mobile` in `$fillable` variable. So database has no worry with other columns except the columns defined in `$fillable` variable.

**Reduced the CRUD (ORM): `Accessor` and `Mutaotors`**

> Mutator function is in `User.php` Model

> Accessor function is in `User.php` Model

> **`UserController.php`**

```php
public function index()
{
    $data = [
        'name'      =>  'elon',
        'email'     =>  'elon@gmail.com',
        'password'  =>  'password',
    ];
    User::create($data);
    $user = User::all();
    return $user;
}
```

> `password` is encrypter from User Defined function in `User.php`

**`User.php`**

```php
class User extends Authenticatable
{
    use Notifiable;

    //changing behavior -- Mutator --- inserting
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    //modifyting -- Accessor -- don't modify in DB  --fetching
    public function getNameAttribute($name)
    {
        return 'My name is: '.ucfirst($name);
    }
}

```

> `setPasswordAttribute` name is important. `set*Attributes`. Here `*` will be replaced by the column name. And the column name here should be in `Title case`. Say for exmaple: `Password`.

> `getNameAttribute` name is important. `get*Attributes`. Here `*` will be replaced by the column name. And the column name here should be in `Title case`. Say for exmaple: `Name`.

**No longer need to use the functions to `bcrypt` as we will import package `laravel ui` for these**

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
~$ php artisan ui:auth          [suggested]
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
~$ php artisan ui bootstrap         [suggested]
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

---

## **Blade Template Engine**

---

> all the routes are in routes/web.php

**To show the all the route list using cmd**

```cmd
~$ php artisan route:list
```

> **home page** is in `home.blade.php` which extend the `app.blade.php`

```php
@extends('layouts.app')
```

> Now this makes contents of `app.blade.php` + `home.blade.php` in one page (not one page actually, it acts like so for simplicity). So `home.blade.php` and `app.blade.php` pages are linked together. We can now call any of the contents directly from another page.

> Here `layout` is directory and `app` is file name which is shoutcut name of `app.blade.php`. This code should be imported on top of file.

> Syntax: `@extends('folder1.sub-folder2.sub-folder3.app')` We can search deeper path using this kind of syntax. That's why blade is is so powerful.

> In `layouts/app.blade.php` there are **navigation** segment and the **main** segment. Inside `<main> </main>` all the contents are getting using below code:

```php
@yield('content')
```

> On above line `@yield('content')` defines there is a code `Section` defined in any of the two pages which we linked before. And we can see there's a `Secion` named `content` in `home.blade.php`.
> Code section from `home.blade.php` given below:

```php
@extends('layouts.app')
@section('content')
<div class="container">
    <!-- codes... -->
</div>
@endsection
```

> To change name `content` of `@yield('content')` from `<main> </main>` in `app.blade.php` we must change name `content` from others files too in below directories:

-   `views/auth/`
-   `viwes/layouts/`
    > because if we don't, some segment will not display.

---

## **Laravel Configuration**

---

-   laravel projects, package and dependency have configuarations (config)

-   Directory:

    -   project/config/

    *   project/.env

*   Configurations in productions and development are different.

For example: in `.env` file below:

```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

> So there must be a file in `config` to get information from `.env` file for **RADIS** settings (setting above). To find the file where its informations are included just search a file related to **database** in `project/config/`. Because **REDIT** is a **database** file.

> One important thing to note that whenever there is a change in `.env` file. we must **restart the dev server**. Because the server keeps the settings in **cache**. So we need to restart te server to start new cache. Otherwise updated settings will not take any effect.

T**he below code is made with a closure function: `routes/web.php`**

```php
Route::get('/', function (){
    // return env('APP_NAME');
    // return View::make('welcome'); //using Aaliyas
    return view('welcome'); //using helper function
});
```

-   Other config

    -   auth.php, etc

**Data flow from .env to services to web.php via config helper function: `web.php`**

```php
Route::get('/', function () {
    return  config('services.ses.key');
});
```

> To learn more about Laravel configuaration [Configuration](https://laravel.com/docs/7.x/configuration#introduction)

    return config('services.ses.key');
    data flow from .env to services to web.php via config helper function

---

## **Upload Avator/Profile Picture**

---

-   Uploaded image will be stored in `storage/app/public` directory

**From for upload an image is in `home.blade.php`**

```php
<div class="card-body">
    <form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image"/>
    <input type="submit" name="upload"/>
    </form>
</div>
```

-   In the from `action ="/upload"` means it will execute in `/upload` directory. So we need to create this `route` in `web.php`

*   csrf = cross site request forgery. `@csrf` is important to `import` inside `form`. Because without it form will not successfully executed.

-   No one can submit the from with fake data Laravel automatically generates a CSRF "token" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.

> When we submit `form` then an exra hidden `input` is generated which is for `csrf token`.

**The input is look like below:**

```php
<input type="hidden" name="_token" value="BlV0DglRFa5wzyCUN88H0OBSocUdz6KKts0hhDjQ">
```

> We can find the above input using `return dd($user);`

> To learn more about csrf token [csrf](https://laravel.com/docs/7.x/csrf#csrf-introduction)

**below code is using closure: `web.php`**

```php
    Route::post('/upload', function(){
       dd(request()->all()); //the requested form will be shown
    });
```

> but above code is not secure instead use below code for injection

```php
Route::post('/upload', function(Request $request){
    // dd($request->all()); //the requested form will be shown --  same as above Route
    //dd($request->file('image'));  //it will shows null in page Why?
                                    //enctype="multipart/form-data" should be used in form
    //dd($request->image); //same as above line
    dd($request->hasFile('image')); //check if form contains any file or not. (true/false)
    });
```

-   We have `user table` without `avatar column`.

```php
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

-   Then, we added `avatar column` in `database/migrations/user table` in schema

```php
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('avatar')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}
```

-   Now we have `extra one column` in user table in `migrations`.
    but user table already in `database` doesn't contain `the column`. So `php artisan migrate` command will not work for it.

**Here are some command for `php artisan migrate`**

-   **migrate:fresh** Drop all tables and re-run all migrations
-   **migrate:install** Create the migration repository
-   **migrate:refresh** Reset and re-run all migrations
-   **migrate:reset** Rollback all database migrations
-   **migrate:rollback** Rollback the last database migration
-   **migrate:status** Show the status of each migration

```cmd
~$ php artisan migrate:refresh
```

> Using above command the `database` will `refresh` all the tablea. So if `new columna` were added in `migration` then these `columns` will also be added in the `database`.

> To upload image we will use `UserController.php`. After uploading it doesn't get the `original name only` instead it contains all the details of images. So will we go to `depth of laravel` to grab the `image name` only

**Directory:** `vendor/laravel/framework/src/illuminate/Http/UploadedFile.php`

```php
public static function createFromBase(SymfonyUploadedFile $file, $test = false)
{
    return $file instanceof static ? $file : new static(
        $file->getPathname(),
        $file->getClientOriginalName(),
        $file->getClientMimeType(),
        $file->getError(),
        $test
        );
}
```

> Search for `original name` in that file. And found `$file->getClientOriginalName()`, in a function like above. Copy `getClientOriginalName` and use it in `UserController.php`

```php
dd($request->image->getClientOriginalName());
```

**`UserController.php`**

```php
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
```

> To view avatar of user in Navigation bar add an `<img/>` tag in the `app.blade.php` on approprite position
> **app.blade.php**

```php
@if(Auth::user()->avatar)
<img src="{{ Auth::user()->avator }}" alt="avatar"/>
@endif
```

> but unfortunately the image of user didn't show here.

---

## **Fixing the problem of not showing avator**

---

**Fixing problem 1: dynamically update database**

> find logged user and update avatar: `UserController.php`

```php
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
```

**Fixing problem 2: View Avatar in Profile Dashboard from Storage Directory**

-   `project/storate` directory is not accesable directly.
-   We can access `project/public` directory directly
-   So We need to make a link between `project/storage/public` and `project/public` directory.

> To make a link between two we need following command

```cmd
~$ php artisan storage:link
```

> After that command we can see a link of `storage` directry in the `project/public` directory. Now we can access the `public` directory inside `storage` directory via `project/public` directory.

**_NOTE: we can access only `public` dir of `storage` dir, Not `other` dir._**

**Now we need to correcly path the location to get the images: `app.blade.php`**

```php
<img src="{{ asset('/storage/images/'.Auth::user()->avatar) }}" alt="avatar" width="60px" height="60px"/>
```

**Problem 3: After updating the new avatar, old image still in storage**

-   This will take space without needing

#### Remove OLD image before update

> to delete the previous avatar of user before updating the avatar

**`User.php` (Model)**

```php
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
```

**`UserController.php`**

```php
public function uploadAvatar(Request $request)
{
    if($request->hasFile('image'))
    {
        User::uploadAvatar(\$request->image);
        return redirect()->back(); //success msg
    }
    return redirect()->back(); //err msg
}
```

---

## **Flash Session**

---

**`UserController.php`**

```php
session()->put('message','Avatar has been changed');
```

**`home.blade.php`**

```php
@if(session()->has('message'))
<div class="alert alert-success">{{ session()->get('message')}} </div>
@endif
```

> But the problem is message stays even after reloading. So how do we remove message after reload?

**Solution: Use below code segment**

**`UserController.php`**

```php
public function uploadAvatar(Request $request)
{
    if($request->hasFile('image'))
    {
        User::uploadAvatar($request->image);
        $request -> session()->flash('message','Image Uploaded!');
        return redirect()->back(); //success msg
    }
    $request -> session()->flash('error','Image Not Uploaded!');
    return redirect()->back(); //err msg
}
```

**`home.blade.php`**

```php
@if(session()->has('message'))
<div class="alert alert-success">{{ session()->get('message')}} </div>
{{ session()->forget('message') }}
@elseif(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error')}} </div>
@endif
```

> But we can do that kind of **messages** more easier way for that **when we redirect to the back page**.

**FINALLY**

**`UserController.php`**

```php
public function uploadAvatar(Request $request)
{
    if($request->hasFile('image'))
    {
        User::uploadAvatar(\$request->image);
        return redirect()->back()->with('message','Image Uploaded!');
    }
    return redirect()->back()->with('error','Image Not Uploaded!');
}
```

**`home.blade.php` (no change)**

```php
@if(session()->has('message'))
<div class="alert alert-success">{{ session()->get('message')}} </div>
{{ session()->forget('message') }}
@elseif(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error')}} </div>
@endif
```

---

## **Blade Include Subview**

---

> We can make another file for `flash message` so that we dont need to explicitely write the code segment again for every file whenever needed. So now we just call the file when needed this kind of flash message.

**`views/layouts/flash.blade.php`**

```php
@if(session()->has('message'))
<div class="alert alert-success">{{ session()->get('message')}} </div>
{{ session()->forget('message') }}
@elseif(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error')}} </div>
@endif
```

**`views/home.blade.php`**

```php
@include('layouts.flash')
```

### **Alternative way of flash message**

> we can create `componets` by installing a library which is laravel's greate feature.

> To learn more about [components](https://laravel.com/docs/7.x/blade#components)

**To create a class based component follow the command**

```cmd
~$ php artisan make:component Alert
```

-   The command will create two directory
    -   `app/view/componets`
    *   `resources/views/components/alert.blade.php`

**Copy the code that was in `flash.blade.php` and Past it to `alert.blade.php`**

**`alert.blade.php`**

```php
<div>
    @if(session()->has('message'))
    <div class="alert alert-success">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <div class="alert alert-danger">{{ session()->get('error')}} </div>
    @endif
</div>
```

**`home.blade.php`**

```php
<x-alert/>
```

> instead of using `@include('layouts.flash')` now we are using use `<x-alert/>`

> Advantages of `components` like `<x-alert>` over `@include`: We can not pass any data inside included file. but using component we can do that

---

## **TO DO list mini project #1**

---

**how to create table?**

> Ans: using migration, need model to interact with table

**Table name: `todos`**

-   title: string
-   complited: boolean

**Model Name: `todo`** (which will interact with table todos)

**So we need 4 things to create a `table`**

1. model: `todo`
2. migration: `todos` [table]
3. routes: Manual Creation
4. controller: `TodoController`

**How we create all these things?**

```cmd
~$ php artisan make:model
~$ php artisan make:migration
~$ php artisan make:controller
```

> But laravel is so smart to do these thing in easy. So we can do all the three command in one line like below:

```cmd
~$ php artisan make:model Todo -mc   [Suggested]
```

**flags:**

-   `m`= migration
-   `c` = controller
-   Model, Migration and Controller is created.

**Results**

> Table: `todos`. Directory: `database/migrations/`

> Model: `todo`. Directory: `view/`

> Controller: `TodoController`. Directory: `Http/Controller/`

**Now we will create structure of todo table in migrations**

**`migratioon/todos table`**

```php
class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }
```

> Then we need to add `table` to database

```cmd
~$ php artisan migrate
```

> Dont use `fresh` or `refresh` migration command, if so then we will loss our datas from table.

> We have done 3 task out of 4 now we need to make routes.

## **To Do list mini project #2: Views, Store and Validation)**

> Create a `todos` directory inside the `resources/views/` So that all the todo related files will be stored in that directory.

---

**Creating a route in `web.php` for `index`**

**`web.php`**

```php
Route::get('/todos', 'TodoController@index');
```

> Inside `todos` directiory file name is `index.blade.php`. `index` function inside the `TodoController`

> Create a file named `index.blade.php` in the folder `todos`

---

**Creating a route in `web.php` for `create` todo**

**`web.php`**

```php
Route::get('/todos/create', 'TodoController@create');
```

> Inside `todos` directiory file name is `create.blade.php`. `create` function inside the `TodoController`

> Create a file named `create.blade.php` in the folder `todos`

---

**Creating a route in `web.php` for `edit` todo**

**`web.php`**

```php
Route::get('/todos/edit', 'TodoController@edit');
```

> Inside `todos` directiory file name is `edit.blade.php`. `edit` function inside the `TodoController`

> Create a file named `edit.blade.php` in the folder `todos`

---

**`TodoController.php`**

```php
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
```

**Now create a form inside the `create.blade.php`**

```php
<div class="text-center pt-10">
    <h1 class="text-2xl">What next you need To-Do</h1>
    <form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
</div>
```

> Here form `method="POST"` so we need to create a function for storing data inside `TodoController` via `Route::post` from `web.php`

> In this `form` We use `Tailwind` framework for `CSS` instead of `bootstrap`.

```css
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
```

**`web.php`**

```php
Route::post('/todos/create','TodoController@store'); //in web.php
```

**Add the store function inside the `TodoController.php`**

**`TodoController.php`**

```php
public function store(Request $request)
{
    //dd($request->all());
    Todo::create(\$request->all());
}
```

> Now after submitting the form error: `Add [_token] to fillable property to allow mass assignment on [App\Todo].`

**Add below line to `Todo.php` (Model)**

```php
class Todo extends Model
{
    protected $fillable = ['_token'];   //added line
}
```

> After submitting the form another error: `Column not found: 1054 Unknown column '\_token' in 'field list' (SQL: insert into todos ( \_token`,`updated_at`,`created_at) values`

**Edit below line to `Todo.php` (Model)**

```php
class Todo extends Model
{
    protected $fillable = ['title'];   //added line
}
```

> Again error: `completed column is required`

> **Edit below line of code from `todo` table in `migrations/`**

```php
$table->boolean('completed')->default(false);
```

**Now the table look like this:**

```php
public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}
```

> It makes `dafault value` of completed as `false`, no need to pass the data, `default value = 0` now

And then

```cmd
~$ php artisan migrate:fresh
```

> Never use in production, because it erash all the datas in table

```cmd
~$ php artisan serve
```

> refresh the page and now no error and data is saved in the database

**`TodoController.php`**

```php
public function store(Request $request)
{
    //dd($request->all());
    Todo::create(\$request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

> But the `message` is not showing weather uploaded or not.

**Solution:** add `<x-alert/>` in the from segment of `create.blade.php`.

> After adding the `<x-alert/>` the message appears but without any `CSS`. Because we use `tailwind` not `bootstrap`

**Solution:** We need to change the `alert.blade.php` file

**`alart.blade.php`**

```php
<div>
    @if(session()->has('message'))
    <div class="py-4 px-2 bg-green-400">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <div class="py-4 px-2 bg-red-300">{{ session()->get('error')}} </div>
    @endif
</div>
```

**Now it works.......**

> But another problem arises when we Click Create button without input anything in the text filled. We need to handle this like before we did.

---

## **TO DO list mini project #5**

---

Solves:

```php
public function store(Request $request)
{
    if(!$request->title)
    {
        return redirect()->back()->with('error', 'Please Give Title');
    }

    Todo::create(\$request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

> but above code is not a good way of validation message. because many more field may have in database. So its bad way to do `condition` for each and every `fields` like that.

**Solution:**

[Writing The Validation Logic](https://laravel.com/docs/7.x/validation#quick-writing-the-validation-logic)

[Available Validation Rules](https://laravel.com/docs/7.x/validation#available-validation-rules)

[Displaying The Validation Errors](https://laravel.com/docs/7.x/validation#validation-quickstart)

**`TodoController.php`**

```php
public function store(Request $request)
{
    $request->validate([
    'title'=>'required'
    ]);

    Todo::create($request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

> But the problem is no error message apppears when submitting without message. Because we do this kind of validation the error will go inside the session as a name of `errors` not `error`. Previously that was `error`. That means when we use this kind of validation the validation autumatically returns and shows the error message as `errors`

**Solution:** Put a segment of code from Documentation to `alert.blade.php` after the first `if-else-endif` condition

**`alert.blade.php`**

```php
<div>
    @if(session()->has('message'))
    <div class="py-4 px-2 bg-green-400">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
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
```

> Another problem also stays. When we pass a title name more than 255 of length then another error occurs. We need to handle this problem.

_**max:value --> Laravel Documentation**_

**Solution:**

```php
$request->validate([
'title'=>'required|max:255'
]);
```

> Now the error message: `The title may not be greater than 255 characters.`

> But I want to display my own message. How to do that?

**Solution:**

[Manually Creating Validators](https://laravel.com/docs/7.x/validation#manually-creating-validators)

**`TodoController.php`**

```php
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
