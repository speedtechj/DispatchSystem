<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Truckcrew;
use Illuminate\Auth\Access\HandlesAuthorization;

class TruckcrewPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Truckcrew');
    }

    public function view(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('View:Truckcrew');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Truckcrew');
    }

    public function update(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('Update:Truckcrew');
    }

    public function delete(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('Delete:Truckcrew');
    }

    public function restore(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('Restore:Truckcrew');
    }

    public function forceDelete(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('ForceDelete:Truckcrew');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Truckcrew');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Truckcrew');
    }

    public function replicate(AuthUser $authUser, Truckcrew $truckcrew): bool
    {
        return $authUser->can('Replicate:Truckcrew');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Truckcrew');
    }

}