<?php

namespace Blog\Service;

class Metadata extends Crud
{
    protected $tableName = 'metatag';
    protected $columns = [
        'related_id',
        'title',
        'description',
        'author',
        'keywords'
    ];

    protected $quotedColumns = [
        'title',
        'description',
        'author',
        'keywords'
    ];
}
