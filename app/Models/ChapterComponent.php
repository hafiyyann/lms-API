<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterComponent extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'created_by', 'visibility', 'order', 'chapter_id'];

    public function video()
    {
      return $this->hasMany(ChapterVideo::class);
    }

    public function exam()
    {
      return $this->hasMany(ChapterExam::class);
    }

    public function meeting()
    {
      return $this->hasMany(ChapterMeeting::class);
    }

    public function article()
    {
      return $this->hasMany(ChapterArticle::class);
    }

    public function chapter()
    {
      return $this->belongsTo(Chapter::class);
    }

    // public function getSourceAttribute()
    // {
    //   $type = $this->type;
    //
    //   if ($type == 'video') {
    //     return $this->video;
    //   } elseif($type == 'exam') {
    //     return $this->exam;
    //   } elseif ($type == 'article') {
    //     return $this->exam;
    //   } elseif ($type == 'meeting') {
    //     return $this->meeting;
    //   } else {
    //     return 'NO SOURCE';
    //   }
    // }

    public function author()
    {
      return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
