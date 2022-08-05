<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterArticle extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'component_id'];

    public function component()
    {
      return $this->belongsTo(ChapterComponent::class, 'component_id', 'id');
    }
}
