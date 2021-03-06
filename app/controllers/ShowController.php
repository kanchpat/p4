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
     * How it works page
     */
    public function getAbout() {

        return View::make('pages.about');

    }

    public function getContact() {

        return View::make('pages.contact');

    }

    public function getMain() {

        return View::make('pages.main');

    }

}