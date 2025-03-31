<x-layouts.app>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">
        <div class="flex justify-between w-full">
            <h1 class="text-2xl">Listado Vehículos</h1>
            <button onclick="openModal(null)" type="button"
                class="w-55 py-2.5 px-5 mb-6 text-sm font-medium text-white focus:outline-none bg-[var(--color-btn)] rounded-lg border border-[var(--color-btn)] hover:bg-[var(--color-btn-hover)] ">
                <i class="fa-solid fa-plus"></i> Nuevo vehículo
            </button>
        </div>


        <div class="flex justify-between items-center mb-4">
            <div>
                <label for="perPage" class="mr-2">Filas:</label>
                <select id="perPage" class="border rounded p-2" onchange="changePerPage(this.value)">
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="75" {{ $perPage == 75 ? 'selected' : '' }}>75</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                <form method="GET" action="{{ route('admin.vehiculos.search') }}" class="flex">
                    <input type="text" name="search" placeholder="Buscar..." class="border rounded-l p-2 w-65">
                </form>
            </div>
        </div>

        <div class="relative overflow-x-auto pt-8">
            <!-- Tabla de Clientes -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Vehículo</th>
                        <th scope="col" class="px-6 py-3">Placa</th>
                        <th scope="col" class="px-6 py-3">Año</th>
                        <th scope="col" class="px-6 py-3">Propietario</th>
                        <th scope="col" class="px-6 py-3">Tipo Combustible</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td class="px-6 py-4">{{ $vehicle['brand_model'] }}</td>
                            <td class="px-6 py-4">{{ $vehicle['registration'] }}</td>
                            <td class="px-6 py-4">{{ $vehicle['year'] }}</td>
                            <td class="px-6 py-4">{{ $vehicle['client_name'] }}</td>
                            <td class="px-6 py-4">
                                {{ $vehicle['fuel_type'] == null ? 'No indicado' : $vehicle['fuel_type'] }}
                            </td>
                            <td>
                                <flux:dropdown>
                                    <flux:button icon:trailing="ellipsis-vertical" class="icon-more-actions">
                                    </flux:button>

                                    <flux:menu>
                                        <flux:menu.item icon="eye"
                                            href="{{ route('admin.detalles-vehiculo.index', ['id' => $vehicle->id]) }}">
                                            Detalles
                                        </flux:menu.item><!-- El botón de editar que pasa la información al modal -->
                                        <flux:menu.item icon="pencil-square"
                                            onclick="openModal({{ json_encode($vehicle) }})">Editar</flux:menu.item>

                                        <form class="delete-form"
                                            action="{{ route('admin.vehiculos.destroy', $vehicle->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <flux:menu.item onclick="submitDeleteForm(event, this)" icon="trash"
                                                variant="danger">
                                                Eliminar
                                            </flux:menu.item>
                                        </form>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $vehicles->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>



    <!-- Modal Nuevo Cliente -->
    <div class="modal fixed inset-0 z-50 bg-[var(--color-bg-modal)] flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-4 w-full max-w-3xl max-h-full">
            <h2 class="text-2xl font-semibold">Nuevo Cliente</h2>
            <form id="createClientForm" class="max-w-2xl mx-auto mt-6" method="POST"
                action="{{ route('admin.vehiculos.store') }}">
                @csrf
                <input type="hidden" id="id_vehicle" name="id_vehicle">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="brand"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</label>
                        <input type="text" id="brand" name="brand"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Honda" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="model"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modelo</label>
                        <input type="text" id="model" name="model"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Civic" required />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="year"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Año</label>
                        <input type="number" id="year" name="year"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="2020" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="registration"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Matrícula</label>
                        <input type="text" id="registration" name="registration"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="1234 BBCD" required />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="vin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VIN
                            (opcional)</label>
                        <input type="text" id="vin" name="vin"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="1HGBH41JXMN109186" />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="no_chasis"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Chasis
                            (opcional)</label>
                        <input type="text" id="no_chasis" name="no_chasis"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="jxq367638yab" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="no_motor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                            motor (opcional)</label>
                        <input type="text" id="no_motor" name="no_motor"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="oak31451fsy" />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="fuel_type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo Combustible
                            (opcional)</label>
                        <input type="text" id="fuel_type" name="fuel_type"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Diesel" />
                    </div>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="id_client" class="block mb-2 text-sm font-medium text-gray-900">Seleccionar
                        Cliente</label>
                    <select name="id_client" required id="id_client"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option selected>Seleccionar un cliente</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client['id'] }}">{{ $client['name'] }} - {{ $client['lastname'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button"
                        class="closeModalButton px-4 py-2 mr-3 bg-red-500 text-white rounded">Cerrar</button>
                    <button type="submit" class="px-4 py-2 bg-[var(--color-btn)] text-white rounded">Guardar</button>
                </div>
            </form>
        </div>

    </div>
    @push('js')
        <script>
            function openModal(client) {
                console.log(client);
                document.querySelector('.modal').classList.remove('hidden');
                const form = document.querySelector('form');
                if (client === null) {
                    form.reset();
                } else {
                    document.querySelector('#id_vehicle').value = client.id || '';
                    document.querySelector('#brand').value = client.brand || '';
                    document.querySelector('#model').value = client.model || '';
                    document.querySelector('#year').value = client.year || '';
                    document.querySelector('#registration').value = client.registration || '';
                    document.querySelector('#vin').value = client.vin || '';
                    document.querySelector('#no_chasis').value = client.no_chasis || '';
                    document.querySelector('#no_motor').value = client.no_motor || '';
                    document.querySelector('#fuel_type').value = client.fuel_type || '';
                    document.querySelector('#id_client').value = client.id_client || '';
                }
            }




            function submitDeleteForm(event, element) {
                event.preventDefault(); // Evita la recarga de la página

                let form = element.closest('form'); // Encuentra el formulario más cercano

                Swal.fire({
                    title: "¿Está seguro?",
                    text: "No podrás revertir esto",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }


            function changePerPage(value) {
                // Recargar la página con el valor de 'perPage'
                window.location.href = '{{ route('admin.vehiculos.index') }}?perPage=' + value;
            }
        </script>
    @endpush

</x-layouts.app>
