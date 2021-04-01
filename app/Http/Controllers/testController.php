<?php

namespace App\Http\Controllers\Api;

use App\Models\Test;
use App\Services\TestService;
use App\Http\Requests\TestRequest;

class TestController extends AbstractController
{
    /**
     * TestController constructor.
     *
     * @param Test $model
     * @param TestService $service
     */
    public function __construct(Test $model, TestService $service)
    {
        parent::__construct($model, $service, new TestRequest());
    }

}
