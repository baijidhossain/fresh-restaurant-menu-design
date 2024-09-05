<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'catalog_id',
    'name',
    'image',
    'description',
    'price',
    'offer_price',
    'popular',
    'custom_field',
    'status',
    'display_order',

  ];
}
