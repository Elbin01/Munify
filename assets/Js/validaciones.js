// assets/Js/validaciones.js

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inyectar el contenedor de Toasts si no existe
    if (!document.getElementById('validationToastContainer')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'validationToastContainer';
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // 2. Función para mostrar Toast de Bootstrap
    window.showValidationToast = function(message) {
        const container = document.getElementById('validationToastContainer');
        const toastId = 'toast-' + Date.now();
        
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', toastHTML);
        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
        
        // Limpiar DOM al ocultar
        toastEl.addEventListener('hidden.bs.toast', function () {
            toastEl.remove();
        });
    };

    // 3. Máscara para DUI
    $(document).on('input', '.dui-mask', function() {
        let value = $(this).val().replace(/\D/g, ''); // Solo números
        if (value.length > 8) {
            value = value.substring(0, 8) + '-' + value.substring(8, 9);
        }
        $(this).val(value);
    });

    $(document).on('keypress', '.dui-mask', function(e) {
        const charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            showValidationToast("El campo DUI solo permite números.");
            e.preventDefault();
        }
    });

    // 4. Validación: Solo Letras
    $(document).on('keypress', '.letras-only', function(e) {
        const charCode = (e.which) ? e.which : e.keyCode;
        const charStr = String.fromCharCode(charCode);
        // Permitir letras mayúsculas, minúsculas, espacios, ñ, acentos
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        
        if (!regex.test(charStr)) {
            showValidationToast("Este campo solo permite letras y espacios.");
            e.preventDefault();
        }
    });

    // 5. Validación: Solo Números
    $(document).on('keypress', '.numeros-only', function(e) {
        const charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            showValidationToast("Este campo solo permite números.");
            e.preventDefault();
        }
    });
    
    // Evitar paste de caracteres inválidos en letras-only
    $(document).on('paste', '.letras-only', function(e) {
        let paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(paste)) {
            showValidationToast("El texto pegado contiene caracteres inválidos.");
            e.preventDefault();
        }
    });

    // Evitar paste de caracteres inválidos en numeros-only
    $(document).on('paste', '.numeros-only', function(e) {
        let paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
        if (!/^\d+$/.test(paste)) {
            showValidationToast("Solo puedes pegar números en este campo.");
            e.preventDefault();
        }
    });
});
