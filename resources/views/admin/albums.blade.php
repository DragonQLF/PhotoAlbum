@extends('layouts.app')

@section('content')
<div class="container py-12">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard - All Albums</h1>

    <!-- Search Form -->
    <div class="mb-4">
        <form action="{{ route('albums.index') }}" method="GET">
            <input type="text" name="search" placeholder="Search albums" class="p-2 border rounded" value="{{ request()->query('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Album Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <table class="table table-bordered w-full">
                <thead>
                    <tr>
                        <th>Album Title</th>
                        <th>Owner</th>
                        <th>Photos Count</th>
                        <th>Created At</th>
                        <th>Deleted At</th>
                        <th>Latest Photo</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($albums as $album)
                        <tr>
                            <td>{{ $album->title }}</td>
                            <td>{{ $album->user->name }}</td>
                            <td>{{ $album->photos_count }}</td>
                            <td>{{ $album->created_at->format('Y-m-d') }}</td>
                            <td>{{ $album->deleted_at ? $album->deleted_at->format('Y-m-d H:i') : 'Active' }}</td>
                            <td>
                                @if($album->photos->isNotEmpty())
                                    <img src="{{ asset('storage/'.$album->photos->first()->path) }}" class="w-16 h-16 object-cover">
                                @else
                                    No photos
                                @endif
                            </td>
                            <td>
                                @if($album->photos->isNotEmpty())
                                    {{ $album->photos->first()->created_at->format('Y-m-d H:i') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $albums->links() }}
        </div>
    </div>
</div>
@endsection