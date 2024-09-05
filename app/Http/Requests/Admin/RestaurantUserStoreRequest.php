<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantUserStoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'max:255', 'string'],
      'bio' => ['nullable', 'max:255', 'string'],
      'designation' => ['required', 'max:255', 'string'],
      'company' => ['nullable', 'max:255', 'string'],
      'phone' => ['required', 'max:255', 'string'],
      'address' => ['nullable', 'max:255', 'string'],
      'email' => ['required', 'email'],
      'photo' => ['nullable', 'file'],
      'password' => ['required'],
      'is_verified' => ['required', 'boolean'],
      'code_id' => ['required', 'exists:codes,id'],
    ];
  }
}
