<?php

namespace Blog\Service;

class Metadata extends Crud
{
    protected $tableName = 'ackceo_metatags';
    protected $columns = [
        'title', 
        'description', 
        'author', 
        'keywords'
    ];
}
