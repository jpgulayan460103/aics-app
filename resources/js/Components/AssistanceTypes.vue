<template>
    <v-card flat>
        <v-card-title>Assistance Type</v-card-title>
        <v-card-text>

            <v-row>
                <v-col>
                    <v-form>
                        <v-text-field v-model="form.name"></v-text-field>

                        <ul>
                            <li v-for="(e,i) in form.subtype">
                                {{ e.name }}
                            </li>
                        </ul>

                        <v-btn color="primary" class="mr-4" @click="submitForm" :disabled="submit"
                            v-if="userData.role == 'Super-Admin'">
                            <span>{{ formType }} Assistance Type</span>
                        </v-btn>

                        <v-btn color="error" class="mr-4" @click="resetForm">
                            <span>Cancel</span>
                        </v-btn>

                    </v-form>
                </v-col>
                <v-col>
                    <v-data-table :headers="headers" :items="types" :items-per-page="5" :loading="loading"
                        class="elevation-1">
                        <template v-slot:item.subtype="{ item }">
                            <ul>
                                <li v-for="(e, i) in item.subtype"> {{ e.name }}</li>
                            </ul>
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-icon small class="mr-2" @click="editType(item)" v-if="userData.role == 'Super-Admin'">
                                mdi-pencil
                            </v-icon>
                            <v-icon small class="mr-2" @click="editType(item)" v-if="userData.role == 'Super-Admin'">
                                mdi-delete
                            </v-icon>
                        </template>


                    </v-data-table>

                </v-col>
            </v-row>
        </v-card-text>
    </v-card>

</template>
<script>
import { debounce, cloneDeep, isEmpty } from 'lodash'
import axios from 'axios';
import userMixin from './../Mixin/userMixin.js'
import authMixin from './../Mixin/authMixin.js'

export default {
    mixins: [userMixin, authMixin],

    data() {
        return {
            form: {},
            types: [],
            headers:
                [{ text: 'Name', value: 'name' },
                { text: 'Subtype', value: 'subtype' },
                { text: 'Actions', value: 'actions' },

                ],
            loading: false,
            formType: "Create",
            submit: false,
        }
    },
    methods:
    {
        submitForm: debounce(function () {
            if (this.formType == "Update") {
                this.updateUser()
            } else {
                this.createUser();
            }
        }, 250),
        getAssistanceTypes() {
            this.loading = true;
            axios.get(route("api.aics.assistance-types")).then(res => {
                console.log(res);
                this.loading = false;
                this.types = res.data;
            }).catch(e => console.log(e));
        },
        editType(item) {
            this.form = cloneDeep(item);
            this.formType = "Update";
        }
        ,
        resetForm() {
            this.form = {};
            this.formErrors = {};
            this.formType = "Create";
        },
    },
    mounted() {
        this.getAssistanceTypes();
    }
}
</script>