import { ref } from 'vue';
import { openModal as jOpenModal, closeModal as jCloseModal } from 'jenesius-vue-modal';

export function useModal() {
  const isVisible = ref(false);

  const openModal = (component, props = {}) => {
    jOpenModal(component, props);
    isVisible.value = true;
  };

  const close = () => {
    jCloseModal();
    isVisible.value = false;
  };

  return {
    isVisible,
    openModal,
    close,
  };
}
