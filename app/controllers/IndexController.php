<?php

class IndexController extends BaseController {

    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

    }

    /**
     *
     */
    public function getIndex() {

        if(Auth::user())
            return View::make('pages.main');
        return View::make('pages.index');

    }

}