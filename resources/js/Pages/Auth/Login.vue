<script setup>
import { usePage, useForm, Link }  from '@inertiajs/vue3'

const page = usePage()

const credentials = useForm({
    username: '',
    password: ''
});

const login = () => {
    credentials.post('/login')
}

</script>
<template>
    <div class="flex flex-col justify-center items-center h-screen">
        <div v-if="page.props.success">{{ page.props.success }}</div>
        <div class="p-6 shadow-lg rounded-lg text-center w-1/3">
            <h2 class="text-2xl flex">Login</h2>
            <form @submit.prevent="login" class="my-2">
                <label for="username" class="flex">Username:</label>
                <input type="text" v-model="credentials.username" class="flex w-full border border-gray-200 rounded-lg p-2 my-3" />
    
                <label for="password" class="flex">Password:</label>
                <input type="password" v-model="credentials.password" class="flex w-full border border-gray-200 rounded-lg p-2 my-3" />
    
                <button type="submit" class="bg-blue-900 p-2 text-white rounded-lg flex w-full justify-center items-center my-4">Login</button>
                <Link href="/register" class="bg-green-900 p-2 text-white rounded-lg flex w-full justify-center items-center mt-4">To Register</Link>
            </form>
        </div>
    </div>
</template>