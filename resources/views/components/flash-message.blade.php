@if (session('status'))
    <div class="mb-4 rounded bg-green-100 border border-green-200 p-3">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded bg-red-100 border border-red-200 p-3">
        <div class="font-semibold">Please fix the following:</div>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
