<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Invoiceissue;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoiceissuePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Invoiceissue');
    }

    public function view(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('View:Invoiceissue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Invoiceissue');
    }

    public function update(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('Update:Invoiceissue');
    }

    public function delete(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('Delete:Invoiceissue');
    }

    public function restore(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('Restore:Invoiceissue');
    }

    public function forceDelete(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('ForceDelete:Invoiceissue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Invoiceissue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Invoiceissue');
    }

    public function replicate(AuthUser $authUser, Invoiceissue $invoiceissue): bool
    {
        return $authUser->can('Replicate:Invoiceissue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Invoiceissue');
    }

}