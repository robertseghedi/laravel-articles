<?php

namespace RobertSeghedi\News\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = ['title', 'content', 'category', 'author', 'comment_count', 'like_count', 'author_ip', 'author_os', 'author_browser'];

    protected $hidden = ['author_ip', 'author_browser', 'author_os'];
}
