import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

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
        const res = await fetch(`/api/task/user/${user}`, {
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
        });
        const data = await res.json();
        if(res.ok) {
          console.log(data, 'getUserTask')
          this.tasks = data
        }
      }
    },
    /******************* Get specific task *******************/
    async getTask(id) {
      if (localStorage.getItem("token")) {
        const res = await fetch(`/api/task/${id}`, {
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
        });
        const data = await res.json();
        if(res.ok) {
          console.log(data, 'getTask');
          return data;
        }
      }
    },
    /******************* Download Attachment *******************/
    async downloadAttachment(id) {
      if (localStorage.getItem("token")) {
        const res = await fetch(`/api/task/download/${id}`, {
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
        if(!res.ok) {
          throw new Error("Failed to download file");
        }
        const blob = await res.blob();
        const downloadUrl = URL.createObjectURL(blob);

        // Extract filename from Content-Disposition header
        const fileName = res.headers
          .get("Content-Disposition")
          ?.split("filename=")[1]
          ?.replace(/"/g, "") || "downloaded-file";

        // Create a link and trigger download
        const link = Object.assign(document.createElement("a"), {
          href: downloadUrl,
          download: fileName,
        });

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(downloadUrl);
      }
    },
    /******************* Create Task *******************/
    async createUserTask(data) {
      const formData = new FormData();
      formData.append('title', data.title);
      formData.append('description', data.description);
      formData.append('due_date', data.due_date);

      if (data.attachment) {
        formData.append('attachment', data.attachment);
      }
      if (data.priority) {
        formData.append('priority', data.priority);
      }
      if (data.tags) {
        formData.append('tags', data.tags);
      }

      if (localStorage.getItem("token")) {
        const res = await fetch("/api/task", {
          method: "POST",
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: formData
        })
        
        if(res.status === 422) {
          const errorData = await res.json();
          this.errors = errorData.errors;
          console.error('Validation errors:', errorData);
        }else {
          const responseData = await res.json();
          console.log('Success:', responseData);
          this.router.push({ name: "home" });
          this.errors = {};
        }
      }
    },
    /******************* Edit Task *******************/
    async updateUserTask(task, form) {
      const formData = new FormData();
      const authStore = useAuthStore();

      console.log(form, 'form in updateUserTask');

      Object.entries(form).forEach(([key, value]) => {
        if (Array.isArray(value)) {
          // Handle arrays (e.g., tags)
          value.forEach((item) => formData.append(`${key}[]`, item));
        } else if (value instanceof File || value instanceof Blob) {
          // Handle file inputs
          formData.append(key, value);
        } else {
          // Handle all other types of values
          formData.append(key, value);
        }
      });

      for (const [key, value] of formData.entries()) {
        console.log(key, value, 'after formData.append()');
      }

      if (authStore.user.id === task.tasks.user_id) {
        const res = await fetch(`/api/task/${task.tasks.id}`, {
          method: "POST",
          headers: {
            authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: formData
        })

        if(!res.ok) {
          const errorData = await res;
          this.errors = errorData.errors;
          console.error('Validation errors:', errorData);
        }else {
          const responseData = await res;
          console.log('Success:', responseData);
          this.router.push({ name: "home" });
          this.errors = {};
        }
      }
    },
    /******************* Delete Task *******************/
    async deleteUserTask(id) {
      const res = await fetch(`/api/task/delete/${id}`, {
        method: "PUT",
        headers: {
          authorization: `Bearer ${localStorage.getItem("token")}`,
          "Content-Type": "application/json"
        },
      })
      
      if(!res.ok) {
        const errorData = await res;
        this.errors = errorData.errors;
        console.error('Errors:', errorData);
      }else {
        const responseData = await res;
        console.log('Success:', responseData);
        this.router.push({ name: "home" });
        this.errors = {};
      }
    }
  }
});