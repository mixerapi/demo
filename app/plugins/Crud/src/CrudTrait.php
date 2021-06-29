<?php
declare(strict_types=1);

namespace Crud;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Xml;

trait CrudTrait
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * Sets the table name
     *
     * @param string $table
     * @return $this
     */
    public function setTable(string $table)
    {
        $this->tableName = $table;

        return $this;
    }
}
