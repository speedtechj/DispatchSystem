<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Logistichub;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogistichubPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Logistichub');
    }

    public function view(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('View:Logistichub');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Logistichub');
    }

    public function update(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('Update:Logistichub');
    }

    public function delete(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('Delete:Logistichub');
    }

    public function restore(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('Restore:Logistichub');
    }

    public function forceDelete(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('ForceDelete:Logistichub');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Logistichub');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Logistichub');
    }

    public function replicate(AuthUser $authUser, Logistichub $logistichub): bool
    {
        return $authUser->can('Replicate:Logistichub');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Logistichub');
    }

}