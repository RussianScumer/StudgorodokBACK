<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Tokens;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase; // Перезагрузка базы данных для каждого теста
    use WithFaker; // Использование фейкеров для создания тестовых данных

    /**
     * Получить последние 10 новостей.
     */
    public function test_get_last_10_news(): void
    {
        $id = 0;
        News::factory()->count(15)->create();
        Tokens::factory()->create();
        $response = $this->withHeaders([
            'Acctoken' => 'test'
        ])->get('api/news/' . $id);

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /**
     * Словить ошибку, если неверный токен GET запроса.
     */
    public function test_get_wrong_token_error(): void
    {
        $id = 0;
        News::factory()->count(15)->create();
        Tokens::factory()->create();
        $response = $this->withHeaders([
            'Acctoken' => 'wrong'
        ])->get('api/news/' . $id);

        $response->assertStatus(401);
    }

    /**
     * Создать новую новость.
     */
    public function test_post_new_news(): void
    {
        Tokens::factory()->create();

        $response = $this->withHeaders([
            'Acctoken' => 'test'
        ])->post('api/news/', ['title' => 'test', 'content' => 'test']);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('status'));
    }

    /**
     * Словить ошибку, если неверный токен POST запроса.
     */
    public function test_post_wrong_token_error(): void
    {
        Tokens::factory()->create();

        $response = $this->withHeaders([
            'Acctoken' => 'wrong'
        ])->post('api/news/', ['title' => 'test', 'content' => 'test']);

        $response->assertStatus(401);
    }

    /**
     * Обновить новость.
     */
    public function test_put_update_news(): void
    {
        Tokens::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->withHeaders([
            'Acctoken' => 'test'
        ])->put('api/news/' . $id, ['title' => 'new_test', 'content' => 'new_test', 'img' => 'unchanged']);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('status'));
    }

    /**
     * Словить ошибку, если неверный токен PUT запроса.
     */
    public function test_put_wrong_token_error(): void
    {
        Tokens::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->withHeaders([
            'Acctoken' => 'wrong'
        ])->put('api/news/' . $id, ['title' => 'new_test', 'content' => 'new_test', 'img' => 'unchanged']);

        $response->assertStatus(401);
    }

    /**
     * Удалить новость.
     */
    public function test_delete_one_news(): void
    {
        Tokens::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->withHeaders([
            'Acctoken' => 'test'
        ])->delete('api/news/' . $id);

        $response->assertStatus(200);
    }

    /**
     * Словить ошибку, если неверный токен DELETE запроса.
     */
    public function test_delete_wrong_token_error(): void
    {
        Tokens::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->withHeaders([
            'Acctoken' => 'wrong'
        ])->delete('api/news/' . $id);

        $response->assertStatus(401);
    }
}
