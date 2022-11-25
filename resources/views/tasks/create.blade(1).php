<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Tasks</h4>

        <div class="page-name-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">
                    Create
                </li>
            </ol>
        </div>
    </x-slot>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Create New Task</h4>
                    <form action="{{ route('task.store') }}" method="post">
                        @csrf
                        <div class="outer">
                            <div class="outer">
                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Task Name</label>
                                    <div class="col-lg-10">
                                        <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                            id="name" placeholder="Enter task name..." :value="old('name')" autofocus />
                                        <x-form.error for="name" />
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label col-lg-2">Task Description</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" id="productdesc" rows="5" name="description"
                                            value="old('description')" placeholder="Description"></textarea>
                                        <x-form.error for="description" />
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label col-lg-2">Task Date</label>
                                    <div class="col-lg-10">
                                        <div class="input-daterange input-group" data-provide="datepicker">

                                            <x-form.input id="start" class="block w-full mt-1" type="text" name="start"
                                                id="start" placeholder="Start date" :value="old('start')" autofocus />
                                            <x-form.input id="end" class="block w-full mt-1" type="text" name="end"
                                                id="end" placeholder="End date" :value="old('end')" autofocus />
                                            <x-form.error for="end" />
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row mb-4">
                                    <label for="taskbudget" class="col-form-label col-lg-2">Budget</label>
                                    <div class="col-lg-10">

                                        <x-form.input id="budget" class="block w-full mt-1" type="number" name="budget"
                                            id="budget" placeholder="Budget" :value="old('budget')" autofocus />
                                        <x-form.error for="budget" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>