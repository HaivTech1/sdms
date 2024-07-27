<x-jet-form-section submit="updateStudentInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information.') }}
    </x-slot>

    <x-slot name="form">

        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                            photoName = $refs.photo.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                    " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ asset('storage/' . $this->user->profile_photo_path)}}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- first_name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="first_name" value="{{ __('First name') }}" />
            <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name"
                autocomplete="first_name" />
            <x-jet-input-error for="first_name" class="mt-2" />
        </div>

        <!-- last_name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
            <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" />
            <x-jet-input-error for="last_name" class="mt-2" />
        </div>

        <!-- other_name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="other_name" value="{{ __('Other Name') }}" />
            <x-jet-input id="other_name" type="text" class="mt-1 block w-full" wire:model.defer="state.other_name" />
            <x-jet-input-error for="other_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="gender" value="Gender" />
            <x-jet-input-error for="gender" class="mt-2" />

            <select id="gender" class="form-select block w-full" wire:model.defer="state.gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <div class="flex items-center">
                <x-jet-label for="dob" value="Date of Birth: " />
                <span class="badge badge-soft-success ml-3">{{ $student->dob() }}</span>
            </div>

            <x-jet-input-error for="dob" class="mt-2" />

            @php
                $date = new \DateTime($student->dob);
            @endphp

            <x-jet-input id="dob" type="date" class="mt-1 block w-full" wire:model.defer="state.dob" wire:ignore
                value="{{ $date->format('Y-m-d')  }}" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="house_id" value="House" />
            <x-jet-input-error for="house_id" class="mt-2" />

            <select id="house_id" class="form-select block w-full" wire:model.defer="state.house_id">
                @foreach ($houses as $house)
                    <option value="{{ $house->id()}}">{{ $house->title()}} House</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="club_id" value="Club" />
            <x-jet-input-error for="club_id" class="mt-2" />

            <select id="club_id" class="form-select block w-full" wire:model.defer="state.club_id">
                @foreach ($clubs as $club)
                    <option value="{{ $club->id()}}">{{ $club->title()}}</option>
                @endforeach
            </select>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>