<x-layouts.app>
    <div class="container mx-auto  px-2">
        <!-- Contenedor principal -->
        <div class="grid grid-cols-[25%_1fr] gap-4 min-h-screen">
            <!-- Sección izquierda (solo en escritorio) -->
            <div class="bg-white p-4 rounded-lg shadow-md hidden lg:block">
    
                <div class="space-y-4 text-gray-700">
                    <div class="border-b flex items-center space-x-2">
                        <div>
                            <p class="font-semibold"><i class="fas fa-user"></i> Nombres</p>
                            <p class="text-gray-500">{{$client->name}}</p>
                            <p class="text-gray-500 pb-3">{{$client->lastname}}</p>
                        </div>
                    </div>
                    
                    <div class="flex border-b items-center space-x-2">
                        <div>
                            <p class="font-semibold pb-3"><i class="fa-solid fa-city"></i> Ciudad</p>
                            <p class="text-gray-500 pb-3">{{$client->city == null ? 'No indicado' : $client->city}}</p>
                        </div>
                    </div>
                    
                    <div class="flex border-b items-center space-x-2">
                        <div>
                            <p class="font-semibold pb-3"><i class="fa-solid fa-location-crosshairs"></i> Provincia</p>
                            <p class="text-gray-500 pb-3">{{$client->province == null ? 'No indicado' : $client->province}}</p>
                        </div>
                    </div>
                    
                    <div class="flex border-b items-center space-x-2">
                        <div>
                            <p class="font-semibold pb-3"><i class="fa-solid fa-location-dot"></i> Dirección</p>
                            <p class="text-gray-500 pb-3">{{$client->address == null ? 'No indicado' : $client->address}}</p>
                        </div>
                    </div>
                    
                    <div class="flex border-b items-center space-x-2">
                        <div>
                            <p class="font-semibold"><i class="fa-solid fa-envelope"></i> Correo</p>
                            <p class="text-gray-500 pb-3">{{$client->email}}</p>
                        </div>
                    </div>
                    
                    <div class="flex border-b items-center space-x-2">
                        <div>
                            <p class="font-semibold"><i class="fa-solid fa-phone"></i> Teléfonos</p>
                            <p class="text-gray-500 pb-3">{{$client->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Sección derecha (en móvil se convierte en full width) -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <!-- Información del cliente (visible en móvil y oculto en escritorio) -->
                <div class="block lg:hidden mb-4">
                    <p><strong>Estado:</strong> <span
                            class="bg-red-500 text-white text-xs px-2 py-1 rounded">Presupuesto Enviado</span></p>
                </div>
    
                @include('admin.vehicles.table_vehicles', ['vehicles' => $vehicles, 'perPage' => $perPage])
            </div>
        </div>
    </div>
    

</x-layouts.app>
