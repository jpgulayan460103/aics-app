<template>
    <v-card flat>
        <v-card-title>Grievance</v-card-title>
        <v-card-text>


            <v-data-table flat :items="data" class="elevation-1" :headers=headers>
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



            </v-data-table>

        </v-card-text>
    </v-card>
</template>

<script>
export default {
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
        }
    },
    methods:
    {
        getGrievanceList() {
            axios.get(route("api.grievance_list")).then(response => {
                console.log(response.data);
                this.data = response.data.data;
            }).catch(err => console.log(err));
        }
    },
    mounted() {
        this.getGrievanceList();
    }

}
</script>

<style></style>