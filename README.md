<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# **Documentation of Laravel 7 Basics**

<h3 style="color:green;">Md. Imrul Hasan</h3>
<h5></h5>

[Laravel Official Docx](https://laravel.com/docs/7.x)

---

## <center>**Installation**</center>

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

## <center>**RAW Structured Query Language**</center>

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

## <center>**Eloquent ORM (Object Relational Model)**</center>

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

## <center>**Blade Template Engine**</center>

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

## <center>**Laravel Configuration**</center>

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

## <center>**Upload Avator/Profile Picture**</center>

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

## <center>**Fixing the problem of not showing avator**</center>

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

## <center>**Flash Session**</center>

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

## <center>**Blade Include Subview**</center>

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

## <center>**TO DO list mini project #1**</center>

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

## <center>**To Do list mini project #2: Views, Store and Validation)**</center>

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

## <center>**TO DO list mini project #5**</center>

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

---

## <center>**From Validation**</center>

---

> In laravel there is very easy for validating a form. So we don't need to define validation rules and function of our own. We can just use the built in system by laravel.

> Documentation: [From Validation](https://laravel.com/docs/7.x/validation#form-request-validation")

> For more complex validation scenarios, you may wish to create a "form request". Form requests are custom request classes that contain validation logic. To create a form request class, use the make:request Artisan CLI command:

**To create our own form request we have command in laravel**

**Create a Request**

```cmd
~$ php artisan make:request TodoCreateRequest
```

-   Directory: `App\Http\Requests\`
    The new file looks like below:

**`TodoCreateRequest`**

```php
<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
```

> If the authorize method `returns false`, a HTTP response with a 403 status code will automatically be returned and your controller method will not execute. If you plan to have authorization logic in another part of your application, `return true` from the authorize method:

```php
/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */
public function authorize()
{
    return true;
}
```

> Now `$rules` move from `TodoController.php` to `TodoCreateRequest.php`

Now `TodoCreateRequest.php`

```php
/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|max:255',
        ];
    }
```

> Now how we can use these rules? We will use our own form request `TodoCreateRequest`
> instead of default parent `Request`. It will not affect any problem because `TodoCreateRequest` indirectly extends `Request`.

> Now we deleted the validation method that was written in `TodoController.php` becuase now our `requests` are comming from the `TodoCreateRequests`

> Use below header in `TodoController.php`

```php
use App\Http\Requests\TodoCreateRequest;
```

**`TodoCreateController.php`**

```php
public function store(TodoCreateRequest $request)
{
    Todo::create($request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

---

> Now check in the dev server.

> Now we are facing the problem of custom validation rules again. Because we want to display our `own message`.

Solution: [Customizing The Error Messages](https://laravel.com/docs/7.x/validation#customizing-the-error-messages")

Add the below function in `ToCreateRequest.php`

```php
public function messages()
{
    return [
        'title.max' => 'ToDo title should not be greater than 255 chars',
    ];
}
```

**Now the `ToCreateRequest.php` looks like below**

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'ToDo title should not be greater than 255 chars',
        ];
    }
}
```

> Now the `store` function of `TodoController` look very clean. And the function now do 2 things. 1. Create and 2. Redirect. And all the business logic of validation task are now moved in to its own dedicated file that is `TodoCreateRequest`.

---

## <center>All todos</center>

---

**How to get all the todos from database [todos table]**

_Flow:_

> `web.php` ---> `Route::get('/todos', 'TodoController@index');`

> `TodoController.php` ---> `index()`

**`TodoController.php`**

```php
public function index()
{
    $todos = Todo::all();
    return $todos;
    // return view('todos.index');
}
```

How can we pass the `$todos` values from this page to `todos/index.blade.php` file?

**Solution**

**`TodoController.php`**

```php
public function index()
{
    $todos = Todo::all();
    // return $todos;
    return view('todos.index')->with(['todos'=> $todos]);
}
```

**`todos/index.blade.php`**

```php
<h3>All todos</h3>

<ul>
    @foreach($todos as $todo)
    <li>
        {{ $todo->title }}
    </li>
    @endforeach
</ul>
```

> But the look is not good. Now we will make it look better with the help of `tailwind` css.

After adding CSS with HTML structure.

**`todos/index.blade.php`**

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Todos</title>
</head>
<body>
    <div class="text-center pt-10">
        <h1 class="text-2xl">All your ToDos</h1>
        <ul>
            @foreach($todos as $todo)
            <li>
                {{ $todo->title }}
            </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
```

> Its its not good practice to have some same pice of code segment in multiple pages. Rather we can save common segemnt in another page. So that we can call it when needed.

> Create a file named `layout.blade.php` inside `views/todos` directory. And this layout is only related to our **todo**. This file contains some common elements of other `todo` pages.

**After Simplifying, the files look like below:**

`views/todos/layout.blade.php`

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Todos</title>
</head>
<body>
    <div class="text-center pt-10">
        @yield('content')
    </div>
</body>
</html>
```

`todos/index.blade.php`

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl">All your ToDo's</h1>
    <ul>
        @foreach($todos as $todo)
        <li>
            {{ $todo->title }}
        </li>
        @endforeach
    </ul>
@endsection
```

`todos/create.blade.php`

```php
@extends('todos.layout')

@section('content')
    <h1 class="text-2xl">What next you need To-Do</h1>
    <x-alert/>
    <form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
@endsection
```

`TodoController.php`

```php
public function index()
{
    $todos = Todo::all();
    return view('todos.index', compact('todos'));
}
```

> We can also simplify `index()` function of `TodoController.php`.
> instead of `with()` we can use `compact()` method of PHP. Inside `compact('variable')`. `variable` should match with the **Variable** name. And no need to provide **`$`** sign inside `compact()` method.

---

# <center>**Dynamic Route parameter**</center>

---

-   We need a `create` button in the `todos/index.blade.php` to **create** new todo.

-   We need a `back` button in the `todos/create.php` to come back to `index` page.

-   We need `edit` buttons for every data in the `todos/index.blade.php` to edit value.

`todos/index.blade.php`

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-center py-2">
       <p>{{$todo->title}}</p>
       <a href="{{'/todos/'.$todo->id.'/edit'}}" class="mx-5 py-1 px-1 bg-orange-400 cursor-pointer rounded text-white">Edit</a>
    </li>
    @endforeach
</ul>
@endsection
```

> here in the `index.blade.php` when we edit a row we need to pass the `id` of `title` in `url` so that we can know which `title` should be edited through unique column `id`. So we passed the `id` into the `url`.

`todos/create.blade.php`

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl">What next you need To-Do</h1>
    <x-alert/>
    <form action="/todos/create" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

> But now the problem is `404 | Not Found` when edit. Lets modify the `route`.

`web.php`

```php
Route::get('/todos/id/edit', 'TodoController@edit');
```

> Still not working. Because this `id` is dynamic. So have a look for solution in documentation
> [Required Parameter](https://laravel.com/docs/7.x/routing#required-parameters). Sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a user's ID from the URL. You may do so by defining route parameters:

`web.php`

```php
Route::get('/todos/{id}/edit', 'TodoController@edit');
```

> Now it works.

**Now its time to work with `TodoController@edit`**

`TodoController.php`

```php
public function edit($id)
{
    // dd($id);
    $todo = Todo::find($id);
    // return $todo;
    return view('todos.edit', compact('todo'));
    //inside todos directiory file named edit.blade.php
}
```

`todos/edit.blade.php`

```php
@extends('todos.layout')
@section('content')
    {{ $todo->title }}
@endsection
```

---

# <center>**Route Model Binding**</center>

---

> When injecting a model ID to a route or controller action, for example: `find($id)`, you will often query to retrieve the model that corresponds to that ID. Laravel route model binding provides a convenient way to automatically inject the model instances directly into your routes. For example, instead of injecting a user's ID, you can inject the entire User model instance that matches the given ID.

> Documentation: [Route Model Binding](https://laravel.com/docs/7.x/routing#route-model-binding)

`web.php`

```php
Route::get('/todos/{todo}/edit', 'TodoController@edit');
```

`TodoController.php`

```php
public function edit(Todo $todo)
{
    dd($todo->title);
    return view('todos.edit', compact('todo'));
}
```

> Instead of using `$id` as parameter of `edit()` function. We Pass the `Model` name following by the `variable` name. And the `variable` name should match the `dynamic` variable name passes through `Route`. The `$todo` variable contains whole information related to that id.

> Here `{todo}` in `Route` and `(Model $todo)`. Note: in route dynamic variable, there is no `$` sign starting of the variable.

---

-   What if we pass the `title` instead of `id`?
    -   this will not work because `{ todo }` alaways try to find through `id`

Documentation: [Customizing The Key](https://laravel.com/docs/7.x/routing#route-model-binding)

below Route will now find through `title`.

**`web.php`**

```php
Route::get('/todos/{todo:title}/edit', 'TodoController@edit');
```

**`todos/index.blade.php`**

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>

<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-center py-2">
       <p>{{$todo->title}}</p>
       <a href="{{'/todos/'.$todo->title.'/edit'}}" class="mx-5 py-1 px-1 bg-orange-400 cursor-pointer rounded text-white">Edit</a>
    </li>
    @endforeach
</ul>
@endsection
```

> So this functionality is very `unique` things. That's why laravel is so powerful.

---

> If you always want to find the todo with `title` on route model binding.

Documentation: [Customizing The Default Key Name](https://laravel.com/docs/7.x/routing#route-model-binding)

**Add below function** to `Todo.php`

```php
public function getRouteKeyName()
{
    return 'title';
}
```

`Todo.php`

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title'];

    public function getRouteKeyName()
    {
        return 'title';
    }
}

```

`web.php`

```php
Route::get('/todos/{todo}/edit', 'TodoController@edit');
```

> So we don't need to use `{ todo:title}` instead of `{ todo }` as we customized the default key name in `Todo.php` **Model**.

`todos/index.blade.php`

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>

<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-center py-2">
       <p>{{$todo->title}}</p>
       <a href="{{'/todos/'.$todo->title.'/edit'}}" class="mx-5 py-1 px-1 bg-orange-400 cursor-pointer rounded text-white">Edit</a>
    </li>
    @endforeach
</ul>
@endsection
```

---

# <center>**Named Route**</center>

---

> Now we will update todo `title`. For that we need a `form` or a simple `textbox` in `edit.blade.php`.

`todos/edit.blade.php`

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl">Update this Todo list</h1>
    <x-alert/>
    <form action="/todos/update" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

`web.php`

```php
Route::patch('/todos/{todo}/update','TodoController@update');
```

> Now we need a `patch` request instead of `post` request. There is also `put` request. Both will work. And we need to update a specific `todo` so the route will be simiter to `store` route. like inside link we need to pass the todo `id` --> `{todo}`

> Difference between `GET`, `POST`, `PATCH` and `PUT`: [Difference](https://stackoverflow.com/questions/31089221/what-is-the-difference-between-put-post-and-patch)

Creating a function named `update` inside `TodoController.php`.

> `TodoController.php`

```php
public function update(Todo $todo)
{
    //update code
}
```

> Now how can we grab the `id` in between these -> `action="/todos/update"`

> Named routes allow the convenient generation of URLs or redirects for specific routes. You may specify a name for a route by chaining the name method onto the route definition:

> Documentation: [Named Route](https://laravel.com/docs/7.x/routing#named-routes).

`web.php`

```php
Route::patch('/todos/{todo}/update','TodoController@update')->name('todo.update');
```

> what are you going to do? -> `todo` and the task is -> `update`. So `name('todo.update')`. This name route will be used inside `<form>` as an `action` for pathing.

And the `todos/edit.blade.php` will be like below:

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl">Update this Todo list</h1>
    <x-alert/>
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
        @csrf
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

> Now it works.... Now if we `inspect` element inside the `http://127.0.0.1:8000/todos/1/edit` page, we can see `action="http://127.0.0.1:8000/todos/1/update"` for the `form`.

Let's check if update function works or not.

`TodoController.php`

```php
public function update(Request $request, Todo $todo)
{
    dd($request->all());
}
```

> We need `Request` inside the function parameter.

> But update function didn't work. Error: `The POST method is not supported for this route. Supported methods: PATCH.`

> So we need a `patch` method. We need a hack. We need to provide a `method` field and say `path` is the method. After updating the `edit.blade.php` file.

`edit.blade.php`

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl">Update this Todo list</h1>
    <x-alert/>
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
        @csrf
        @method('patch')
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

Now we will make the `update` operation inside the `update` function on `TodoController`.

`TodoController.php`

```php
public function update(Request $request, Todo $todo)
{
    $todo->update(['title' => $request ->title]);
    return redirect()->back()->with('message','Updated!');
}
```

> Update operation successful! And the page is redirect to the edit page.

Below is the way to redirect to the `All Todo` page that's the main page.

`TodoController.php`

```php
public function update(Request $request, Todo $todo)
{
    $todo->update(['title' => $request ->title]);
    return redirect(route('todo.index'))->with('message','Updated!');
}
```

> we also need to provide the **`Named Route`** of `index` route in `web.php` so that we can `route` it from anywhere with the `Named Route` only. We don't need to explicitely write the path there. Named routes is an important feature in the Laravel framework. It allows you to refer to the routes when generating URLs or redirects to the specific routes. In short, we can say that the naming route is the way of providing a nickname to the route.

`web.php`

```php
Route::get('/todos', 'TodoController@index')->name('todo.index');
```

> We also need to add `<x-alert/>` in the `index.blade.php` to view the message.

`index.blade.php`

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>
<x-alert/>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-center py-2">
       <p>{{$todo->title}}</p>
       <a href="{{'/todos/'.$todo->id.'/edit'}}" class="mx-5 py-1 px-1 bg-orange-400 cursor-pointer rounded text-white">Edit</a>
    </li>
    @endforeach
</ul>
@endsection
```

> Solved!!!

---

# <center>**Update Todo Validation**</center>

---

> Previously we have use validation which is `FormRequest` when we were storing the `todo`. We can create another `FormRequest` for update. But we want same kind of functionality, exactly same validation on the update. So we can use the same `FormRequest` also.

Just replace the normal `Requst` with the `FormRequest` that's the `TodoCreateRequest`.

```php
public function update(TodoCreateRequest $request, Todo $todo)
{
    $todo->update(['title' => $request ->title]);
    return redirect(route('todo.index'))->with('message','Updated!');
}
```

> We can now successfully complete the validation.

> Suppose, you will have the condition when you need to create a different **form request** for `update` only. For example, for the `store()` function if you have some kind of `upload` operation. Then you need `image` valodation also. So the validation for `TodoCreateRequest` will contains validation for `title` as well as `image`. But the problem is in `update()` operation you just want to update the `title` only not the `image`. Then if you use the same `FormRequest` also then you must update the `image` also because that `FromRequest` contains `image` validation also. So need to create another `FormRequest` for update operation.

---

> Now we beautify the message in page. Because the message block whole page with horizozntal line. And fix some padding and etc.

After Cleaning up

`layout.blade.php`

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Todos</title>
</head>
<body>
    <div class="text-center flex justify-center pt-10">
        <div class="w-1/3 border border-grey-400 rounded py-4">
        @yield('content')
        </div>
    </div>
</body>
</html>
```

`create.blade.php`

```php
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
```

`edit.blade.php`

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl border-b pb-4">Update this Todo list</h1>
    <x-alert/>
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
        @csrf
        @method('patch')
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
    <a href="/todos" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

`index.blade.php`

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center border-b pb-4">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>
<x-alert/>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-between px-2 py-2">
       <p>{{$todo->title}}</p>
       <a href="{{'/todos/'.$todo->id.'/edit'}}" class="mx-5 py-1 px-1 bg-orange-400 cursor-pointer rounded text-white">Edit</a>
    </li>
    @endforeach
</ul>
@endsection


```

---

# <center>**Complete a Todo**<center>

---

After beautify the `index` page.

`TodoConroller.php`

```php
public function index()
{
    $todos = Todo::orderBy('completed')->get();
    return view('todos.index', compact('todos'));
}
```

> Documentation: [Order By](https://laravel.com/docs/7.x/eloquent#advanced-subqueries)

> Use `Todo::orderBy('completed')->get();` instead of `Todo::all()`. We will use `get()` instead of `all()` when we have some task like `orderBy`.

Completed task will be in `green` mark on the other hand incomplete task will be in `gray` mark. using below condition:

```php
@if($todo->completed)
<span class="fas fa-check text-green-300 px-2"></span>
@else
<span class="fas fa-check text-gray-300 cursor-pointer px-2"></span>
@endif
```

Completed task title is visualizd by `linethrough` like below code:

```php
@if($todo->completed)
<p class="line-through">{{$todo->title}}</p>
@else
<p class="line-through">{{$todo->title}}</p>
@endif
```

`todos/index.blade.php`

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center border-b pb-4">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>
<x-alert/>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-between px-2 py-2">
        @if($todo->completed)
        <p class="line-through">{{$todo->title}}</p>
        @else
        <p>{{$todo->title}}</p>
        @endif
        <div>
        <a href="{{'/todos/'.$todo->id.'/edit'}}" class="text-orange-400 cursor-pointer text-white">
        <span class="fas fa-edit px-2"></span>
        </a>
        @if($todo->completed)
        <span class="fas fa-check text-green-300 px-2"></span>
        @else
        <span class="fas fa-check text-gray-300 cursor-pointer px-2"></span>
        @endif
        </div>
    </li>
    @endforeach
</ul>
@endsection
```

---

# <center>**Using Core JavaScript**</center>

---

## Task `Mark as Complete` for **todos**.

We created the below `submit` form.

```php
<form style="display:none" id="{{'form-complete-'.$todo->id}}" method="post" action="{{ route('todo.complete', $todo->id) }}">
@csrf
@method('put')
</form>
```

We added below line of code to submit form using `JS`

```php
<span onclick="event.preventDefault();
                        document.getElementById('form-complete-{{$todo->id}}')
                        .submit()"
                        class="fas fa-check text-gray-300 cursor-pointer px-2">
</span>
```

> We call the `form` using the `id` selector with JS.

And the `index` page will look like below:

**`todos/index.blade.php`**

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center border-b pb-4">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="/todos/create" class="mx-5 py-1 px-1 bg-blue-400 cursor-pointer rounded text-white">Create New</a>
</div>
<x-alert/>
<ul class="my-5">
    @foreach($todos as $todo)
    <li class="flex justify-between px-2 py-2">
        @if($todo->completed)
        <p class="line-through">{{$todo->title}}</p>
        @else
        <p>{{$todo->title}}</p>
        @endif
        <div>
        <a href="{{'/todos/'.$todo->id.'/edit'}}" class="text-orange-400 cursor-pointer text-white">
        <span class="fas fa-edit px-2"></span>
        </a>
        @if($todo->completed)
        <span class="fas fa-check text-green-300 px-2">
        </span>
        @else
        <span onclick="event.preventDefault();
                        document.getElementById('form-complete-{{$todo->id}}')
                        .submit()"
                        class="fas fa-check text-gray-300 cursor-pointer px-2">
        </span>
        <form style="display:none" id="{{'form-complete-'.$todo->id}}" method="post" action="{{ route('todo.complete', $todo->id) }}">
        @csrf
        @method('put')
        </form>
        @endif
        </div>
    </li>
    @endforeach
</ul>
@endsection
```

**`web.php`**

```php
Route::put('/todos/{todo}/complete','TodoController@complete') -> name('todo.complete');
```

> `patch` and `put` is similar things so we can also use it.

**`TodoController.php`**

```php
public function complete(Todo $todo)
{
    $todo->update(['completed'=> true]);
    return redirect()->back()->with('message','Task Marked as Completed!!!');
}
```

> The update operation.

**`Todo.php`**

```php
class Todo extends Model
{
    protected $fillable = ['title','completed'];
}
```

> Initially the `$fillable` variable didn't contains the `completed` column. So our value of `completed` column didn't take any effect in DB after updating. After we added the column in the variable. And the update process is successfull.

---

## Task `Mark as incomplete` for **todos**.

> This segment is fully same as `complete` task. So I am not going to describe the process.

**`web.php`**

```php
Route::delete('/todos/{todo}/incomplete','TodoController@incomplete') -> name('todo.incomplete');
```

> `delete` is another alternative of `patch` or `put`.

`**TodoController.php`\*\*

```php
public function incomplete(Todo $todo)
{
    $todo->update(['completed'=> false]);
    return redirect()->back()->with('message','Task UnMarked as Completed!!!');
}
```

`**todos/index.blade.php`\*\*

```php
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
        @if($todo->completed)
        <p class="line-through">{{$todo->title}}</p>
        @else
        <p>{{$todo->title}}</p>
        @endif
        <div>
        <a href="{{'/todos/'.$todo->id.'/edit'}}" class="text-orange-400 cursor-pointer text-white">
        <span class="fas fa-edit px-2"></span>
        </a>
        @if($todo->completed)
        <span onclick="event.preventDefault();
                        document.getElementById('form-incomplete-{{$todo->id}}')
                        .submit()" class="fas fa-check text-green-300 cursor-pointer px-2">
        </span>
        <form style="display:none" id="{{'form-incomplete-'.$todo->id}}" method="post" action="{{ route('todo.incomplete', $todo->id) }}">
        @csrf
        @method('delete')
        </form>
        @else
        <span onclick="event.preventDefault();
                        document.getElementById('form-complete-{{$todo->id}}')
                        .submit()"
                        class="fas fa-check text-gray-300 cursor-pointer px-2">
        </span>
        <form style="display:none" id="{{'form-complete-'.$todo->id}}" method="post" action="{{ route('todo.complete', $todo->id) }}">
        @csrf
        @method('put')
        </form>
        @endif
        </div>
    </li>
    @endforeach
</ul>
@endsection
```

---

## Delete a task in **todos**.

**`web.php1**

```php
Route::delete('/todos/{todo}/delete','TodoController@delete') -> name('todo.delete');
```

**`todos/index.blade.php`**

```php
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
```

> Some changes in `index`. We move the code of `complete` and `incomplete` logic in another file for simplicity, named `complete-button.blade.php`.

> Any user may delete the task accidentaly that's why there will display an alert window after click on delete button, if user is sure to delete the task.

**`todos/complete-button.blade.php`**

```php
@if($todo->completed)
<span onclick="event.preventDefault();
                        document.getElementById('form-incomplete-{{$todo->id}}')
                        .submit()" class="fas fa-check text-green-300 cursor-pointer px-2">
</span>
<form style="display:none" id="{{'form-incomplete-'.$todo->id}}" method="post" action="{{ route('todo.incomplete', $todo->id) }}">
@csrf
@method('delete')
</form>
@else
<span onclick="event.preventDefault();
                        document.getElementById('form-complete-{{$todo->id}}')
                        .submit()"
                        class="fas fa-check text-gray-300 cursor-pointer px-2">
</span>
<form style="display:none" id="{{'form-complete-'.$todo->id}}" method="post" action="{{ route('todo.complete', $todo->id) }}">
@csrf
@method('put')
</form>
@endif
```

**`TodoController.php`**

```php
public function delete(Todo $todo)
{
    $todo->delete();
    return redirect()->back()->with('message', $todo->title.' Task Deleted!!!');
}
```

---

# <center>**Resource Routes**</center>

> In `web.php` we created 6 routes for `todo` thats are for insert, update and delete operation. But we can combine all together in a route called `Rosource Route`.

> Documentation [Rosource ROute](https://laravel.com/docs/7.x/controllers#resource-controllers)

> First thing you requred a `resource controller` which is done by this command -> `php artisan make:controller PhotoController --resource`. But because we have already done with the controllers in `web.php`, we can directly use like this `Route::resource('photos', 'PhotoController');`

Before adding the resource route, the 6 defined route in `web.php` is given below:

```php
Route::get('/todos', 'TodoController@index')->name('todo.index');
Route::get('/todos/create', 'TodoController@create');
Route::post('/todos/create','TodoController@store');
Route::get('/todos/{todo}/edit', 'TodoController@edit');
Route::patch('/todos/{todo}/update','TodoController@update') -> name('todo.update');
Route::delete('/todos/{todo}/destroy','TodoController@delete') -> name('todo.delete');
```

So the below only one route itself will replace the 6 defined routes.

```php
Route::resource('/todo','TodoController');
```

> Notice that we set `path` of the resource route as `/todo` instead of `/todos`.

**Actions Handled By Resource Controller**

| Verb      | URI                  | Action  | Route Name     |
| --------- | -------------------- | ------- | -------------- |
| GET       | /photos              | index   | photos.index   |
| GET       | /photos/create       | create  | photos.create  |
| POST      | /photos              | store   | photos.store   |
| GET       | /photos/{photo}      | show    | photos.show    |
| GET       | /photos/{photo}/edit | edit    | photos.edit    |
| PUT/PATCH | /photos/{photo}      | update  | photos.update  |
| DELETE    | /photos/{photo}      | destroy | photos.destroy |

> let's create a resource route and compare wether we we read this resource route or not using following command.

```cmd
~$ php artisan make:controller TodoResourceController --resource
```

Now I can differentiated with exixting controller and the controller I just created.

A file, named `TodoResourceController` is created in `app\Http\Controllers\TodoResourceController.php` directory.
like below:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
```

> We don't need to use this function in `TodoResourceController`. Because we have implemented those function in`TodoController.php` before. And those function override these functions. So don't worry about this.

> To see all the route name including function name type the command `php artisan route:list`

Edit the name of `delete` function to `destroy`

```php
public function destroy(Todo $todo)
{
    $todo->delete();
    return redirect()->back()->with('message', $todo->title.' Task Deleted!!!');
}
```

`index.blade.php` (updated)

```php
@extends('todos.layout')
@section('content')
<div class="flex justify-center border-b pb-4 px-4">
    <h1 class="text-2xl">All your ToDos</h1>
    <a href="{{route('todo.create')}}" class="mx-5 py-2 text-blue-400 cursor-pointer text-white">
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
        <a href="{{ route('todo.edit',$todo->id )}}" class="text-orange-400 cursor-pointer text-white">
        <span class="fas fa-edit px-2"></span>
        </a>

        <span class="fas fa-trash text-red-500 px-2 cursor-pointer"
                        onclick="event.preventDefault();
                        if(confirm('Are you sure to delete?'))
                        {
                            document.getElementById('form-delete-{{$todo->id}}')
                            .submit()
                        }"></span>

        <form style="display:none" id="{{'form-delete-'.$todo->id}}" method="post" action="{{ route('todo.destroy', $todo->id) }}">
        @csrf
        @method('delete')
        </form>
        </div>
    </li>
    @endforeach
</ul>
@endsection
```

> We just change some of the route using `named routes` instead of `hard code path`.

`edit.blade.php` (updated)

```php
@extends('todos.layout')
@section('content')
    <h1 class="text-2xl border-b pb-4">Update this Todo list</h1>
    <x-alert/>
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
        @csrf
        @method('patch')
        <input type="text" name="title" value="{{ $todo->title }}" class="py-2 px-2 border"/>
        <input type="submit" value="Update" class="p-2 border rounded"/>
    </form>
    <a href="{{ route ('todo.index')}}" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

> We just change some of the route using `named routes` instead of `hard code path`

`create.blade.php`

```php
@extends('todos.layout')

@section('content')
    <h1 class="text-2xl border-b pb-4">What next you need To-Do</h1>
    <x-alert/>
    <form action="{{ route('todo.store') }}" method="POST" enctype="multipart/form-data" class="py-5">
        @csrf <!-- this @csrf token handles routes in form -->
        <input type="text" name="title" class="py-2 px-2 border"/>
        <input type="submit" value="Create" class="p-2 border rounded"/>
    </form>
    <a href="{{route('todo.index')}}" class="m-5 py-1 px-1 bg-white-400 border cursor-pointer rounded text-black">Back</a>
@endsection
```

> We just change some of the route using `named routes` instead of `hard code path`

---

# <center>**Middlewares**</center>

---

> Documentation [MiddleWare](https://laravel.com/docs/7.x/middleware#introduction)

> Middle Ware Dir: `E:\github\seven\app\Http\Middleware\`

> If we go to `E:\github\seven\app\Http\Kernel.php` we will se we have a list of middleware that we already applied on Laravel. Laravel do all these things out of the box.

> Route Model Binding that actually works with these kind of `middleware`.

> But we gonna use the middleware which is called `Authenticate` middleware.

> If `user` is `logged in` then will will do something, otherwise we will `redirect` back that means some routes are `protected`.

> To assign middleware to all routes within a group, you may use the middleware method before defining the group. Middleware are executed in the order they are listed in the array:

We will use the `GroupedMiddleWare` now. [Route Groups](https://laravel.com/docs/7.x/routing#route-parameters)

## 3 ways to do that:

**Way 1:**

`web.php`

```php
Route::middleware('auth')->group(function(){
    Route::resource('/todo','TodoController');
    Route::put('/todos/{todo}/complete','TodoController@complete') -> name('todo.complete');
    Route::delete('/todos/{todo}/incomplete','TodoController@incomplete') -> name('todo.incomplete');
});
```

> We put all the `todos` route inside the `group-middleware`. So that no one can visits those routes without authentication.

**Way 2:**

`TodoController.php`

```php
public function __construct()
{
    $this->middleware('auth');
}
```

> We can also set the middleware in the `Controller` that's the `TodoController.php` instead of set in `web.php`.

> So we created a constructor above all functions like above.

**Way 3:**

`web.php`

```php
Route::resource('/todo','TodoController')->middleware('auth');
```

> This type of way is use for individual `route`.

**From the above 3 ways of `middleware` technique I think `Controller` middle ware is easier to manipulate.**

---

If we want to access `todo` index page without authenticating. Other pages `(delete, update, add)` need authentication. How to do that?

`TodoController.php`

```php
public function __construct()
{
    $this->middleware('auth')->except('index');
}
```

> This means we need `authentication` without index page.

---

# <center>**Elequent Relationship**</center>

---

**One to Many** relationship: [Elequent Relationship](https://laravel.com/docs/7.x/eloquent-relationships#one-to-many)

First create a `One to Many` relationship among `user` and `todos`

`User.php`

```php
public function todos()
{
    return $this->hasMany(Todo::class);
}
```

> Remember, Eloquent will automatically determine the proper foreign key column on the Comment model. By convention, Eloquent will take the "snake case" name of the owning model and suffix it with `_id`. So, for this example, Eloquent will assume the foreign key on the Comment model is `post_id`.

> In our case Model name is `User`, So the foreign key is `user_id`. We we need `user_id` in our Todo table.

We added below column in `Todo` table for foreign key constraint.

```php
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
```

> Here firts we create an `user_id` column in `Todo` table. Then we reference this `user_id` to column `user_id` on `User` table.

> Now the table will look like below:

```php
Schema::create('todos', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')->references('id')->on('users');
    $table->boolean('completed')->default(false);
    $table->timestamps();
});
```

> Documentation: [Foreign Key Constraint](https://laravel.com/docs/7.x/migrations#foreign-key-constraints)

`TodoController.php`

```php
public function store(TodoCreateRequest $request)
{
    $userId             = auth()->id();
    $request['user_id'] = $userId;

    Todo::create($request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

> To grab the `user` and save the `user_id` in `todo` table, we use the first 2 lines of code on above function.

Another preblem arises. We need to Mask Assignemnt on `Model`

`Todo.php`

```php
protected $fillable = ['title','completed','user_id'];
```

> Above code should be written in the model. Here `user_id` is added now.

---

---

## Alternative way: One to Many (Best way)

Documentation: [Insering and Updating Related Model](https://laravel.com/docs/7.x/eloquent-relationships#inserting-and-updating-related-models)

We added `dd(auth()->user());` in `store` function in `TodoController.php`

```json
App\User {#1221 ▼
  #fillable: array:4 [▶]
  #hidden: array:2 [▶]
  #casts: array:1 [▶]
  #connection: "mysql"
  #table: "users"
  #primaryKey: "id"
  #keyType: "int"
  +incrementing: true
  #with: []
  #withCount: []
  #perPage: 15
  +exists: true
  +wasRecentlyCreated: false
  #attributes: array:9 [▶]
  #original: array:9 [▶]
  #changes: []
  #classCastCache: []
  #dates: []
  #dateFormat: null
  #appends: []
  #dispatchesEvents: []
  #observables: []
  #relations: []
  #touches: []
  +timestamps: true
  #visible: []
  #guarded: array:1 [▶]
  #rememberTokenName: "remember_token"
}
```

> We can see there is no relationship `#relations: []`.

Now change with `dd(auth()->user()->todos);` and we can se below:

```json
Illuminate\Database\Eloquent\Collection {#1242 ▼
  #items: array:1 [▼
    0 => App\Todo {#1245 ▶}
  ]
}
```

Now change with `dd(auth()->user()->todos());` and we can se below:

```json
Illuminate\Database\Eloquent\Relations\HasMany {#1241 ▼
  #foreignKey: "todos.user_id"
  #localKey: "id"
  #query: Illuminate\Database\Eloquent\Builder {#1214 ▶}
  #parent: App\User {#1221 ▶}
  #related: App\Todo {#1202 ▶}
}
```

> And now we can see the relationsip. Which is `hasMany` relationship. `User` is **parent** and has **relation** with `Todo` So from that I can do the create part.

So finally the `store` function of `TodoController` will look like below:

```php
public function store(TodoCreateRequest $request)
{
    // dd(auth()->user()->todos());
    auth()->user()->todos()->create($request->all());
    return redirect()->back()->with('message', 'Todo created successfully!');
}
```

**Line Desc:** authenticated user has some todos and we are creating this

> Here `auth()->user()` will definely the autheticted user. We have no chance to miss the user. Because we have **middleware** constructor in `TodoController`.

> Now we don't have to define the `$userId`.

---

## <center>**Todo of Auth User**</center>

---

## Primary way

> We will make a system so that an authenticated user can see only his `todos`.

in `store` function in `TodoController.php` if we add below code.

```php
$todos = auth()->user()->todos;
return $todos;
```

Output in SCREEN will look like below:

```json
[
    {
        "id": 1,
        "title": "new todo",
        "user_id": 1,
        "completed": 0,
        "created_at": "2020-06-20T18:43:13.000000Z",
        "updated_at": "2020-06-20T18:43:13.000000Z"
    },
    {
        "id": 4,
        "title": "new use",
        "user_id": 1,
        "completed": 0,
        "created_at": "2020-06-21T04:16:32.000000Z",
        "updated_at": "2020-06-21T04:16:32.000000Z"
    }
]
```

Below two lines of code for getting the data `orderedBy`.

```php
$todos = auth()->user()->todos()->orderBy('completed')->get();
return $todos;
```

FInally

`TodoController.php`

**Way 1:**

```php
public function index()
{
    $todos = auth()->user()->todos()->orderBy('completed')->get();  //SQL type of orderBy query
    return view('todos.index', compact('todos'));
}
```

**Way 2:**

```php
public function index()
{
    $todos = auth()->user()->todos->sortBy('completed');    //Collection type
    return view('todos.index', compact('todos'));
}
```

> Documentation: [Sort By](https://laravel.com/docs/7.x/collections#method-sortby)

> `orderBy` is for SQL, and `sortBy` is for collection.

> Now we can see `todos` created by specific authenticated user. So todos are protected from other user now.

---

## Alternative way:

> We can also set `orderBy` in `User` model instead of coding here in `TodoController`, then the model and controller will look like below:

`User.php`

```php
public function todos()
{
    return $this->hasMany(Todo::class)->orderBy('completed')->get();
}
```

`TodoController.php`

```php
public function index()
{
    $todos = auth()->user()->todos();
    return $todos;
}
```

> Here we don't need to say `orderBy` in `Controller`. Because we already set this functionality in `User` Model.

Gives Same result

```json
[
    {
        "id": 1,
        "title": "new todo",
        "user_id": 1,
        "completed": 0,
        "created_at": "2020-06-20T18:43:13.000000Z",
        "updated_at": "2020-06-20T18:43:13.000000Z"
    },
    {
        "id": 4,
        "title": "new use",
        "user_id": 1,
        "completed": 0,
        "created_at": "2020-06-21T04:16:32.000000Z",
        "updated_at": "2020-06-21T04:16:32.000000Z"
    }
]
```

### **But Primary Way is better to use because we can change the order at any time. Because setting this in `Controller` is way easier than `Model`.**

---

---

## <center>**Redirect to Todo After login**</center>

---
