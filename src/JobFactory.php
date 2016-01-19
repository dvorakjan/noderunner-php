<?php

namespace NodeRunner;

/**
  * Factory for creating jobs of certain types
  *
  * @author     JD
  */
class JobFactory
{
    /**
     * @param  string $command  command to be executed
     * @return \NodeRunner\Job\Command
     */
    public static function createByCommand($command) {
        return new \NodeRunner\Job\Command($command);
    }

    /**
     * @param  array $data  data which will be passed to noderunner document
     * @return \NodeRunner\Job\Data
     */
    public static function createByData($data) {
        return new \NodeRunner\Job\Data($data);
    }

}