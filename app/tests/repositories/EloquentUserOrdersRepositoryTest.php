<?php

/**
 * Class EloquentUserOrdersRepositoryTest
 */
class EloquentUserOrdersRepositoryTest extends TestCase
{
    /**
     * @var EloquentUserOrdersRepository
     */
    private $repo;

    public function setUp ()
    {
        parent::setUp();

        $this->repo = App::make("EloquentUserOrdersRepository");
    }

    public function testFindByIdReturnsModel()
    {
        $user = $this->repo->findById(1);

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
    }

    public function testFindAllReturnsCollection()
    {
        $users = $this->repo->findAll();

        $this->assertTrue($users instanceof Illuminate\Database\Eloquent\Collection);
    }

    public function testValidatePasses()
    {
        $data = array(
            'user_id'=>1,
            'meal_id'=>1,
            'order_id'=>1,
            'count'=>1,
        );
        $reply = $this->repo->validate($data);

        $this->assertTrue($reply);
    }


    public function testPaginateReturnsPaginator()
    {
        $users = $this->repo->paginate(10);
        $this->assertTrue($users instanceof Illuminate\Pagination\Paginator);
    }


    public function testValidationFailsWithWrongScenario()
    {
        try
        {
            $data = array(
                'user_id'=>1,
                'meal_id'=>1,
                'order_id'=>1,
                'count'=>1,
            );

            $this->repo->validate($data,'wrong_scenario');
        }
        catch (ValidationScenarioException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutUserId()
    {
        try
        {
            $data = array(
                'meal_id'=>1,
                'order_id'=>1,
                'count'=>1,
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutMealId()
    {
        try
        {
            $data = array(
                'user_id'=>1,
                'order_id'=>1,
                'count'=>1,
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutOrderId()
    {
        try
        {
            $data = array(
                'user_id'=>1,
                'meal_id'=>1,
                'count'=>1,
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutCount()
    {
        try
        {
            $data = array(
                'user_id'=>1,
                'meal_id'=>1,
                'order_id'=>1,
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithWrongCount()
    {
        try
        {
            $data = array(
                'user_id'=>1,
                'meal_id'=>1,
                'order_id'=>1,
                'count'=>-10,
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
            'user_id'=>1,
            'meal_id'=>1,
            'order_id'=>1,
            'count'=>1,
        );

        $userOrder = $this->repo->store($data);

        $this->assertTrue($userOrder instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($userOrder->user_id === $data['user_id']);
        $this->assertTrue($userOrder->meal_id === $data['meal_id']);
        $this->assertTrue($userOrder->order_id === $data['order_id']);
        $this->assertTrue($userOrder->count === $data['count']);
    }


    public function testUpdateSaves()
    {
        $data = array(
            'user_id'=>1,
            'meal_id'=>1,
            'order_id'=>1,
            'count'=>11,
        );

        $userOrder = $this->repo->update(1,$data);

        $this->assertTrue($userOrder instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($userOrder->count === $data['count']);
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
        $user = $this->repo->instance();

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
    }

    public function testInstanceReturnsModelWithData()
    {
        $data = array(
            'user_id' => 1,
            'meal_id' => 1,
            'order_id' => 1,
        );

        $user = $this->repo->instance($data);

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($user->user_id === $data['user_id']);
        $this->assertTrue($user->meal_id === $data['meal_id']);
        $this->assertTrue($user->order_id === $data['order_id']);
    }


}