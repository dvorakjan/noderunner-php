<?php

namespace NodeRunner;

use NodeRunner\Exception\QueueException;

class Queue
{
    /** @var string */
    private $queueName;

    /** @var IAdapter $adapter */
    private $adapter;

    /**
     * Queue constructor.
     *
     * @param $DBAdapter
     * @param $queueName
     */
    public function __construct($DBAdapter, $queueName)
    {
        $this->queueName = $queueName;
        $this->adapter = $DBAdapter;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @param \NodeRunner\IJob $message
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function push(IJob $message)
    {
        try {
            if ($message instanceof IJob) {
                $query = $this->transformMessageToQuery($message);
            }

            $this->adapter->insert($this->queueName, $query);

            return $this->adapter->getLastInsertId();
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param bool $remove
     * @return array|mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function pop($remove = true)
    {
        try {
            $sort = new \stdClass;
            $sort->_id = +1;

            if ($remove) {
                $data = $this->adapter->findAndModify($this->queueName, [], null, null, ['sort' => $sort, 'remove' => true]);
            } else {
                $data = $this->adapter->findOne($this->queueName, ['sort' => $sort]);
            }

            return $this->transformDataToMessage($data);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param       $data
     * @param array $options
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function insert($data, array $options = [])
    {
        try {
            return $this->adapter->insert($this->queueName, $data, $options);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param array $criteria
     * @param array $options
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function remove(array $criteria = [], array $options = [])
    {
        try {
            return $this->adapter->remove($this->queueName, $criteria, $options);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function drop()
    {
        try {
            return $this->adapter->drop($this->queueName);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param       $criteria
     * @param       $data
     * @param array $options
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function update($criteria, $data, array $options = [])
    {
        try {
            return $this->adapter->update($this->queueName, $criteria, $data, $options);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param array $query
     * @param array $fields
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function find(array $query = [], array $fields = [])
    {
        try {
            return $this->adapter->find($this->queueName, $query, $fields);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param $query
     * @param $update
     * @param $fields
     * @param $options
     * @return array|mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function findAndModify($query, $update, $fields, $options)
    {
        try {
            return $this->transformDataToMessage($this->adapter->findAndModify($this->queueName, $query, $update, $fields, $options));
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @param array $query
     * @return mixed
     * @throws \NodeRunner\Exception\QueueException
     */
    public function count($query = [])
    {
        try {
            return $this->adapter->count($this->queueName, $query);
        } catch (\Exception $exception) {
            throw new QueueException($exception->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \NodeRunner\Exception\QueueException
     */
    public function isEmpty()
    {
        return $this->count() <= 0;
    }

    /**
     * @param \NodeRunner\IJob $message
     * @return array
     */
    private function transformMessageToQuery(IJob $message)
    {
        $data = $message->toArray();
        $data['__class'] = get_class($message);

        return $data;
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function transformDataToMessage($data)
    {
        if (empty($data)) {
            return [];
        }

        $class = $data['__class'];
        unset($data['__class']);
        $message = call_user_func_array([$class, 'create'], ['data' => $data]);

        return $message;
    }

    /**
     * @return IAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
