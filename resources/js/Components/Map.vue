<script setup>
import { ref, onMounted, watch, defineProps } from 'vue';
import L from 'leaflet';

const props = defineProps({
    visits: Array,
});

const map = ref(null);
const markers = ref([]);

onMounted(() => {
    if (map.value) {
        map.value = L.map(map.value).setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map.value);

        watch(() => props.visits, (newVisits) => {
            updateMarkers(newVisits);
        }, { immediate: true });
    }
});

const updateMarkers = (visits) => {
    markers.value.forEach(marker => {
        marker.removeFrom(map.value);
    });

    markers.value = visits.map(visit => {
        return L.marker([visit.latitude, visit.longitude])
            .addTo(map.value)
            .bindPopup(`<b>${visit.name}</b><br>${visit.email}`)
            .openPopup();
    });
};


</script>

<template>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Map</h2>
            <div ref="map" style="height: 400px;"></div>
        </div>
</template>

