import { defineStore } from "pinia";

export const useTasksStore = defineStore("tasksStore", {
  state: () => {
    return {
      tasks: null,
      errors: {},
    };
  },
  actions: {
    /******************* Get tasks for user *******************/
    async getUserTasks(user) {
        if (localStorage.getItem("token")) {
          const res = await fetch(`/api/tasks/${user}`);
          const data = await res.json();
          return data
        }
      },
    /******************* Create Task *******************/
    async createUserTask(formData) {
      if (localStorage.getItem("token")) {
        const res = await fetch("/api/create", {
          headers: {
            method: 'post',
            authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: JSON.stringify(formData)
        });
        const data = await res.json();

        if (data.errors) {
          this.errors = data.errors;
        } else {
          this.router.push({ name: "home" });
          this.errors = {}
        }
      }
    },
  }
});