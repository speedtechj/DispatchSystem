<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Workposition;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkpositionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Workposition');
    }

    public function view(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('View:Workposition');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Workposition');
    }

    public function update(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('Update:Workposition');
    }

    public function delete(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('Delete:Workposition');
    }

    public function restore(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('Restore:Workposition');
    }

    public function forceDelete(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('ForceDelete:Workposition');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Workposition');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Workposition');
    }

    public function replicate(AuthUser $authUser, Workposition $workposition): bool
    {
        return $authUser->can('Replicate:Workposition');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Workposition');
    }

}