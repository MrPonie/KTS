<?php

namespace App\Livewire;

use Livewire\Component;

class ModelSearch extends Component
{
    public string $model;
    public string $searchcolumn;
    public array $filter=[]; // [ [ 'column' => string, 'operator' => string, 'value' => string ], ... ]
    public array $join=[]; // [ [ 'table' => string, 'table-col' => string, 'operator' => string, 'other-col' => string ], ... ]

    public string $name='';
    public string $label='';

    public string $search='';

    public array $options=[]; // [ {id:int, name:string}, ... ]

    public function clear() {
        $this->search = '';
    }

    public function render()
    {
        $this->options = [];
        if(!empty($this->search)){
            $cls = '\App\Models\\'.$this->model;
            $records = $cls::select('id', $this->searchcolumn.' as name')->where($this->searchcolumn, 'like', "%$this->search%");
            foreach($this->filter as $filter) {
                $records = $records->where($filter['column'], $filter['operator'], $filter['value']);
            }
            foreach($this->join as $join) {
                $records = $records->leftJoin($join['table'], $join['table-col'], $join['operator'], $join['other-col']);
            }
            $records = $records->get();
            foreach($records as $record) {
                $item = (object)['id'=>$record->id, 'name'=>htmlspecialchars($record->name)];
                if(!in_array($item, $this->list)) {
                    $this->options[] = $item;
                }
            }
        }
        return view('livewire.model-search');
    }
}
