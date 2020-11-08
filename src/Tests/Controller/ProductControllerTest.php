<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends AbstractControllerTest
{
    // should be with data fixture
    public function testFindAll()
    {
        $this->client->request('GET', '/products');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testFindById()
    {
        $this->client->request('GET', '/products/5');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($response->getContent(), json_encode(
            ['id' => 5, 'uuid' => '94d88fda-14a1-11eb-8584-0242ac130002', 'name' => 'Speed TR Flexweave Shoes', 'brand' => 'Flexweave', 'brand' => 1300]
        ));
    }


    public function testProductNotFound()
    {
        $this->client->request('GET', '/products/99999');
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

}
