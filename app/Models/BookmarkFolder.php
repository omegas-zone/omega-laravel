<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookmarkFolder extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'sort_order',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function bookmarkLinks(): HasMany
    {
        return $this->hasMany(
            BookmarkLink::class,
            'bookmark_folder_id',
            'id',
        )->orderBy('sort_order');
    }
}
