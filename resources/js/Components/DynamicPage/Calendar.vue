<script setup>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'

const props = defineProps({
    events: {
        type: Array,
        default: () => []
    }
})

const options = {
    plugins: [dayGridPlugin],
    initialView: 'dayGridMonth',
    events: props.events.map(event => ({
        title: event.title,
        date: event.date
    }))
}
</script>

<template>
    <FullCalendar :options="options" />
</template>
