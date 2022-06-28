<?php namespace App\Controllers;

class DashboardController extends BaseController {

    public function layout()
    {
        helper("html");
        return view('dashboard');
    }

}
