<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index(Request $request): LengthAwarePaginator|Collection
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder
         */
        $builder = User::select();
        $table = $builder->getModel()->getTable();

        $builder->select($table.'.*')->distinct($table.'.id');

        $builder = $this->addFilters($builder, $request->query('filter'), $table);

        $results = $builder->get();

        return $results;

    }

    protected function addFilters(Builder $builder, ?array $filters, string $table): Builder
    {
        if (is_array($filters)) {
            foreach ($filters as $field => $filterRules) {
                if (\str_contains($field, '.')) {
                    $field = preg_replace('/^.*\./', '', $field);
                } else {
                    $qualifiedField = $table.'.'.$field;
                }

                foreach ($filterRules as $ruleOperator => $value) {
                    $operator = null;

                    switch ($ruleOperator) {
                        case '_eq':
                            $operator = '=';
                            break;

                        case '_neq':
                            $operator = '<>';
                            break;
                        }

                        if (! is_null($operator)) {
                            $builder->where($qualifiedField, $operator, $value);
                        }
                    }
                }
            }

        return $builder;
    }

}
