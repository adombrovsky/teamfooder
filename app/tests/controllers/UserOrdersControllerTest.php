<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 17.08.14
 * Time: 2:18
 */

class UserOrdersControllerTest extends TestCase {

    public function testIndex()
    {
        $response = $this->call('GET', route('dev.users.index') );
        $this->assertTrue($response->isOk());
    }

    public function testCreate()
    {
        //
        $response = $this->call('GET', route('dev.userorders.create') );
        $this->assertTrue($response->isOk());
    }

   /* public function testStore()
    {
        //
        $response = $this->call('POST', route('dev.userorders.store') );
        $this->assertTrue($response->isOk());
    }*/

    public function testShow()
    {
        //
        $response = $this->call('GET', route('dev.userorders.show', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testEdit()
    {
        //
        $response = $this->call('GET', route('dev.userorders.edit', array(1)) );
        $this->assertTrue($response->isOk());
    }

    /*public function testUpdate()
    {
        //
        $response = $this->call('PUT', route('dev.userorders.update', array(1)) );
        $this->assertTrue($response->isOk());
    }*/

    public function testDestroy()
    {
        //
        $response = $this->call('DELETE', route('dev.userorders.destroy', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testIndexShouldCallFindAllMethod ()
    {
        $mock = Mockery::mock("UserOrdersRepositoryInterface");
        $mock->shouldReceive("findAll")->once()->andReturn('foo');

        App::instance("UserOrdersRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.userorders.index'));

        $this->assertTrue(!!$response->original);
    }


    public function testShowShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("UserOrdersRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn('foo');

        App::instance("UserOrdersRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.userorders.show',array(1)));

        $this->assertTrue(!!$response->original);
    }

    public function testCreateShouldCallInstanceMethod()
    {
        $mock = Mockery::mock("UserOrdersRepositoryInterface");
        $mock->shouldReceive("instance")->once()->andReturn(array());

        App::instance("UserOrdersRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.userorders.create"));

        $this->assertTrue(!!$response->original);
    }

    public function testEditShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("UserOrdersRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn(array());

        App::instance("UserOrdersRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.userorders.edit",array(1)));

        $this->assertTrue(!!$response->original);
    }

    //ensure that the store method should call the repository's "store" method
    public function testStoreShouldCallStoreMethod()
    {
        $mock = Mockery::mock('UserOrdersRepositoryInterface');
        $mock->shouldReceive('store')->once()->andReturn('foo');
        App::instance('UserOrdersRepositoryInterface', $mock);

        $response = $this->call('POST', route('dev.userorders.store'));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the update method should call the repository's "update" method
    public function testUpdateShouldCallUpdateMethod()
    {
        $mock = Mockery::mock('UserOrdersRepositoryInterface');
        $mock->shouldReceive('update')->once()->andReturn('foo');
        App::instance('UserOrdersRepositoryInterface', $mock);

        $response = $this->call('PUT', route('dev.userorders.update', array(1)));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the destroy method should call the repositories "destroy" method
    public function testDestroyShouldCallDestroyMethod()
    {
        $mock = Mockery::mock('UserOrdersRepositoryInterface');
        $mock->shouldReceive('destroy')->once()->andReturn(true);
        App::instance('UserOrdersRepositoryInterface', $mock);

        $response = $this->call('DELETE', route('dev.userorders.destroy', array(1)));
        $this->assertTrue( empty($response->original) );
    }


}
