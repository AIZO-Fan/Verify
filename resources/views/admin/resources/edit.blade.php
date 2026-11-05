@extends('layouts.admin')

@section('title', 'Edit Resource')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.resources.index') }}"
           class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Edit Resource</h2>
            <p class="text-slate-500 text-sm mt-0.5">Update "{{ $resource->title }}"</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.resources.update', $resource) }}" method="POST"
          class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                Resource Title <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title', $resource->title) }}" required
                   placeholder="e.g. NIST Cybersecurity Framework"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-400 @enderror">
            @error('title')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                Description
            </label>
            <textarea id="description" name="description" rows="3"
                      placeholder="Brief description of this resource..."
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y @error('description') border-red-400 @enderror">{{ old('description', $resource->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Source Name --}}
        <div>
            <label for="source_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                Source Name
            </label>
            <input type="text" id="source_name" name="source_name" value="{{ old('source_name', $resource->source_name) }}"
                   placeholder="e.g. NIST, CISA, OWASP"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('source_name') border-red-400 @enderror">
            @error('source_name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- URL --}}
        <div>
            <label for="url" class="block text-sm font-medium text-slate-700 mb-1.5">
                Resource URL <span class="text-red-500">*</span>
            </label>
            <input type="url" id="url" name="url" value="{{ old('url', $resource->url) }}" required
                   placeholder="https://example.com/resource"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url') border-red-400 @enderror">
            @error('url')
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
                <option value="phishing" {{ old('category', $resource->category) === 'phishing' ? 'selected' : '' }}>Phishing</option>
                <option value="malware" {{ old('category', $resource->category) === 'malware' ? 'selected' : '' }}>Malware</option>
                <option value="social-engineering" {{ old('category', $resource->category) === 'social-engineering' ? 'selected' : '' }}>Social Engineering</option>
                <option value="password-security" {{ old('category', $resource->category) === 'password-security' ? 'selected' : '' }}>Password Security</option>
                <option value="network-security" {{ old('category', $resource->category) === 'network-security' ? 'selected' : '' }}>Network Security</option>
                <option value="data-privacy" {{ old('category', $resource->category) === 'data-privacy' ? 'selected' : '' }}>Data Privacy</option>
                <option value="safe-browsing" {{ old('category', $resource->category) === 'safe-browsing' ? 'selected' : '' }}>Safe Browsing</option>
                <option value="incident-response" {{ old('category', $resource->category) === 'incident-response' ? 'selected' : '' }}>Incident Response</option>
            </select>
            @error('category')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-4 border-t border-slate-200">
            <a href="{{ route('admin.resources.index') }}"
               class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                Update Resource
            </button>
        </div>

    </form>

</div>
@endsection
