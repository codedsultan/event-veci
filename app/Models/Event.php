<?php

namespace App\Models;

use App\Notifications\ReplyHasAdded;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Str;

class Event extends Model implements Searchable
{
    use RecordsActivity;
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
        'deleted_at' => 'date',
        'strtdt' => 'date',
        'enddt' => 'date',
    ];

    protected $guarded = [];

    protected $appends = ['isFollowedTo'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path()
    {
        return "/events/{$this->slug}";
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($event) {
            $event->replies->each->delete();
        });
        static::created(function ($event) {
            $event->update(['slug'=>$event->name]);
            $event->topic()->increment('events_count');
        });
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $original = $slug;

        $count = 2;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-".$count++;
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function purchaseTicket()
    {
        return $this->hasMany(PurchaseTicket::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        //Prepare notifications for all follower

        foreach ($this->followers as $follower) {
            if ($follower->user_id != $reply->user_id) {
                $follower->user->notify(new ReplyHasAdded($this, $reply));
            }
        }

        return $reply;
    }

    public function follow($userId = null)
    {
        $this->followers()->create([
            'user_id'=>$userId ?:  Auth::id()
        ]);

        return $this;
    }

    public function unfollow($userId = null)
    {
        $this->followers()->where('user_id', $userId ?:  Auth::id())->delete();
    }

    public function getIsFollowedToAttribute()
    {
        return  $this->followers()
            ->where('user_id',  Auth::id())
            ->exists();
    }

    public function getSearchResult(): SearchResult
    {
        $url = $this->slug;

        return new SearchResult($this, $this->name, $url);
    }

    public function getStartDateAttribute()
    {
        return Carbon::parse($this->strtdt)->format('j F, Y');
    }

    public function getEndDateAttribute()
    {
        return Carbon::parse($this->enddt)->format('j F, Y');
    }

    public function getEventStartAttribute()
    {
        return Carbon::parse($this->strtdt)->format('d-m-Y');
    }

    public function getEventEndAttribute()
    {
        return Carbon::parse($this->enddt)->format('d-m-Y');
    }

    protected static function newFactory(): Factory
    {
        return EventFactory::new();
    }
}
