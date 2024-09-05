<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
  use HasFactory;

  // Specify the associated table name

  // Specify the fields that are mass assignable
  protected $fillable = [
    'restaurant_id',
    'name',
    'status',
    'display_order',
    'created_at',
    'updated_at',
  ];

  public function items()
  {
    return $this->hasMany(CatalogItem::class);
  }

  public function catalog_items()
  {
    return $this->hasManyThrough(CatalogItem::class, Catalog::class);
  }
}
