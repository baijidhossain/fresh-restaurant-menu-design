<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RestaurantUser extends Authenticatable
{
  use HasFactory;
  use Searchable;

  protected $fillable = [
    'slug',
    'name',
    'bio',
    'designation',
    'company',
    'phone',
    'address',
    'email',
    'email_verified_at',
    'photo',
    'password',
    'is_verified',
    'code_id',
  ];

  protected $searchableFields = ['*'];

  protected $hidden = ['password'];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'is_verified' => 'boolean',
  ];

  public function socialLinks()
  {
    return $this->hasMany(SocialLink::class);
  }

  public function notes()
  {
    return $this->hasMany(Note::class);
  }

  public function code()
  {
    return $this->belongsTo(Code::class);
  }

  public function restaurant()
  {
    return $this->belongsTo(Restaurant::class);
  }

  public static function generateSlug($name)
  {

    // Generate slug from name
    $slug = str($name)->slug();

    $slug = '@' . $slug;

    // Generate a random string
    $randString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);

    // Check if slug already exists
    $slugExists = self::where('slug', $slug)->exists();

    // If slug already exists, recursively call function with a modified name
    if ($slugExists) {
      return self::generateSlug($name . $randString);
    }

    // Return unique slug
    return $slug;
  }
}
