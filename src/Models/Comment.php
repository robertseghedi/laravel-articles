<?php

namespace RobertSeghedi\News\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['text', 'created_by', 'article_id', 'created_by_ip', 'created_by_browser', 'created_by_os'];

    protected $hidden = ['created_by_ip', 'created_by_os', 'created_by_browser'];
}
