<x-app-layout>
    @section('title', application('name') . " | Parent Details")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Parent Details</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Father's Details</h4>

                    <form class="father_details">
                        @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="name" value="{{ __('Full Name') }}" />
                            <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                :value="$father?->name" />
                            <x-form.error for="name" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="email" value="{{ __('Email') }}" />
                            <x-form.input id="email" class="block w-full mt-1" type="email" name="email"
                                :value="$father?->email"/>
                            <x-form.error for="email" />
                        </div>
                    
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="phone" value="{{ __('Phone Number') }}" />
                            <x-form.input :value="$father?->phone" name="phone" type="text" class="block w-full mt-1" />
                            <x-form.error for="phone" />
                        </div>
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                            <x-form.input id="occupation" class="block w-full mt-1" type="occupation" name="occupation"
                                :value="$father?->occupation" />
                            <x-form.error for="occupation" />
                        </div>
                    
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                            <x-form.input id="office_address" class="block w-full mt-1" type="text" name="office_address"
                                :value="$father?->office_address" />
                            <x-form.error for="office_address" />
                        </div>

                        <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                            <button id="submit_father" type="button" class="btn btn-primary block waves-effect waves-light pull-right">Update</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Mother's Details</h4>

                    <form class="mother_details">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="name" value="{{ __('Full Name') }}" />
                                <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                    :value="$mother?->name" />
                                <x-form.error for="name" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="email" value="{{ __('Email') }}" />
                                <x-form.input id="email" class="block w-full mt-1" type="email" name="email"
                                    :value="$mother?->email" />
                                <x-form.error for="email" />
                            </div>
                        
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="phone" value="{{ __('Phone Number') }}" />
                                <x-form.input id="phone" class="block w-full mt-1" type="tel" name="phone"
                                    :value="$mother?->phone" />
                                <x-form.error for="phone" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                <x-form.input id="occupation" class="block w-full mt-1" type="occupation" name="occupation"
                                    :value="$mother?->occupation" />
                                <x-form.error for="occupation" />
                            </div>
                        
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                <x-form.input id="office_address" class="block w-full mt-1" type="text" name="office_address"
                                    :value="$mother?->office_address" />
                                <x-form.error for="office_address" />
                            </div>

                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="submit_mother" type="button" class="btn btn-primary block waves-effect waves-light pull-right">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#submit_mother').on('click', function(){
                let formData = $('.mother_details').serializeArray();
                toggleAble($(this), true, 'Submitting...');
                var url = "{{ route('student.updateMotherData') }}";

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                }).done((res) => {
                    toggleAble($(this), false);
                    toastr.success(res.message, 'Success!');
                }).fail((err) => {
                    toggleAble($(this), false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

             $('#submit_father').on('click', function () {
                    let formData = $('.father_details').serializeArray();
                    toggleAble($(this), true, 'Submitting...');
                    var url = "{{ route('student.updateFatherData') }}";

                    $.ajax({
                        method: "POST",
                        url,
                        data: formData,
                    }).done((res) => {
                        toggleAble($(this), false);
                        toastr.success(res.message, 'Success!');
                    }).fail((err) => {
                        toggleAble($(this), false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });
        </script>
    @endsection
</x-app-layout>