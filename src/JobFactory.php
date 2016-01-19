<?php

namespace NodeRunner;

/**
  * Factory for creating jobs of certain types
  *
  * @author     JD
  * @copyright  Ebrana s.r.o. (http://ebrana.cz)
  * @license    Ebrana Licence 
  */
class JobFactory
{
    /**
     * @param  string $command  prikaz ktery se ma spustit
     * @return \NodeRunner\Job\Command
     */
    public static function createByCommand($command) {
        return new \NodeRunner\Job\Command($command);
    }

}