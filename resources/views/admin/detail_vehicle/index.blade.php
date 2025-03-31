<x-layouts.app>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full items-start p-5 relative overflow-x-auto">
        
        <!-- Pestañas -->
        <div class="flex border-b">
            <button class="tab-link p-4 w-1/3 text-center border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500 focus:outline-none" onclick="openTab(event, 'tab1')">Pestaña 1</button>
            <button class="tab-link p-4 w-1/3 text-center border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500 focus:outline-none" onclick="openTab(event, 'tab2')">Pestaña 2</button>
            <button class="tab-link p-4 w-1/3 text-center border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500 focus:outline-none" onclick="openTab(event, 'tab3')">Pestaña 3</button>
        </div>
        
        <!-- Contenido de pestañas -->
        <div id="tab1" class="tab-content p-6 hidden">Contenido de la Pestaña 1</div>
        <div id="tab2" class="tab-content p-6 hidden">Contenido de la Pestaña 2</div>
        <div id="tab3" class="tab-content p-6 hidden">Contenido de la Pestaña 3</div>
    </div>


    <script>
        function openTab(evt, tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabName).classList.remove('hidden');
            document.querySelectorAll('.tab-link').forEach(tab => tab.classList.remove('border-blue-500'));
            evt.currentTarget.classList.add('border-blue-500');
        }
        
        // Mostrar la primera pestaña por defecto
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('.tab-link').click();
        });
    </script>
</x-layouts.app>
