<?php

namespace superadmin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Generic search model for superadmin CRUD listing pages.
 *
 * Provides a minimal, uniform "load + filter + sort + paginate" wrapper
 * around an ActiveRecord query. Individual search models can extend and
 * customize filtering logic as needed.
 */

abstract class _BaseSearch extends Model
{
	public function search(array $params): ActiveDataProvider
	{
        $query = ($this->model_class)::find();
        $provider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        if (!$this->validate()) {
			return $provider;
		}

        $this->applyFilters($query);
        return $provider;
    }

    // abstract protected function applyFilters($query): void;
}
