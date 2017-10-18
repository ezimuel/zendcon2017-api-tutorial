<?php

namespace Book;

use PDO;
use PDOStatement;
use RuntimeException;
use Zend\Paginator\Adapter\AdapterInterface;

class PdoPaginator implements AdapterInterface
{
    private $class;
    private $count;
    private $params;
    private $select;

    public function __construct(PdoStatement $select, PdoStatement $count, array $params = [], string $class = null)
    {
        $this->select = $select;
        $this->count  = $count;
        $this->params = $params;
        $this->class  = $class;
    }

    /**
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $params = array_merge($this->params, [
            ':offset' => $offset,
            ':limit'  => $itemCountPerPage,
        ]);

        $result = $this->select->execute($params);

        if (! $result) {
            throw new RuntimeException('Failed to fetch items from database');
        }

        switch ($this->class) {
            case null:
                return $this->select->fetchAll(PDO::FETCH_ASSOC);
            default:
                return $this->select->fetchAll(PDO::FETCH_CLASS, $this->class);
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        $result = $this->count->execute($this->params);
        if (! $result) {
            throw new RuntimeException('Failed to fetch count from database');
        }
        return $this->count->fetchColumn();
    }
}
