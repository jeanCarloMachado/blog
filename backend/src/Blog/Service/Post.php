<?php

namespace Blog\Service;

class Post extends Crud
{
    private $root = false;
    protected $tableName = 'ackblog_post';
    protected $columns = [
        'conteudo', 
        'titulo',
        'publicado',
        'data'
    ];

    public function findAll(array $params)
    {
        $sql = "SELECT * FROM `$this->tableName` 
            WHERE 1=1 ";

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

    private function getOnlyResumeOfContent($content)
    {
        $maxLen = 300;
        foreach ($content as $key => $entry) {
            if (strlen($entry['conteudo']) > $maxLen) {
                $content[$key]['conteudo'] = $this->showNChars(
                    $entry['conteudo'], 
                    $maxLen
                );
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
