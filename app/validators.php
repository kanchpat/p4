<?php

/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
return preg_match('/^[\pL\x20]+$/u', $value);
});
Validator::extend('alpha_num_spaces', function($attribute, $value)
{
    return preg_match('/^([-a-z0-9\x20])+$/i', $value);
});