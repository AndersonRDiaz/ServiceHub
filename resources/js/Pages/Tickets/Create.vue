<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Recebe a lista de projetos do backend (vinda do TicketController@create)
defineProps({ projects: Array });

// Referência para o elemento DOM input de arquivo (para limpar manualmente após sucesso)
// Necessária porque o Vue não consegue resetar o 'value' de campos file diretamente
const fileInput = ref(null);

// Inicializa o helper useForm do Inertia, ele gerencia automaticamente o estado de carregamento (processing) e erros de validação
const form = useForm({
    project_id: '',
    title: '',
    description: '',
    attachment: null,
});

const submit = () => {
    form.post(route('tickets.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            if (fileInput.value) fileInput.value.value = '';
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Novo Ticket" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Novo Ticket de Serviço
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow">   

                <!-- Formulário de criação de ticket, com vinculação ao projeto e upload de arquivo -->
                <form @submit.prevent="submit">
                    <div class="mb-5">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Projeto Relacionado</label>
                        <select v-model="form.project_id" 
                                class="w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                :class="{ 'border-red-500': form.errors.project_id }">
                            <option value="">Selecione o projeto relacionado</option>
                            <option v-for="p in projects" :key="p.id" :value="p.id">
                                {{ p.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.project_id" class="text-red-600 text-xs mt-1 italic">
                            {{ form.errors.project_id }}
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Título</label>
                        <input v-model="form.title" 
                            type="text" class="w-full 
                            border-gray-300 rounded-md shadow-sm"
                            :class="{ 'border-red-500': form.errors.title }"/>
                        <div v-if="form.errors.title" class="text-red-600 text-xs mt-1 italic">
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Descrição</label>
                        <textarea v-model="form.description" 
                            rows="4" 
                            class="w-full 
                            border-gray-300 rounded-md shadow-sm" 
                            :class="{ 'border-red-500': form.errors.description }">
                        </textarea>
                        <div v-if="form.errors.description" class="text-red-600 text-xs mt-1 italic">
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Anexo Técnico (JSON/TXT)</label>
                        <input 
                            type="file" 
                            ref="fileInput"
                            @input="form.attachment = $event.target.files[0]" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                        />
                        <div v-if="form.errors.attachment" class="text-red-600 text-xs mt-1 italic">
                            {{ form.errors.attachment }}
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <Link 
                            :href="route('dashboard')" 
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition"
                        >
                            Cancelar
                        </Link>

                        <button 
                            type="submit" 
                            :disabled="form.processing" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md font-bold hover:bg-indigo-700 disabled:opacity-50 transition"
                        >
                            {{ form.processing ? 'Processando Arquivo...' : 'Criar Ticket' }}
                        </button>
                        
                    </div>

                    

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>