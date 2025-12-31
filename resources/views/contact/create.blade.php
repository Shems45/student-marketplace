<x-layouts.public title="Contact">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Contact</h1>

        <x-flash-message />

        <form class="bg-white shadow rounded p-6 space-y-4" method="POST" action="{{ route('contact.store') }}">
            @csrf

            <div>
                <label class="block font-medium mb-1">Name <span class="text-red-500">*</span></label>
                <input class="w-full border-gray-300 rounded shadow-sm" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Email <span class="text-red-500">*</span></label>
                <input class="w-full border-gray-300 rounded shadow-sm" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Subject <span class="text-red-500">*</span></label>
                <input class="w-full border-gray-300 rounded shadow-sm" name="subject" value="{{ old('subject') }}" required minlength="3">
                @error('subject')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Message <span class="text-red-500">*</span></label>
                <textarea class="w-full border-gray-300 rounded shadow-sm" name="message" rows="6" required minlength="10">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Send Message</button>
                <a href="{{ route('home') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.public>
