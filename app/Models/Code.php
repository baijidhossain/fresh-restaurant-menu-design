<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Code extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = ['code', 'has_card'];

  protected $searchableFields = ['*'];

  protected $casts = [
    'has_card' => 'boolean',
  ];

  public static function generate()
  {

    $code = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 32)), 0, 10);

    //check if code already exists
    $codeExists = Code::where('code', $code)->exists();

    //if code already exists, recursively call function with a modified name
    if ($codeExists) {
      return self::generate();
    }

    return $code;
  }

  public function contact()
  {
    return $this->hasOne(RestaurantUser::class);
  }
}
