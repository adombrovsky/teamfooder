<?php

/**
 * Class EloquentUserRepository
 */
class EloquentUserRepository implements UserRepositoryInterface
{


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return User
     */
    public function findById ($id)
    {
        $user = User::find($id);

        if (!$user) throw new NotFoundException('User not found');
        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        return User::all();
    }

    /**
     * @param null $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = NULL)
    {
        return User::paginate($limit);
    }

    /**
     * @param $data
     *
     * @param $scenario
     *
     * @return User
     */
    public function store ($data, $scenario)
    {
        $this->validate($data, $scenario);
        User::observe(new UserObserver());
        $model = new User();
        $model->fill($data);
        $model->password = $data['password'];
        $model->save();
        return $model;
    }

    /**
     * @param $id
     * @param $data
     *
     * @return User
     */
    public function update ($id, $data)
    {
        $user = $this->findById($id);
        $this->validate($data);
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function destroy ($id)
    {
        $user = $this->findById($id);

        return $user->delete();
    }

    /**
     * @param        $data
     *
     * @param string $scenario
     *
     * @throws ValidationException
     * @throws ValidationScenarioException
     * @return bool
     */
    public function validate ($data, $scenario = User::DEFAULT_SCENARIO)
    {
        if (!isset(User::$rules[$scenario])) throw new ValidationScenarioException("Scenario: ".$scenario." not found in User model");
        $validator = Validator::make($data, User::$rules[$scenario]);
        if($validator->fails()) throw new ValidationException($validator);
        return true;
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function instance ($data = array())
    {
        return new User($data);
    }
}