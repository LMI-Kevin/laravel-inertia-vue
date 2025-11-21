<script setup>
import AppLayout from '@/Pages/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
    layout: AppLayout
})

const props = defineProps({
    user: Object,
    posts: Array
})

const forEdit = ref(false)

const userDetails = useForm({
    username: props.user.username,
    password: ''
})

</script>
<template>
    <div class="flex flex-col items-center mt-12 mb-12">
        <div class="shadow-lg w-3/4 p-6 rounded-lg">
            <form>
                <label>Username:</label>
                <input
                    type="text"
                    v-model="userDetails.username"
                    class="border p-2 w-full rounded-lg my-2"
                    :disabled="!forEdit"
                />

                <label>Password:</label>
                <input
                    type="password"
                    v-model="userDetails.password"
                    class="border p-2 w-full rounded-lg mt-2"
                    :disabled="!forEdit"
                />
                
                <div class="my-2 flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <label>Edit?</label>
                        <input type="checkbox" @change="forEdit = !forEdit" />
                    </div>
                    <button v-show="forEdit" class="px-2 bg-green-900 rounded-lg text-white">Edit</button>
                </div>
            </form>
        </div>

        <p class="text-2xl mt-8 w-3/4 bg-blue-900 p-4 text-white rounded-lg">Posts</p>

        <div v-for="post in posts" class="flex justify-between w-3/4 p-6 shadow-lg rounded-lg mt-6" :key="post.id">
            <div>
                <p class="text-lg font-bold">{{ post.title }}</p>
                <p><i>{{ post.created_at }}</i></p>
            </div>
            <div>
                <Link :href="`/viewPost/${post.id}`" class="p-2 bg-green-900 text-white rounded-lg">Checkout</Link>
            </div>
        </div>
    </div>
</template>