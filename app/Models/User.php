<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'avatar',
        'background_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Get the posts for the user.
     *
     * @return HasMany<Post, User>
     */
    public function posts(): HasMany
    {
        /** @var HasMany<Post, User> */
        return $this->hasMany(Post::class);
    }

    /**
     * Get the likes for the user.
     *
     * @return HasMany<Like, User>
     */
    public function likes(): HasMany
    {
        /** @var HasMany<Like, User> */
        return $this->hasMany(Like::class);
    }
    /**
     * Users that this user is following.
     *
     * @return BelongsToMany<User, User>
     */
    public function following(): BelongsToMany
    {
        /** @var BelongsToMany<User, User> */
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    /**
     * Users that are following this user.
     *
     * @return BelongsToMany<User, User>
     */
    public function followers(): BelongsToMany
    {
        /** @var BelongsToMany<User, User> */
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function getFollowersCountAttribute(): int
    {
        return $this->followers()->count();
    }


    /**
     * Get the cards associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Card, self>
     */
    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Card, self> */
        return $this->hasMany(Card::class, 'email', 'email');
    }


    /**
     * Check if the user has a card.
     */
    public function hasCard(): bool
    {
        return $this->cards()->exists();
    }
}
