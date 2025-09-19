<script setup>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'

const options = {
    plugins: [dayGridPlugin],
    initialView: 'dayGridMonth',
    events: [
        { title: 'Event 1', date: '2025-09-18' },
        { title: 'Event 2', date: '2025-09-25' }
    ]
}
</script>

<template>
    <FullCalendar :options="options" />
</template>
