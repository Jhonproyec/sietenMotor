{{-- <div class="flex justify-between w-full">
    <h1 class="text-2xl">Listado Vehículos</h1>
    <button onclick="openModal(null)" type="button"
        class="w-55 py-2.5 px-5 mb-6 text-sm font-medium text-white focus:outline-none bg-[var(--color-btn)] rounded-lg border border-[var(--color-btn)] hover:bg-[var(--color-btn-hover)] ">
        <i class="fa-solid fa-plus"></i> Nuevo vehículo
    </button>
</div> --}}
<div class="flex justify-between items-start w-full">
    <h1 class="text-2xl">Listado Vehículos</h1>
    <button onclick="openModal(null)" type="button" class="btn btn-primary w-45" data-bs-toggle="modal"
        data-bs-target="#addvehicle">
        <i class="fa-solid fa-plus"></i> Nuevo Vehículo
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
            <input type="hidden" name="perPage" value="{{ $perPage }}">
        </form>
    </div>
</div>

<div class="table-responsive">
    <!-- Tabla de Clientes -->
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="px-6 py-3">Vehículo</th>
                <th scope="col" class="px-6 py-3">Placa</th>
                <th scope="col" class="px-6 py-3">Año</th>
                <th scope="col" class="px-6 py-3">Propietario</th>
                <th scope="col" class="px-6 py-3">Fecha que ingresó</th>
                <th scope="col" class="px-6 py-3">Tipo Combustible</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="fs-6">
            @foreach ($vehicles as $vehicle)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                        <a href="{{ route('admin.vehiculos.detalles_vehiculo', ['id' => $vehicle->id]) }}">
                            {{ $vehicle['brand_model'] }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $vehicle['registration'] }}</td>
                    <td class="px-6 py-4">{{ $vehicle['year'] }}</td>
                    <td class="px-6 py-4">{{ $vehicle['client_name'] }}</td>
                    <td class="px-6 py-4">{{ $vehicle['formatted_date'] }}</td>
                    <td class="px-6 py-4">
                        {{ $vehicle['fuel_type'] == null ? 'No indicado' : $vehicle['fuel_type'] }}
                    </td>
                    <td>
                        <flux:dropdown>
                            <flux:button style="border:none !important;" icon:trailing="ellipsis-vertical"
                                class="icon-more-actions">
                            </flux:button>

                            <flux:menu>
                                <flux:menu.item icon="eye"
                                    href="{{ route('admin.vehiculos.detalles_vehiculo', ['id' => $vehicle->id]) }}">
                                    Detalles
                                </flux:menu.item><!-- El botón de editar que pasa la información al modal -->
                                <flux:menu.item data-bs-toggle="modal" data-bs-target="#addvehicle" icon="pencil-square"
                                    onclick="openModal({{ json_encode($vehicle) }})">
                                    Editar</flux:menu.item>

                                <form class="delete-form" action="{{ route('admin.vehiculos.destroy', $vehicle->id) }}"
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


<div class="modal fade" id="addvehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="createVehicle" class="max-w-2xl mx-auto mt-6" method="POST"
            action="{{ route('admin.vehiculos.store') }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_vehicle" name="id_vehicle">
                <div id="createVehicle" class="max-w-2xl mx-auto mt-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand"class="form-label">Marca</label>
                                <input type="text" id="brand" name="brand"
                                    class="form-control custom-border" placeholder="Honda" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="model" class="form-label">Modelo</label>
                                <input type="text" id="model" name="model"
                                    class="form-control custom-border" placeholder="Civic" required />
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year" class="form-label">Año</label>
                                <input type="number" id="year" name="year"
                                    class="form-control custom-border" placeholder="2020" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registration" class="form-label">Matrícula</label>
                                <input type="text" id="registration" name="registration"
                                    class="form-control custom-border" placeholder="1234 BBCD" required />
                            </div>
                        </div>
                    </div>


                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vin" class="form-label">VIN
                                    (opcional)</label>
                                <input type="text" id="vin" name="vin"
                                    class="form-control custom-border" placeholder="1HGBH41JXMN109186" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_chasis" class="form-label">No.
                                    Chasis
                                    (opcional)</label>
                                <input type="text" id="no_chasis" name="no_chasis"
                                    class="form-control custom-border" placeholder="jxq367638yab" />
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_motor" class="form-label">No.
                                    motor (opcional)</label>
                                <input type="text" id="no_motor" name="no_motor"
                                    class="form-control custom-border" placeholder="oak31451fsy" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fuel_type" class="form-label">Tipo
                                    Combustible
                                    (opcional)</label>
                                <input type="text" id="fuel_type" name="fuel_type"
                                    class="form-control custom-border" placeholder="Diesel" />
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_entered" class="form-label">Fecha de
                                    ingreso</label>
                                <input type="date" id="date_entered" name="date_entered"
                                    class="form-control custom-border" placeholder="Diesel" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_client" class="form-label">Seleccionar
                                    Cliente</label>
                                <select name="id_client" required id="id_client" class="form-control custom-border ">
                                    <option selected>Seleccionar cliente</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client['id'] }}">{{ $client['name'] }} -
                                            {{ $client['lastname'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="flex justify-end">
                    <button type="button"
                        class="closeModalButton px-4 py-2 mr-3 bg-red-500 text-white rounded">Cerrar</button>
                    <button style="margin-left: 10px;" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>



</div>
@push('js')
    <script>
        function openModal(client) {
            console.log(client);
            const form = document.querySelector('#createVehicle');
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
                document.querySelector('#id_client').value = client.id_client;
                document.querySelector('#date_entered').value = client.date_entered || '';
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
