/**
 * Sweet Alert Helper Functions
 * File: public/js/sweetalert-helper.js
 *
 * Usage: Include this after Sweet Alert 2 CDN
 * <script src="{{ asset('js/sweetalert-helper.js') }}"></script>
 */

// =====================================
// CONFIRMATION DIALOGS
// =====================================

/**
 * Confirm Delete Action
 * @param {HTMLElement} button - The button that triggered the action
 * @param {string} itemName - Name of item being deleted (optional)
 */
function confirmDelete(button, itemName = 'data ini') {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: `<p class="text-gray-600">Data <strong class="text-gray-900">${itemName}</strong> akan dihapus permanen dan tidak dapat dikembalikan!</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg',
            cancelButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form
            button.closest('form').submit();

            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    });
}

/**
 * Confirm General Action
 * @param {string} title - Dialog title
 * @param {string} text - Dialog text
 * @param {Function} callback - Function to execute on confirm
 * @param {string} confirmText - Confirm button text
 */
function confirmAction(title, text, callback, confirmText = 'Ya, Lanjutkan!') {
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3B82F6',
        cancelButtonColor: '#6B7280',
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg',
            cancelButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Confirm Return Item
 * @param {string} itemName - Name of item being returned
 * @param {Function} callback - Function to execute on confirm
 */
function confirmReturn(itemName, callback) {
    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        html: `<p class="text-gray-600">Apakah Anda yakin ingin mengembalikan <strong class="text-gray-900">${itemName}</strong>?</p>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: '<i class="bi bi-arrow-return-left"></i> Ya, Kembalikan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg',
            cancelButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

// =====================================
// NOTIFICATION TOASTS
// =====================================

/**
 * Show Success Toast
 * @param {string} message - Success message
 * @param {number} timer - Auto close timer in ms (default: 3000)
 */
function showSuccessToast(message, timer = 3000) {
    Swal.fire({
        icon: 'success',
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        customClass: {
            popup: 'colored-toast'
        }
    });
}

/**
 * Show Error Toast
 * @param {string} message - Error message
 * @param {number} timer - Auto close timer in ms (default: 4000)
 */
function showErrorToast(message, timer = 4000) {
    Swal.fire({
        icon: 'error',
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true
    });
}

/**
 * Show Info Toast
 * @param {string} message - Info message
 * @param {number} timer - Auto close timer in ms (default: 3000)
 */
function showInfoToast(message, timer = 3000) {
    Swal.fire({
        icon: 'info',
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true
    });
}

/**
 * Show Warning Toast
 * @param {string} message - Warning message
 * @param {number} timer - Auto close timer in ms (default: 3500)
 */
function showWarningToast(message, timer = 3500) {
    Swal.fire({
        icon: 'warning',
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true
    });
}

// =====================================
// LOADING STATES
// =====================================

/**
 * Show Loading Dialog
 * @param {string} title - Loading title
 * @param {string} text - Loading text
 */
function showLoading(title = 'Loading...', text = 'Mohon tunggu sebentar') {
    Swal.fire({
        title: title,
        html: text,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

/**
 * Close Loading Dialog
 */
function closeLoading() {
    Swal.close();
}

// =====================================
// FORM VALIDATION
// =====================================

/**
 * Show Validation Errors
 * @param {Array} errors - Array of error messages
 */
function showValidationErrors(errors) {
    let errorList = '<ul class="text-left space-y-1 mt-2">';
    errors.forEach(error => {
        errorList += `<li class="text-sm text-gray-700">• ${error}</li>`;
    });
    errorList += '</ul>';

    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: errorList,
        confirmButtonColor: '#EF4444',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    });
}

// =====================================
// CUSTOM ALERTS
// =====================================

/**
 * Show Custom Alert
 * @param {Object} options - Swal options object
 */
function showCustomAlert(options) {
    const defaultOptions = {
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg',
            cancelButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    };

    Swal.fire({...defaultOptions, ...options});
}

/**
 * Show Success Dialog
 * @param {string} title - Dialog title
 * @param {string} text - Dialog text
 */
function showSuccess(title, text) {
    Swal.fire({
        icon: 'success',
        title: title,
        text: text,
        confirmButtonColor: '#10B981',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    });
}

/**
 * Show Error Dialog
 * @param {string} title - Dialog title
 * @param {string} text - Dialog text
 */
function showError(title, text) {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text,
        confirmButtonColor: '#EF4444',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg'
        }
    });
}

// =====================================
// EXAMPLE USAGE
// =====================================

/**
 * Example: Delete Button with Sweet Alert
 *
 * HTML:
 * <form action="{{ route('alat.destroy', $alat->id) }}" method="POST">
 *     @csrf
 *     @method('DELETE')
 *     <button type="button" onclick="confirmDelete(this, '{{ $alat->nama_alat }}')">
 *         Hapus
 *     </button>
 * </form>
 */

/**
 * Example: Custom Action
 *
 * confirmAction(
 *     'Konfirmasi Aksi',
 *     'Apakah Anda yakin ingin melanjutkan?',
 *     function() {
 *         // Your code here
 *         console.log('Action confirmed!');
 *     }
 * );
 */

/**
 * Example: Show Toast
 *
 * showSuccessToast('Data berhasil disimpan!');
 * showErrorToast('Gagal menyimpan data!');
 */
