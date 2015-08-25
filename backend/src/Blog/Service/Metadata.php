<?php

namespace Blog\Service;

class Metatag extends Crud
{
    protected $tableName = 'metatag';
    protected $columns = [
        'title',
        'description',
        'author',
        'keywords'
    ];
}
