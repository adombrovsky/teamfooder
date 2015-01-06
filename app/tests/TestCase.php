<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

    /**
     * setUp is called prior to each test
     */
    public function setUp()
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * tearDown is called after each test
     * @return void [type] [description]
     */
    public function tearDown()
    {
        Mockery::close();
    }

}
