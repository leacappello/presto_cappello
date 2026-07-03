<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'user_id',
        'is_accepted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value)
    {
    $this->is_accepted = $value;
    $this->save();

    return true;
    }

    public static function toBeRevisedCount()
    {
    return Article::where('is_accepted', null)->get()->count();
    }
}
