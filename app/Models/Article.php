<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

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
        return self::where('is_accepted', null)->count();
    }

    public function toSearchableArray()
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'category' => $this->category->name,
    ];
}
}
