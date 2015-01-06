<?php

/**
 * Class EloquentOrderRepositoryTest
 */
class EloquentOrderRepositoryTest extends TestCase
{
    /**
     * @var EloquentOrderRepository
     */
    private $repo;

    public function setUp ()
    {
        parent::setUp();

        $this->repo = App::make("EloquentOrderRepository");
    }

    public function testFindByIdReturnsModel()
    {
        $order = $this->repo->findById(1);

        $this->assertTrue($order instanceof Illuminate\Database\Eloquent\Model);
    }

    public function testFindAllReturnsCollection()
    {
        $orders = $this->repo->findAll();

        $this->assertTrue($orders instanceof Illuminate\Database\Eloquent\Collection);
    }

    public function testValidatePasses()
    {
        $data = array(
            'title'=>'test',
            'date'=>'2014-10-10 10:10:10'
        );
        $reply = $this->repo->validate($data);

        $this->assertTrue($reply);
    }


    public function testPaginateReturnsPaginator()
    {
        $orders = $this->repo->paginate(10);
        $this->assertTrue($orders instanceof Illuminate\Pagination\Paginator);
    }


    public function testValidationFailsWithWrongScenario()
    {
        try
        {
            $data = array(
                'title'=>'test',
                'date'=>'2014-10-10 10:10:10'
            );

            $this->repo->validate($data,'wrong_scenario');
        }
        catch (ValidationScenarioException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutTitle()
    {
        try
        {
            $data = array(
                'date'=>'2014-10-10 10:10:10'
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutDate()
    {
        try
        {
            $data = array(
                'title'=>'test',
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testStoreReturnsModel()
    {
        $data = array(
            'title'=>'test',
            'date'=>'2014-10-10 10:10:10'
        );

        $order = $this->repo->store($data);

        $this->assertTrue($order instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($order->title === $data['title']);
        $this->assertTrue($order->date === strtotime($data['date']));
    }


    public function testUpdateSaves()
    {
        $data = array(
            'title'=>'test1',
            'date'=>'2014-10-10 10:10:10'
        );

        $order = $this->repo->update(1,$data);

        $this->assertTrue($order instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($order->title === $data['title']);
    }

    public function testDestroySaves()
    {
        $reply = $this->repo->destroy(1);
        $this->assertTrue($reply);

        try
        {
            $this->repo->findById(1);
        }
        catch (NotFoundException $expected)
        {
            return;
        }

        $this->fail("NotFoundException was not raised");
    }

    public function testInstanceReturnsModel()
    {
        $order = $this->repo->instance();

        $this->assertTrue($order instanceof Illuminate\Database\Eloquent\Model);
    }

    public function testInstanceReturnsModelWithData()
    {
        $data = array(
            'id'=>1,
        );

        $order = $this->repo->instance($data);

        $this->assertTrue($order instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($order->id === $data['id']);
    }


}