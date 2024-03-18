<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function groups() {
        $groups = \App\Models\Group::select(['groups.*', DB::raw('count(group__users.id) as user_count')])
            ->leftJoin('group__users', 'groups.id', '=', 'group__users.group_id')
            ->groupBy('groups.id', 'groups.name', 'groups.description', 'groups.created_at', 'groups.updated_at')
            ->get();
        return view('admin/groups/groups')->with(['groups' => $groups]);
    }

    public function create_view() {
        return view('admin/groups/create_new_group');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $group = new \App\Models\Group;
        $group->name = $validated['name'];
        $group->description = $validated['description'];

        if($group->save()){
            return back()->with('success', 'Successfuly created new group.');
        }

        return back()->with('error', 'Failed to create new group.');
    }

    public function edit_view(int $id) {
        $group = \App\Models\Group::select('name', 'description')->where('id', '=', $id)->get();

        if($group){
            return view('admin/groups/edit_group')->with(['group'=>$group[0]]);
        }

        return back()->with('error', 'Failed to get group data.');
    }

    public function edit(Request $request, int $id) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        return back()->with('error', 'Failed updating group.');
    }
}
