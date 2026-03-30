<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Recebemos o ticket com os relacionamentos carregados pelo Controller (load)
const props = defineProps({
    ticket: Object
});

// Helper para formatar a data de criação de forma legível
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('pt-BR');
};

// Define cores dinâmicas baseadas no status que o seu JOB atualiza
const statusClasses = {
    'OPEN': 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'IN_PROCESSING': 'bg-blue-100 text-blue-800 border-blue-200',
    'PROCESSED': 'bg-green-100 text-green-800 border-green-200',
    'FAILED': 'bg-red-100 text-red-800 border-red-200'
};
</script>

<template>
    <Head :title="`Ticket #${ticket.id}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detalhes do Ticket #{{ ticket.id }}
                </h2>
                <Link :href="route('dashboard')" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                    &larr; Voltar para Dashboard
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    
                    <div class="border-b border-gray-200 pb-4 mb-6 flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ ticket.title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Aberto em {{ formatDate(ticket.created_at) }} por {{ ticket.user.name }}
                            </p>
                        </div>
                        <span :class="statusClasses[ticket.status.toUpperCase()] || 'bg-gray-100 text-gray-800'" 
                              class="px-3 py-1 rounded-full text-xs font-bold uppercase border">
                            {{ ticket.status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-1">Empresa</h4>
                            <p class="text-gray-800 font-medium">{{ ticket.project.company.name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-1">Projeto</h4>
                            <p class="text-gray-800 font-medium">{{ ticket.project.name }}</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-gray-700 mb-2">Descrição do Usuário:</h4>
                        <div class="text-gray-600 bg-white border border-gray-100 p-4 rounded-md italic">
                            {{ ticket.description }}
                        </div>
                    </div>


                    <div class="mt-10">
                        <h4 class="text-sm font-bold text-indigo-700 mb-3 flex items-center">
                            Conteúdo Extraído do Anexo (Processamento Assíncrono)
                        </h4>

                        <div v-if="ticket.detail" class="bg-gray-900 rounded-lg p-5 overflow-x-auto">
                            <pre class="text-green-400 font-mono text-sm leading-relaxed whitespace-pre-wrap">{{ ticket.detail.content }}</pre>
                        </div>
                        
                        <div v-else-if="ticket.status === 'IN_PROCESSING'" class="bg-blue-50 text-blue-700 p-4 rounded-md border border-blue-100 flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-3 text-blue-600" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            O arquivo está sendo processado pela fila... Atualize em instantes.
                        </div>

                        <div v-else class="bg-gray-50 text-gray-500 p-4 rounded-md border border-dashed border-gray-300 text-center">
                            Nenhum anexo técnico foi enviado para este ticket.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>