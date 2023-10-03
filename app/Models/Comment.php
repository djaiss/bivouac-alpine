<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Comment extends Model
{
    use HasFactory, Searchable;

    protected $table = 'comments';

    protected $fillable = [
        'organization_id',
        'user_id',
        'body',
        'commentable_id',
        'commentable_type',
    ];

    #[SearchUsingPrefix(['id', 'organization_id'])]
    #[SearchUsingFullText(['body'])]
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'organization_id' => (int) $this->organization_id,
            'body' => $this->body,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }
}
