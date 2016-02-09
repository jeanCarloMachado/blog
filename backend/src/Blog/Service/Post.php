<?php

namespace Blog\Service;

use Blog\Model\Metatag;

class Post extends Crud
{
    private $root = false;
    protected $tableName = 'post';
    protected $columns = [
        'conteudo',
        'titulo',
        'publicado',
        'data',
    ];

    protected $quotedColumns = [
        'conteudo',
        'titulo',
    ];

    public function findAll(array $params)
    {
        $sql = "SELECT t1.id, t2.title, t1.conteudo, t1.publicado, t2.description, t1.data FROM $this->tableName  AS t1 LEFT JOIN ".Metatag::TABLE_NAME." as t2 ON ( t1.id = t2.related_id ) WHERE 1=1 ";

        $queryParams = [];

        if (!$this->root) {
            $sql .= 'AND publicado = 1 ';
        }

        if (isset($params['search'])) {
            $sql .= "AND ( titulo LIKE '%".$params['search']."%' OR conteudo LIKE '%".$params['search']."%' ) ";
        }

        $sql .= ' order by data desc';

        if (isset($params['firstResult'])
            && isset($params['maxResults'])) {
            $sql .= ' LIMIT ?, ?';
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
