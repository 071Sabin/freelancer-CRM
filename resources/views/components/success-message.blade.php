<div>
    <p id="toastSuccess" class="fixed top-10 right-5 z-999 bg-green-600 text-white px-4 py-3">
        {{ $slot }}
    </p>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        const toast = document.getElementById('toastSuccess');
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000); // Hide after 3 seconds
    });
</script>
