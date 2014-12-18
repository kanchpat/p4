<?php

class UserController extends BaseController {

    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('guest',
            array(
                'only' => array('getLogin','getSignup')
            ));

    }


    /**
     * Show the new user signup form
     * @return View
     */
    public function getSignup() {

        return View::make('pages.signup');

    }

    /**
     * Process the new user signup
     * @return Redirect
     */
    public function postSignup() {

        # Step 1) Define the rules
        $rules = array(
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|alpha_num'
        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {

            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed; please fix the errors listed below.')
                ->withInput()
                ->withErrors($validator);
        }
        $confirmation_code = str_random(30);

        $user = new User;
        $user->email    = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmation_code = $confirmation_code;

        try {
            $user->save();
        }
        catch (Exception $e) {
            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed; please try again.')
                ->withInput();
        }

        Mail::send('emails.verify', compact('confirmation_code'), function($message) {
            $message->to(Input::get('email'), 'user')
                ->subject('Verify your email address');
        });

        Auth::logout();
        return Redirect::to('/')->with('flash_message', 'Welcome to Bookbuddy verify with the confirmation code sent to your email!');

    }

    /**
     * Display the login form
     * @return View
     */
    public function getLogin() {
        if(Auth::check())
        {
            return Redirect::intended('pages.main')->with('flash_message', 'Welcome Back ');
        }
        return View::make('pages.login')->with('flash_message','Email Id does not exist');

    }

    /**
     * Process the login form
     * @return View
     */
    public function postLogin() {

        if( Input::get('action') == 'Submit')
        {
        $credentials = [ 'email' => Input::get('email'),
                        'password' => Input::get('password'),
                        'confirmed' => '1'];

        # Note we don't have to hash the password before attempting to auth - Auth::attempt will take care of that for us
        if (Auth::attempt($credentials, $remember = false)) {
            $name = Owner::getName(Auth::user()->id);
          if(!is_null($name))
                return Redirect::intended('/main')->with('flash_message', 'Welcome Back!')
                                                  ->with('name',$name);
        }
        else {
             return Redirect::to('/login')
                ->with('flash_message', 'Log in failed; please try again.')
                ->withInput();
             }
        }
        else
        {/*
            $credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));
            return Password::remind($credentials);*/
            return View::make('pages.remind')->withInput('email',Input::get('email'));
        }

    }


    /**
     * Logout
     * @return Redirect
     */
    public function getLogout() {

        # Log out
        Auth::logout();

        # Send them to the homepage
        return Redirect::to('/');

    }

    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::to('/login')
                ->with('flash_message', 'Confirmation code does not exist')
                ->withInput();        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return Redirect::to('/login')
                ->with('flash_message', 'User not found for this confirmation code')
                ->withInput();
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Auth::login($user);

        return View::make('pages.owner_info_add');

    }

}