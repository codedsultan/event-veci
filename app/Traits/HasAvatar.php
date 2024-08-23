<?php

namespace App\Traits;

use App\Actions\CreateAvatar;

trait HasAvatar
{
    public function getAvatarAttribute(): string
    {
        $name = $this->name ?? $this->first_name.' '.$this->last_name;

        if ($this->getPhotoPath() === null) {
            return CreateAvatar::run($name, $this->email);
        }

        return $this->getPhotoUrlAttribute();
    }
}
