import { writable } from 'svelte/store';

export const modalStore = writable({
    activeModal: null,
    modalProps: {}
});

export const modalActions = {

    open: (modalName, props = {}) => {
        modalStore.set({ activeModal: modalName, modalProps: props });
    },
    
    close: () => {
        modalStore.set({ activeModal: null, modalProps: {} });
    }

};