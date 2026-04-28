<?php

namespace superadmin\models\filter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

abstract class _BaseFilter extends Model
{
    protected string $model_class;

    private array $_values = [];

    public function rules(): array
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }

    public function attributes(): array
    {
        $class = $this->model_class;
        $active_record = new $class();

        return $active_record->attributes();
    }

    public function __get($name)
    {
        if (in_array($name, $this->attributes(), true)) {
            return $this->_values[$name] ?? null;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->attributes(), true)) {
            $this->_values[$name] = $value;
            return;
        }

        parent::__set($name, $value);
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = ($this->model_class)::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $provider;
        }

        $this->applyFilters($query);

        return $provider;
    }

    protected function applyFilters(ActiveQuery $query): void
    {
        foreach ($this->attributes() as $attribute) {
            $value = $this->$attribute ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            $query->andFilterWhere([$attribute => $value]);
        }
    }
}
