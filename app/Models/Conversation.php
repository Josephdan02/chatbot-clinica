<?php

namespace App\Models;

use App\Enums\ConversationState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_identifier',
        'state',
        'context',
    ];

    protected function casts(): array
    {
        return [
            'state' => ConversationState::class,
            'context' => 'array',
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getContextValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->context ?? [], $key, $default);
    }

    public function setContextValue(string $key, mixed $value): void
    {
        $context = $this->context ?? [];
        data_set($context, $key, $value);
        $this->context = $context;
    }

    public function clearContext(): void
    {
        $this->context = [];
    }
}
