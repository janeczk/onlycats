<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = ['user_id', 'post_id'];

    /**
     * Get the user that owns the like.
     *
     * @return BelongsTo<User, Like>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Like> */
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that this like belongs to.
     *
     * @return BelongsTo<Post, Like>
     */
    public function post(): BelongsTo
    {
        /** @var BelongsTo<Post, Like> */
        return $this->belongsTo(Post::class);
    }
}
