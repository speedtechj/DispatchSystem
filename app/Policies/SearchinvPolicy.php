<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Searchinv;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchinvPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Searchinv');
    }

    public function view(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('View:Searchinv');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Searchinv');
    }

    public function update(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('Update:Searchinv');
    }

    public function delete(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('Delete:Searchinv');
    }

    public function restore(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('Restore:Searchinv');
    }

    public function forceDelete(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('ForceDelete:Searchinv');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Searchinv');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Searchinv');
    }

    public function replicate(AuthUser $authUser, Searchinv $searchinv): bool
    {
        return $authUser->can('Replicate:Searchinv');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Searchinv');
    }

}