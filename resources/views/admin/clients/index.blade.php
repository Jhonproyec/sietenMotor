<x-layouts.app>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">
        <div class="flex justify-between items-start w-full">
            <h1 class="text-2xl">Listado Clientes</h1>
            <button onclick="openModal(null)" type="button" class="btn btn-primary w-45" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="fa-solid fa-plus"></i> Nuevo cliente
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
                <form method="GET" action="{{ route('admin.clientes.search') }}" class="flex">
                    <input type="text" name="search" placeholder="Buscar..." class="border rounded-l p-2 w-65">
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <!-- Tabla de Clientes -->
            <table class="table ">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nombre Cliente</th>
                        <th scope="col" class="px-6 py-3">Teléfono</th>
                        <th scope="col" class="px-6 py-3">Correo</th>
                        <th scope="col" class="px-6 py-3">Fecha Alta Cliente</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <a href="{{ url('/admin/clientes/vehiculos/' . $client->id) }}">
                                    {{ $client['name'] . ' ' . $client['lastname'] }}
                                </a>
                            </th>
                            <td class="px-6 py-4">{{ $client['phone'] }}</td>
                            <td class="px-6 py-4">{{ $client['email'] }}</td>
                            <td class="px-6 py-4">{{ $client['created_at'] }}</td>

                            <td>
                                <flux:dropdown>
                                    <flux:button style="border:none !important;" icon:trailing="ellipsis-vertical"
                                        class="icon-more-actions">
                                    </flux:button>

                                    <flux:menu>
                                        <a href="{{ url('/admin/clientes/vehiculos/' . $client->id) }}">
                                            <flux:menu.item icon="eye">Detalles</flux:menu.item>
                                        </a>
                                        <!-- El botón de editar que pasa la información al modal -->
                                        <flux:menu.item data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            icon="pencil-square" onclick="openModal({{ json_encode($client) }})">Editar
                                        </flux:menu.item>



                                        <form class="delete-form"
                                            action="{{ route('admin.clientes.destroy', $client->id) }}" method="POST">
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
            {{ $clients->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="POST" action="{{ route('admin.clientes.store') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="createClientForm" class="max-w-2xl mx-auto mt-6">
                        <input type="hidden" id="id_client" name="id_client">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombres</label>
                                    <input type="text" class="form-control custom-border" id="name"
                                        name="name" placeholder="Juan José" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control custom-border" id="lastname"
                                        name="lastname" placeholder="Pérez Martínez" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control custom-border" id="phone"
                                        name="phone" placeholder="612 34 56 78" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Corre</label>
                                    <input type="email" class="form-control custom-border" id="email"
                                        name="email" placeholder="juanperez@gmail.com" required>
                                </div>
                            </div>
                        </div>


                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control custom-border" id="city"
                                        name="city" placeholder="Madrid" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provincia</label>
                                    <input type="text" class="form-control custom-border" id="province"
                                        name="province" placeholder="Barcelona" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección (opcional)</label>
                                <input type="text" class="form-control custom-border" id="address"
                                    name="address" placeholder="Calle Gran Vía, 28, 3ºA">
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





    @push('js')
        <script>
            function openModal(client) {

                document.querySelector('.modal').classList.remove('hidden');
                const form = document.querySelector('form');
                if (client === null) {
                    form.reset();
                } else {
                    // Llena los campos del formulario con los datos del cliente
                    document.querySelector('#id_client').value = client.id;
                    document.querySelector('#name').value = client.name;
                    document.querySelector('#lastname').value = client.lastname;
                    document.querySelector('#phone').value = client.phone;
                    document.querySelector('#email').value = client.email;
                    document.querySelector('#city').value = client.city;
                    document.querySelector('#province').value = client.province;
                    document.querySelector('#address').value = client.address || '';
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
        </script>
    @endpush
</x-layouts.app>
