<?php

namespace App\Controllers;

use App\Controllers\BaseControllers;

class PostController extends BaseController
{
	public function index()
	{
        $data = [
            'title' => "Blog - Posts", 
        ];
        echo view('layouts/header', $data);
        echo view('layouts/navbar');
		echo view('v_post');
        echo view('layouts/footer');
        //bisa pake return atau echo
        //echo 'view('v_post')'; echo 'hello'; bisa nampilin berulang
        //return cm bisa sekali (kecuali ditulis sebelum return)
	}
}
