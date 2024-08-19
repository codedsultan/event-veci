<?php

namespace App\Models;

use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($topic) {
            $topic->update(['slug'=>$topic->name]);
        });
        static::deleting(function ($topic) {
            $topic->events->each->forceDelete();
        });
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    protected static function newFactory(): Factory
    {
        return TopicFactory::new();
    }
}
