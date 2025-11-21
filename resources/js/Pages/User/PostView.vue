<script setup>
import AppLayout from '@/Pages/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'

const alert = ref();

defineOptions({
    layout: AppLayout
})

const props = defineProps({
    post: Array,
    user: Object
})

const postDetails = reactive({ ...props.post[0] })
const postForm = useForm({
    title: props.post[0].title,
    content: props.post[0].content,
})

const editPost = () => {
    postForm.put(`/editPost/${postDetails.id}`, {
        onSuccess: () => {
            alert.value = "Successfully Edited Post!"
        }
    })
}

const deletePost = () => {
    if(confirm('Delete Post?')) {
        postForm.delete(`/deletePost/${postDetails.id}`)
    }
}

</script>
<template>
    <div class="flex flex-col items-center mt-12 mb-12">
        <p>{{ alert }}</p>
        <div class="w-3/4 shadow-lg p-6 rounded-lg" v-if="user.id != postDetails.author">
            <p class="mb-6">{{ postDetails.username }} - {{ postDetails.created_at }}</p>
            <p class="text-2xl font-bold">{{ postDetails.title }}</p>
            <p class="">{{ postDetails.content }}</p>
        </div>
        <div class="w-3/4 shadow-lg p-6 rounded-lg" v-else>
            <p class="mb-6">{{ postDetails.username }} - {{ postDetails.created_at }}</p>
            <form @submit.prevent="editPost">
                <label>Title:</label>
                <input
                    type="text"
                    v-model="postForm.title"
                    class="border p-2 w-full rounded-lg my-2"
                />
                <label>Content:</label>
                <input
                    type="text"
                    v-model="postForm.content"
                    class="border p-2 w-full rounded-lg mt-2"
                />
                <div class="flex mt-2 gap-1">
                    <button class="bg-blue-900 rounded-lg p-2 w-full text-white">Edit</button>
                    <form @submit.prevent="deletePost">
                        <button type="submit" class="bg-green-900 rounded-lg p-2 w-full text-center text-white">Delete</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</template>