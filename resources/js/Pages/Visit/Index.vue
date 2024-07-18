<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import Map from '@/Components/Map.vue';
import { EyeIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    visits: {
        type: Object,
        default: () => ({}),
    },
});

const headers = ["Name", "Email", "Latitude", "Longitude", "Actions"];
const form = useForm({});

const deleteVisit = (id) => {
    if (confirm('Are you sure you want to delete this visit?')) {
        form.delete(`visits/${id}`);
    }
};

const showModal = ref(false);
const selectedVisit = ref(null);

const openModal = (visit) => {
    selectedVisit.value = visit;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Visits</h1>
            <div class="text-right mb-4">
                <Link href="/visits/create"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                    Create new visit
                </Link>
            </div>
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th v-for="header in headers" :key="header"
                            class="py-2 px-4 border-b border-gray-300 text-left">
                            {{ header }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="visit in visits.data" :key="visit.id" class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ visit.name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ visit.email }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ visit.latitude }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ visit.longitude }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <button @click.prevent="openModal(visit)" class="text-blue-500 hover:text-blue-700 mr-2">
                                <EyeIcon class="h-5 w-5 inline" />
                            </button>
                            <Link :href="`/visits/${visit.id}/edit`" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <PencilIcon class="h-5 w-5 inline" />
                            </Link>
                            <button @click.prevent="deleteVisit(visit.id)" class="text-red-500 hover:text-red-700">
                                <TrashIcon class="h-5 w-5 inline" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :links="visits.links" />
        </div>

        <Modal :show="showModal" @close="closeModal">
            <div class="p-6" v-if="selectedVisit">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Visit Details</h2>
                <p class="mb-2"><strong>Name:</strong> {{ selectedVisit.name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ selectedVisit.email }}</p>
                <p class="mb-2"><strong>Latitude:</strong> {{ selectedVisit.latitude }}</p>
                <p class="mb-2"><strong>Longitude:</strong> {{ selectedVisit.longitude }}</p>
                <div class="mt-4 flex justify-end">
                    <button @click="closeModal"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                        Close
                    </button>
                </div>
            </div>
        </Modal>
        <Modal :show="showMapModal" @close="closeMapModal">
            <template #default="{ show }">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Visit Map</h2>
                    <Map :visits="visits.data" />
                    <div class="mt-4 flex justify-end">
                        <button @click="closeMapModal"
                            class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                            Close
                        </button>
                    </div>
                </div>
            </template>
        </Modal>

        <div class="container mx-auto p-6">
            <Map :visits="visits.data" />
        </div>
    </AuthenticatedLayout>
</template>
