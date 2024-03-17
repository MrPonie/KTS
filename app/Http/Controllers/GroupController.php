<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function groups() {
        // $groups = \App\Models\Group::select('id', 'name', 'description', 'count(select * from group__users where group_id = id)')->get();
        return view('admin/groups/groups');
    }

    public function create_new_group_view(Request $request) {
        return back()->with('error', 'TODO');
    }
}
