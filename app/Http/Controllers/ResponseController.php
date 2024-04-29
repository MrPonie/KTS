<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function test_results_view(Request $request, int $id) {
        return back()->with('error', 'todo');
    }
}
