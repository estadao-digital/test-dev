<div>
    <form>
        <input type="hidden" wire:model="car_id">

        <div class="form-group">
            <label for="brand">Brand</label>
            <select class="form-control" wire:model="brand_id" id="brand">
                <option value="">-</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="brand">Model</label>
            <select class="form-control" wire:model="model_id" id="model">
                <option value="">-</option>
                @if($models)
                    @foreach($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('model_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" id="year" placeholder="" wire:model="year">
            @error('year') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <button wire:click.prevent="update()" class="btn btn-dark">Update</button>
        <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
    </form>

</div>
