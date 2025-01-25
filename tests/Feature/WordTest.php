<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WordTest extends TestCase
{
      use RefreshDatabase;

      public function test_can_get_all_words()
      {
            Word::factory()->count(3)->create();

            $response = $this->getJson('/api/v1/words');

            $response->assertStatus(200)
                  ->assertJsonCount(3);
      }

      public function test_can_create_word()
      {
            $data = [
                  'turkish' => 'Test',
                  'english' => 'Test',
                  'learning_status' => 0
            ];

            $response = $this->postJson('/api/v1/words', $data);

            $response->assertStatus(201)
                  ->assertJson([
                        'turkish' => 'Test',
                        'english' => 'Test',
                        'learning_status' => 0
                  ]);
      }

      public function test_can_update_word()
      {
            $word = Word::factory()->create();

            $data = [
                  'turkish' => 'Updated',
                  'english' => 'Updated',
                  'learning_status' => 1
            ];

            $response = $this->putJson("/api/v1/words/{$word->id}", $data);

            $response->assertStatus(200)
                  ->assertJson([
                        'turkish' => 'Updated',
                        'english' => 'Updated',
                        'learning_status' => 1
                  ]);
      }

      public function test_can_delete_word()
      {
            $word = Word::factory()->create();

            $response = $this->deleteJson("/api/v1/words/{$word->id}");

            $response->assertStatus(204);
            $this->assertSoftDeleted($word);
      }

      public function test_can_update_word_learning_status()
      {
            $word = Word::factory()->create(['learning_status' => 0]);

            $response = $this->patchJson("/api/v1/words/{$word->id}/learning-status", [
                  'status' => 1
            ]);

            $response->assertStatus(200)
                  ->assertJson([
                        'learning_status' => 1
                  ]);
      }

      public function test_validates_required_fields_for_word()
      {
            $response = $this->postJson('/api/v1/words', []);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['turkish', 'english']);
      }

      public function test_validates_learning_status_range()
      {
            $word = Word::factory()->create();

            $response = $this->patchJson("/api/v1/words/{$word->id}/learning-status", [
                  'status' => 3
            ]);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['status']);
      }
}
