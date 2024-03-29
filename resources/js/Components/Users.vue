<template>
  <v-row no-gutters>
    <v-col cols="12" sm="4">
      <v-card flat>
        <v-card-title>User Form</v-card-title>
        <v-card-text>
          <v-form ref="form">
            <v-text-field v-model="formData.name" label="Name" :error-messages="formErrors.name"></v-text-field>

            <v-text-field v-model="formData.email" label="E-mail" :error-messages="formErrors.email"></v-text-field>

            <v-select v-model="formData.role" :items="items" label="Role" item-text="role" item-value="value"
              :error-messages="formErrors.role"></v-select>

            <v-text-field v-model="formData.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPassword ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters"
              counter @click:append="showPassword = !showPassword" :error-messages="formErrors.password"></v-text-field>

            <v-text-field v-model="formData.password_confirmation"
              :append-icon="showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPasswordConfirmation ? 'text' : 'password'" name="input-10-1" label="Confirm Password"
              hint="At least 8 characters" counter
              @click:append="showPasswordConfirmation = !showPasswordConfirmation"></v-text-field>

            <v-btn color="primary" class="mr-4" @click="submitForm" :disabled="submit"
              v-if="userData.role == 'Super-Admin'">
              <span>{{ formType }} User</span>
            </v-btn>

            <v-btn color="error" class="mr-4" @click="resetForm">
              <span>Cancel</span>
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>


    <v-col cols="12" sm="8">
      <v-card flat>
        <v-card-title>User Table</v-card-title>
        <v-card-text>
          <v-data-table :headers="headers" :items="users" :items-per-page="5" :loading="loading" class="elevation-1">
            <template v-slot:item.role="{ item }">
              <span>
                {{ userRole(item) }}
              </span>
            </template>

            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editUser(item)" v-if="userData.role == 'Super-Admin'">
                mdi-pencil
              </v-icon>
              <v-icon small class="mr-2" @click="deleteUser(item)" v-if="userData.role == 'Super-Admin'">
                mdi-delete
              </v-icon>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-col>


  </v-row>
</template>

<script>
import axios from 'axios';
import userMixin from './../Mixin/userMixin.js'
import authMixin from './../Mixin/authMixin.js'

import { debounce, cloneDeep, isEmpty } from 'lodash'
export default {
  mixins: [userMixin, authMixin],
  props: ['user'],
  data() {
    return {
      formType: "Create",
      formData: {},
      formErrors: {},
      items: [
        {
          role: "Admin",
          value: "admin",
        },
        {
          role: "Encoder",
          value: "Encoder",
        },
        {
          role: "grievance-officer",
          value: "grievance-officer",
        },
      ],
      showPassword: false,
      showPasswordConfirmation: false,
      headers: [
        { text: 'Name', value: 'name' },
        { text: 'Email Address', value: 'email' },
        { text: 'Role', value: 'role' },
        { text: 'Actions', value: 'actions' },
      ],
      users: [],
      loading: true,
      submit: false,
    };
  },
  methods: {
    submitForm: debounce(function () {
      if (this.formType == "Update") {
        this.updateUser()
      } else {
        this.createUser();
      }
    }, 250),
    createUser() {
      this.submit = true;
      axios.post(route('users.store'), this.formData)
        .then(res => {
          this.submit = false;
          this.getUsers();
          this.resetForm();
          alert('User has been created');
        })
        .catch(err => {
          this.submit = false;
          this.formErrors = err.response.data.errors
        })
    },
    updateUser() {
      this.submit = true;
      this.formErrors = {};
      axios.put(route('users.update', this.formData.id), this.formData)
        .then(res => {
          this.submit = false;
          this.getUsers();
          this.resetForm();
          alert('User has been updated');
        })
        .catch(err => {
          this.submit = false;
          this.formErrors = err.response.data.errors
        })
    },
    resetForm() {
      this.formData = {};
      this.formErrors = {};
      this.formType = "Create";
    },
    getUsers() {
      this.loading = true;
      axios.get(route('users.index'))
        .then(res => {
          this.loading = false;
          this.users = res.data.users;
        })
        .catch(err => {
          this.loading = false;
        })
        ;
    },
    editUser(user) {
      this.formType = "Update";
      this.formData = cloneDeep(user);
      this.formData.role = this.userRole(user);
    },
    deleteUser(user) {
      if (confirm(`Are you sure you want to delete ${user.email}`)) {
        axios.delete(route('users.destroy', user.id))
          .then(res => {
            this.getUsers();
          })
          .catch(err => { })
          ;
      }
    },
  },
  mounted() {
    this.getUsers();
  },
}
</script>

<style></style>