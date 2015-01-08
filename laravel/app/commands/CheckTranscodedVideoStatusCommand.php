<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CheckTranscodedVideoStatusCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wazaar:check-transcoded-videos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Will check transcoded video status from AWS. Will mark with proper status and extract the output videos for completed jobs';
	protected $videoHelper;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->videoHelper = new VideoHelper();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		// We will only check for videos which are in current Submitted and Progressing status
		$statusFilter = [
			Video::STATUS_SUBMITTED,
			Video::STATUS_PROGRESSING
		];

		$videos = Video::whereIn('transcode_status', $statusFilter)->get();

		if ($videos) {
			foreach ($videos as $video) {
				$jobId = $video->transcode_job_id;
				$job = $this->videoHelper->getTranscodingJob($jobId);

				if ($job['Job']['Status']){

				}
				echo '<pre>';
				print_r($job);
				echo '</pre>';
				die;
			}
		}
	}





}
