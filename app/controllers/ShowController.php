<?php

class ShowController extends BaseController {

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
    public function getAbout() {

        return View::make('pages.about');

    }

    public function getContact() {

        return View::make('pages.contact');

    }

}