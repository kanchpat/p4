<?php

class Owner extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at','user_id');

    /**
     * Book belongs to Author
     * Define an inverse one-to-many relationship.
     */
    public function user() {

        return $this->belongsTo('User');

    }

    public static function getName($query) {

        # If there is a query, search the library with that query
        if($query) {

            $owners = Owner::where('user_id','=',$query)->first();

        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $owners=null;
        }
        if(!is_null($owners))
        {
            $name = $owners->first_name.$owners->last_name;
            return $name;
        }
        else{
        return null;
        }
    }

    public static function findOwnerInfoForUserId($query){
        if($query) {

            $owner = Owner::where('user_id','=',$query)->first();

        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $owner=null;
        }
        return $owner;
    }
 }