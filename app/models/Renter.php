<?php

class Renter extends Eloquent {

      public function books() {
        # Tags belong to many Books
        return $this->belongsToMany('Book');
    }


}