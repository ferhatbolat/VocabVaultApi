<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
{
      public function authorize()
      {
            return true;
      }

      public function rules()
      {
            return [
                  'name' => 'required|string|max:255',
                  'content' => 'required|string',
                  'current_page' => 'nullable|integer|min:0'
            ];
      }

      public function messages()
      {
            return [
                  'name.required' => 'Story name is required',
                  'name.max' => 'Story name cannot exceed 255 characters',
                  'content.required' => 'Story content is required',
                  'current_page.integer' => 'Current page must be a number',
                  'current_page.min' => 'Current page cannot be negative'
            ];
      }
}
