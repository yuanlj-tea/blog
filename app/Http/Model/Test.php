<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Sharding
{
    protected $table = 'test';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable=[
        'user_id',
        'user_name'
    ];

    public function setConnectionName(?string $value): string
    {
        return $this->connection = 'mysql';
        // 根据value分库
        // return $this->connection = 'passport_' . $this->getConnectionHashId($value);
    }

    public function setTableName(?string $value): string
    {
        // 根据value分表
        $tableName =  $this->table = 'tets_' . $this->getTableHashId($value);
        // pd($tableName);
        return $tableName;
    }

    public function getShardingKey(): string
    {
        // 分表字段
        return 'user_id';
    }
}
