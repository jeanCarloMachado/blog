<?php

namespace Blog\Service;

use Zend\Db\Adapter\Adapter;

class Post
{
    private $adapter;
    private $root = false;

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

        $sql = 'UPDATE `ackblog_post` SET ';

        foreach ($data as $key => $entry) {
            $sql.= " ".$qi($key)." = ".$fp($key);
        }

        $sql .= ' WHERE id = ?';

        $stmt = $this->adapter->query($sql);
        $data['id'] = $id;
        $stmt->execute($data);

        return true;
    }

    public function findAll(array $params)
    {
        $sql = 'SELECT * FROM `ackblog_post` 
            WHERE 1=1 ';

        $queryParams = [];

        if (!$this->root) {
            $sql.= 'AND publicado = 1 ';
        }

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
            'SELECT * FROM ackblog_post JOIN ackceo_metatags 
            WHERE ackblog_post.id = ackceo_metatags.related_id 
            AND ackblog_post.id = ?'
        );

        $result = $stmt->execute(array($id));

        return $this->toArray($result);
    }

    private function toArray($data)
    {
        $result = [];

        foreach ($data as $entry) {
            $result[] = $entry;
        }

        return $result;
    }

    private function getOnlyResumeOfContent($content)
    {
        $maxLen = 300;
        foreach ($content as $key => $entry) {
            if (strlen($entry['conteudo']) > $maxLen) {
                $content[$key]['conteudo'] = $this->showNChars($entry['conteudo'], $maxLen);
            }
        }

        return $content;
    }

    private static function showNChars($str, $n = 100)
    {
        if (strlen($str) < $n) {
            return $str;
        }
        $str = substr($str, 0, $n);
        $restChars = strrpos($str, ' ');
        $n = $n - ($n - $restChars);
        $str = substr($str, 0, $n);

        return $str;
    }

    public function getRoot()
    {
        return $this->root;
    }
    
    public function setRoot($root)
    {
        $this->root = $root;
    
        return $this;
    }
}
