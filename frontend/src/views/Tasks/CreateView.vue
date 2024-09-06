<script setup>
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const formData = reactive({
  title: "",
  description: "",
  due_date: "",
  priority: "",
  attachment: {},
  tags: {"Hello", "World"},
});

onMounted(() => (errors.value = {}));

const handleFileUpload = (event) => {
  formData.attachment.value = event.target.files[0];
};
</script>

<template>
  <main>
    <h1 class="title">Create a new task</h1>

    <form
      @submit.prevent="authenticate('register', formData)"
      class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input type="text" placeholder="Title" v-model="formData.title" />
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
      </div>

      <div>
        <input type="date" placeholder="Due Date" v-model="formData.due_date" />
        <p v-if="errors.due_date" class="error">{{ errors.due_date[0] }}</p>
      </div>

      <div>
        <select name="Priority" v-model="formData.priority">
          <option value="0">Select a priority</option>
          <option value="1">Low</option>
          <option value="2">Normal</option>
          <option value="3">High</option>
          <option value="4">Urgent</option>
        </select>
        <p v-if="errors.priority" class="error">{{ errors.priority[0] }}</p>
      </div>

      <div>
        <label for="file">Upload a file</label>
        <input type="file" name="file" @change="handleFileUpload" />
      </div>

      <div>
        <input type="text" placeholder="Enter a Tag" v-model="formData.due_date" />
        <p v-if="errors.due_date" class="error">{{ errors.due_date[0] }}</p>
      </div>

      <button class="primary-btn">Register</button>
    </form>
  </main>
</template>
