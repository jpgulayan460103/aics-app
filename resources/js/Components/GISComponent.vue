<template>
  <v-app>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 text-center">
            <img max-height="64" max-width="250px" src="/images/DSWD-DVO-LOGO.png" class="img-fluid" />
          </div>
          <div class="col-md-8 text-md-end text-center">
            <h1 style="font-size: 2rem;
              font-family: arial;
              font-weight: bold;
              margin-bottom: 0px;">
              CRISIS INTERVENTION DIVISION
            </h1>
            <p>
              IBP Road, Batasan Pambansa Complex Constitution Hills, Quezon City
            </p>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-12">
            <img src="" />

            <h2 style="font-family: 'Arial black', sans-serif; margin-bottom: 0px">
              GENERAL INTAKE SHEET<br />
            </h2>
            <p>MAARING MAGPATULONG SUMAGOT SA DSWD PERSONNEL</p>
          </div>
        </div>


        <!--<<div class="card mt-2">
          <div class="card-title">
            NAIS HINGIIN NA TULONG (Assistance Requested)
            <span color="red"></span>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              select name="assistance_type" v-model="form.aics_type_id" class="form-control" @change="getRequirements" readonly>
                <option :value="e.id" v-for="e in assistance_types" :key="e.id">
                  {{ e.name }}
                </option>
              </select>

              <div v-if="validationErrors && validationErrors.aics_type_id" style="color: red">
                  {{ validationErrors.aics_type_id[0] }}
                </div>

            </div>
          </div>
        </div>-->

        <div class="card mt-2">
          <div class="card-title">
            IMPORMASYON NG BENEPISYARYO (Beneficiary's Identifying Information)
          </div>
          <div class="card-body">
            <div class="container-fluid">
              <!--<div class="row" v-if="">
              <div class="col-md-3">
                <label for="last_name">
                  Apelyido <small>(Last name) <span color="red"></span></small>
                </label>
                <input id="last_name" v-model="form.last_name" type="text" class="form-control" />
                <div v-if="validationErrors && validationErrors.last_name" style="color: red">
                  {{ validationErrors.last_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="first_name">
                  Unang Pangalan
                  <small>(First name) <span color="red"></span></small></label>
                <input id="first_name" v-model="form.first_name" type="text" class="form-control" />

                <div v-if="validationErrors && validationErrors.first_name" style="color: red">
                  {{ validationErrors.first_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="middle_name">Gitnang Pangalan <small>(Middle name)</small></label>
                <input id="middle_name" v-model="form.middle_name" type="text" class="form-control" />

                <div v-if="validationErrors && validationErrors.middle_name" style="color: red">
                  {{ validationErrors.middle_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="ext_name">Ext <small>(Sr.,Jr., II, III)</small></label><br />
                <select id="ext_name" v-model="form.ext_name" type="text" class="form-control" :class="{
                  'is-invalid':
                    validationErrors.ext_name && validationErrors.ext_name,
                }">
                  <option value=" "> </option>
                  <option value="JR">JR</option>
                  <option value="SR">SR</option>
                  <option value="I">I</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="IV">IV</option>
                  <option value="V">V</option>
                  <option value="VI">VI</option>
                </select>

                <div v-if="validationErrors && validationErrors.ext_name" style="color: red">
                  {{ validationErrors.ext_name[0] }}
                </div>
              </div>
            </div>-->
              <div class="row" v-if="userData.role != 'Super-Admin'">

                <div class="col-md-3 underline">
                  <label for="">Last Name</label><br>
                  {{ form.last_name }}
                </div>
                <div class="col-md-3 underline">
                  <label for="">First Name</label><br>
                  {{ form.first_name }}
                </div>
                <div class="col-md-3 underline">
                  <label for="">Middle Name</label><br>
                  {{ form.middle_name }}
                </div>
                <div class="col-md-3 underline">
                  <label for="">Ext. Name</label><br>
                  {{ form.ext_name }}
                </div>

              </div>
              <div class="row" v-else>
                <div class="col-md-3">
                  <label for="last_name">Last Name</label>
                  <input id="last_name" v-model="form.last_name" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.last_name" style="color: red">
                    {{ validationErrors.last_name[0] }}
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="first_name">First Name</label>
                  <input id="first_name" v-model="form.first_name" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.first_name" style="color: red">
                    {{ validationErrors.first_name[0] }}
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="middle_name">Middle Name</label>
                  <input id="middle_name" v-model="form.middle_name" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.middle_name" style="color: red">
                    {{ validationErrors.middle_name[0] }}
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="ext_name">Ext Name</label>
                  <input id="ext_name" v-model="form.ext_name" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.ext_name" style="color: red">
                    {{ validationErrors.ext_name[0] }}
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-12">
                  <label for="street_number">House No./Street/Purok
                    <small>(Ex. 123 Sun St.)</small>
                    <span color="red"></span>
                  </label>
                  <input id="street_number" v-model="form.street_number" class="form-control" type="text" />

                  <div v-if="validationErrors && validationErrors.street_number" style="color: red">
                    {{ validationErrors.street_number[0] }}
                  </div>
                </div>
              </div>
              <v-row class="row mt-2">
                <div class="col-md-3">
                  <v-select label="Region" v-model="region" outlined dense :items="['XI']">
                  </v-select>
                </div>
                <div class="col-md-3">
                  <v-autocomplete v-model="province_name" :loading="loading" :items="provinces" @change="getCities()"
                    cache-items hide-no-data hide-details label="Province" outlined item-text="province_name"
                    item-value="id" dense></v-autocomplete>
                </div>
                <div class="col-md-3">
                  <v-autocomplete v-model="city_name" :disabled="!cities" :loading="loading" :items="cities"
                    @change="getBrgys()" hide-no-data hide-details label="City/Municipality" outlined
                    item-text="city_name" item-value="id" dense></v-autocomplete>
                </div>
                <div class="col-md-3">
                  <v-autocomplete v-model="form.psgc_id" :disabled="!brgys" :loading="loading" :items="brgys"
                    hide-no-data hide-details label="Barangay" outlined item-text="brgy_name" item-value="id" dense
                    :error-messages="validationErrors.psgc_id" required></v-autocomplete>
                </div>
              </v-row>
              <!--<div class="row mt-2">
                <div class="col-md-3">
                  <label>Region <small>(Ex. NCR)</small>
                    <span color="red"></span>
                  </label>
                  <select id="psgc_id" name="" v-model="beneficiary_region_selector" v-if="regions" class="form-control"
                    @change="getBeneficiaryPsgc">
                    <option value=""></option>
                    <option :value="e" v-for="(e, i) in regions" :key="i">
                      {{ i }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.psgc_id" style="color: red">
                    {{ validationErrors.psgc_id[0] }}
                  </div>
                </div>

                <div class="col-md-3">
                  <label>Province/District <small>(Ex. Dis. III)</small>
                    <span color="red"></span>
                  </label>
                  <select id="psgc_id" name="" v-model="beneficiary_province_selector" v-if="beneficiary_provinces"
                    class="form-control">
                    <option :value="e" v-for="(e, i) in beneficiary_provinces" :key="i">
                      {{ i }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.psgc_id" style="color: red">
                    {{ validationErrors.psgc_id[0] }}
                  </div>
                </div>

                <div class="col-md-3">
                  <label>
                    City/Municipality <small>(Ex. Quezon City)</small>
                    <span color="red"></span>
                  </label>

                  <select name="" v-model="beneficiary_city_selector" v-if="beneficiary_cities" class="form-control">
                    <option :value="e" v-for="(e, i) in beneficiary_cities" :key="i">
                      {{ i }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.psgc_id" style="color: red">
                    {{ validationErrors.psgc_id[0] }}
                  </div>
                </div>

                <div class="col-md-3">
                  <label>Barangay
                    <small>(Ex. Batasan Hills)</small>
                    <span style="color:red;">*</span>
                  </label>
                  <select id="psgc_id" name="" v-model="form.psgc_id" v-if="beneficiary_cities" class="form-control">
                    <option :value="e[0].id" v-for="(e, i) in beneficiary_barangays" :key="i">
                      {{ i }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.psgc_id" style="color: red">
                    {{ validationErrors.psgc_id[0] }}
                  </div>
                </div>
              </div>-->

              <div class="row mt-2">
                <div class="col-md-3">
                  <label for="mobile_number">Telepono
                    <small>(Mobile Number)
                      <span style="color:red;"></span>
                    </small>
                  </label>

                  <v-text-field v-model="form.mobile_number"
                    :error-messages="validationErrors.mobile_number" outlined dense>
                  </v-text-field>
                </div>

                <div class="col-md-3">
                  <label for="birth_date">Kapanganakan <small>(Birthdate)</small><span style="color:red">*</span></label>

                  <v-text-field type="date" @input="calculateAge" v-model="form.birth_date" required
                    :error-messages="validationErrors.birth_date" outlined dense>
                  </v-text-field>

                </div>

                <div class="col-md-3">
                  <label for="age">Edad <small>(Age)</small>
                    <span color="red"></span>
                  </label>

                  <v-text-field v-model="form.age" required :error-messages="validationErrors.age" outlined dense
                    readonly>
                  </v-text-field>

                </div>

                <div class="col-md-3">
                  <label for="birth_date">Kasarian<small>(Gender)</small> <span style="color:red">*</span> </label>
                  <v-select v-model="form.gender" :items="['Babae', 'Lalake']" required
                    :error-messages="validationErrors.gender" outlined dense>
                  </v-select>

                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-3">
                  <label for="occupation">Trabaho <small> (Occupation)</small> <span color="red"></span></label>
                  <input id="occupation" v-model="form.occupation" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.occupation" style="color: red">
                    {{ validationErrors.occupation[0] }}
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="monthly_salary">Buwanang Kita <small> (Monthly Salary) </small>
                    <span color="red"></span></label>
                  <input id="monthly_salary" v-model="form.monthly_salary" type="text" class="form-control" />

                  <div v-if="validationErrors && validationErrors.monthly_salary" style="color: red">
                    {{ validationErrors.monthly_salary[0] }}
                  </div>
                </div>

                <div class="col-md-3">
                  <label for="civil_status">Civil Status <span style="color:red;">*</span></label>
                  <select id="civil_status" v-model="form.civil_status" class="form-control">
                    <option :value="e" v-for="(e, i) in ['Single', 'Married', 'Common-law', 'Widowed', 'Separated']"
                      :key="i">
                      {{ e }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.civil_status" style="color: red">
                    {{ validationErrors.civil_status[0] }}
                  </div>
                </div>

                <div class="col-md-3">
                  <label for="mode_of_admission">Mode of Admission <span style="color:red;">*</span></label>
                  <select id="mode_of_admission" v-model="form.mode_of_admission" class="form-control">
                    <option :value="e" v-for="(e, i) in ['Referral']" :key="i">
                      {{ e }}
                    </option>
                  </select>

                  <div v-if="validationErrors && validationErrors.mode_of_admission" style="color: red">
                    {{ validationErrors.mode_of_admission[0] }}
                  </div>
                </div>
              </div>


              <div class="row mt-2">
                <div class="col-md-3">
                  <label>Valid ID Presented<span style="color:red;">*</span></label>
                  <v-combobox v-model="form.valid_id_presented" clearable outlined dense
                    :error-messages="validationErrors && validationErrors.valid_id_presented ? validationErrors.valid_id_presented[0] : ''"
                    :items="['National ID',
      'Driver\'s License',
      'Senior Citizen ID',
      'Voter\'s ID/Certificate',
      'Person\'s With Disability (PWD) ID',
      '4Ps ID',
      'Phil-health ID',
      'NBI Clearance',
      'BIR (TIN)',
      'Pag-ibig ID',
      'School ID',
      'Passport',
      'SSS ID/UMID Card',
      'PRC ID'
    ].sort()"></v-combobox>




                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-title">Beneficiary Category</div>
              <div class="card-body">
                Target Sector

                <select v-model="form.category_id" class="form-control">
                  <option></option>
                  <option v-for="(e, i) in categories" :key="i" :value="e.id">
                    {{ e.category }}
                  </option>
                </select>

                Specific Subcategory

                <select v-model="form.subcategory_id" class="form-control">
                  <option></option>
                  <option v-for="(e, i) in subcategories" :key="i" :value="e.id">
                    {{ e.subcategory }}
                  </option>
                </select>

                <div class="" v-if="form.subcategory_id == 8">
                  Others
                  <input type="text" v-model="form.subcategory_others" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-title">Social Worker's Assessment</div>
              <div class="card-body">
                <textarea name="" id="" v-model="form.assessment" class="form-control" cols="30" rows="5"></textarea>

                Interviewed by
                <input type="text" class="form-control" v-model="form.interviewed_by" />
              </div>
            </div>
          </div>
        </div>
        <br />

        <div class="card">
          <div class="card-title"> Records on File </div>
          <div class="card-body">
            <v-row>
              <v-alert v-if="validationErrors && validationErrors.records" dense type="error" outlined
                class="error--text">
                <ul>
                  <li v-for="error in validationErrors.records" :key="error">{{ error }}</li>
                </ul>
              </v-alert>
            </v-row>

            <v-row no-gutters dense>
              <v-col dense v-for="(record, index) in record_opts" :key="index" cols="12" sm="6" md="4" lg="3">
                <v-checkbox v-model="form.records" :label="record" :value="record" dense
                  class="shrink mr-0 mt-0"></v-checkbox>
              </v-col>
              <v-col xs="12" sm="5" md="3" lg="3">
                <v-text-field outlined dense class="rounded-0" v-model="form.records_others"
                  v-if="form.records && form.records.includes('Others')" label="Others"></v-text-field>
              </v-col>
            </v-row>


          </div>
        </div>
        <br />

        <div class="card">
          <div class="card-title">Select Payroll <span style="color:red;">*</span></div>
          <div class="card-body">

            <div
              v-if="dialog_data.payroll_client && dialog_data.payroll_client.payroll.status == 'closed' && (dialog_data.payroll_client.status != 'cancelled-revalidate')">

              <div v-if="dialog_data.payroll_client.new_payroll_client">
                Client No: {{ dialog_data.payroll_client.new_payroll_client.sequence }} <br>
                <span v-if="dialog_data.payroll_client.new_payroll_client.payroll.status"> Status:{{
      dialog_data.payroll_client.new_payroll_client.payroll.status }}</span> <br>
                In Payroll:{{ dialog_data.payroll_client.new_payroll_client.payroll.title }} |
                Schedule: {{ dialog_data.payroll_client.new_payroll_client.payroll.schedule }} |
                Amount:{{ dialog_data.payroll_client.new_payroll_client.payroll.amount }}
              </div>

              <div v-else>
                Client No: {{ dialog_data.payroll_client.sequence }}<br>
                <span v-if="dialog_data.payroll_client.payroll.status">
                  Status:{{ dialog_data.payroll_client.payroll.status }}
                </span><br>
                In Payroll: {{ dialog_data.payroll_client.payroll.title }}<br>
                Schedule: {{ dialog_data.payroll_client.payroll.schedule }} <br>
                Amount:{{ dialog_data.payroll_client.payroll.amount }}

              </div>

              Date Accomplished: {{ dialog_data.payroll_client.updated_at | FormatDateAccomplished }}


            </div>
            <div v-else>


              <div v-if="payrolls.length > 0">
                <v-select v-model="form.payroll_id"
                  :disabled="dialog_data.payroll_client && dialog_data.payroll_client.status != 'cancelled-revalidate'"
                  :items="payrolls" label="Payroll" outlined dense item-text="title" item-value="id">
                  <template v-slot:item="{ item }">
                    <v-list-item-content>
                      <v-list-item-title>{{ item.title }}</v-list-item-title>
                      <v-list-item-subtitle>
                        Amount: Php.{{ item.amount }} | Schedule: {{ item.schedule }}
                        <span v-if="item.aics_type">
                          | Assistance Requested: {{ item.aics_type.name }}
                        </span>
                        <span v-if="item.aics_subtype"> for {{ item.aics_subtype.name }} </span>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                  </template>
                </v-select>
              </div>
              <div v-else>
                NO ACTIVE PAYROLLS
              </div>
            </div>
          </div>
        </div>
        <v-row justify="center">
          <v-col cols="6">
            <v-btn block color="red" class="xs2" dark large @click="isVerified(form.id, 'grievance', form)">
              GRIEVANCE
            </v-btn></v-col>
          <v-col cols="6">
            <v-btn block color="blue" class="xs2" dark large type="submit" :disabled="submit">
              SUBMIT
            </v-btn>
          </v-col>
        </v-row>

      </div>
    </form>
  </v-app>
</template>

<style>
.card-title {
  background: #001997;
  color: #fff;
  padding: 1pc;
}
</style>

<script>
import { debounce, cloneDeep } from 'lodash'

export default {
  props: ["dialog_data", "getList", "userData", "setDialogCreate", "provinces"],

  data() {
    return {
      form: {
        mode_of_admission: "Referral",
        assessment: "The family is identified as indigent member of the barangay. Family's Income is below poverty threshold. Thus, this prompted client to seek government intervention."
      },
      assistance_types: {},
      psgc: {},
      regions: {},
      errors: {},
      validationErrors: {
        client: {},
        beneficiary: {},
        assistance: {},
      },
      max_date: new Date().toISOString().split("T")[0],

      categories: [],
      subcategories: [],
      payrolls: [],
      submit: false,
      selectedAssistances: [],
      record_opts: ["General Intake Sheet",
        "Medical Certificate/Abstract",
        "Discharge Summary",
        "Death Summary",
        "Valid ID Presented",
        "Prescriptions",
        "Laboratory Request",
        "Referral Letter",
        "Statement of Account",
        "Charge Slip",
        "Social Case Study Report",
        "4PS DSWD ID",
        "Treatment Protocol",
        "Funeral Contract",
        "Others",
        "Justification",
        "Quotation",
        "Death Certificate"],
      region: "XI",
      loading: false,
      province_name: "",
      city_name: "",
      cities: [],
      brgys: [],

    };
  },
  watch: {
    "form.subcategory_id": function (newVal, oldVal) {
      if (newVal != 8) {
        this.form.subcategory_others = "";
      }
    },
    dialog_data(e) {
      this.resetForm();
      this.populateForm(e);
    },
    "form.records": function (newVal, oldVal) {
      if (!newVal.includes("Others")) {
        this.form.records_others = "";
      }
    },
  },

  methods: {
    submitForm: debounce(function () {
      this.submit = true;
      if (this.form.payroll_id) {
        axios
          .post(route("api.client.update", this.dialog_data.id), this.form)
          .then((response) => {
            this.submit = false;
            /*console.log(response.data);*/
            this.setDialogCreate(false);
            let message = `${response.data.message}! Client number: ${response.data.client.payroll_client.sequence}`;
            if (response.data.client.payroll_client.new_payroll_client) {
              message = `${response.data.message}! Client number: ${response.data.client.payroll_client.new_payroll_client.sequence}`
            }
            alert(message);
            this.getList();

          })
          .catch((error) => {
            this.submit = false;
            //  console.log(error);

            this.$nextTick(() => {
              const el = this.$el.querySelector(".error--text:first-of-type");
              if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
              }

            });


            if (error.response && error.response.status == 422) {
              alert("Kumpletohin ang form. \nPlease complete the form.");
              this.validationErrors = error.response.data.errors;
            }
          });
      } else {
        alert(
          "Pumili ng Payroll!"
        );
        this.submit = false;
      }
    }, 250),
    resetForm() {
      this.form = {
        mode_of_admission: "Referral",
        assessment: "The family is identified as indigent member of the barangay. Family's Income is below poverty threshold. Thus, this prompted client to seek government intervention.",

      };
      this.province_name = "";
      this.city_name = "";
      this.validationErrors = {};
    },
    calculateAge: function () {
      if (!this.form.birth_date) {
        this.form.age = 0;
      } else {
        let currentDate = new Date();
        let birthDate = new Date(this.form.birth_date);
        let difference = currentDate - birthDate;
        let age = Math.floor(difference / 31557600000);
        this.form.age = age;
      }
    },

    isEmpty(value) {
      return _.isEmpty(value);
    },

    getAssistanceTypes() {
      axios.get(route("api.aics.assistance-types")).then((response) => {
        this.assistance_types = response.data;
      });
    },

    getCategories() {
      axios.get(route("api.categories")).then((response) => {
        this.categories = response.data.categories;
        this.subcategories = response.data.subcategory;
      });
    },
    getPayrolls() {
      axios
        .get(route("api.active_payrolls"))
        .then((response) => {
          this.payrolls = response.data;
        })
        .catch((error) => console.log(error));
    },
    isVerified: debounce(function (id, stat, client) {

      let message = "TAG " + client.full_name + " AS " + stat.toUpperCase() + "? \n"

      var conf = confirm(message);
      if (conf) {

        axios.post(route("api.client.verify", id), { "is_verified": stat }).then(response => {
          //console.log(response.data);
          if (response.data.message) {
            alert(response.data.message);
          }

        }).catch(err => console.log(err))

        this.$nextTick(() => {
          this.getList();
          this.setDialogCreate(false);
        })




      }

    }, 500),
    getCities() {
      this.cities = [];
      this.brgys = [];
      this.loading = true;
      axios.get(route("api.psgc.show", { type: "cities", field: "province_name", value: this.province_name })).then(response => {
        this.cities = response.data;
        this.loading = false;
      }).catch(error => { console.log(error); this.loading = false; });
    },
    getBrgys() {
      this.loading = true;
      let fields = [{ field: "city_name", value: this.city_name }, { field: "province_name", value: this.province_name, }];

      axios.get(route("api.psgc.show", { type: "brgy", fields })).then(response => {
        this.brgys = response.data;
        this.loading = false;
      }).catch(error => { console.log(error); this.loading = false; });

    },
    populateForm(e) {
      this.form = cloneDeep(e);


      if (this.form.payroll_client) {
        this.form.payroll_id = this.form.payroll_client.payroll_id;
      }

      this.form.mode_of_admission = "Referral";
      this.form.assessment = this.form.assessment ? this.form.assessment : "The family is identified as indigent member of the barangay. Family's Income is below poverty threshold. Thus, this prompted client to seek government intervention.";
      this.form.interviewed_by = this.userData ? this.userData.name : "";
      this.form.records = this.form.records && this.form.records.length > 0 ? JSON.parse(this.form.records) : ["General Intake Sheet", "Valid ID Presented"];

      if (this.form.payroll_client) { this.form.payroll_id = this.form.payroll_client.payroll_id; }
      this.calculateAge();

      if (this.form.psgc) {
        this.province_name = this.form.psgc.province_name;
        this.getCities();
        this.city_name = this.form.psgc.city_name;
        this.getBrgys();
      }

    }

  },
  mounted() {

    this.populateForm(this.dialog_data);
    this.calculateAge();
    this.getCategories();
    this.getPayrolls();


  },
};
</script>

<style></style>
