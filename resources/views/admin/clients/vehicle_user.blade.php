<x-layouts.app>
    <div class="pl-2">
        <!-- Contenedor principal -->
        <div class="row min-vh-100 g-4">
            <!-- Sección izquierda (solo en escritorio) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="text-secondary">
                        <div class="border-bottom mb-4">
                            <p class="fw-semibold fs-5"><i class="fas fa-user"></i> Nombres</p>
                            <p class="text-muted">{{$client->name}}</p>
                            <p class="text-muted">{{$client->lastname}}</p>
                        </div>
                        
                        <div class="border-bottom mb-3">
                            <p class="fw-semibold pb-1 fs-5"><i class="fa-solid fa-city"></i> Ciudad</p>
                            <p class="text-muted pb-1">{{$client->city ?? 'No indicado'}}</p>
                        </div>
                        
                        <div class="border-bottom mb-3">
                            <p class="fw-semibold pb-1 fs-5"><i class="fa-solid fa-location-crosshairs"></i> Provincia</p>
                            <p class="text-muted pb-1">{{$client->province ?? 'No indicado'}}</p>
                        </div>
                        
                        <div class="border-bottom mb-3">
                            <p class="fw-semibold pb-1 fs-5"><i class="fa-solid fa-location-dot"></i> Dirección</p>
                            <p class="text-muted pb-1">{{$client->address ?? 'No indicado'}}</p>
                        </div>
                        
                        <div class="border-bottom mb-3">
                            <p class="fw-semibold fs-5"><i class="fa-solid fa-envelope"></i> Correo</p>
                            <p class="text-muted pb-1">{{$client->email}}</p>
                        </div>
                        
                        <div class="border-bottom mb-3">
                            <p class="fw-semibold fs-5"><i class="fa-solid fa-phone"></i> Teléfonos</p>
                            <p class="text-muted pb-1">{{$client->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección derecha (en móvil se convierte en full width) -->
            <div class="col-lg-9">
                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="d-block d-lg-none mb-4">
                        <p class="fs-4"><strong>Nombre Cliente:</strong> {{$client->name}} {{$client->lastname}} </p>
                    </div>
                    
                    @include('admin.vehicles.table_vehicles', ['vehicles' => $vehicles, 'perPage' => $perPage])
                </div>
            </div>
        </div>
    </div>
    

</x-layouts.app>
