<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class NewsTest extends TestCase
{
    use RefreshDatabase; // Перезагрузка базы данных для каждого теста
    use WithFaker; // Использование фейкеров для создания тестовых данных

    /**
     * Получить последние 10 новостей.
     */
    public function test_get_last_10_news(): void
    {
        News::factory()->count(15)->create();
        User::factory()->create();
        $response = $this->get('api/news/', ['token' => 'test', 'cursor' => null]);

        $response->assertStatus(200);
    }

    /**
     * Словить ошибку, если неверный токен GET запроса.
     */
    public function test_get_wrong_token_error(): void
    {
        News::factory()->count(15)->create();
        User::factory()->create();
        $response = $this->get('api/news/', ['token' => 'wrong', 'cursor' => null]);

        $error = $response->json()[("error")];
        assertEquals(401, $error["code"]);
    }

    /**
     * Создать новую новость.
     */
    public function test_post_new_news(): void
    {
        User::factory()->create();

        $response = $this->post('api/news/', ['token' => 'test', 'title' => 'test', 'content' => 'test']);

        $response->assertStatus(200);
    }

    /**
     * Словить ошибку, если неверный токен POST запроса.
     */
    public function test_post_wrong_token_error(): void
    {
        User::factory()->create();

        $response = $this->post('api/news/', ['token' => 'wrong', 'title' => 'test', 'content' => 'test']);

        $error = $response->json()[("error")];
        assertEquals(403, $error["code"]);
    }

    /**
     * Обновить новость.
     */
    public function test_put_update_news(): void
    {
        User::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->put('api/news/', ['token' => 'wrong', 'title' => 'new_test', 'content' => 'new_test', 'img' => 'unchanged', 'id' => $id]);

        $response->assertStatus(200);
    }

    /**
     * Словить ошибку, если неверный токен PUT запроса.
     */
    public function test_put_wrong_token_error(): void
    {
        User::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->put('api/news/', ['token' => 'wrong', 'title' => 'new_test', 'content' => 'new_test', 'img' => 'unchanged', 'id' => $id]);

        $error = $response->json()[("error")];
        assertEquals(403, $error["code"]);
    }

    /**
     * Удалить новость.
     */
    public function test_delete_one_news(): void
    {
        User::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->delete('api/news/', ['token' => 'test', 'id' => $id]);

        $response->assertStatus(200);
    }

    /**
     * Словить ошибку, если неверный токен DELETE запроса.
     */
    public function test_delete_wrong_token_error(): void
    {
        User::factory()->create();
        News::factory()->create();
        $id = DB::getPdo()->lastInsertId();

        $response = $this->delete('api/news/', ['token' => 'wrong', 'id' => $id]);

        $error = $response->json()[("error")];
        assertEquals(403, $error["code"]);
    }
}
