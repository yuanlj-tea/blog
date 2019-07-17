<?php


namespace App\Http\Model;

use App\Extensions\ShardingBuilder;

abstract class Sharding extends Model
{
    /**
     * 返回分表字段
     * @return string
     */
    abstract public function getShardingKey(): string;

    /**
     * 根据value指定数据库连接名
     * @param string|null $value
     * @return string
     */
    abstract public function setConnectionName(?string $value): string;

    /**
     * 根据value指定数据库表名
     * @param string|null $value
     * @return string
     */
    abstract public function setTableName(?string $value): string;

    /**
     * @inheritdoc
     */
    public function newEloquentBuilder($query)
    {
        return new ShardingBuilder($query);
    }

    /**
     * @param string|null $value
     * @return string
     */
    protected function getConnectionHashId(?string $value): string
    {
        $num = hexdec(md5($value)[0]);
        $r = $num < 8 ? ($num < 4 ? 0 : 1) : ($num < 12 ? 2 : 3);
        return $r;
    }

    /**
     * @param string|null $value
     * @return string
     */
    protected function getTableHashId(?string $value): string
    {
        return md5($value)[1];
    }
}