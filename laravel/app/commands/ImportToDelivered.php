<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportToDeliveredCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:import-to-delivered';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Imports missing users to Delivered and updates tags';

	/**
	 * Create a new command instance.
	 *
	 * @return void
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
            DeliveredImporter::import();
            DeliveredImporter::updateTags();
	}

	

}
