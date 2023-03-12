<x-jet-form-section submit="updateStudentInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information.') }}
    </x-slot>

    <x-slot name="form">

        <!-- first_name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="first_name" value="{{ __('First name') }}" />
            <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
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

            <x-jet-input id="dob" type="date" class="mt-1 block w-full" wire:model.defer="state.dob" wire:ignore value="{{ $date->format('Y-m-d')  }}" />
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
