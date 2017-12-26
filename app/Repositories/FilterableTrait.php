<?php 

namespace App\Repositories;

trait FilterableTrait
{

    protected $filters = [];
    

     protected function addFilter($field, $value)
    {
        $exits = false;
        $seachLike;

        foreach ($this->validFilterableFields as $validField) {
            $seachLike = false;
            if (strpos($validField, '%') !== false) {
                $validField = substr($validField, 1, -1);
                $seachLike = true;
            }
            if($validField == $field){
                $exits=true;
                break;
            }
        }

        if($exits) {
            $this->filters[$field] = $seachLike ? '%' . $value . '%' : $value;
        }
    }

    public function applyFilters($filters){
        foreach ($filters as $param => $value) {
            $this->addFilter($param,$value);
        }
        return $this;
    }

    public function all()
    {
        return $this->applyFiltersToQuery()->get();
    }

    private function applyFiltersToQuery()
    {
        $query = $this->query();
        foreach($this->filters as $field => $value) {
            if (strpos($value, '%') !== false) {
                $query->where($field, 'like' , $value);
            } else {
                $query->where($field, $value);
            }
        }
        return $query;
    }

    abstract public function query();
}