<template>
    <v-card flat>
        <v-card-title>Grievance</v-card-title>
        <v-card-text>
            <v-data-table dense flat :items="data" class="elevation-1" :headers=headers :loading="isloading">
                <template v-slot:item.created_at="{ item }">
                    {{ item.created_at | formatDate }}
                </template>

                <template v-slot:item.barangay="{ item }">
                    <span v-if="item.psgc"> {{ item.psgc.brgy_name }}</span>
                </template>

                <template v-slot:item.city_muni="{ item }">
                    <span v-if="item.psgc"> {{ item.psgc.city_name }}</span>
                </template>

                <template v-slot:item.province="{ item }">
                    <span v-if="item.psgc"> {{ item.psgc.province_name }}</span>
                </template>

                <template v-slot:item.region="{ item }">
                    <span v-if="item.psgc"> {{ item.psgc.region_name }}</span>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="EditItem(item)">
                        mdi-pencil
                    </v-icon>
                </template>
            </v-data-table>
        </v-card-text>

        <v-dialog v-model="dialog_create" width="80%">
            <v-card color="primary">
                <v-card-title>Grievance
                    <v-spacer></v-spacer>
                    <v-btn icon @click="dialog_create = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <div class="row">
                            <div class="col-md-3">
                                <v-text-field v-model="formData.first_name" label="First Name"
                                    :error-messages="formErrors.first_name"></v-text-field>
                            </div>
                            <div class="col-md-3">
                                <v-text-field v-model="formData.middle_name" label="Middle Name"
                                    :error-messages="formErrors.middle_name"></v-text-field>
                            </div>
                            <div class="col-md-3">
                                <v-text-field v-model="formData.last_name" label="Last Name"
                                    :error-messages="formErrors.last_name"></v-text-field>
                            </div>
                            <div class="col-md-3">
                                <v-text-field v-model="formData.ext_name" label="Ext"
                                    :error-messages="formErrors.ext_name"></v-text-field>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <v-text-field v-model="formData.mobile_number" label="Mobile Number"
                                    :error-messages="formErrors.mobile_number"></v-text-field>
                            </div>
                            <div class="col-md-3">

                                <v-text-field type="date" v-model="formData.birth_date" label="Birth Date"
                                    :error-messages="formErrors.birth_date"></v-text-field>
                            </div>

                            <div class="col-md-3">
                                <v-text-field label="Age " readonly></v-text-field>
                            </div>
                            <div class="col-md-3">
                                <v-select v-model="formData.gender" :items="['Lalake', 'Babae']" label="Gender"
                                    :error-messages="formErrors.gender"></v-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <v-select v-model="formData.civil_status"
                                    :items="['Single', 'Married', 'Common-law', 'Widowed', 'Separated']"
                                    label="Civil Status" :error-messages="formErrors.civil_status"></v-select>
                            </div>

                        </div>

                        <v-btn dark color="primary" class="mr-4" @click="submitForm" :disabled="submit"
                            v-if="userData.role == 'Super-Admin' || userData.role == 'grievance-officer'">
                            SUBMIT
                        </v-btn>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


        <div v-if="userData.role == 'Super-Admin' || userData.role == 'grievance-officer'">
            <v-btn color="primary" :loading="isExporting" @click="downloadClient()">Download</v-btn>
        </div>


    </v-card>
</template>

<script>
import { debounce, cloneDeep, isEmpty } from 'lodash'
import userMixin from './../Mixin/userMixin.js'
import authMixin from './../Mixin/authMixin.js'

export default {
    mixins: [userMixin, authMixin],
    data() {
        return {
            data: [],
            headers: [
                { value: "first_name", text: "First Name", sortable: true },
                { value: "middle_name", text: "Middle Name", sortable: true },
                { value: "last_name", text: "Last Name", sortable: true },
                { value: "ext_name", text: "Ext", sortable: true },
                { value: "birth_date", text: "DOB", sortable: true },
                { value: "barangay", text: "Barangay", sortable: true },
                { value: "city_muni", text: "City/Muni", sortable: true },
                { value: "province", text: "Province", sortable: true },
                { value: "is_verified", text: "Verification Status", sortable: true },
                { value: "actions", text: "Actions" },
            ],
            isloading: false,
            dialog_create: false,
            formErrors: [],
            formData: {},
            submit: false,
            isExporting: false,
        }
    },
    methods:
    {
        getGrievanceList() {
            this.isloading = true;
            axios.get(route("api.grievance_list")).then(response => {
                console.log(response.data);
                this.data = response.data.data;
                this.isloading = false;
            }).catch(err => console.log(err));
        },
        EditItem(item) {
            this.dialog_create = true;
            this.formData = {};
            this.formData = cloneDeep(item);
        },
        submitForm() {
            this.submit = true;
            this.formErrors = {};
            axios.post(route('api.grievance.update', this.formData.id), this.formData)
                .then(res => {
                    this.submit = false;
                    this.getGrievanceList();
                    alert('Client has been updated');
                })
                .catch(err => {
                    this.submit = false;
                    this.formErrors = err.response.data.errors
                })
        },
        downloadClient: debounce(function (status = "unclaimed") {
            this.isExporting = true;
            axios.post(route('api.grievance.export'), { status })
                .then((res) => {
                    this.isExporting = false;
                    window.location.href = res.data.file;
                })
                .catch(err => {
                    console.warn(err);
                    this.isExporting = false;
                });
        }, 250),
    },
    mounted() {
        this.getGrievanceList();
    }

}
</script>

<style></style>