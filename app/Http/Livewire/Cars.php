<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Model;

class Cars extends Component
{
    /**
     * @var
     */
    public $cars, $car_id, $brand_id, $model_id, $year, $brands, $models;

    /**
     * @var bool
     */
    public $updateMode = false;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->cars = Car::all();
        $this->brands = Brand::all();

        if ($this->brand_id) {
            $this->models = Model::where('brand_id', $this->brand_id)->get();
        }

        return view('livewire.cars');
    }

    /**
     * Store car
     */
    public function store()
    {
        $data = $this->validate([
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ]);

        Car::create($data);

        session()->flash('message', 'Car created.');

        $this->resetInputFields();
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $this->updateMode = true;

        $car = Car::where('id', $id)->first();

        $this->car_id = $id;
        $this->brand_id = $car->brand_id;
        $this->model_id = $car->model_id;
        $this->year = $car->year;
    }

    /**
     * Update car
     */
    public function update()
    {
        $this->validate([
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ]);

        if ($this->car_id) {
            $car = Car::find($this->car_id);
            $car->update([
                'brand_id' => $this->brand_id,
                'model_id' => $this->model_id,
                'year' => $this->year,
            ]);

            $this->updateMode = false;

            session()->flash('message', 'Car updated.');

            $this->resetInputFields();
        }
    }

    /**
     * Delete car
     *
     * @param $id
     */
    public function delete($id)
    {
        if($id){
            Car::where('id', $id)->delete();

            session()->flash('message', 'Car deleted.');
        }
    }

    /**
     * Cancel
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    /**
     * Reset inputs
     */
    private function resetInputFields()
    {
        $this->brand_id = '';
        $this->model_id = '';
        $this->year = '';
    }

}
