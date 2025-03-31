<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    

    @stack('js')

    @if (session('swal'))
        <script>
            Swal.fire(@json(session()->pull('swal')))
        </script>
    @endif
</x-layouts.app.sidebar>
