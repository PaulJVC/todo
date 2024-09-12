<script setup>
import { RouterLink, RouterView } from "vue-router";
import { useAuthStore } from "./stores/auth";
import { ref } from "vue";

const authStore = useAuthStore();

const tab = ref('');
const leftDrawerOpen = ref(false);

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};
</script>

<template>
  <q-layout view="hHh lpR fFf"> <!-- Layout configuration -->
    <!-- Header with a toolbar inside -->
    <q-header elevated>
      <q-toolbar>
        <!-- Optional: Left-side menu button -->
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="toggleLeftDrawer" />
        
        <!-- Navbar title -->
        <q-toolbar-title>
          My Quasar App
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <q-list>
        <q-item clickable v-ripple :to="{ name: 'home' }">
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            Home
          </q-item-section>
        </q-item>
        <template v-if="authStore.user">
          <q-item clickable v-ripple :to="{ name: 'tasks' }">
            <q-item-section avatar>
              <q-icon name="list_alt" />
            </q-item-section>
            <q-item-section>
              My Tasks
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple :to="{ name: 'create' }">
            <q-item-section avatar>
              <q-icon name="add_task" />
            </q-item-section>
            <q-item-section>
              Create Task
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple @click="authStore.logout">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>
            <q-item-section>
              Logout
            </q-item-section>
          </q-item>
        </template>
        <template v-else>
          <q-item clickable v-ripple :to="{ name: 'register' }">
            <q-item-section avatar>
              <q-icon name="how_to_reg" />
            </q-item-section>
            <q-item-section>
              Register
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple :to="{ name: 'login' }">
            <q-item-section avatar>
              <q-icon name="login" />
            </q-item-section>
            <q-item-section>
              Login
            </q-item-section>
          </q-item>
        </template>
        <!-- Add more items as needed -->
      </q-list>
    </q-drawer>

    <q-page-container>
        <RouterView />
    </q-page-container>
  </q-layout>
  <!-- <header>
    <div class="q-pa-md">
      <q-toolbar class="bg-purple text-white shadow-2 rounded-borders">
        <q-btn flat :to="{ name: 'home' }" name="home" label="Homepage"></q-btn>
        <q-space />
        
        <q-tabs v-model="tab" shrink>
          <template v-if="authStore.user">
            <q-tab :to="{ name: 'create'}" name="create" label="Create Task"></q-tab>
            <q-tab @click="authStore.logout" name="logout" label="Logout"></q-tab>
          </template>
          <template v-else>
            <q-tab :to="{ name: 'register'}" name="register" label="Register"></q-tab>
            <q-tab :to="{ name: 'login'}" name="login" label="Login"></q-tab>
          </template>
        </q-tabs>
      </q-toolbar>
    </div>
    <nav>
      <RouterLink :to="{ name: 'home' }" class="nav-link">Home</RouterLink>

      <div v-if="authStore.user" class="flex items-center space-x-6">
        <p class="text-sm text-slate-300"></p>

        <RouterLink :to="{ name: 'create'}" class="nav-link">Create Task</RouterLink>

        <form @submit.prevent="authStore.logout">
          <button class="nav-link">Logout</button>
        </form>
      </div>

      <div v-else class="space-x-6">

        <RouterLink :to="{ name: 'register' }" class="nav-link"> Register </RouterLink>

        <RouterLink :to="{ name: 'login' }" class="nav-link"> Login </RouterLink>

      </div>
    </nav>
  </header> -->
</template>
