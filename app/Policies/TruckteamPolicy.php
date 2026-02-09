<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Truckteam;
use Illuminate\Auth\Access\HandlesAuthorization;

class TruckteamPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Truckteam');
    }

    public function view(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('View:Truckteam');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Truckteam');
    }

    public function update(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('Update:Truckteam');
    }

    public function delete(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('Delete:Truckteam');
    }

    public function restore(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('Restore:Truckteam');
    }

    public function forceDelete(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('ForceDelete:Truckteam');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Truckteam');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Truckteam');
    }

    public function replicate(AuthUser $authUser, Truckteam $truckteam): bool
    {
        return $authUser->can('Replicate:Truckteam');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Truckteam');
    }

}