<template>
    <footer class="px-smpad bg-secondary-dark text-tertiary md:px-lgpad py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Friends of Ijebu-Ode Diocese Info -->
            <div class="space-y-2">
                <h3 class="font-bold text-lg">FRIENDS OF IJEBU-ODE DIOCESE, INC.</h3>
                <p>P.O. BOX 2348, GLEN BURNIE, MD 21060</p>
                <p>240-796-7269</p>
                <p>foid11@yahoo.com</p>
            </div>

            <!-- Headquarters Info -->
            <div class="space-y-2">
                <h3 class="font-bold text-lg">HEADQUARTERS</h3>
                <p>CATHOLIC DIOCESE OF IJEBU-ODE</p>
                <p>CATHOLIC BISHOPS COURT, 83 STADIUM ROAD G.R.A., IJEBU-ODE, OGUN STATE 120101</p>
                <p>+234-803-069-2835</p>
                <p>ijodecathdio@yahoo.com</p>
            </div>
        </div>

        <!-- Donation Note -->
        <div class="mt-6 text-center text-sm text-tertiary-light">
            This website made possible in part through your donations. Thank you.
        </div>
    </footer>
        <footer class="bg-blue-900 text-tertiary px-6 py-4 text-center">
            <p class="text-sm">
                <Link href="/login" class="underline hover:text-primary transition-colors"> Login </Link>
                powered by
                <Link href="https://stechmax.com" class="underline hover:text-primary transition-colors"> S-TechMax Ltd </Link>
            </p>
        </footer>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
</script>
