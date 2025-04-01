<x-layouts.app>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">

        <div class="flex border-b">
            <button id="btn-tab1" class="tab-link p-4 w-1/2 text-center border-b-2 hover:border-[var(--color-btn)] focus:outline-none" onclick="openTab(event, 'tab1')">Detalles de Vehículo</button>
            <button id="btn-tab2" class="tab-link p-4 w-1/2 text-center border-b-2 hover:border-[var(--color-btn)] focus:outline-none" onclick="openTab(event, 'tab2')">Historial Mantenimiento</button>
            {{-- <button id="btn-tab3" class="tab-link p-4 w-1/3 text-center border-b-2 hover:border-[var(--color-btn)] focus:outline-none" onclick="openTab(event, 'tab3')">Notas</button> --}}
        </div>

        <div class="py-6">
            <h2 class="text-xl pb-1">{{$vehicle->owner_full_name}}</h2>
            <h3>{{$vehicle->info_car}} - <b>Matricula - {{$vehicle->registration}}</b></h3>
        </div>


        <!-- Contenido de pestañas -->
        <div id="tab1" class="tab-content">

            <div class="flex justify-between mt-6 space-x-0 md:space-x-4 w-full ">
                <div class="border border-gray-300 rounded-lg p-4 w-full md:w-1/2 flex items-center justify-center h-32 text-4xl h-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-40">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>

                </div>
                <div class="border border-gray-300 rounded-lg p-4 w-full md:w-1/2">
                    <h2 class="text-lg font-semibold mb-4">Mas información</h2>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                        <p><span class="font-medium">Marca Vehículo:</span> <span class="text-gray-700">{{$vehicle['brand']}}</span></p>
                        <p><span class="font-medium">Modelo:</span> <span class="text-gray-700">{{$vehicle['model']}}</span></p>

                        <p><span class="font-medium">Año:</span> <span class="text-gray-700">{{$vehicle['year']}}</span></p>
                        <p><span class="font-medium">No. Chasis</span> <span class="text-gray-700">{{$vehicle['no_chasis'] == null ? 'No indicado' : $vehicle['no_chasis']}}</span></p>

                        <p><span class="font-medium">Matrícula:</span> <span class="text-gray-700">{{$vehicle['registration']}}</span></p>
                        <p><span class="font-medium">No Motor:</span> <span class="text-gray-700">{{$vehicle['no_motor'] == null ? 'No indicado' : $vehicle['no_motor']}}</span></p>

                        <p><span class="font-medium">Tipo Gasolina:</span> <span class="text-gray-700">{{$vehicle['fuel_type'] == null ? 'No indicado' : $vehicle['fuel_type']}}</span></p>
                        <p><span class="font-medium">Fecha que ingresó:</span> <span class="text-gray-700">{{$vehicle['formatted_date'] }}</span></p>

                    </div>
                </div>
            </div>
        </div>
        <div id="tab2" class="tab-content hidden">
            @include('admin.maintenance.index', ['maintenances' => $maintenances, 'vehicle_id' => $vehicle->id])
        </div>
        <div id="tab3" class="tab-content p-6 hidden">Contenido de la Pestaña 3</div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener la pestaña activa desde PHP
        const activeTab = "{{ $tab ?? 'tab1' }}"; // Si no se pasa 'tab', usa 'tab1' por defecto
        
        // Mostrar la pestaña activa
        showTab(activeTab);
    });

    function openTab(event, tabId) {
        // Prevenir el comportamiento por defecto si es un enlace
        event.preventDefault();
        showTab(tabId);
    }
    
    function showTab(tabId) {
        // Ocultar todas las pestañas
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Mostrar la pestaña seleccionada
        const activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.classList.remove('hidden');
        }

        // Quitar la clase activa de todos los botones
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.classList.remove('border[var(--color-btn)]', 'text-[var(--color-btn)]');
            tab.classList.add('border-transparent');
        });

        // Resaltar el botón seleccionado
        const activeButton = document.getElementById(`btn-${tabId}`);
        if (activeButton) {
            activeButton.classList.add('border-[var(--color-btn)]', 'text-[var(--color-btn)]');
            activeButton.classList.remove('border-transparent');
        }
    }
    </script>



</x-layouts.app>