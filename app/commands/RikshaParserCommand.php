<?php

use Illuminate\Console\Command;
use Adombrovsky\RestaurantParser\Facades\RestaurantParser;

/**
 * Class RikshaParserCommand
 */
class RikshaParserCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'parser:riksha';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
    protected $description = 'Parses http://riksha.com.ua/ online restaurant.';

    /**
     * Create a new command instance.
     *
     * @return \RikshaParserCommand
     */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        /**
         * @var $parser \Adombrovsky\RestaurantParser\Classes\Restaurants\RikshaRestaurantParser
         */
        $parser = RestaurantParser::getRikshaParser();
        $parser->parse();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
