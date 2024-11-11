<template>
  <div>
    <v-dialog v-model="openModal" small>
      <v-app>
        <v-card>
          <v-card-title>New Payroll</v-card-title>
          <v-card-text>
            <form @submit.prevent="submit" enctype="multipart/form-data" action="">

              <v-row>
                <v-col cols="12" sm="3">
                  <v-text-field v-model="formData.title" label="Title" outlined flat dense tile
                    :error-messages="validationErrors && validationErrors.title ? validationErrors.title[0] : ''"></v-text-field>
                </v-col>

                <v-col cols="12" md="3" sm="12">
                  <v-select v-model="formData.assistance_type" :items="assistance_types" label="Assistance Requested"
                    outlined flat dense tile item-text="name" item-value="id" return-object @change="getSubtypes"
                    :error-messages="validationErrors && validationErrors.assistance_type ? validationErrors.assistance_type[0] : ''">
                  </v-select>
                </v-col>
                <v-col cols="12" sm="3">
                  <div>
                    <v-select v-model="formData.aics_type_subcategory_id" :items="subtypes" :loading="!subtypes"
                      outlined flat dense label="Subtype" item-text="name" item-value="id"
                      :error-messages="validationErrors && validationErrors.aics_type_subcategory_id ? validationErrors.aics_type_subcategory_id[0] : ''"></v-select>

                  </div>
                </v-col>



                <v-col cols="12" sm="3">

                  <v-text-field type="date" v-model="formData.schedule" label="Schedule" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.schedule ? validationErrors.schedule[0] : ''"></v-text-field>


                </v-col>

              </v-row>

              <div class="row mt-2">
                <div class="col-md-3">
                  <v-select label="Region" v-model="region" outlined dense :items="['XI']">
                  </v-select>
                </div>

                <div class="col-md-3">
                  <v-autocomplete v-model="province_name" :loading="psgc_loading" :items="provinces"
                    @change="getCities()" cache-items hide-no-data hide-details label="Province" outlined
                    item-text="province_name" item-value="id" dense></v-autocomplete>
                </div>

                <div class="col-md-3">
                  <v-autocomplete v-model="city_name" :disabled="!cities" :loading="psgc_loading" :items="cities"
                    @change="getBrgys()" hide-no-data hide-details label="City/Municipality" outlined
                    item-text="city_name" item-value="id" dense></v-autocomplete>
                </div>

                <div class="col-md-3">
                  <v-autocomplete v-model="formData.psgc_id" :disabled="!brgys" :loading="psgc_loading" :items="brgys"
                    hide-no-data hide-details label="Barangay" outlined item-text="brgy_name" item-value="id" dense
                    :error-messages="validationErrors && validationErrors.psgc_id ? validationErrors.psgc_id[0] : ''"
                    required></v-autocomplete>


                </div>
              </div>

              <v-row class="py-0">
                <v-col cols="12" md="3" sm="12" xs="12">
                  <v-text-field v-model="formData.amount" label="Amount" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.amount ? validationErrors.amount[0] : ''"></v-text-field>
                </v-col>
                <v-col cols="12" md="3" sm="12" xs="12">

                  <v-text-field v-model="formData.sdo" label="SDO" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.sdo ? validationErrors.sdo[0] : ''"></v-text-field>
                </v-col>

                <v-col cols="12" md="3" sm="12" xs="12">
                  <!--<v-text-field v-model="formData.source_of_fund" label="Fund Source" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.source_of_fund ? validationErrors.source_of_fund[0] : ''"></v-text-field>-->


                  <v-combobox v-model="formData.source_of_fund" clearable outlined dense label="Fund Source"
                    :error-messages="validationErrors && validationErrors.source_of_fund ? validationErrors.source_of_fund[0] : ''"
                    :items="['AKAP','AICS FUND',].sort()"></v-combobox>


                </v-col>

                <v-col cols="12" md="3" sm="12" xs="12">
                  <v-text-field v-model="formData.charging" label="Charging" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.charging ? validationErrors.charging[0] : ''"></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="3" sm="12" xs="12">
                  <v-text-field v-model="formData.approved_by" label="Approving Authority" outlined dense flat tile
                    :error-messages="validationErrors && validationErrors.approved_by ? validationErrors.approved_by[0] : ''"></v-text-field>
                </v-col>

                <v-col cols="12" md="3" sm="12" xs="12">

                  <v-select v-model="formData.status" label="Status" outlined dense flat tile
                    :items="['active', 'closed']"
                    :error-messages="validationErrors && validationErrors.status ? validationErrors.status[0] : ''"></v-select>

                </v-col>
              </v-row>



              <button type="submit" class="btn btn-primary btn-block">
                SUBMIT
              </button>
            </form>
          </v-card-text>
        </v-card>
      </v-app></v-dialog>

    <v-card flat>

      <v-card-title>Payroll <v-spacer />
        <v-progress-circular :width="3" indeterminate color="primary" v-if="isExporting"></v-progress-circular>
        <v-btn class="m-1" @click="NewPayroll()" dark v-if="userData.role == 'Super-Admin' || userData.role == 'admin'">
          New Payroll
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-data-table :headers="headers" :items="payrolls" :items-per-page="50" :loading="isBusy"
          loading-text="Loading... Please wait" :search="search">
          <template v-slot:item.province="{ item }">
            <small> {{ item.psgc.brgy_name }},
              {{ item.psgc.city_name }},
              {{ item.psgc.province_name }}</small>
          </template>


          <template v-slot:item.actions="{ item }">

            <v-icon small class="mr-5" @click="ViewList(item.id)">
              mdi-eye
            </v-icon>

            <v-icon small class="mr-5" @click="EditItem(item)"
              v-if="userData.role == 'Super-Admin' || userData.role == 'admin'">
              mdi-pencil
            </v-icon>

            <v-icon small class="mr-5" @click="DeleteItem(item)" v-if="userData.role == 'Super-Admin'">
              mdi-delete
            </v-icon>


            <v-menu bottom left>
              <template v-slot:activator="{ on, attrs }">

                <v-icon small v-bind="attrs" v-on="on"
                  v-if="userData.role == 'Super-Admin' || userData.role == 'admin'">mdi-download</v-icon>

              </template>

              <v-list>
                <v-list-item link>
                  <v-list-item-title @click="DownloadPayroll(item, 'unclaimed')" :disabled="isExporting">
                    Export (Unclaimed)
                  </v-list-item-title>
                </v-list-item>
                <v-list-item link>
                  <v-list-item-title @click="DownloadPayroll(item)" :disabled="isExporting">
                    Export (CRIMS)
                  </v-list-item-title>
                </v-list-item>
                <v-list-item link>
                  <v-list-item-title @click="exportCoe(item.id, 'pdf')">
                    Export (COE PDF)
                  </v-list-item-title>
                </v-list-item>
                <v-list-item link>
                  <v-list-item-title @click="exportCoe(item.id, 'xlsx')">
                    Export (COE EXCEL)
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>


          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { debounce, cloneDeep } from "lodash";
import userMixin from './../Mixin/userMixin.js'
import authMixin from './../Mixin/authMixin.js'

export default {
  mixins: [userMixin, authMixin],
  props: ['user'],

  data() {
    return {

      openModal: false,
      formData: {
        title: "",
        source_of_fund: "AICS FUND " + new Date().getFullYear(),
      },
      search: "",
      isBusy: false,
      headers: [
        { value: "schedule", text: "Schedule", sortable: true },
        { value: "title", text: "Title", sortable: true },
        { value: "aics_type.name", text: "Assistance Requested", sortable: true },
        { value: "aics_subtype.name", text: "For", sortable: true },
        { value: "sdo", text: "SDO", sortable: true },
        { value: "charging", text: "Charging", sortable: true },
        { value: "province", text: "Venue", sortable: true },
        { value: "amount", text: "AMOUNT", sortable: true },
        { value: "status", text: "STATUS", sortable: true },
        { value: "actions", text: "Actions", sortable: true },
      ],
      payrolls: [],
      provinces: {},
      cities: {},
      regions: {},
      barangays: {},
      region_selector: {},
      province_selector: {},
      city_selector: {},
      validationErrors: {},
      search: "",
      isExporting: false,
      purposes: ["FOOD ASSISTANCE FOR DAILY CONSUMPTION AND OTHER NEEDS",
        "OTHER CASH ASSISTANCE  FOR  FIRE VICTIM",
        "OTHER CASH ASSISTANCE  FOR  FLOOD VICTIM",
        "OTHER CASH ASSISTANCE  FOR  VICTIM OF CALAMITY",
        "EDUCATIONAL ASSISTANCE FOR TUITION FEE",
        "EDUCATIONAL ASSISTANCE FOR OTHER SCHOOL NEEDS"
      ],
      validationErrors: null,
      assistance_types: [],
      region: "XI",
      province_name: "",
      city_name: "",
      cities: [],
      brgys: [],
      psgc_loading: false,
      subtypes: [],
    };
  },
  watch: {
    region_selector(newVal, oldVal) {
      ((this.provinces = {}), (this.cities = {}), (this.barangays = {})),
        (this.provinces = this.groupByKey(newVal, "province_name"));
    },

    province_selector(newVal, oldVal) {
      ((this.cities = {}), (this.barangays = {})),
        (this.cities = this.groupByKey(newVal, "city_name"));
    },

    city_selector(newVal, oldVal) {
      (this.barangays = {}),
        (this.barangays = this.groupByKey(newVal, "brgy_name"));
    },

    /*"formData.assistance_type"(newVal, oldVal) {
      console.log("newVal");
      console.log(newVal);
      console.log("oldVal");
      console.log(oldVal);
      if(newVal != oldVal )
      if (newVal && newVal.subtype && newVal.subtype.length > 0) {
        this.formData.aics_type_subcategory_id = newVal.subtype[0].id;
       // this.formData.title = newVal.name;
      }
    }*/




  },
  methods: {
    submit() {
      this.isBusy = true;
      if (this.formData.id > 0) {
        axios
          .post(route("api.payroll.update", this.formData.id), this.formData)
          .then((response) => {
            //console.log(response.data);
            this.isBusy = false;
            alert(response.data.Message);
            this.getPayrolls();
            this.openModal = false;
          })
          .catch((error) => {
            if (error.response && error.response.status == 422) {
              this.validationErrors = error.response.data.errors;
            }

          });
      } else {
        axios
          .post(route("api.payroll.create"), this.formData)
          .then((response) => {
            this.isBusy = false;
            this.data = response.data;
            alert(response.data.Message);
            if (response.data.Message == "Saved") {
              this.getPayrolls();
              this.openModal = false;
            } else {
              if (response.data.Message.errorInfo) {
                alert(response.data.Message.errorInfo[2]);
              } else {
                alert(response.data.Message);
              }
            }
          })
          .catch((error) => {
            if (error.response && error.response.status == 422) {
              this.validationErrors = error.response.data.errors;
            }
          });
      }
    },
    getPayrolls() {
      axios.get(route("api.payroll.index")).then((response) => {
        this.payrolls = response.data;
      });
    },
    NewPayroll() {
      this.formData = {
        title: "",
        source_of_fund: "AICS FUND " + new Date().getFullYear()
      };
      this.province_name = "";
      this.city_name = "";
      this.validationErrors = null;
      this.subtypes = [];
      this.openModal = true;
    },
    EditItem(e) {
      this.formData = {
        assistance_type: { id: null }
      };
      this.validationErrors = null;
      this.subtypes = [];
      this.formData = cloneDeep(e);
      console.log(e);
      this.openModal = true;


      if (this.formData.psgc) {
        this.province_name = this.formData.psgc.province_name;
        this.getCities();
        this.city_name = this.formData.psgc.city_name;
        this.getBrgys();

      }

      if (this.formData.aics_type_id) {
        this.formData.assistance_type = this.assistance_types.find(type => {
          return type.id === this.formData.aics_type_id
        });

        this.getSubtypes();


      }




    },
    DeleteItem(e) {
      let x = confirm("Delete this Payroll?");
      if (x) {
        axios
          .post(route("api.payrolls.delete", e.id))
          .then((response) => {
            // console.log(response.data);
            if (response.data.Message == "Deleted") {
              alert(response.data.Message);
              this.getPayrolls();
            } else {
              alert(response.data.Message);
            }
          })
          .catch((error) => console.log(error));
      } else {
        alert("Cancelled");
      }
    },
    DownloadPayroll: debounce(function (payroll, status = "claimed") {
      this.isExporting = true;
      axios.post(route('api.payroll.export', payroll.id), { status })
        .then((res) => {
          this.isExporting = false;
          window.location.href = res.data.file;
        })
        .catch(err => {
          console.warn(err);
          this.isExporting = false;
        });
    }, 250),
    ViewList(id) {
      //this.$router.push("payroll/" + id);
      this.$router.push({ name: "payroll_list", params: { id: id } });
    },
    getPsgc() {
      axios
        .get(route("api.psgc.show", "brgy"), {
          params: {
            field: "region_psgc",
            value: this.region_selector[0].region_psgc,
          },
        })
        .then((response) => {
          this.psgc = response.data;
          this.provinces = this.groupByKey(this.psgc, "province_name");
        });
    },
    groupByKey(array, key) {
      return array.reduce((hash, obj) => {
        if (obj[key] === undefined) return hash;
        return Object.assign(hash, {
          [obj[key]]: (hash[obj[key]] || []).concat(obj),
        });
      }, {});
    },
    exportCoe(id, ext) {
      window.open(route("pdf.payroll.print_coe", { id, _query: { ext } }));
    },
    getAssistanceTypes() {
      axios.get(route("api.aics.assistance-types")).then((response) => {
        this.assistance_types = response.data;
      });
    },
    getProvinces() {
      axios.get(route("api.psgc.show", "province")).then((response) => {
        this.provinces = response.data;

      });
    },
    getCities() {
      this.cities = [];
      this.brgys = [];
      this.psgc_loading = true;
      axios.get(route("api.psgc.show", { type: "cities", field: "province_name", value: this.province_name })).then(response => {
        this.cities = response.data;
        this.psgc_loading = false;
      }).catch(error => { console.log(error); this.psgc_loading = false; });
    },
    getBrgys() {
      this.loading = true;
      let fields = [{ field: "city_name", value: this.city_name }, { field: "province_name", value: this.province_name, }];

      axios.get(route("api.psgc.show", { type: "brgy", fields })).then(response => {
        this.brgys = response.data;
        this.loading = false;
      }).catch(error => { console.log(error); this.loading = false; });

    },
    getSubtypes() {
      this.loading = true;
      this.formData.aics_type_subcategory_id = null;
      this.formData.aics_subtype = {};

      axios.get(route("assistances.subtypes.show", { id: this.formData.assistance_type.id })).then(response => {
        this.subtypes = response.data.subtype;
      }).catch(error => { console.log(error); this.loading = false; })
    }


  },
  mounted() {
    this.getProvinces();
    this.getAssistanceTypes();
    this.getPayrolls();

  },
};
</script>

<style></style>