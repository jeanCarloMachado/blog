<?php

namespace Blog\Service;

/**
 * * @author Jean Carlo Machado <contato@jeancarlomachado.com.br>
 */
class Markdown
{
    private $converter;
    private $data;

    public function __construct($converter, $data)
    {
        $this->converter = $converter;
        $this->data = $data;
    }

    public function convert()
    {
        $parsedown = $this->converter;
        $textToMarkdown = function ($data) use ($parsedown, &$textToMarkdown) {
            if (is_array($data)) {
                foreach ($data as $key => $entry) {
                    if ($key == 'conteudo') {
                        $result[$key] = $textToMarkdown($entry);
                    } else {
                        $result[$key] = $entry;
                    }
                }

                return $result;
            }

            return $parsedown->text($data);
        };

        $result = $textToMarkdown($this->data);

        return $result;
    }
}
