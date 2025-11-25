<script setup>
import AppLayout from '@/Pages/Layouts/AppLayout.vue'
import { router, useForm, Link } from '@inertiajs/vue3'
import { reactive, ref, computed } from 'vue'

const alert = ref();

defineOptions({
    layout: AppLayout
})

const props = defineProps({
    comments: Array,
    post: Array,
    user: Object
})

const postDetails = reactive({ ...props.post[0] })
const postForm = useForm({
    title: props.post[0].title,
    content: props.post[0].content,
})

const commentForm = useForm({
    comment: ''
})

const comments = computed(() => props.comments )

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

const postComment = () => {
    commentForm.post(`/postComment/${postDetails.id}`, {
        onSuccess: () => {
            commentForm.comment = ""
            router.reload()
        }
    })
}

const deleteComment = (commentId) => {
    console.log(postDetails.id)
    // router.delete(`/deleteComment/${commentId}/${postDetails.id}`)
    // router.reload()
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
                        <button type="submit" class="bg-red-900 rounded-lg p-2 w-full text-center text-white">Delete</button>
                    </form>
                </div>
            </form>
        </div>
        <div class="w-3/4 shadow-lg p-6 rounded-lg">
            <form @submit.prevent="postComment">
                <div class="flex gap-3 justify-center items-end">
                    <textarea v-model="commentForm.comment" class="border p-2 w-full rounded-lg mt-2"></textarea>
                    <button type="submit" class="bg-green-900 rounded-lg text-white text-xs p-1">Post Comment</button>
                </div>
            </form>
            <p class="my-2"><i>Comments:</i></p>
            <div v-for="comment in comments" class="flex justify-between items-center border rounded-lg my-2 p-3">
                <div>
                    <p><b>{{ comment.username }}</b> - {{ comment.comment }}</p>
                </div>
                <div v-if="comment.commenter == postDetails.author">
                    <form @submit.prevent="deleteComment(comment.id)">
                        <button class="p-2 m-2 text-xs rounded-lg bg-red-900 text-white">Delete Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>