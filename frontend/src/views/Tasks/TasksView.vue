<script setup>
import { useAuthStore } from "@/stores/auth";
import { useTasksStore } from "@/stores/tasks";
import { ref, onMounted } from "vue";
import DataTable from "../components/DataTable.vue";

const { getUserTasks } = useTasksStore();
const tasks = ref({});
// onMounted(async () => {
//   const res = await fetch("/api/tasks/");
//   tasks.value = await getUserTasks(route.params.id);
// });
</script>

<template>
  <main>
    <div class="header">
      <h1 class="title">My Tasks</h1>
      <button class="round-btn mx-4">+</button>
    </div>
    <div>
      <data-table :tasks="tasks"></data-table>
    </div>
  </main>
</template>

<style scoped>
.header {
  @apply flex items-center mb-4;
}
</style>
