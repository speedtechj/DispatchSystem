<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Routearea;
use Illuminate\Auth\Access\HandlesAuthorization;

class RouteareaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Routearea');
    }

    public function view(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('View:Routearea');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Routearea');
    }

    public function update(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('Update:Routearea');
    }

    public function delete(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('Delete:Routearea');
    }

    public function restore(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('Restore:Routearea');
    }

    public function forceDelete(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('ForceDelete:Routearea');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Routearea');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Routearea');
    }

    public function replicate(AuthUser $authUser, Routearea $routearea): bool
    {
        return $authUser->can('Replicate:Routearea');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Routearea');
    }

}