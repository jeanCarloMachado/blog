<?php

namespace Blog\Service;

use Zend\Feed\Writer\Feed as ZendFeed;
use Parsedown;

class Feed
{
    public function hasCache()
    {
        return file_exists('/tmp/feed');
    }

    public function getCache()
    {
        return file_get_contents('/tmp/feed');
    }

    public function removeCache()
    {
        @unlink('/tmp/feed');
    }

    public function create($postCollection)
    {
        $authorData = array(
            'name' => 'Jean Carlo Machado',
            'email' => 'cotato@jeancarlomachado.com.br',
            'uri' => 'http://jeancarlomachado.com.br/about',
        );

        $feed = new ZendFeed();
        $feed->setTitle('Jean Carlo Machado\'s Blog');
        $feed->setLink('http://jeancarlomachado.com.br');
        $feed->setFeedLink('http://backend.jeancarlomachado.com.br/feed', 'atom');
        $feed->addAuthor($authorData);

        $feed->setDateModified(time());

        $filter = new \Zend\Filter\StripTags(array('allowTags' => ''));
        foreach ($postCollection as $postData) {
            $entry = $feed->createEntry();
            $entry->setTitle($postData['titulo']);
            $entry->setLink('http://jeancarlomachado.com.br/#/post/'.$postData['id']);
            $entry->addAuthor($authorData);
            $entry->setDateModified(time());

            $markdown = new Markdown(new Parsedown(), $postData['conteudo']);
            $content = $markdown->convert();
            $content = $filter->filter($content);
            $content = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '', $content);

            $description = $content;

            $entry->setDescription($description);
            $entry->setContent($content);
            $feed->addEntry($entry);
        }

        $feedContent = $feed->export('atom');
        file_put_contents('/tmp/feed', $feedContent);

        return $feedContent;
    }
}
