<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookmarkLink extends Model
{
    protected $fillable = [
        'bookmark_folder_id',
        'title',
        'url',
        'description',
        'sort_order',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(
            BookmarkFolder::class,
            'bookmark_folder_id',
            'id',
        );
    }
}
