<div class="flex justify-end w-full">
    <!-- <h1 class="text-xl">Historial Mantenimiento</h1> -->
    <button onclick="openModal(null)" type="button"
        class="w-55 py-2.5 px-5 mb-6 text-sm font-medium text-white focus:outline-none bg-[var(--color-btn)] rounded-lg border border-[var(--color-btn)] hover:bg-[var(--color-btn-hover)] ">
        <i class="fa-solid fa-plus"></i> Agregar mantenimiento
    </button>
</div>


<div class="relative overflow-x-auto pt-6">
    <!-- Tabla de Clientes -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Id. Mantenimiento</th>
                <th scope="col" class="px-6 py-3">Mecánico Encargado</th>
                <th scope="col" class="px-6 py-3">Fecha Mantenimiento</th>
                <th scope="col" class="px-6 py-3">Fecha Estimada Próximo mantenimiento</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3">Factura</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $maintenance)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                <td class="px-6 py-4">{{ $maintenance->id}}</td>
                <td class="px-6 py-4">{{ $maintenance->mechanic_charge}}</td>
                <td class="px-6 py-4">{{ $maintenance->date_maintenance}}</td>
                <td class="px-6 py-4">{{ $maintenance->date_next_maintenance == null ? 'No especificado' : $maintenance->date_next_maintenance}}</td>
                <td class="px-6 py-4">{{ $maintenance->status}}</td>
                <td>
                    @if (!empty($maintenance->factura))
                    <a href="{{ asset($maintenance->factura) }}" download class="flex items-center justify-center">
                        <flux:menu.item style="display: flex; justify-content: center; align-items: center; cursor: pointer;" icon="document-arrow-down"></flux:menu.item>
                    </a>
                    @else
                    <span>No cargada</span>
                    @endif
                </td>
                <td>
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-vertical" class="icon-more-actions">
                        </flux:button>

                        <flux:menu>
                            <flux:menu.item icon="pencil-square"
                                onclick="openModal({{ json_encode($maintenance)}})">Editar</flux:menu.item>
                            <form class="delete-form"
                                action="{{ route('admin.mantenimiento.destroy', $maintenance->id) }}" method="POST">
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


<!-- Modal Nuevo Cliente -->
<div class="modal fixed inset-0 z-50 bg-[var(--color-bg-modal)] flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-4 w-full max-w-3xl max-h-full">
        <h2 class="text-2xl font-semibold">Nuevo mantenimiento</h2>
        <form class="max-w-2xl mx-auto mt-6" method="POST" action="{{ route('admin.mantenimiento.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id_maintenance" name="id_maintenance">
            <input type="hidden" id="id_vehicle" name="id_vehicle" value="{{$vehicle_id}}">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <label for="mechanic_charge"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre mecánico encargado</label>
                    <input type="text" id="mechanic_charge" name="mechanic_charge"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        placeholder="Juan Perez" required />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="date_maintenance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Mantenimiento</label>
                    <input type="date" id="date_maintenance" name="date_maintenance"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        required />
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <label for="date_next_maintenance"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Próximo mantenimiento (opcional)</label>
                    <input type="date" id="date_next_maintenance" name="date_next_maintenance"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        placeholder="Juan Perez" required />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="sstatus" class="block mb-2 text-sm font-medium text-gray-900">Seleccionar
                        Cliente</label>
                    <select name="status" required id="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option selected>Estado</option>
                        <option value="Ingresado">Ingresado</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Finalizado">Finalizado</option>

                    </select>
                </div>
            </div>

            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="factura">
                Cargar Factura (PDF)
            </label>
            <input class="block w-full h-10 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2.5"
                id="factura" type="file" name="factura" accept="application/pdf">

            <div class="flex justify-end mt-4">
                <button type="button"
                    class="closeModalButton px-4 py-2 mr-3 bg-red-500 text-white rounded">Cerrar</button>
                <button type="submit" class="px-4 py-2 bg-[var(--color-btn)] text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    function openModal(maintenance) {
        document.querySelector('.modal').classList.remove('hidden');
        const form = document.querySelector('form');
        if (maintenance === null) {
            form.reset();
        } else {
            console.log(maintenance);
            document.querySelector('#id_maintenance').value = maintenance.id || '';
            document.querySelector('#mechanic_charge').value = maintenance.mechanic_charge || '';
            document.querySelector('#date_maintenance').value = maintenance.date_maintenance || '';
            document.querySelector('#date_next_maintenance').value = maintenance.date_next_maintenance || '';
            document.querySelector('#status').value = maintenance.status || '';

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