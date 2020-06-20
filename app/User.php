<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;


//Model --> create obj of that model --> UserController.php
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $guarded = []; //this will tell if any errors in database changes
    protected $fillable = [
        'name', 'email', 'password','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public static function uploadAvatar($image)
    {   //we are already in the model so we dont need to explicitely call auth()->user()
        //but in a static function we can not use $this So we need to use (new self())
        //(new self()) = $this
        //so we dont need to use request also
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

    
    ///No longer need to use the below functions as we will import package laravel ui for these
    // //changing behavior -- Mutator              --- inserting
    // public function setPasswordAttribute($password) //setPasswordAttribute name is important
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    // //modifyting -- Accessor -- don't modify in DB   --fetching
    // public function getNameAttribute($name) //getNameAttribute name is important
    // {
    //     return 'My name is: '.ucfirst($name);
    // }
    
    //Relationsip
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
