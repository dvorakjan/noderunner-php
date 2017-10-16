<?php

namespace NodeRunner\Adapter;

use NodeRunner\IAdapter;
use NodeRunner\Utils;

class Mongo implements IAdapter {

    private $dsn = null;
    private $dataDatabase = null;

    /** @var \MongoClient $client */
    private $client = null;

    /** @var \MongoDB $collection */
    private $db = null;


    /**
     * Keep last inserted array, because it is needed in getInsertId function
     *
     * @var \MongoId $lastInsertId
     */
    private $lastInsertId = null;

    /**
     * @param string $dsn
     * @param string $dataDatabase
     */
    public function __construct($dsn, $dataDatabase = null)
    {
        $this->dsn = $dsn;
        $this->dataDatabase = $dataDatabase;
    }

    /**
     * Method must make connection to DB, when disconnect.
     */
    public function connect()
    {
        if(is_null($this->client))
        {
            $this->client = new \MongoClient($this->dsn);
            $parsedDsn = Utils::ParseDsn($this->dsn);
            if(is_null($this->dataDatabase)) {
                $this->db = $this->client->{$parsedDsn['database']};
            }else{
                $this->db = $this->client->{$this->dataDatabase};
            }
        }
    }

    /**
     * Check if adapter is connected.
     *
     * @author Vojta Biberle
     *
     * @return bool
     */
    public function isConnected()
    {
        return !is_null($this->client);
    }

    public function insert($collection, $data, $options = [])
    {
        $this->connect();

        $status = $this->db->{$collection}->insert($data, $options);
        $this->lastInsertId = isset($data['_id']) ? $data['_id'] : null;
        return $status;
    }

    public function update($collection, $criteria, $data, $options = [])
    {
        $this->connect();
        return $this->db->{$collection}->update($criteria, $data, $options);
    }

    public function count($collection, $query = [])
    {
        $this->connect();
        return $this->db->{$collection}->count($query);
    }

    public function remove($collection, $criteria = [], $options = [])
    {
        $this->connect();
        return $this->db->{$collection}->remove($criteria, $options);
    }

    public function drop($collection)
    {
        $this->connect();
        return $this->db->{$collection}->drop();
    }

    public function find($collection, $query = [], $fields = [])
    {
        $this->connect();
        return $this->db->{$collection}->find($query, $fields);
    }

    public function findOne($collection, $query = [], $fields = [])
    {
        $this->connect();
        return $this->db->{$collection}->findOne($query, $fields);
    }

    public function findAndModify($collection, $query = [], $update = [], $fields = [], $options = [])
    {
        $this->connect();
        return $this->db->{$collection}->findAndModify($query, $update, $fields, $options);
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId ? $this->lastInsertId->__toString() : null;
    }

    public function objectId($id)
    {
        return new \MongoId($id);
    }

    public function regex($pattern, $flags = '')
    {
        return new \MongoRegex('/'.$pattern.'/'.$flags);
    }
}
