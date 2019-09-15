<?php

namespace App\Extensions;

use App\Http\Model\Sharding;
use Illuminate\Database\Eloquent\Builder;

class ShardingBuilder extends Builder
{
    protected $model;

    /**
     * @inheritdoc
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        do {
            if (!$this->model instanceof Sharding || $column instanceof \Closure) {
                break;
            }

            if (func_num_args() === 2) {
                $value = $operator;
                $operator = '=';
            }

            if ($operator !== '=' && !is_array($column)) {
                break;
            }

            $rawShardingKey = $this->model->getShardingKey();
            $shardingKey = '.' . $rawShardingKey;
            $keyLen = strlen($shardingKey);
            $column = $tmpColumns = $operator === '=' ? [$column => $value] : $column;

            foreach ($tmpColumns as $c => $v) {
                if (!$cv = $this->parseCV($c, $v)) {
                    continue;
                }
                list($nc, $nv) = $cv;

                if (strncasecmp(substr('.' . $nc, -$keyLen), $shardingKey, $keyLen) === 0) {
                    $this->updateQuery($nv);

                    unset($column[$c]);
                    $column[$rawShardingKey] = $nv;

                    break;
                }
            }
        } while (false);

        return parent::where($column, $operator, $value, $boolean);
    }

    /**
     * @inheritdoc
     */
    public function newModelInstance($attributes = [])
    {
        $shardingKey = $this->model->getShardingKey();

        if ($attributes && isset($attributes[$shardingKey])) {
            $this->updateQuery($attributes[$shardingKey]);
        }

        return parent::newModelInstance($attributes);
    }

    /**
     * @param string|null $value
     */
    protected function updateQuery(?string $value): void
    {
        $oldConnectionName = $this->model->getConnectionName();
        $model = $this->model->setConnectionName($value);

        $oldTableName = $this->model->getTable();
        $table = $this->model->setTableName($value);
// pd($model,$table);die;
        $oldConnectionName != $model && $this->query->connection = $this->model->getConnection();
        $oldTableName != $table && $this->query->from = $table;
    }

    /**
     * @param string|int $column
     * @param mixed $value
     * @return array|null
     */
    protected function parseCV($column, $value): ?array
    {
        if (is_numeric($column) && is_array($value)) {
            if (count($value) === 2) {
                return $value;
            }

            list($column, $operator, $value) = $value;

            return $operator === '=' ? [$column, $value] : null;
        }

        return [$column, $value];
    }
}