<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($updateMode)
        @include('livewire.update')
    @else
        @include('livewire.create')
    @endif

    <table class="table border-top border-bottom table-hover mt-5">
        <thead>
            <tr>
                <th>#</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($cars as $car)
            <tr>
                <td>{{ $car->id }}</td>
                <td>{{ $car->brand->name }}</td>
                <td>{{ $car->model->name }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->created_at }}</td>
                <td>
                    <button wire:click="edit({{ $car->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="delete({{ $car->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        @empty
            <tr class="text-center">
                <td colspan="6">No records found..</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
