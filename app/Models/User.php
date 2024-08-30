<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Actions\CreateAvatar;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected $appends = ['isAdmin', 'profile','gravatar'];

    // protected $appends = ['avatar', 'country_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function me($user)
    {
        return $this->id === $user->id;
    }

    /**
     * Get the activity timeline for the user.
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * Record new activity for the user.
     *
     * @param  string $name
     * @param  mixed  $related
     * @throws \Exception
     * @return void
     */
    public function recordActivity($name, $related)
    {
        if (! method_exists($related, 'recordActivity')) {
            throw new \Exception('..');
        }

        return $related->recordActivity($name);
    }

    public function accounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function tickets()
    {
        return $this->hasMany(PurchaseTicket::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function ticket()
    {
        return $this->belongsTo(PurchaseTicket::class);
    }

    public function discussionreplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->events->each->forceDelete();
        });
    }

    //User avatar path
    public function getProfileAttribute()
    {
        if ($this->avatar_path != null) {
            $path = pathinfo($this->avatar_path);

            return $path['dirname'].'/'.$path['filename'].'-thumb.jpg';
        } else {
            $path = 'https://i.pinimg.com/originals/53/54/f7/5354f750a2816333f42efbeeacb4e244.jpg';

            return $path;
        }
    }

    public function isAdmin()
    {
        return in_array($this->email, config('dream.adminstrators'));
    }

    public function getisAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function gravatar(): Attribute
    {
        return Attribute::get(fn () => CreateAvatar::run($this->name, $this->email, null, null, 'initials'));
    }
}

