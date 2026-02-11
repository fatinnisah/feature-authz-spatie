<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;


class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'full_name' => $this->full_name . ' ' . $this->last_name,
            'initials' => strtoupper(substr($this->full_name, 0, 1)),
                                    substr($this->last_name, 0, 1),
            'account_age_days'=> $this->created_at->diffInDays(now()),
            'is_active' => $this->status === 'active',

        ];

    }

    public function index()
    {
        return new UserCollection(User::paginate(10));
}
}