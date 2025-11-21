<script setup>
import { Link } from '@inertiajs/vue3'
</script>
<template>
    <div>
        <nav class="bg-black text-white p-4 flex gap-6 fixed top-0 w-full flex-end">
            <Link href="/">Dashboard</Link>
            <Link href="/profile">Profile</Link>
            <Link href="/login">Logout</Link>
        </nav>

        <main class="mt-24">
            <slot />
        </main>
    </div>
</template>