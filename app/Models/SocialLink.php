<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
  use HasFactory;
  use Searchable;

  protected $fillable = ['key', 'value', 'contact_id'];

  protected $searchableFields = ['*'];

  protected $table = 'social_links';

  public static $buttons = [
    'facebook' => [
      'iconClass' => 'ri-facebook-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'twitter' => [
      'iconClass' => 'ri-twitter-x-line text-gray-800 text-md',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'instagram' => [
      'iconClass' => 'ri-instagram-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'linkedin' => [
      'iconClass' => 'ri-linkedin-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'youtube' => [
      'iconClass' => 'ri-youtube-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'pinterest' => [
      'iconClass' => 'ri-pinterest-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'github' => [
      'iconClass' => 'ri-github-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'snapchat' => [
      'iconClass' => 'ri-snapchat-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'reddit' => [
      'iconClass' => 'ri-reddit-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'tiktok' => [
      'iconClass' => 'ri-tiktok-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
    'website' => [
      'iconClass' => 'ri-global-line text-gray-800 text-xl',
      'btnClass' => 'hover:bg-gray-200 border border-1 border-gray-400 cursor-pointer duration-300 flex h-10 items-center justify-center rounded-full shadow-transparent text-gray-900 transition-all w-10',
    ],
  ];



  public function contact()
  {
    return $this->belongsTo(RestaurantUser::class);
  }

  public static function getIconClass($key)
  {
    return self::$buttons[$key]['iconClass'];
  }

  public static function getBtnClass($key)
  {
    return self::$buttons[$key]['btnClass'];
  }
}
