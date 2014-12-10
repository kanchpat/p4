<?php

class OwnerController extends BaseController {

    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();
    }


    /**
     * Show the new user signup form
     * @return View
     */
    public function getOwner() {

        return View::make('pages.owner_info_add');

    }

    /**
     * Process the new user signup
     * @return Redirect
     */
    public function postOwner() {

        # Step 1) Define the rules
        $rules = array(
            'first_name' => 'required|min:4|alpha',
            'last_name' => 'required|min:4|alpha',
            'address1' => 'required|min:4|alpha_num_spaces',
            'address2' => 'min:4|alpha_dash',
            'city' => 'required|min:4|alpha_spaces',
            'zip_code' => 'required|max:99999|numeric',

        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {

            return Redirect::to('/owner/create')
                ->with('flash_message', 'Entries failed; please fix the errors listed below.')
                ->withInput()
                ->withErrors($validator);
        }

        $owner = new Owner();
        $owner->fill(Input::all());

     if(Helper::checkPostalAddress($owner))
       {
            $owner->user_id = Auth::user()->id;
            # Magic: Eloquent
            $owner->save();
            return Redirect::to('/main')->with('flash_message', 'Your address and name details have been added!');
        }
        else
        {
            return Redirect::to('/owner/create')
                ->with('flash_message', 'Address incorrect')
                ->withInput()
                ->withErrors($validator);
        }
    }
 }