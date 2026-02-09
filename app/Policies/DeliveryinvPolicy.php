<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Deliveryinv;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryinvPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Deliveryinv');
    }

    public function view(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('View:Deliveryinv');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Deliveryinv');
    }

    public function update(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('Update:Deliveryinv');
    }

    public function delete(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('Delete:Deliveryinv');
    }

    public function restore(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('Restore:Deliveryinv');
    }

    public function forceDelete(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('ForceDelete:Deliveryinv');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Deliveryinv');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Deliveryinv');
    }

    public function replicate(AuthUser $authUser, Deliveryinv $deliveryinv): bool
    {
        return $authUser->can('Replicate:Deliveryinv');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Deliveryinv');
    }

}