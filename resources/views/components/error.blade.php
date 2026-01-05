@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> <br>
        @endforeach
    </div>
@endif
