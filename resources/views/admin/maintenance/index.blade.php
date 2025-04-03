<div class="flex justify-end w-full">
    <!-- <h1 class="text-xl">Historial Mantenimiento</h1> -->
    <button onclick="openModal(null)" type="button"
    class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#addmaintenance">
        <i class="fa-solid fa-plus"></i> Agregar mantenimiento
    </button>
</div>


<div class="relative overflow-x-auto pt-6">
    <!-- Tabla de Clientes -->
    <table class="table">
        <thead class="fs-5 table-light">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Mecánico Encargado</th>
                <th scope="col" class="px-6 py-3">Fecha Mantenimiento</th>
                <th scope="col" class="px-6 py-3">Descripción Mantenimiento</th>
                {{-- <th scope="col" class="px-6 py-3">Fecha Estimada Próximo mantenimiento</th> --}}
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3">Factura</th>
                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="fs-5">
            @foreach($maintenances as $maintenance)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                <td class="px-6 py-4">{{ $maintenance->id}}</td>
                <td class="px-6 py-4">{{ $maintenance->mechanic_charge}}</td>
                <td class="px-6 py-4">{{ $maintenance->formatted_date_maintenance}}</td>
                <td class="px-6 py-4">{{ $maintenance->description_maintenance}}</td>
                {{-- <td class="px-6 py-4">{{ $maintenance->date_next_maintenance == null ? 'No especificado' : $maintenance->formatted_date_next_maintenance}}</td> --}}
                <td class="px-6 py-4">{{ $maintenance->status}}</td>
                <td>
                    @if (!empty($maintenance->factura))
                    <a href="{{ route('admin.mantenimiento.downloadPDF', basename($maintenance->factura)) }}" class="fs-4 pt-3 flex items-center justify-center">
                        <i class="fa-solid fa-download"></i>
                    </a>
                    @else
                    <span>No cargada</span>
                    @endif
                </td>
                <td>
                    <flux:dropdown>
                        <flux:button style="border:none !important;" icon:trailing="ellipsis-vertical" class="icon-more-actions">
                        </flux:button>

                        <flux:menu>
                            <flux:menu.item data-bs-toggle="modal"
                            data-bs-target="#addmaintenance" icon="pencil-square"
                                onclick="openModal({{ json_encode($maintenance)}})">Editar</flux:menu.item>
                            <form class="delete-form"
                                action="{{ route('admin.mantenimiento.destroy', $maintenance->id) }}" method="POST">
                                <input type="hidden" name="previous_url" value="{{ request()->fullUrl() }}">
                                <input type="hidden" name="id" value="{{ $maintenance->id }}">
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



<!-- Modal -->
<div class="modal fade" id="addmaintenance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('admin.mantenimiento.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Mantenimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="createClientForm" class="max-w-2xl mx-auto mt-6">
                    <input type="hidden" id="id_maintenance" name="id_maintenance">
                    <input type="hidden" id="id_vehicle" name="id_vehicle" value="{{$vehicle_id}}">
                    <input type="hidden" name="previous_url" value="{{ request()->fullUrl() }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mechanic_charge" class="form-label">Nombre mecánico
                                    encargado</label>
                                <input type="text" id="mechanic_charge" name="mechanic_charge"
                                    class="form-control custom-border" placeholder="Juan Perez" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_maintenance" class="form-label">Fecha
                                    Mantenimiento</label>
                                <input type="date" id="date_maintenance" name="date_maintenance"
                                    class="form-control custom-border" required />
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_next_maintenance" class="form-label">Fecha Próximo
                                    Mantenimiento (opcional)</label>
                                <input type="date" id="date_next_maintenance" name="date_next_maintenance"
                                    class="form-control custom-border" placeholder="Juan Perez" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Seleccionar
                                    Estado</label>
                                <select name="status" required id="status" class="form-control custom-border">
                                    <option selected>Estado</option>
                                    <option value="Ingresado">Ingresado</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Finalizado">Finalizado</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description_maintenance" class="form-label">Descripción
                                    Mantenimiento</label>
                                <input type="text" id="description_maintenance" name="description_maintenance"
                                    class="form-control custom-border" placeholder="Descripción" required />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="factura">
                                    Cargar Factura (PDF)
                                </label>
                                <input class="form-control custom-border" id="factura" type="file"
                                    name="factura" accept="application/pdf">
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
            document.querySelector('#description_maintenance').value = maintenance.description_maintenance || '';

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