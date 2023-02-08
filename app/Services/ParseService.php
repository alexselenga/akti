<?php

namespace App\Services;

use App\Contracts\Captions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ReflectionClass;

class ParseService
{
    public function __construct(protected $modelClass, protected $delimiter = ';')
    {
    }

    public function parse(mixed $data): Collection
    {
        $lines = explode("\n", $data);
        if(count($lines)) unset($lines[0]); //Заголовки не учитываем
        $collection = new Collection;

        foreach($lines as $line)
        {
            $values = explode($this->delimiter, $line);
            $keyValues = $this->getKeyValues($values); //Сопостовляем поля и значения
            $this->correctValues($keyValues); //Корректируем артефакты
            $model = new $this->modelClass; /** @var Model $model */
            $model->fill($keyValues);
            $this->validate($model->attributesToArray());
            $collection->add($model);
        }

        return $collection;
    }

    protected function getKeyValues(array $values): array
    {
        $class = new ReflectionClass($this->modelClass);

        if(!$class->implementsInterface(Captions::class))
        {
            throw new \Exception("The $this->modelClass class must implement the Captions interface");
        }

        $fields = array_keys($this->modelClass::getCaptions());
        $result = [];
        $key = 0;

        foreach($fields as $field)
        {
            $result[$field] = $values[$key++];
        }

        return $result;
    }

    protected function correctValues(array &$keyValues)
    {
    }

    protected function validate(array $keyValues)
    {
    }
}
