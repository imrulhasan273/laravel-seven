<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //for using database
use App\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        if($request->hasFile('image'))
        {
            ////we use auth()->user() because we have to get the model
            // $filename = $request->image->getClientOriginalName();
            // $this->deleteOldImage();
            // $request->image->storeAs('images', $filename,'public'); 
            // auth()->user()->update(['avatar' => $filename]); //for log user

            //instead of use above code segment we go those segment through the below line of code
            User::uploadAvatar($request->image);
            // session()->put('message','Image Uploaded!');
            // $request -> session()->flash('message','Image Uploaded!');
            // return redirect()->back();
            ////instead of above two lines of code we can use the below 1 line of code
            return redirect()->back()->with('message','Image Uploaded!');  
        }     
        // $request -> session()->flash('error','Image Not Uploaded!');
        // return redirect()->back(); 
        ////instead of above two lines of code we can use the below 1 line of code
        return redirect()->back()->with('error','Image Not Uploaded!');
    }
    ////we move the below segment to User model
    // protected function deleteOldImage()
    // {
    //     if(auth()->user()->avatar)
    //     {
    //         Storage::delete('/public/images/'.auth()->user()->avatar);
    //     }   
    // }

    public function index()
    {
        //________________________Run RAW QUERY_________________________
        // ______insert
        // DB::insert('insert into users (name, email, password) values (?, ?, ?)', 
        // ['Imrul', 'imrulhasan273@gmail.com', 'imrul']);
        // $users = DB::select('select * from users');
        // return $users;


        //_______select
        // $users = DB::select('select * from users');
        // return $users;


        //_______update
        // DB::update('update users set name = ? where id = ?', 
        // ['Imrul',13]);
        // $users = DB::select('select * from users');
        // return $users;


        //_______delete
        // DB::delete('delete from users');
        // $users = DB::select('select * from users');
        // return $users;

        // return view('home');
        //_____________________________________________________________________





        //_______________________________Eloquent ORM (alternative of raw query)__________
        //_____________Insert
        // $user =  new User();
        // // var_dump($user); //var dumb
        // // dd($user); //die and dumb, so much clean

        // $user->name = 'Imrul Hasan';
        // $user->email = 'imrulhasan273@gmail.com';
        // $user->password = bcrypt('imrul');
        // $user->save();


        //_____________Fetch all the data from database table (select)
        // $user = User::all(); //all() is a statis method and not static method --> magical?
        // return $user;
        //We can see all the fields value except password.
        //because password is 'protected_hidden' field defined in User.php
        //so that field will not come in all()
        

        //______________Update
        // User::where('id',16)->update(['name' => 'Imrul Hasan']);
        // $user = User::all(); //all() is a statis method and not static method --> magical?
        // return $user;


        //______________Delete
        // User::where('id',14)->delete();
        //User model can only interact with users table

        // return view('home');
        //____________________________________________________________________________________
        




        // //__________________reduced the CRUD (ORM) - create method
        // $data = [
        //     'name'      =>  'Elon',
        //     'email'     =>  'elon@gmail.com',
        //     'password'  =>  bcrypt('password'),
        //     'mobile'    =>  112298989,  //it will not affect the database nor give any error
        //                                 //because fillable will define which colums to
        //                                 //be checked or inserted. Database has no col named mobile.
        // ];
        // User::create($data);
        // $user = User::all(); 
        // return $user;
        // // So far we have still 5 lines. How to reduced? We will see later
        //________________________________________________________________________
        

        //_____________________________reduced the CRUD (ORM) Accessor and Mutaotors
        //Mutator function is in User.php Model
        //Accessor functionis in User.php Model
        // $data = [
        //     'name'      =>  'elon',
        //     'email'     =>  'elon@gmail.com',
        //     'password'  =>  'password', //password is encrypter from User Defined function
        // ];
        // User::create($data);
        // $user = User::all(); 
        // return $user;


        return view('home');

    } 
}
