<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";
import { useTasksStore } from "@/stores/tasks";

const { tasks } = storeToRefs(useTasksStore());
const { getUserTasks, deleteUserTask } = useTasksStore();
const authStore = useAuthStore();

getUserTasks(authStore.user.id)
const listTask = tasks;

const onDelete = () => {
  deleteUserTask();
}

const sortOptions = [
  { label: 'Due Date', value: 'due_date' },
  { label: 'Priority', value: 'priority' },
  { label: 'Title', value: 'title' },
  { label: 'Order', value: 'order' }
];

const columns = [
  {
    name: 'title',
    required: true,
    align: 'left',
    field: row => row.title,
    format: val => `${val}`,
    sortable: true,
    label: 'Title'
  },
  { name: 'description', align: 'center', label: 'description', field: row => row.description },
  { name: 'due_date', label: 'Due Date', sortable: true, field: row => row.due_date },
  { name: 'priority', label: 'Priority', field: row => row.name },
  { name: 'attachment', label: 'Attachment', field: row => row.attachment_name },
  { name: 'tags', label: 'Tags', field: row => row.tags },
  { name: 'actions', label: 'Actions' }
]
</script>

<template>
  <main>
    <div class="q-pa-xl">
      <q-table
        title="My Tasks"
        :rows="listTask"
        :columns="columns"
        row-key="name"
        :pagination="{
          sortBy: 'title'
        }"
      >
        <template v-slot:body-cell-actions="props">
          <q-td :props="props">
            <q-btn icon="mode_edit" :to="{ name: 'update', params: { id: props.row.id } }"></q-btn>
            <q-btn icon="delete" @click="onDelete(props.row.id)"></q-btn>
          </q-td>
        </template>
      </q-table>
    </div>
  </main>
</template>

