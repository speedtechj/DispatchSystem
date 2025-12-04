<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Deliverylog;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliverylogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Deliverylog');
    }

    public function view(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('View:Deliverylog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Deliverylog');
    }

    public function update(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('Update:Deliverylog');
    }

    public function delete(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('Delete:Deliverylog');
    }

    public function restore(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('Restore:Deliverylog');
    }

    public function forceDelete(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('ForceDelete:Deliverylog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Deliverylog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Deliverylog');
    }

    public function replicate(AuthUser $authUser, Deliverylog $deliverylog): bool
    {
        return $authUser->can('Replicate:Deliverylog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Deliverylog');
    }

}