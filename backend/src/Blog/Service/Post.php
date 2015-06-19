<?php

namespace Blog\Service;

use Zend\Db\Adapter\Adapter;

class Post
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function findAll($firstResult = null, $maxResults = null)
    {
        $sql = 'SELECT * FROM `ackblog_post` WHERE publicado = 1 order by data desc';
        if ($firstResult !== null && $maxResults !== null) {
            $sql.= ' LIMIT ?, ?';
            $stmt = $this->adapter->query($sql);
            $result = $stmt->execute([$firstResult, $maxResults]);
        } else {
            $stmt = $this->adapter->query($sql);
            $result = $stmt->execute();
        }

        return $this->toArray($result);
    }

    public function find($id)
    {
        $stmt = $this->adapter->query('SELECT * FROM `ackblog_post` WHERE id = ? order by data desc');
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

    public function getOnlyResumeOfContent($content)
    {
        $maxLen = 300;
        foreach ($content as $key => $entry) {
            if (strlen($entry['conteudo']) > $maxLen) {
                $content[$key]['conteudo'] = $this->showNChars($entry['conteudo'], $maxLen);
            }
        }

        return $content;
    }

    public static function showNChars($str, $n = 100)
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
}
