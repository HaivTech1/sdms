<div>
    <x-loading />
    <x-jet-form-section submit="updateApplicationInformation">

        <x-slot name="title">
            {{ __('Application Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your application\'s information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="row">
                <!-- Site Name -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="name" value="{{ __('Name') }}" />
                    <x-form.input id="name" type="text" class="block w-full mt-1" wire:model.defer="app.name"
                        autocomplete="name" />
                    <x-form.error for="name" class="mt-2" />
                </div>

                <!-- Site Alias -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="alias" value="{{ __('Alias') }}" />
                    <x-form.input id="alias" type="text" class="block w-full mt-1" wire:model.defer="app.alias"
                        autocomplete="alias" />
                    <x-form.error for="alias" class="mt-2" />
                </div>
                <!-- Site Email -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="email" value="{{ __('Email') }}" />
                    <x-form.input id="email" type="email" class="block w-full mt-1" wire:model.defer="app.email" />
                    <x-form.error for="email" class="mt-2" />
                </div>
                <!-- Site line 1 -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="line1" value="{{ __('Mobile Number 1') }}" />
                    <x-form.input id="line1" type="text" class="block w-full mt-1" wire:model.defer="app.line1"
                        autocomplete="line1" />
                    <x-form.error for="line1" class="mt-2" />
                </div>
                <!-- Site line2 -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="line2" value="{{ __('Mobile Line 2') }}" />
                    <x-form.input id="line2" type="text" class="block w-full mt-1" wire:model.defer="app.line2"
                        autocomplete="line2" />
                    <x-form.error for="line2" class="mt-2" />
                </div>
                <!-- Site slogan -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="slogan" value="{{ __('Slogan') }}" />
                    <x-form.input id="slogan" type="text" class="block w-full mt-1" wire:model.defer="app.slogan"
                        autocomplete="slogan" />
                    <x-form.error for="slogan" class="mt-2" />
                </div>

                <!-- Site motto -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="motto" value="{{ __('Motto') }}" />
                    <x-form.input id="motto" type="text" class="block w-full mt-1" wire:model.defer="app.motto"
                        autocomplete="motto" />
                    <x-form.error for="motto" class="mt-2" />
                </div>

                <!-- Site whatsapp -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="whatsapp" value="{{ __('Whatsapp') }}" />
                    <x-form.input id="whatsapp" type="text" class="block w-full mt-1" wire:model.defer="app.whatsapp"
                        autocomplete="whatsapp" />
                    <x-form.error for="whatsapp" class="mt-2" />
                </div>

                <!-- Site facebook -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="facebook" value="{{ __('Facebook') }}" />
                    <x-form.input id="facebook" type="text" class="block w-full mt-1" wire:model.defer="app.facebook"
                        autocomplete="facebook" />
                    <x-form.error for="facebook" class="mt-2" />
                </div>

                <!-- Site instagram -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="instagram" value="{{ __('Instagram') }}" />
                    <x-form.input id="instagram" type="text" class="block w-full mt-1" wire:model.defer="app.instagram"
                        autocomplete="instagram" />
                    <x-form.error for="instagram" class="mt-2" />
                </div>

                <!-- Site address -->
                <div class="col-md-6 mb-3">
                    <x-form.label for="address" value="{{ __('Address') }}" />
                    <x-form.input id="address" type="text" class="block w-full mt-1" wire:model.defer="app.address"
                        autocomplete="address" />
                    <x-form.error for="address" class="mt-2" />
                </div>

                <!-- Site description -->
                <div class="col-sm-12">

                    <div class="mb-3">
                        <x-form.label for="Postdesc" value="{{ __('Description') }}" />
                        <textarea class="form-control" id="Postdesc" rows="5" wire:model.defer="app.description"
                            value="old('description')" placeholder="Post Description"></textarea>
                    </div>

                </div>
            </div>
        </x-slot>
        <div class="col-sm-12">
            <x-slot name="actions" class="float-right">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <button class="btn btn-primary block waves-effect waves-light pull-right" wire:loading.attr="disabled"
                    wire:target="photo">
                    {{ __('Update Settings') }}
                </button>
            </x-slot>
        </div>
    </x-jet-form-section>
</div>