<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Boxsummary;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoxsummaryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Boxsummary');
    }

    public function view(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('View:Boxsummary');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Boxsummary');
    }

    public function update(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('Update:Boxsummary');
    }

    public function delete(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('Delete:Boxsummary');
    }

    public function restore(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('Restore:Boxsummary');
    }

    public function forceDelete(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('ForceDelete:Boxsummary');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Boxsummary');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Boxsummary');
    }

    public function replicate(AuthUser $authUser, Boxsummary $boxsummary): bool
    {
        return $authUser->can('Replicate:Boxsummary');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Boxsummary');
    }

}