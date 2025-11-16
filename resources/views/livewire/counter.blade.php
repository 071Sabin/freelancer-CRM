<div class="bg-slate-800 text-white w-1/4 p-2 rounded mt-10">
    <h1>
        <p class="text-xl font-semibold">{{ $count }}</p>
    </h1>

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- <input type="number" wire:model.live="count" class="bg-slate-700 rounded p-2"> --}}
    <button wire:click="increment" class="bg-blue-500 text-xl font-bold px-3 py-2 mt-5 rounded-lg">+</button>
    {{-- <input type="text" wire:model.live="message" class="border-white rounded border p-2"> --}}
    {{-- message: {{ $message }} --}}
    <br>

    <div>
        <label>
            <input type="radio" wire:model="SendNews" value="yes">
            YES
        </label>
        <label>
            <input type="radio" wire:model="SendNews" value="no">
            NO
        </label>
        Answer: {{ $SendNews }}
    </div>
</div>
