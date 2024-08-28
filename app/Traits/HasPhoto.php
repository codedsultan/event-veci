<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
// use Intervention\Image\Image;
// use Intervention\Image\ImageManager as Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


trait HasPhoto
{
    public function updatePhoto(UploadedFile $photo): void
    {
        $photo = $this->handlePhotoUpload($photo);

        tap($this->getPhotoPath(), function ($previous) use ($photo) {
            $hash = md5($photo.'-'.time());

            $extension = $this->getPhotoOptions()['format'] ?? 'png';

            $filePath = "{$this->getPhotoFolder()}/$hash.$extension";

            $saved = Storage::disk($this->photoDisk())->put($filePath, $photo, 'public');

            if ($saved) {
                $this->forceFill([
                    $this->getPhotoColumn() => $filePath,
                ])->save();
            }

            if ($previous) {
                Storage::disk($this->photoDisk())->delete($previous);
            }
        });
    }

    public function deletePhoto(): void
    {
        Storage::disk($this->photoDisk())->delete($this->getPhotoPath());

        $this->forceFill([
            $this->getPhotoColumn() => null,
        ])->save();
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->getPhotoPath()) {
            return null;
        }

        $image = URL::isValidURL($this->getPhotoPath()) ? $this->getPhotoPath() : Storage::disk($this->photoDisk())->url($this->getPhotoPath());

        return $this->getPhotoColumn()
            ? $image
            : $this->placeholderPhoto();
    }

    protected function placeholderPhoto(): string
    {
        return url(public_path('images/placeholder.jpg'));
    }

    protected function photoDisk(): string
    {
        return config('filesystems.default', 'public');
    }

    public function getPhotoColumn(): string
    {
        return 'profile_photo_path';
    }

    private function getPhotoPath()
    {
        return $this->{$this->getPhotoColumn()};
    }

    public function getPhotoFolder(): string
    {
        return 'profile-photos';
    }

    private function handlePhotoUpload(UploadedFile $photo)
    {
        $options = $this->getPhotoOptions();

        if (! $options) {
            return Image::make($photo)->stream('png');
        }

        return Image::make($photo)->{$options['style'] ?? 'fit'}($options['width'] ?? null, $options['height'] ?? null, function ($constraint) use ($options) {
            if ($options['upsize']) {
                $constraint->upsize();
            }

            if ($options['aspectRatio']) {
                $constraint->aspectRatio();
            }
        })->sharpen($options['sharpen'] ?? 0)->stream($options['format'] ?? 'png');
    }

    public function getPhotoOptions(): array
    {
        return [
            'height' => 800,
            'width' => 800,
            'upsize' => true,
            'aspectRatio' => false,
            'sharpen' => 5,
            'format' => 'png',
            'style' => 'fit', // fit, resize, crop, fill
        ];
    }
}
