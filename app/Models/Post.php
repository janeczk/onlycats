<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Post extends Model
{
    protected $fillable = ['content','photo', 'user_id'];

    /**
     * Tworzy nowy post na podstawie zwalidowanych danych.
     *
     * @param array<string,mixed> $validated Zawiera dane do stworzenia posta.
     * @return self
     */
    public static function create(array $validated): self
    {
        // Sprawdzenie, czy wymagane pola istnieją
        if (!isset($validated['content'], $validated['user_id'])) {
            throw new InvalidArgumentException('The required fields "content" and "user_id" are missing.');
        }

        // Utworzenie i zapisanie posta
        $post = new self();
        $post->fill($validated);
        $post->save();

        return $post;
    }

    /**
     * Get the user that owns the post.
     *
     * @return BelongsTo<User, Post>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Post> */
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for the post.
     *
     * @return HasMany<Like, Post>
     */
    public function likes(): HasMany
    {
        /** @var HasMany<Like, Post> */
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the current user liked the post.
     *
     * @return Like|null
     */
    public function userLiked(): ?Like
    {
        /** @var ?Like */
        return $this->likes()->where('user_id', auth()->id())->first();
    }

    /**
     * Get the comments for the post.
     *
     * @return HasMany<Comment, Post>
     */
    public function comments(): HasMany
    {
        /** @var HasMany<Comment, Post> */
        return $this->hasMany(Comment::class);
    }
}
