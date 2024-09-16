<template>
  <q-page class="flex flex-center">
    <q-card class="q-pa-md">
      <q-card-section>
        <div>
          <h5>Login to your account</h5>
        </div>

        <q-form
          @submit.prevent="authenticate('login', formData)"
        >
          <q-input class="mb-2" filled v-model="formData.email" placeholder="Email" :dense="dense" />
          <p v-if="errors.email" class="error">{{ errors.email[0] }}</p>

          <q-input
            filled
            type="password"
            placeholder="Password"
            v-model="formData.password"
            :dense="dense"
          />
          <p v-if="errors.password" class="error">{{ errors.password[0] }}</p>
        </q-form>
      </q-card-section>

      <q-card-actions vertical>
        <q-btn flat color="primary">Login</q-btn>
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const { errors } = storeToRefs(useAuthStore());
const { authenticate } = useAuthStore();

const formData = reactive({
  email: "",
  password: "",
});

onMounted(() => (errors.value = {}));
</script>

<style scoped>

</style>