<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class)->withDefault();
    }

    public static function findByEmail($email)
    {
        return static::where(compact('email'))->first();
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return;
        }
        $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        });
    }
}
