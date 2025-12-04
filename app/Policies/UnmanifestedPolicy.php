<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Unmanifested;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnmanifestedPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Unmanifested');
    }

    public function view(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('View:Unmanifested');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Unmanifested');
    }

    public function update(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('Update:Unmanifested');
    }

    public function delete(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('Delete:Unmanifested');
    }

    public function restore(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('Restore:Unmanifested');
    }

    public function forceDelete(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('ForceDelete:Unmanifested');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Unmanifested');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Unmanifested');
    }

    public function replicate(AuthUser $authUser, Unmanifested $unmanifested): bool
    {
        return $authUser->can('Replicate:Unmanifested');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Unmanifested');
    }

}