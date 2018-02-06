<?php

namespace NodeRunner;

/**
  * Factory for creating adapter based on their name.
  */
class AdapterFactory
{
    /**
     * @param  string $adapter name of one of classes in ./Adapter folder
     * @param  string $dsn
     * @param  string $database
     * @throws \NodeRunner\Exception\AdapterNotFoundException
     * @return \NodeRunner\IAdapter
     */
    public static function create($adapter, $dsn, $database) {
      $class = '\\NodeRunner\\Adapter\\'.ucfirst($adapter);
      if (class_exists($class)) {
        return new $class($dsn, $database);
      } else {
        throw new \NodeRunner\Exception\AdapterNotFoundException('Adapter "'.$adapter.'" was not found in noderunner-php library.');
      }
    }

}