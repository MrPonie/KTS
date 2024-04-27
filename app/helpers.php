<?php

if(!function_exists('has_permission')) {
    function has_permission($permission) {
        if($permissions = session('role')['permissions'])
            if($permissions->{$permission}) return true;
        return false;
    }
}