<script setup>
import { useAuthStore } from "@/stores/auth";
import { useTasksStore } from "@/stores/tasks";
import { storeToRefs } from "pinia";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const { user } = storeToRefs(useAuthStore());
const { errors } = storeToRefs(useTasksStore());
const { getTask, updateUserTask, downloadAttachment } = useTasksStore();

const router = useRouter();
const route = useRoute();

const task = ref(null);

const formData = reactive({
  title: "",
  description: "",
  due_date: "",
  priority: "",
  attachment: "",
  tags: "",
  completed: "",
})

const newTag = ref('');
const fileUrl = ref('');
const fileName = ref('');

const handleFileUpload = (event) => {
  formData.attachment = event.target.files[0];
};

const addTag = () => {
  if (newTag.value.trim() && !formData.tags.includes(newTag.value)) {
    formData.tags.push(newTag.value.trim());
  }
  newTag.value = ''; // Reset input
};

const removeTag = (index) => {
  formData.tags.splice(index, 1);
}

onMounted(async () => {
  errors.value = {}
  
  task.value = await getTask(route.params.id);
  fileUrl.value = task.value.fileURL;
  fileName.value = task.value.fileName;

  console.log(task.value.tasks.title, task.value.tasks.description, task.value.fileURL, 'task value')

  if (task.value.tasks.user_id !== user.value.id) {
    router.push({ name: "home" });
  } else {
    formData.title = task.value.tasks.title;
    formData.description = task.value.tasks.description;
    formData.due_date = task.value.tasks.due_date;
    formData.priority = task.value.tasks.priority_id;
    formData.tags = task.value.tasks.tags.split(',');
    formData.completed = task.value.tasks.completed ? true : false;
  }
});

</script>

<template>
  <main>
    <h1 class="title">Update this task</h1>

    <form
      @submit.prevent="updateUserTask(task, formData)"
      class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input type="text" placeholder="Title" v-model="formData.title" />{{ formData.title }}
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
      </div>

      <div>
        <input type="text" placeholder="Description" v-model="formData.description" />{{ formData.description }}
        <p v-if="errors.description" class="error">{{ errors.description[0] }}</p>
      </div>

      <div>
        <VueDatePicker placeholder="Due Date" v-model="formData.due_date" model-type="yyyy-MM-dd" format="yyyy-MM-dd" type="date" :lowerLimit="new Date()"></VueDatePicker>
        <p v-if="errors.due_date" class="error">{{ errors.due_date[0] }}</p>
      </div>

      <div>
        <select name="Priority" v-model="formData.priority">
          <option value="" disabled selected>Select a priority</option>
          <option value="1">Low</option>
          <option value="2">Normal</option>
          <option value="3">High</option>
          <option value="4">Urgent</option>
        </select>
      </div>

      <div>
        <label for="file">Upload a file</label>
        <input type="file" name="file" @change="handleFileUpload" />
        <p v-if="errors.attachment" class="error">{{ errors.attachment[0] }}</p>
      </div>

      <div v-if="fileUrl">
        <p>Uploaded File:</p>
        <!-- <a :href="fileUrl" target="_blank">View File</a> -->
        <q-btn @click="downloadAttachment(task.tasks.id)">{{ fileName }}</q-btn>
      </div>

      <div>
        <q-input
          v-model="newTag"
          label="Enter Tags"
          @keydown.enter.prevent="addTag"
          @keydown.prevent.tab="addTag"
          dense
          type="text"
        >
        </q-input>

        <div class="q-mt-md">
          <q-chip
            v-for="(tag, index) in formData.tags"
            :key="index"
            removable
            @remove="removeTag(index)"
            class="q-mr-xs"
            color="primary"
            outline
          >
            {{ tag }}
          </q-chip>
        </div>
      </div>

      <div>
        <label for="completed">Completed?</label>
        <q-checkbox name="completed" v-model="formData.completed" />
      </div>

      <button class="primary-btn">Submit</button>
    </form>
  </main>
</template>

<style scoped>
.dp__theme_light {
    --dp-background-color: #fff;
    --dp-text-color: #0c4a6e;
    --dp-hover-color: #f3f3f3;
    --dp-hover-text-color: #7dd3fc;
    --dp-hover-icon-color: #7dd3fc;
    --dp-primary-color: #1976d2;
    --dp-primary-disabled-color: #6bacea;
    --dp-primary-text-color: #1976d2;
    --dp-secondary-color: #7dd3fc;
    --dp-border-color: #7dd3fc;
    --dp-menu-border-color: #ddd;
    --dp-border-color-hover: #3c82aa;
    --dp-border-color-focus: #5ab0e2;
    --dp-disabled-color: #f6f6f6;
    --dp-scroll-bar-background: #f3f3f3;
    --dp-scroll-bar-color: #959595;
    --dp-success-color: #76d275;
    --dp-success-color-disabled: #a3d9b1;
    --dp-icon-color: #0ea5e9;
    --dp-danger-color: #ff6f60;
    --dp-marker-color: #ff6f60;
    --dp-tooltip-color: #1976d2;
    --dp-disabled-color-text: #0ea5e9;
    --dp-highlight-color: rgb(25 118 210 / 10%);
    --dp-range-between-dates-background-color: var(--dp-hover-color, #f3f3f3);
    --dp-range-between-dates-text-color: var(--dp-hover-text-color, #212121);
    --dp-range-between-border-color: var(--dp-hover-color, #f3f3f3);
}
</style>
