<template>
    <div class="flex flex-row w-full h-screen items-center justify-center">
        <form @submit.prevent="submit" class="flex flex-col gap-4 bg-base-300 p-10 rounded-md">
            <h3 class="text-accent-content text-lg mb-4">
                Effect - PDF Upload
            </h3>
            <div class="form-control mb-2">
                <input @input="form.document = $event.target.files[0]" type="file" class="file-input file-input-bordered">
                <p v-if="$page.props.errors.document" class="text-red-500 text-sm mt-2">
                    {{ $page.props.errors.document }}
                </p>
            </div>
            <div class="flex flex-row w-full justify-end">
                <button :disabled="!form.document || isLoading" type="submit" class="btn btn-sm btn-primary">
                    <span v-if="isLoading">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    {{ isLoading ? 'Uploading' : 'Upload' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const props = defineProps({
    errors: Object,
    flash: Object
});

const form = useForm({
    document: null
})

const isLoading = ref(false);

const submit = () => {
    form.post(route('documents.upload'), {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            isLoading.value = true;
        },
        onError: () => {
            const toast = useToast();
            toast.error(props.errors.message);
        },
        onSuccess: () => {
            const toast = useToast();
            toast.success(props.flash.message);
        },
        onFinish: () => {
            isLoading.value = false;
            form.document = null;
        }
    })
}
</script>

