<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordRequest extends FormRequest
{
      public function authorize()
      {
            return true;
      }

      public function rules()
      {
            return [
                  'turkish' => 'required|string|max:255',
                  'english' => 'required|string|max:255',
                  'learning_status' => 'nullable|integer|min:0|max:2'
            ];
      }

      public function messages()
      {
            return [
                  'turkish.required' => 'Turkish word is required',
                  'turkish.max' => 'Turkish word cannot exceed 255 characters',
                  'english.required' => 'English word is required',
                  'english.max' => 'English word cannot exceed 255 characters',
                  'learning_status.integer' => 'Learning status must be a number',
                  'learning_status.min' => 'Learning status must be between 0 and 2',
                  'learning_status.max' => 'Learning status must be between 0 and 2'
            ];
      }
}
