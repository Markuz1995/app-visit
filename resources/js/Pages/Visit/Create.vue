<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: "",
    email: "",
    latitude: "",
    longitude: "",
});

const props = defineProps({
    visit: {
        type: Object,
        default: null,
    },
    isUpdating: {
        type: Boolean,
        default: false,
    },
});

const submit = () => {
    if (props.isUpdating) {
        form.put(`/visits/${props.visit.id}`);
    } else {
        form.post("/visits");
    }
};

watch(() => props.visit, (newVisit) => {
    if (newVisit) {
        form.name = newVisit.name;
        form.email = newVisit.email;
        form.latitude = newVisit.latitude;
        form.longitude = newVisit.longitude;
    }
}, { immediate: true });
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto p-6 max-w-5xl">
            <h1 class="text-2xl font-bold mb-6 text-center">{{ isUpdating ? 'Edit Visit' : 'Create New Visit' }}</h1>
            <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" v-model="form.name" placeholder="Name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="text" id="email" v-model="form.email" placeholder="admin@example.com"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</div>
                </div>
                <div class="mb-4">
                    <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude</label>
                    <input type="text" id="latitude" v-model="form.latitude" placeholder="19.4324"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="form.errors.latitude" class="text-red-500 text-xs italic">{{ form.errors.latitude }}
                    </div>
                </div>
                <div class="mb-4">
                    <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude</label>
                    <input type="text" id="longitude" v-model="form.longitude" placeholder="-99.1334"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="form.errors.longitude" class="text-red-500 text-xs italic">{{ form.errors.longitude }}
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Link href="/visits"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back</Link>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>

                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
