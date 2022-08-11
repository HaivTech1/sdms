<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Contest</h4>

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
                    <h4 class="card-title mb-4">Create New Contest</h4>
                    <form action="{{ route('contest.store') }}" method="post">
                        @csrf
                        <div class="outer">
                            <div class="outer">
                                <div class="form-group row mb-4">
                                    <label for="Contestname" class="col-form-label col-lg-2">Contest Title</label>
                                    <div class="col-lg-10">
                                        <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                            id="title" placeholder="Enter Contest title..." :value="old('title')"
                                            autofocus />
                                        <x-form.error for="title" />
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="Contestname" class="col-form-label col-lg-2">Contest Theme</label>
                                    <div class="col-lg-10">
                                        <x-form.input id="theme" class="block w-full mt-1" type="text" name="theme"
                                            id="theme" placeholder="Enter Contest theme..." :value="old('theme')"
                                            autofocus />
                                        <x-form.error for="theme" />
                                    </div>
                                </div>


                                <div class="form-group row mb-4">
                                    <label class="col-form-label col-lg-2">Contest Date</label>
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
                                    <label for="Contestbudget" class="col-form-label col-lg-2">Budget</label>
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
                                <button type="submit" class="btn btn-primary">Create Contest</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>