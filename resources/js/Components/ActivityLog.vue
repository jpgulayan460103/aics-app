<template>
    <v-card flat>
        <v-card-title>Logs Name Change</v-card-title>
        <v-card-text>

            <v-data-table flat :items="data" class="elevation-1" :headers=headers>
                <template v-slot:item.created_at="{ item }">
                    {{ item.created_at | formatDate }}
                </template>

            </v-data-table>
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





            ]
        }
    },

    methods: {
        getLogs() {
            axios.get(route("clients.logs")).then(response => {
                console.log(response.data);
                this.data = response.data.data;
            }).catch(error => console.log(error))
        }
    },
    mounted() {
        this.getLogs();
    }


}
</script>

<style></style>