<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['topic', 'url', 'component_id'];

    public function component()
    {
      return $this->belongsTo(ChapterComponent::class, 'component_id', 'id');
    }
}
