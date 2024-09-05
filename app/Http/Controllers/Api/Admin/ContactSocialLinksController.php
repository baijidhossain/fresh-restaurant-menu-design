<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\SocialLinkCollection;

class restaurant_userocialLinksController extends Controller
{
  public function index(
    Request $request,
    Contact $contact
  ): SocialLinkCollection {
    $this->authorize('view', $contact);

    $search = $request->get('search', '');

    $SocialLinks = $contact
      ->SocialLinks()
      ->search($search)
      ->latest()
      ->paginate();

    return new SocialLinkCollection($SocialLinks);
  }

  public function store(Request $request, Contact $contact): SocialLinkResource
  {
    $this->authorize('create', SocialLink::class);

    $validated = $request->validate([
      'key' => ['required', 'max:255', 'string'],
      'value' => ['required', 'max:255', 'string'],
    ]);

    $SocialLink = $contact->SocialLinks()->create($validated);

    return new SocialLinkResource($SocialLink);
  }
}
