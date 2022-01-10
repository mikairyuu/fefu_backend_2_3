<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'login' => $this->login,
            'email' => $this->email,
            'github_login_date' => $this->github_login_date,
            'github_registration_date' => $this->github_registration_date,
            'google_login_date' => $this->google_login_date,
            'google_registration_date' => $this->google_registration_date,
        ];
    }
}
