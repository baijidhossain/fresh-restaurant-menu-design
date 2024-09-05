<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Restaurant extends Model
{
  use HasFactory;

  protected $fillable = [
    'restaurant_user_id',
    'name',
    'phone',
    'address',
    'start_time',
    'end_time',
    'logo',
    'banner'
  ];

  public function catalogs()
  {
    return $this->hasMany(Catalog::class);
  }

  public function catalogItems()
  {
    return $this->hasManyThrough(CatalogItem::class, Catalog::class);
  }
}
