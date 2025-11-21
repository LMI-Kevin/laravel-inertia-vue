<script setup>
import { useForm, Link } from '@inertiajs/vue3'

const credentials = useForm({
    username: '',
    password: ''
})

const register = () => {
    credentials.post('/storeUser')
}

</script>
<template>
    <div class="flex flex-col justify-center items-center h-screen">
        <div class="p-6 shadow-lg rounded-lg text-center w-1/3">
            <h2 class="text-2xl flex">Register</h2>
            <form @submit.prevent="register" class="my-2">
                <label for="username" class="flex">Username:</label>
                <input v-model="credentials.username" class="flex w-full border border-gray-200 rounded-lg p-2 my-3" type="text" id="username" name="username" />
        
                <label for="password" class="flex">Password:</label>
                <input v-model="credentials.password" class="flex w-full border border-gray-200 rounded-lg p-2 my-3" type="password" id="password" name="password" />

                <button class="bg-blue-900 p-2 text-white rounded-lg flex w-full justify-center items-center my-4" type="submit">Register</button>
                <Link href="/login" class="bg-green-900 p-2 text-white rounded-lg flex w-full justify-center items-center mt-4">To Login</Link>
            </form>
        </div>
    </div>
</template>