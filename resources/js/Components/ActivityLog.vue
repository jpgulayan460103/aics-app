<template>
    <v-card flat>
        <v-card-title>Logs Name Change</v-card-title>
        <v-card-text>

            <v-data-table flat dense :items="data" :headers="headers" :hide-default-footer="true"
                :items-per-page="10" :loading="isloading">
                <template v-slot:item.created_at="{ item }">
                    {{ item.created_at | formatDate }}
                </template>

            </v-data-table>

            <v-col cols="12" sm="12" md="8" lg="4">
                <v-pagination v-model="currentPage" :length="lastPage" @input = "getLogs" ></v-pagination>
            </v-col>


        </v-card-text>

    </v-card>
</template>

<script>
import userMixin from './../Mixin/userMixin.js'
import authMixin from './../Mixin/authMixin.js'

export default {
    mixins: [userMixin, authMixin],
    props: ['user'],

    data() {
        return {
            data: [],
            headers: [

                {
                    text: 'Date',
                    value: 'created_at',
                },

                {
                    text: 'OLD Name',
                    value: 'properties.old.full_name',
                },
                {
                    text: 'NEW Name',
                    value: 'properties.attributes.full_name',
                },
                {
                    text: 'Updated By',
                    value: 'causer.name',
                },

            ],
            search: "",
            perPage: 20,
            currentPage: 1,
            lastPage: 1,
            isloading: false
        }
    },

    methods: {
        getLogs() {
            this.isloading = true;
            axios.get(route("clients.logs"), {
                params: {
                    search: this.search,
                    page: this.currentPage,
                }
            }).then(response => {
               
                this.data = response.data.data;
                this.isloading = false;
                this.perPage = response.data.per_page;
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;

            }).catch(error => console.log(error))
        }
    },
    mounted() {
        this.getLogs();
    }


}
</script>

<style></style>