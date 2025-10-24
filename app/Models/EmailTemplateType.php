<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplateType extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'variables',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    public function emailTemplates(): HasMany
    {
        return $this->hasMany(EmailTemplate::class);
    }
}
