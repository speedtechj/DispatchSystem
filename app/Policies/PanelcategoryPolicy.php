<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Panelcategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PanelcategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Panelcategory');
    }

    public function view(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('View:Panelcategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Panelcategory');
    }

    public function update(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('Update:Panelcategory');
    }

    public function delete(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('Delete:Panelcategory');
    }

    public function restore(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('Restore:Panelcategory');
    }

    public function forceDelete(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('ForceDelete:Panelcategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Panelcategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Panelcategory');
    }

    public function replicate(AuthUser $authUser, Panelcategory $panelcategory): bool
    {
        return $authUser->can('Replicate:Panelcategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Panelcategory');
    }

}