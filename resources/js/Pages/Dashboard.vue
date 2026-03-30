<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

//Props recebe os tickets filtrados e paginados vindos do servidor 
defineProps({
    tickets: Array  
});

//Mapeia cada status vindo do Job para uma cor específica
const statusStyles = {
    'OPEN': 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'IN_PROCESSING': 'bg-blue-100 text-blue-800 border-blue-200',
    'PROCESSED': 'bg-green-100 text-green-800 border-green-200',
    'FAILED': 'bg-red-100 text-red-800 border-red-200'
};

</script>

<template>
    <Head title="Painel de Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Meus Tickets
                </h2>
                <Link 
                    :href="route('tickets.create')" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-bold transition"
                >
                    + Abrir Novo Ticket
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
               
                <div v-if="$page.props.flash?.message" class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg shadow-sm">
                    {{ $page.props.flash?.message }}
                </div>
                    
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-100">
                    <div class="p-6 text-gray-900">
                        
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase">ID</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase">Título</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase">Projeto</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase text-center">Status</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-4 text-sm text-gray-500">#{{ ticket.id }}</td>
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ ticket.title }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">{{ ticket.project.name }}</td>
                                    <td class="py-4 px-4 text-sm text-center">
                                        <span :class="statusStyles[ticket.status.toUpperCase()] || 'bg-gray-100'" 
                                            class="px-3 py-1 rounded-full text-xs font-bold uppercase border">
                                            {{ ticket.status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-right">
                                        <Link 
                                            :href="route('tickets.show', ticket.id)" 
                                            class="text-indigo-600 hover:text-indigo-900 font-bold"
                                        >
                                            Ver Detalhes
                                        </Link>
                                    </td>
                                </tr>
                                
                                <tr v-if="tickets.length === 0">
                                    <td colspan="5" class="py-12 text-center text-gray-400 italic">
                                        Você ainda não possui tickets abertos.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>