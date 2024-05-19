<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GroupController extends Controller
{
    public function groups() {
        $groups = \App\Models\Group::select(['groups.*', DB::raw('count(group__users.id) as user_count')])
            ->leftJoin('group__users', 'groups.id', '=', 'group__users.group_id')
            ->groupBy('groups.id', 'groups.name', 'groups.description', 'groups.created_at', 'groups.updated_at')
            ->get();
        return view('admin/groups/groups')->with(['groups' => $groups]);
    }

    public function student_groups() {
        $groups = \App\Models\Group::select('id', 'name')->get();
        $group_users = [];
        foreach($groups as $group) {
            $group_users[] = \App\Models\User::select('users.username')
                ->leftJoin('group__users', 'group__users.user_id', '=', 'users.id')
                ->where('group__users.group_id', '=', $group->id)
                ->get();
        }
        return view('user/student_groups', ['groups'=>$groups, 'group_users'=>$group_users]);
    }

    public function create_view() {
        return view('admin/groups/create_new_group');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'users' => 'sometimes|array',
        ]);

        $group = \App\Models\Group::firstOrCreate([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_at' => \Carbon\Carbon::now(),
        ]);

        if(isset($validated['users'])){
            foreach($validated['users'] as $item) {
                $record = new \App\Models\Group_User;
                $record->group_id = $group->id;
                $record->user_id = $item;
                $record->save();
            }
        }

        return back()->with('success', 'Successfuly created new group.');
    }

    public function edit_view(int $id) {
        $group = \App\Models\Group::find($id);
        if(!$group) {return back()->with('error', 'Failed to get group data.');}

        $group_users = DB::table('groups as g')
            ->select('u.id', 'u.username')
            ->leftJoin('group__users as gu', 'gu.group_id', '=', 'g.id')
            ->leftJoin('users as u', 'gu.user_id', '=', 'u.id')
            ->where('g.id', '=', $id)
            ->get();
        if(!$group_users) {return back()->with('error', 'Failed to get group users data.');}

        $list = [];
        foreach($group_users as &$gu) {
            if($gu->id !== null) {$list[] = (object)['id'=>$gu->id, 'name'=>$gu->username];}
        }

        return view('admin/groups/edit_group')->with(['group'=>$group,'list'=>$list]);
    }

    public function edit(Request $request, int $id) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'users' => 'sometimes|array',
        ]);

        $group = \App\Models\Group::find($id);
        if(!$group) {return back()->with('error', 'Could not find the group to update');}

        $group->name = $validated['name'];
        $group->description = $validated['description'];
        $group->updated_at = \Carbon\Carbon::now();

        if(!$group->save()){
            return back()->with('error', 'Failed to update the group.');   
        }

        if(isset($validated['users'])){
            // delete all old group users
            \App\Models\Group_User::where('group_id', '=', $id)->delete();
            // add new group users
            foreach($validated['users'] as $item) {
                $record = new \App\Models\Group_User;
                $record->group_id = $id;
                $record->user_id = $item;
                $record->created_at = \Carbon\Carbon::now();
                $record->updated_at = \Carbon\Carbon::now();
                $record->save();
            }
        }
        // clear group users
        else{
            \App\Models\Group_User::where('group_id', '=', $id)->delete();
        }

        return back()->with('success', 'Successfuly updated the group.');
    }

    public function delete(Request $request, int $id)  {
        $group = \App\Models\Group::find($id);
        if(!$group) {return back()->with('error', 'Could not find the group to update');}

        $gus = \App\Models\User_Group::where('group_id', $id)->get();
        foreach($gus as $gu) $gu->delete();

        $group->delete();

        return back()->with('success', 'Successfuly deleted the group.');
    }
}
