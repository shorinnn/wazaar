<?php
require_once 'vendor/autoload.php';

class RoboFile extends \Robo\Tasks
{
    use \Codeception\Task\MergeReports;
    use \Codeception\Task\SplitTestsByGroups;

    public function parallelSplitTests()
    {
        $this->taskSplitTestFilesByGroups(5)
            ->projectRoot('.')
            ->testsFrom('tests/functional')
            ->groupsTo('tests/_log/p')
            ->run();

        // alternatively
//        $this->taskSplitTestsByGroups(5)
//            ->projectRoot('.')
//            ->testsFrom('tests/functional')
//            ->groupsTo('tests/_log/p')
//            ->run();
    }

    public function parallelRun()
    {

    }

    public function parallelMergeResults()
    {

    }
}