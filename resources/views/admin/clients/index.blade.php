<x-layouts.app>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">
        <div class="flex justify-between w-full">
            <h1 class="text-2xl">Listado Clientes</h1>
            <button onclick="openModal(null)" type="button"
                class="w-55 py-2.5 px-5 mb-6 text-sm font-medium text-white focus:outline-none bg-[var(--color-btn)] rounded-lg border border-[var(--color-btn)] hover:bg-[var(--color-btn-hover)] ">
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

        <div class="relative overflow-x-auto pt-8">
            <!-- Tabla de Clientes -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                {{ $client['name'] . ' ' . $client['lastname'] }}
                            </th>
                            <td class="px-6 py-4">{{ $client['phone'] }}</td>
                            <td class="px-6 py-4">{{ $client['email'] }}</td>
                            <td class="px-6 py-4">{{ $client['created_at'] }}</td>

                            <td>
                                <flux:dropdown>
                                    <flux:button icon:trailing="ellipsis-vertical" class="icon-more-actions">
                                    </flux:button>

                                    <flux:menu>
                                        <flux:menu.item icon="eye">Detalles</flux:menu.item>
                                        <!-- El botón de editar que pasa la información al modal -->
                                        <flux:menu.item icon="pencil-square"
                                            onclick="openModal({{ json_encode($client) }})">Editar</flux:menu.item>



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
            {{ $clients->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>



    <!-- Modal Nuevo Cliente -->
    <div class="modal fixed inset-0 z-50 bg-[var(--color-bg-modal)] flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-4 w-full max-w-3xl max-h-full">
            <h2 class="text-2xl font-semibold">Nuevo Cliente</h2>
            <form id="createClientForm" class="max-w-2xl mx-auto mt-6" method="POST"
                action="{{ route('admin.clientes.store') }}">
                @csrf
                <input type="hidden" id="id_client" name="id_client">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
                        <input type="text" id="name" name="name"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Juan José" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="lastname"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                        <input type="text" id="lastname" name="lastname"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Pérez Martínez" required />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="phone"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                        <input type="tel" id="phone" name="phone"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="612 34 56 78" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                        <input type="email" id="email" name="email"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="juanperes@gmail.com" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="city"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
                        <input type="text" id="city" name="city"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Madrid" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="province"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
                        <input type="text" id="province" name="province"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Barcelona" required />
                    </div>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección
                        (opcional)</label>
                    <input type="text" id="address" name="address"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        placeholder="Calle Gran Vía, 28, 3ºA" />
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


            function changePerPage(value) {
                // Recargar la página con el valor de 'perPage'
                window.location.href = '{{ route('admin.clientes.index') }}?perPage=' + value;
            }
        </script>
    @endpush
</x-layouts.app>
