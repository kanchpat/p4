<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public function book() {
        # User has many Books
        # Define a one-to-many relationship.
        return $this->hasMany('Book');
    }

    public function renter() {
        # User has many Renters
        # Define a one-to-many relationship.
        return $this->hasMany('Renter');
    }

    public function message() {
        # User has many Messages
        # Define a one-to-many relationship.
        return $this->hasMany('Message');
    }
    public function owner() {
        #Owner is a One to one relationship
        return $this->hasOne('User');
    }

}
