<?php

namespace Blog\Service;

use Zend\Db\Adapter\Adapter;

class Crud
{
    protected $adapter;
    protected $tableName = '';
    protected $columns = [];

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function update($id, array $data)
    {
        if (!$id) {
            throw new \Exception('Theres no id to update');
        }

        if (empty($data)) {
            throw new \Exception('Theres no data to update');
        }

        $adapter = $this->adapter;
        $qi = function($name) use ($adapter) { 
            return $adapter->platform->quoteIdentifier($name);  
        };

        $fp = function($name) use ($adapter) { 
            return $adapter->driver->formatParameterName($name);  
        };

        $sql = "UPDATE `$this->tableName` SET ";

        foreach ($data as $key => $entry) {
            if (!in_array($key, $this->columns)) {
                unset($data[$key]);
                continue;
            }

            $sql.= $key."='".$entry."',";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ' WHERE id = '.$id;

        try {
            $stmt = $this->adapter->query($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            die(
                'Sql: '.$sql.PHP_EOL
                .'Data: '.implode($data,'|').PHP_EOL
                .'Message: '.$e->getMessage()
            );
        }

        return true;
    }

    public function findAll(array $params)
    {
        $sql = "SELECT * FROM `$this->tableName` 
            WHERE 1=1 ";

        $queryParams = [];

        $sql.=' order by data desc';

        if (isset($params['firstResult']) 
            && isset($params['maxResults'])) {

            $sql.= ' LIMIT ?, ?';
            $queryParams[] = $params['firstResult'];
            $queryParams[] = $params['maxResults'];
        } 

        $stmt = $this->adapter->query($sql);
        $result = $stmt->execute($queryParams);

        $result = $this->toArray($result);

        if (isset($params['resume']) && $params['resume'] == 1) {
            $result = $this->getOnlyResumeOfContent($result);
        }

        return $result;
    }

    public function find($id)
    {
        $stmt = $this->adapter->query(
            "SELECT * FROM $this->tableName JOIN ackceo_metatags 
            WHERE $this->tableName.id = ackceo_metatags.related_id 
            AND $this->tableName.id = ?"
        );

        $result = $stmt->execute(array($id));

        return $this->toArray($result);
    }

    protected function toArray($data)
    {
        $result = [];

        foreach ($data as $entry) {
            $result[] = $entry;
        }

        return $result;
    }

}
