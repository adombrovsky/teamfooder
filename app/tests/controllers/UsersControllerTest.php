<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 17.08.14
 * Time: 2:18
 */

class UsersControllerTest extends TestCase {

    public function testIndex()
    {
        $response = $this->call('GET', route('dev.users.index') );
        $this->assertTrue($response->isOk());
    }

    public function testCreate()
    {
        //
        $response = $this->call('GET', route('dev.users.create') );
        $this->assertTrue($response->isOk());
    }

    /*public function testStore()
    {
        //
        $response = $this->call('POST', route('dev.users.store') );
        $this->assertTrue($response->isOk());
    }*/

    public function testShow()
    {
        //
        $response = $this->call('GET', route('dev.users.show', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testEdit()
    {
        //
        $response = $this->call('GET', route('dev.users.edit', array(1)) );
        $this->assertTrue($response->isOk());
    }

    /*public function testUpdate()
    {
        //
        $response = $this->call('PUT', route('dev.users.update', array(1)) );
        $this->assertTrue($response->isOk());
    }*/

    public function testDestroy()
    {
        //
        $response = $this->call('DELETE', route('dev.users.destroy', array(1)) );
        $this->assertTrue($response->isOk());
    }

    public function testIndexShouldCallFindAllMethod ()
    {
        $mock = Mockery::mock("UserRepositoryInterface");
        $mock->shouldReceive("findAll")->once()->andReturn('foo');

        App::instance("UserRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.users.index'));

        $this->assertTrue(!!$response->original);
    }


    public function testShowShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("UserRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn('foo');

        App::instance("UserRepositoryInterface",$mock);

        $response = $this->call("GET",route('dev.users.show',array(1)));

        $this->assertTrue(!!$response->original);
    }

    public function testCreateShouldCallInstanceMethod()
    {
        $mock = Mockery::mock("UserRepositoryInterface");
        $mock->shouldReceive("instance")->once()->andReturn(array());

        App::instance("UserRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.users.create"));

        $this->assertTrue(!!$response->original);
    }

    public function testEditShouldCallFindByIdMethod()
    {
        $mock = Mockery::mock("UserRepositoryInterface");
        $mock->shouldReceive("findById")->once()->andReturn(array());

        App::instance("UserRepositoryInterface",$mock);

        $response = $this->call("GET",route("dev.users.edit",array(1)));

        $this->assertTrue(!!$response->original);
    }

    //ensure that the store method should call the repository's "store" method
    public function testStoreShouldCallStoreMethod()
    {
        $mock = Mockery::mock('UserRepositoryInterface');
        $mock->shouldReceive('store')->once()->andReturn('foo');
        App::instance('UserRepositoryInterface', $mock);

        $response = $this->call('POST', route('dev.users.store'));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the update method should call the repository's "update" method
    public function testUpdateShouldCallUpdateMethod()
    {
        $mock = Mockery::mock('UserRepositoryInterface');
        $mock->shouldReceive('update')->once()->andReturn('foo');
        App::instance('UserRepositoryInterface', $mock);

        $response = $this->call('PUT', route('dev.users.update', array(1)));
        $this->assertTrue(!! $response->original);
    }

    //ensure that the destroy method should call the repositories "destroy" method
    public function testDestroyShouldCallDestroyMethod()
    {
        $mock = Mockery::mock('UserRepositoryInterface');
        $mock->shouldReceive('destroy')->once()->andReturn(true);
        App::instance('UserRepositoryInterface', $mock);

        $response = $this->call('DELETE', route('dev.users.destroy', array(1)));
        $this->assertTrue( empty($response->original) );
    }


}
