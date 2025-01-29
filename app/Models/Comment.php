<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'text'];

    /**
     * Get the post that this comment belongs to.
     *
     * @return BelongsTo<Post, Comment>
     */
    public function post(): BelongsTo
    {
        /** @var BelongsTo<Post, Comment> */
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that owns the comment.
     *
     * @return BelongsTo<User, Comment>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Comment> */
        return $this->belongsTo(User::class);
    }
}
