<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CitabicReference extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'client',
        'image',
        'summary',
        'description',
        'surface',
        'budget',
        'items',
        'blocks',
        'translations',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'blocks' => 'array',
            'translations' => 'array',
        ];
    }

    /**
     * Get a plain-text excerpt with all HTML tags and HTML entities stripped.
     */
    public function getCleanExcerpt(int $limit = 250): string
    {
        $raw = !empty($this->summary) ? $this->summary : ($this->description ?? '');
        $clean = strip_tags((string) $raw);
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $clean = str_replace(["\xc2\xa0", '&nbsp;'], ' ', $clean);
        $clean = trim((string) preg_replace('/\s+/', ' ', $clean));

        return Str::limit($clean, $limit);
    }

    /**
     * Build the social share caption with clean plain text.
     */
    public function getShareCaption(): string
    {
        $url = route('references.show', $this->slug);
        $title = trim((string) ($this->title ?? ''));
        $client = $this->client ? ' (Client : ' . trim((string) $this->client) . ')' : '';
        $excerpt = $this->getCleanExcerpt();
        $excerptText = $excerpt !== '' ? "\n\n" . $excerpt : '';

        return "Découvrez notre réalisation : {$title}{$client}.{$excerptText}\n\n👉 {$url}\n\n#CITABIC #Architecture #GénieCivil #Construction #Maroc";
    }
}
