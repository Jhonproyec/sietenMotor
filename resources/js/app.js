
    // Obtener todos los botones para abrir modales
    const modalButtons = document.querySelectorAll('.openModalButton');
    const modals = document.querySelectorAll('.modal');
    const closeButtons = document.querySelectorAll('.closeModalButton');

    // Abrir el modal correspondiente
    modalButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            modals[index].classList.remove('hidden');
        });
    });

    // Cerrar los modales
    closeButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            modals[index].classList.add('hidden');
        });
    });

    // Cerrar si se hace clic fuera del modal
    window.addEventListener('click', function(event) {
        modals.forEach((modal) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
