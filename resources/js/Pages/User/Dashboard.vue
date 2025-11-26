<script setup>
import { router, useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Pages/Layouts/AppLayout.vue'

const image = ref(null)
const imagePreview = ref(null)

defineOptions({
    layout: AppLayout
})

defineProps({
    posts: Array
})

const toPost = useForm({
    title: '',
    content: '',
    image: null
})

const submitPost = () => {
    if(image.value?.files[0]) {
        toPost.image = image.value.files[0]
    }

    // console.log(toPost)
    toPost.post('/submitPost', {
        forceFormData: true,
        onSuccess: () => {
            toPost.reset('title', 'content', 'image')
            image.value.value = ''
            router.reload()
        }
    })
}

const handleImageChange = (e) => {
    const file = e.target.files[0]
    if(!file) return

    toPost.image = file
    imagePreview.value = URL.createObjectURL(file)
}

</script>
<template>
    <div class="flex flex-col items-center mt-12 mb-12">
        <div class="shadow-lg rounded-lg p-4 w-3/4 bg-white">
            <form @submit.prevent="submitPost">
                <label>Title:</label>
                <input type="text" v-model="toPost.title" class="flex border rounded-lg w-full p-2 my-2" />

                <label>Content:</label>
                <textarea v-model="toPost.content" class="flex border rounded-lg w-full p-2 my-2"></textarea>
                
                <img :src="imagePreview" class="w-full my-2 rounded-lg" />
                <input type="file" class="flex border rounded-lg w-full p-2" ref="image" @change="handleImageChange" accept="image/*" />
                <button type="submit" class="flex bg-blue-900 rounded-lg w-full justify-center text-white mt-5 p-1">Post</button>
            </form>
        </div>
        <p class="text-2xl mt-8 w-3/4 bg-blue-900 p-4 text-white rounded-lg">Posts</p>
        
        <div v-for="post in posts" class="flex justify-between items-center shadow-lg rounded-lg p-4 w-3/4 mt-6 bg-white" :key="post.id">
            <div>
                <h1 class="text-sm"><i>{{ post.username }}</i></h1>
                <h1 class="text-lg font-bold">{{ post.title }}</h1>
                <h1 class="text-sm"><i>{{ post.created_at }}</i></h1>
            </div>
            <div>
                <Link :href="`/viewPost/${post.id}`" class="p-2 bg-green-900 text-white rounded-lg">Checkout</Link>
            </div>
        </div>
    </div>
</template>