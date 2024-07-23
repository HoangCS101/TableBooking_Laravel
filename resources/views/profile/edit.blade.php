@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal Profile')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Profile')

{{-- Content body: main page content --}}

@section('content_body')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="col-span-1">
                <div class="grid grid-cols-1 gap-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="grid grid-cols-1 gap-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl flex flex-col items-center justify-center">
                            {{-- Avatar upload form --}}
                            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center justify-center">
                                @csrf
                                @method('patch')
                                <label for="avatar" class="cursor-pointer">
                                    <img src="{{ $user->picture_url }}" alt="Current Avatar" class="w-80 h-80 rounded-full mb-4">
                                    <!-- <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*"> -->
                                </label>
                                <div class="flex flex-wrap items-center justify-center w-full">
                                    <div class="w-full md:w-auto md:flex-1 md:mr-3">
                                        <x-input-label for="picture_url" :value="__('Save avatar by putting its link down here.')" />
                                        <x-text-input id="picture_url" name="picture_url" type="text" class="mt-1 block w-full" :value="old('picture_url', $user->picture_url)" required autofocus autocomplete="name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('picture_url')" />
                                    </div>
                                    <x-primary-button type="submit" class="mt-4 md:mt-0">
                                        {{ __('Upload Avatar') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush