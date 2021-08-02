<?php

require('vendor/autoload.php');

class BooksTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    /**
     * setting up guzzle to hit API.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost/shopping-pal/books/'
        ]);
    }

    /**
     * Testcase for listing API.
     *
     * @return void
     */
    public function testGet_ValidInput_BookObject()
    {
        $response = $this->client->get('list', [
            'query' => [],
            'headers'=> [ 
                'Accept'    =>'application/json'
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testcase for new book rceated.
     *
     * @return void
     */
    public function testPost_NewBook_BookObject()
    {
        $response = $this->client->post('create/', [
            'headers'=> [ 
                'Accept'    =>'application/json',
                'Content-Type'=>'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'title'     => 'My Random Test Book',
                'isbn'     => '2090',
                'date'     => '2021-07-21',
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $response = $data['data'];
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('title', $response);
        $this->assertArrayHasKey('isbn', $response);
        $this->assertArrayHasKey('date', $response);
    }

    /**
     * Testcase for edited book.  
     *
     * @return void
     */
    public function testPost_UpdateBook_BookObject()
    {
        $response = $this->client->post('update/2/', [
            'headers'=> [ 
                'Accept'    =>'application/json',
                'Content-Type'=>'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'title'     => 'My Random Test Book',
            ]
        ]);
    }

    /**
     * Testcases for deleted book.
     *
     * @return void
     */
    public function testDelete_Error()
    {
        $response = $this->client->delete('http://localhost/shopping-pal/books/delete/11/', [
            'http_errors' => true
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

}