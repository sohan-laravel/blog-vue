<?php

namespace Tests\Feature\Crud;

use Tests\TestCase;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class TestTest extends BaseCrudTest
{

    use RefreshDatabase;

    protected $myResource;
    protected $model;
    protected $data;
    protected $endpoint;
    protected $add;

    protected function setUp()
    {
        parent::setUp();
        $this->endpoint = '/api/v1/tests';
        $this->data = [
            'name' => "Meu novo CRUD de Tests",
        ];
        $this->model = Test::create($this->data);
    }

}
