<x-layouts.app>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">


        @include('admin.vehicles.table_vehicles', ['vehicles' => $vehicles, 'clients' => $clients, 'perPage' => $perPage])

    </div>


</x-layouts.app>
