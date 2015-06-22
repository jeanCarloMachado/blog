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

        $sql = "UPDATE `$this->tableName` SET ";

        foreach ($data as $key => $entry) {
            if (!in_array($key, $this->columns)) {
                unset($data[$key]);
                continue;
            }
            
            if ($key == 'data' || $key == 'publicado') {
                $sql.= $key."='".$entry."',";
                unset($data[$key]);
                continue;
            }

            $sql.= 
            $this->adapter->platform->quoteIdentifier($key) 
            . ' = ' . $this->adapter->driver->formatParameterName($key).',';
        }
        $sql = substr($sql, 0, -1);

        $sql .= ' WHERE id = '.$id;

        $stmt = $this->adapter->query($sql);
        $stmt->execute($data);

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


    public function getColumns()
    {
        return $this->columns;
    }
    
    public function setColumns($columns)
    {
        $this->columns = $columns;
    
        return $this;
    }
}
