<script setup>
defineProps({
  tasks: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="container">
    <table>
      <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date Due</th>
        <th>Priority</th>
        <th>Tags</th>
        <th>Attachments</th>
        <th>
          <span>Actions</span>
        </th>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          {{
            task.id
          }}
        </tr>
      </tbody>
    </table>
  </div>
</template>
