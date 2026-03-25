<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'status', 'published_at', 'reading_time', 'views', 'featured',
        'allow_comments', 'meta_title', 'meta_description', 'canonical_url',
        'meta_keywords', 'focus_keyword', 'og_title', 'og_description', 'og_image',
        'twitter_title', 'twitter_description', 'twitter_image', 'twitter_card',
        'robots_index', 'robots_follow', 'schema_type', 'schema_json',
        'author_id', 'translations', 'blocks',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'translations' => 'array',
            'blocks' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content')) {
                $post->reading_time = $post->calculateReadingTime($post->content);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function publish(): void
    {
        $this->status = PostStatus::Published;
        $this->published_at = $this->published_at ?? now();
        $this->save();
    }

    public function unpublish(): void
    {
        $this->status = PostStatus::Draft;
        $this->published_at = null;
        $this->save();
    }

    protected function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute

        return (int) $minutes;
    }
}
