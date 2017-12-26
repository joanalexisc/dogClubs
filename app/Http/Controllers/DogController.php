<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\DogService;

class DogController extends Controller
{
    protected $dogService;

    public function __construct(DogService $dogService)
    {
        $this->userService = $dogService;
    }
}
