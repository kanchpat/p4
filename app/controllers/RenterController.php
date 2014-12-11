<?php

class RenterController extends \BaseController {


    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array('except' => 'getIndex'));

    }


    /**
     * Process the "Add a book form"
     * @return Redirect
     */
    public function postRent() {
        $value = Input::get('BookRent');
        if(is_array($value))
        {
        foreach($value as $bookInfo){
            Renter::createRent($bookInfo);
            Book::make_rent($bookInfo);
            return Redirect::to ('/book/rent')->with('flash_message','Book Rent');
        }
        }
    }


    public function getLoan() {
        $renter = Renter::rentInfo(Auth::user()->id);
        return View::make('pages.book_loan')->with('renter',$renter);

    }

}