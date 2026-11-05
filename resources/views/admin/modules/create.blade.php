@extends('layouts.admin')

@section('title', 'Add New Module')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.modules.index') }}"
           class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Add New Module</h2>
            <p class="text-slate-500 text-sm mt-0.5">Create a new learning module for the platform</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                Module Title <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="e.g. Introduction to Phishing"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-400 @enderror">
            @error('title')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">
                Category <span class="text-red-500">*</span>
            </label>
            <select id="category" name="category" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-400 @enderror">
                <option value="">— Select a category —</option>
                <option value="phishing" {{ old('category') === 'phishing' ? 'selected' : '' }}>Phishing</option>
                <option value="malware" {{ old('category') === 'malware' ? 'selected' : '' }}>Malware</option>
                <option value="social-engineering" {{ old('category') === 'social-engineering' ? 'selected' : '' }}>Social Engineering</option>
                <option value="password-security" {{ old('category') === 'password-security' ? 'selected' : '' }}>Password Security</option>
                <option value="network-security" {{ old('category') === 'network-security' ? 'selected' : '' }}>Network Security</option>
                <option value="data-privacy" {{ old('category') === 'data-privacy' ? 'selected' : '' }}>Data Privacy</option>
                <option value="safe-browsing" {{ old('category') === 'safe-browsing' ? 'selected' : '' }}>Safe Browsing</option>
                <option value="incident-response" {{ old('category') === 'incident-response' ? 'selected' : '' }}>Incident Response</option>
            </select>
            @error('category')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                Description
            </label>
            <textarea id="description" name="description" rows="3"
                      placeholder="Short description shown in module listings..."
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content --}}
        <div>
            <label for="content" class="block text-sm font-medium text-slate-700 mb-1.5">
                Module Content <span class="text-red-500">*</span>
            </label>
            <textarea id="content" name="content" rows="12" required
                      placeholder="Write the full module content here. HTML is supported."
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y @error('content') border-red-400 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div>
            <label for="image" class="block text-sm font-medium text-slate-700 mb-1.5">
                Cover Image
            </label>
            <div class="flex items-center gap-4">
                <label for="image"
                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors">
                    <div class="flex flex-col items-center justify-center gap-1 text-slate-400" id="image-label">
                        <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                        <p class="text-sm">Click to upload image</p>
                        <p class="text-xs">PNG, JPG, GIF up to 2MB</p>
                    </div>
                    <input id="image" type="file" name="image" accept="image/*" class="hidden"
                           onchange="document.getElementById('image-label').querySelector('p').textContent = this.files[0]?.name || 'Click to upload image'">
                </label>
            </div>
            @error('image')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Is Published --}}
        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg">
            <input type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published') ? 'checked' : '' }}
                   class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
            <div>
                <label for="is_published" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Publish this module
                </label>
                <p class="text-xs text-slate-400 mt-0.5">Unchecked = saved as draft (not visible to users)</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-4 border-t border-slate-200">
            <a href="{{ route('admin.modules.index') }}"
               class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                Save Module
            </button>
        </div>

    </form>

</div>
@endsection
