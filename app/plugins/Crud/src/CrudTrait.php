<?php
declare(strict_types=1);

namespace Crud;

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
    public function table(string $table)
    {
        $this->tableName = $table;

        return $this;
    }
}
