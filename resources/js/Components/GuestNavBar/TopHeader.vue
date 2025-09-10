<template>
    <header class="relative md:hidden">
        <!-- Top Sticky Bar -->
        <div class="sticky top-0 z-50 bg-secondary text-white px-4 py-3 flex justify-between items-center">
            <!-- Hamburger -->
            <button
                @click="sidebarOpen = true"
                class="md:hidden flex items-center justify-center w-8 h-8 border border-tertiary rounded hover:bg-primary hover:text-tertiary transition"
            >
                <span class="block w-5 h-0.5 bg-tertiary mb-1"></span>
                <span class="block w-5 h-0.5 bg-tertiary mb-1"></span>
                <span class="block w-5 h-0.5 bg-tertiary"></span>
            </button>

            <!-- Desktop Contact Links -->
            <div class="hidden md:flex space-x-4">
                <Link href="/contact-us" class="hover:text-primary transition-colors">Contact Us</Link>
                <Link href="/our-bishop" class="hover:text-primary transition-colors">Our Bishop</Link>
            </div>

            <!-- Social Icons -->
            <div class="flex items-center space-x-2">
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-facebook-f">F</i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-twitter">T</i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-instagram">I</i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fas fa-envelope">F</i>
                </Link>
            </div>
        </div>
        <!-- Heading + Tagline -->
        <div class="text-center px-4 py-4 bg-tertiary">
            <Link href="/" class="block">
                <h1 class="text-xl md:text-3xl font-heading font-bold hover:text-primary transition-colors">
                    Friends of Ijebu-Ode Diocese Inc
                </h1>
            </Link>
            <p class="text-sm md:text-base mt-1">
                Come over to Macedonia and help us (Act 16:9).
            </p>
        </div>

        <!-- Mobile Sidebar -->
        <transition name="slide">
            <div
                v-if="sidebarOpen"
                class="fixed inset-0 z-50 flex"
            >
                <!-- Overlay -->
                <div
                    class="fixed inset-0 bg-black bg-opacity-50"
                    @click="sidebarOpen = false"
                ></div>

                <!-- Sidebar -->
                <div class="relative w-64 bg-secondary-dark p-4 flex flex-col space-y-2">
                    <div class="flex justify-between">
                        <h1 class="text-tertiary">FOIDINC</h1>

                    <button
                        class="self-end mb-4 text-tertiary hover:text-white"
                        @click="sidebarOpen = false"
                    >
                        ✕
                    </button>
                    </div>
                    <MobileSideBar v-for="link in $page.props.links" :key="link.id" :link="link" />
                </div>
            </div>
        </transition>
    </header>

<!-- Desktop section-->
    <div class="hidden md:block">
        <header class="bg-secondary-dark text-tertiary px-4 py-3">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            <!-- Left: Hamburger Menu on Mobile / Contact Links on Desktop -->
            <div class="flex items-center">
                <!-- Mobile Hamburger -->
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="md:hidden flex items-center justify-center w-8 h-8 border border-tertiary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <span class="block w-5 h-0.5 bg-tertiary mb-1"></span>
                    <span class="block w-5 h-0.5 bg-tertiary mb-1"></span>
                    <span class="block w-5 h-0.5 bg-tertiary"></span>
                </button>

                <!-- Desktop Links -->
                <div class="hidden md:flex space-x-4">
                    <Link href="/contact-us" class="hover:text-primary transition-colors">Contact Us</Link>
                    <Link href="/our-bishop" class="hover:text-primary transition-colors">Our Bishop</Link>
                </div>
            </div>

            <!-- Center: Heading + Tagline -->
            <div class="flex-1 text-center mt-2 md:mt-0">
                <Link href="/" class="block">
                    <h1 class="text-xl md:text-3xl font-heading font-bold hover:text-primary transition-colors">
                        Friends of Ijebu-Ode Diocese Inc
                    </h1>
                </Link>
                <p class="text-sm md:text-base mt-1 hidden md:block">
                    Come over to Macedonia and help us (Act 16:9).
                </p>
            </div>

            <!-- Right: Social Icons (always visible) -->
            <div class="flex items-center space-x-2">
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-facebook-f"></i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-twitter"></i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fab fa-instagram"></i>
                </Link>
                <Link
                    href="/"
                    class="w-6 h-6 md:w-8 md:h-8 flex items-center justify-center bg-tertiary text-secondary rounded hover:bg-primary hover:text-tertiary transition"
                >
                    <i class="fas fa-envelope"></i>
                </Link>
            </div>
        </div>

        <!-- Mobile Sidebar / Menu -->
        <div
            v-if="sidebarOpen"
            class="md:hidden mt-2 bg-secondary-dark border-t border-tertiary"
        >
            <Link href="/contact-us" class="block px-4 py-2 hover:bg-primary hover:text-tertiary transition">
                Contact Us
            </Link>
            <Link href="/our-bishop" class="block px-4 py-2 hover:bg-primary hover:text-tertiary transition">
                Our Bishop
            </Link>
        </div>
    </header>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import MobileSideBar from "@/Components/GuestSideBar/MobileSideBar.vue";

const sidebarOpen = ref(false);
</script>
