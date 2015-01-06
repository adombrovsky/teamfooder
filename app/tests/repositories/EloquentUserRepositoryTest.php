<?php

/**
 * Class EloquentUserRepositoryTest
 */
class EloquentUserRepositoryTest extends TestCase
{
    /**
     * @var EloquentUserRepository
     */
    private $repo;

    public function setUp ()
    {
        parent::setUp();

        $this->repo = App::make("EloquentUserRepository");
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
            'name'=>'test',
            'email'=>'test@test.com'
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
                'name'=>'test',
                'email'=>'test@test.com'
            );

            $this->repo->validate($data,'wrong_scenario');
        }
        catch (ValidationScenarioException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutName()
    {
        try
        {
            $data = array(
                'email' => 'test@test.com'
            );

            $this->repo->validate($data);
        }
        catch (ValidationException $expected)
        {
            return;
        }

        $this->fail("Exception was not raised");
    }

    public function testValidationFailsWithoutEmail()
    {
        try
        {
            $data = array(
                'name' => 'test'
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
            'name'=>'test',
            'email'=>'test@test.com'
        );

        $user = $this->repo->store($data);

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($user->name === $data['name']);
        $this->assertTrue($user->email === $data['email']);
    }


    public function testUpdateSaves()
    {
        $data = array(
            'name'=>'user',
            'email'=>'test@test.com'
        );

        $user = $this->repo->update(1,$data);

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($user->name === $data['name']);
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
            'email' => 'test@test.com'
        );

        $user = $this->repo->instance($data);

        $this->assertTrue($user instanceof Illuminate\Database\Eloquent\Model);
        $this->assertTrue($user->email === $data['email']);
    }


}