@extends('layouts.app')

@section('content')
<div class="container py-12">
    <!-- Back to All Albums -->
    <a href="{{ route('albums.index') }}" class="text-blue-500 mb-4 inline-block">← Back to Albums</a>

    <h1 class="text-3xl font-semibold mb-6 text-black-800">{{ $album->title }}</h1>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Upload Form -->
    <form method="POST" action="{{ route('photos.store', $album) }}" enctype="multipart/form-data" class="mb-8" id="uploadForm">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-800 text-sm font-bold mb-2">Upload Photos</label>
            <div class="relative border-dashed border-2 border-gray-300 rounded-lg p-6">
                <input type="file" name="photos[]" multiple 
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                       accept="image/*"
                       id="fileInput"
                       onchange="validateFiles(this)">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="mt-1 text-sm text-gray-600" id="file-list">
                        Click to upload or drag and drop<br>
                        <span class="text-xs text-gray-500">PNG, JPG up to 10MB</span>
                    </p>
                    <p id="error-message" class="text-red-500 text-sm mt-2 hidden"></p>
                </div>
            </div>
            
            <!-- Dynamic Description Inputs -->
            <div id="descriptionFields" class="mt-4 space-y-3 hidden">
                <!-- JavaScript will populate this -->
            </div>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            Upload Photos
        </button>
    </form>

    <!-- Photos Grid -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Photos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($album->photos as $photo)
                <div class="group relative cursor-zoom-in">
                    <img src="{{ asset('storage/' . $photo->path) }}" 
                         alt="{{ $photo->description }}"
                         class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow"
                         onclick="openModal('{{ asset('storage/' . $photo->path) }}', '{{ $photo->description }}', {{ $photo->id }})">
                    @if($photo->description)
                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-black/60">
                        <p class="text-white text-sm truncate">{{ $photo->description }}</p>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm" 
    onclick="if (!event.target.closest('.modal-content')) closeModal()">
    <div class="modal-content relative max-w-4xl w-full p-4 bg-transparent">

        <!-- Modal Image -->
        <img id="modalImage" class="w-full h-auto max-h-[70vh] object-contain rounded-lg" src="">

        <!-- Update Form -->
        <form id="descriptionForm" method="POST" action="" class="mt-4 p-4 bg-white rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <input type="hidden" id="photoId" name="photo_id">

            <div class="mb-4">
                <label class="bg-white block text-gray-700 text-sm font-bold mb-2">
                    Photo Description
                </label>
                <textarea name="description" id="modalDescription"
    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-transparent"
    rows="3"></textarea>

            </div>

            <div class="flex justify-between items-center">
                <div class="space-x-3">
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
                <button type="button" 
    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors"
    onclick="document.getElementById('deleteForm').submit()">
    Delete Photo
</button>
            </div>
        </form>
        <form id="deleteForm" method="POST" action="" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
    // Client-Side Validation for File Uploads
    function validateFiles(input) {
        const maxFiles = 100; // Maximum number of files allowed
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']; // Allowed MIME types
        const errorMessage = document.getElementById('error-message');
        const fileList = document.getElementById('file-list');
        const descriptionFields = document.getElementById('descriptionFields');

        // Clear previous errors
        errorMessage.classList.add('hidden');
        errorMessage.textContent = '';

        // Check number of files
        if (input.files.length > maxFiles) {
            errorMessage.textContent = `Maximum ${maxFiles} files allowed per upload.`;
            errorMessage.classList.remove('hidden');
            input.value = ''; // Clear selected files
            return;
        }

        // Check file sizes and types
        for (let file of input.files) {
            if (file.size > maxSize) {
                errorMessage.textContent = `File "${file.name}" exceeds the maximum size of 10MB.`;
                errorMessage.classList.remove('hidden');
                input.value = ''; // Clear selected files
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                errorMessage.textContent = `File "${file.name}" is not a valid image type (JPEG, PNG, JPG, GIF).`;
                errorMessage.classList.remove('hidden');
                input.value = ''; // Clear selected files
                return;
            }
        }

        // Update file list and description fields
        if (input.files.length > 0) {
            fileList.innerHTML = Array.from(input.files).map(file => `
                <span class="block text-sm">${file.name}</span>
            `).join('');

            descriptionFields.innerHTML = Array.from(input.files).map((file, index) => `
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium truncate">${file.name}</span>
                    </div>
                    <input type="text" 
                           name="descriptions[]" 
                           placeholder="Add description (optional)"
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            `).join('');

            descriptionFields.classList.remove('hidden');
        } else {
            fileList.innerHTML = `Click to upload or drag and drop<br>
                                <span class="text-xs text-gray-500">PNG, JPG up to 10MB</span>`;
            descriptionFields.classList.add('hidden');
        }
    }

    // Open Modal Function
    function openModal(imageSrc, description, photoId) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const updateForm = document.getElementById('descriptionForm');
        const deleteForm = document.getElementById('deleteForm');
        
        // Set image source and ensure it's loaded
        modalImage.src = imageSrc;
        modalImage.onload = () => {  
            modal.classList.remove('hidden');
            modal.classList.add('flex'); 
            document.body.classList.add('overflow-hidden');
        };
        document.getElementById('modalDescription').value = description || '';
        
        // Set form actions with photo ID
        updateForm.action = `/photos/${photoId}/description`;
        deleteForm.action = `/photos/${photoId}`;
        
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Close Modal Function
    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal with ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>
</div>
@endsection