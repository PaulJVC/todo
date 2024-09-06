<script setup>
import { useAuthStore } from "@/stores/auth";
import { ref, onMounted } from "vue";

const authStore = useAuthStore();
</script>

<template>
  <main>
    <h1 class="title">
      Welcome
      <span v-if="authStore.user">{{ authStore.user.name }}</span>
      <span v-else></span>
    </h1>
  </main>
</template>
