<!-- resources/views/albums/share.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-12">

    <h1 class="text-2xl font-semibold mb-4">Share Album: {{ $album->title }}</h1>

    <form method="POST" action="{{ route('albums.processShare', $album) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Select Users to Share With</label>
            <select name="users[]" multiple class="form-input w-full">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Share Album</button>
    </form>

</div>
@endsection
