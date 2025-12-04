<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Consolidator;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsolidatorPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Consolidator');
    }

    public function view(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('View:Consolidator');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Consolidator');
    }

    public function update(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('Update:Consolidator');
    }

    public function delete(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('Delete:Consolidator');
    }

    public function restore(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('Restore:Consolidator');
    }

    public function forceDelete(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('ForceDelete:Consolidator');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Consolidator');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Consolidator');
    }

    public function replicate(AuthUser $authUser, Consolidator $consolidator): bool
    {
        return $authUser->can('Replicate:Consolidator');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Consolidator');
    }

}