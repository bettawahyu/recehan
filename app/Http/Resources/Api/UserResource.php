<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'avatar_url'    => $this->avatar_url,
            'no_hp'         => $this->no_hp,
            'alamat'        => $this->alamat,
            'is_active'     => (bool) $this->is_active,
            'last_login_at' => $this->last_login_at,
            'role'          => $this->roles->first()?->name,
        ];
    }
}