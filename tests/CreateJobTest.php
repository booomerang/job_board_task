<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateJobTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJobCreatePageVisiting()
    {
        $this->visit('/job/create')
            ->see('Create');
    }
}
