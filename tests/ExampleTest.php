<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanierTest extends TestCase
{

    // The base URL to use while testing the application.
    protected $baseUrl = 'http://localhost';


    /**
     * A basic functional test example.
     *
     * @return void
     */
    // public function testBasicExample()
    // {
    //     $this->visit('/')
    //     ->see('Laravel 5');
    // }

        public function testExample()
    {
        $this->assertTrue(true);
    }

        public function testExample2()
    {
        $this->assertTrue(false);
    }

}
