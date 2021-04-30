<?php

namespace RobertSeghedi\News\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'created_by', 'created_by_ip', 'created_by_browser', 'created_by_os'];

    protected $hidden = ['created_by_ip', 'created_by_browser', 'created_by_os'];
}
