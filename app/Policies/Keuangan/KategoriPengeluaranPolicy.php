<?php

declare(strict_types=1);

namespace App\Policies\Keuangan;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Keuangan\KategoriPengeluaran;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriPengeluaranPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KategoriPengeluaran');
    }

    public function view(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        return $authUser->can('View:KategoriPengeluaran');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KategoriPengeluaran');
    }

    public function update(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        return $authUser->can('Update:KategoriPengeluaran');
    }

    public function delete(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        return $authUser->can('Delete:KategoriPengeluaran');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KategoriPengeluaran');
    }

    public function restore(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        return $authUser->can('Restore:KategoriPengeluaran');
    }

    public function forceDelete(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        // Kategori yang masih dipakai transaksi tidak boleh dihapus permanen (foreign key).
        return $authUser->can('ForceDelete:KategoriPengeluaran')
            && ! $kategoriPengeluaran->pengeluaran()->withTrashed()->exists();
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KategoriPengeluaran');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KategoriPengeluaran');
    }

    public function replicate(AuthUser $authUser, KategoriPengeluaran $kategoriPengeluaran): bool
    {
        return $authUser->can('Replicate:KategoriPengeluaran');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KategoriPengeluaran');
    }

}