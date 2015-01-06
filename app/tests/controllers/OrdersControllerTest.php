<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 17.08.14
 * Time: 2:18
 */

class OrdersControllerTest extends TestCase {

    public function testIndex()
    {
        $response = $this->call('GET', route('dev.orders.index') );
        $this->assertTrue($response->isOk());
    }

    public function testCreate()
    {
        //
        $response = $this->call('GET', route('dev.orders.create') );
        $this->assertTrue($response->isOk());
    }

    public function testShow()
    {
        //
        $response = $this->call('GET', route('dev.orders.show', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testEdit()
    {
        //
        $response = $this->call('GET', route('dev.orders.edit', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testDestroy()
    {
        //
        $response = $this->call('DELETE', route('dev.orders.destroy', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testIndexShouldCallFindAllMethod ()
    {
        $mock = Mockery::mock("OrderRepositoryInterface");
        $mock->shouldReceive("findAll")->once()->andReturn('foo');

        App::instance("OrderRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.orders.index'));

        $this->assertTrue(!!$response->original);
    }


    public function testShowShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("OrderRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn('foo');

        App::instance("OrderRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.orders.show',array(1)));

        $this->assertTrue(!!$response->original);
    }

    public function testCreateShouldCallInstanceMethod()
    {
        $mock = Mockery::mock("OrderRepositoryInterface");
        $mock->shouldReceive("instance")->once()->andReturn(array());

        App::instance("OrderRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.orders.create"));

        $this->assertTrue(!!$response->original);
    }

    public function testEditShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("OrderRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn(array());

        App::instance("OrderRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.orders.edit",array(1)));

        $this->assertTrue(!!$response->original);
    }

    //ensure that the store method should call the repository's "store" method
    public function testStoreShouldCallStoreMethod()
    {
        $mock = Mockery::mock('OrderRepositoryInterface');
        $mock->shouldReceive('store')->once()->andReturn('foo');
        App::instance('OrderRepositoryInterface', $mock);

        $response = $this->call('POST', route('dev.orders.store'));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the update method should call the repository's "update" method
    public function testUpdateShouldCallUpdateMethod()
    {
        $mock = Mockery::mock('OrderRepositoryInterface');
        $mock->shouldReceive('update')->once()->andReturn('foo');
        App::instance('OrderRepositoryInterface', $mock);

        $response = $this->call('PUT', route('dev.orders.update', array(1)));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the destroy method should call the repositories "destroy" method
    public function testDestroyShouldCallDestroyMethod()
    {
        $mock = Mockery::mock('OrderRepositoryInterface');
        $mock->shouldReceive('destroy')->once()->andReturn(true);
        App::instance('OrderRepositoryInterface', $mock);

        $response = $this->call('DELETE', route('dev.orders.destroy', array(1)));
        $this->assertTrue( empty($response->original) );
    }


}
