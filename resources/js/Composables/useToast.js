import { ref } from 'vue';

const messages = ref([]);

export function useToast() {
    const showToast = (message, type = 'default') => {
        const id = Date.now();
        messages.value.push({ id, message, type });
        
        setTimeout(() => {
            messages.value = messages.value.filter(m => m.id !== id);
        }, 5000);
    };

    const showSuccess = (message) => {
        showToast(message, 'success');
    };

    const showError = (message) => {
        showToast(message, 'destructive');
    };

    return {
        messages,
        showToast,
        showSuccess,
        showError
    };
} 