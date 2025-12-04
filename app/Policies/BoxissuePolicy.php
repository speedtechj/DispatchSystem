<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Boxissue;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoxissuePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Boxissue');
    }

    public function view(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('View:Boxissue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Boxissue');
    }

    public function update(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('Update:Boxissue');
    }

    public function delete(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('Delete:Boxissue');
    }

    public function restore(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('Restore:Boxissue');
    }

    public function forceDelete(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('ForceDelete:Boxissue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Boxissue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Boxissue');
    }

    public function replicate(AuthUser $authUser, Boxissue $boxissue): bool
    {
        return $authUser->can('Replicate:Boxissue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Boxissue');
    }

}