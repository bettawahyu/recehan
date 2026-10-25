<?php

declare(strict_types=1);

namespace App\Policies\Keuangan;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Keuangan\KategoriPemasukan;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriPemasukanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KategoriPemasukan');
    }

    public function view(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        return $authUser->can('View:KategoriPemasukan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KategoriPemasukan');
    }

    public function update(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        return $authUser->can('Update:KategoriPemasukan');
    }

    public function delete(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        return $authUser->can('Delete:KategoriPemasukan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KategoriPemasukan');
    }

    public function restore(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        return $authUser->can('Restore:KategoriPemasukan');
    }

    public function forceDelete(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        // Kategori yang masih dipakai transaksi tidak boleh dihapus permanen (foreign key).
        return $authUser->can('ForceDelete:KategoriPemasukan')
            && ! $kategoriPemasukan->pemasukan()->withTrashed()->exists();
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KategoriPemasukan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KategoriPemasukan');
    }

    public function replicate(AuthUser $authUser, KategoriPemasukan $kategoriPemasukan): bool
    {
        return $authUser->can('Replicate:KategoriPemasukan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KategoriPemasukan');
    }

}