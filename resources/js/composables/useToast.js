import Swal from 'sweetalert2';

// Define a SweetAlert2 toast configuration
const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  },
});

export function useToast() {
  const showToast = (message, type = 'info') => {
    toast.fire({
      icon: type,
      title: message,
    });
  };

  const success = (message) => showToast(message, 'success');
  const error = (message) => showToast(message, 'error');
  const info = (message) => showToast(message, 'info');
  const warning = (message) => showToast(message, 'warning');

  return {
    success,
    error,
    info,
    warning
  };
}
