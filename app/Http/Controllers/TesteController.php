<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return $this->response('Autorized', 200);
    }

    public function store(Request $request)
    {
        // Handle the POST request data here
        $data = $request->all();
        return $this->response('Data received', 200, ['data' => $data]);
    }
}
