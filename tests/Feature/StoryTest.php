<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoryTest extends TestCase
{
      use RefreshDatabase;

      public function test_can_get_all_stories()
      {
            Story::factory()->count(3)->create();

            $response = $this->getJson('/api/v1/stories');

            $response->assertStatus(200)
                  ->assertJsonCount(3);
      }

      public function test_can_create_story()
      {
            $data = [
                  'name' => 'Test Story',
                  'content' => 'Test Content',
                  'current_page' => 0
            ];

            $response = $this->postJson('/api/v1/stories', $data);

            $response->assertStatus(201)
                  ->assertJson([
                        'name' => 'Test Story',
                        'content' => 'Test Content',
                        'current_page' => 0
                  ]);
      }

      public function test_can_update_story()
      {
            $story = Story::factory()->create();

            $data = [
                  'name' => 'Updated Story',
                  'content' => 'Updated Content',
                  'current_page' => 1
            ];

            $response = $this->putJson("/api/v1/stories/{$story->id}", $data);

            $response->assertStatus(200)
                  ->assertJson([
                        'name' => 'Updated Story',
                        'content' => 'Updated Content',
                        'current_page' => 1
                  ]);
      }

      public function test_can_delete_story()
      {
            $story = Story::factory()->create();

            $response = $this->deleteJson("/api/v1/stories/{$story->id}");

            $response->assertStatus(204);
            $this->assertSoftDeleted($story);
      }

      public function test_validates_required_fields_for_story()
      {
            $response = $this->postJson('/api/v1/stories', []);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['name', 'content']);
      }
}
