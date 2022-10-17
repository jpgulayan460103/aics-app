<template>
  <form @submit.prevent="submit" enctype="multipart/form-data">
    <div class="container m-10" style="margin-top: 50px">
      <div class="row">
        <div class="col-md-4 text-center">
          <img
            max-height="64"
            max-width="250px"
            src="/images/DSWD-DVO-LOGO.png"
            class="img-fluid"
          />
        </div>
        <div class="col-md-8 text-md-end text-center">
          <h1
            style="
              font-size: 2rem;
              font-family: arial;
              font-weight: bold;
              margin-bottom: 0px;
            "
          >
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
          <!--<h1 style="font-size: 20pt">Assistance to Individuals in Crisis</h1>-->
          <h2
            style="font-family: 'Arial black', sans-serif; margin-bottom: 0px"
          >
            GENERAL INTAKE SHEET<br />
          </h2>
          <p>MAARING MAGPATULONG SUMAGOT SA DSWD PERSONNEL</p>
        </div>
      </div>

      <!--<div v-if="validationErrors">
        <ul class="alert alert-danger">
          <li
            v-for="(value, index) in validationErrors.beneficiary"
            :key="index"
          >
           {{index}} -  {{ value }}
          </li>
        </ul>

        <ul class="alert alert-danger">
          <li v-for="(value, index) in validationErrors.client" :key="index">
            {{ value }}
          </li>
        </ul>
      </div>-->

      <div class="card mt-2">
        <div class="card-title">
          NAIS HINGIIN NA TULONG (Assistance Requested)
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <!--<label for="">The Client needs assistance for</label>-->

            <select
              name="assistance_type"
              v-model="form.assistance.aics_type_id"
              class="form-control"
              @change="getRequirements"
            >
              <option :value="e.id" v-for="e in assistance_types" :key="e.id">
                {{ e.name }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <div class="card mt-2">
        <div class="card-title">Ako ang:</div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="row">
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="is_beneficiary"
                  v-model="is_beneficiary"
                  :value="true"
                />
                <label class="form-check-label" for="inlineRadio1"
                  >Beneficiary</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="is_beneficiary"
                  v-model="is_beneficiary"
                  :value="false"
                />
                <label class="form-check-label" for="inlineRadio2"
                  >Representative</label
                >
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-2">
        <div class="card-title">
          IMPORMASYON NG BENEPISYARYO (Beneficiary's Identifying Information)
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <label for="last_name">
                  Apelyido <small>(Last name)</small>
                </label>
                <input
                  id="last_name"
                  v-model="form.beneficiary.last_name"
                  type="text"
                  class="form-control"
                />
                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.last_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.last_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="first_name">
                  Unang Pangalan <small>(First name)</small></label
                >
                <input
                  id="first_name"
                  v-model="form.beneficiary.first_name"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.first_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.first_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="middle_name"
                  >Gitnang Pangalan <small>(Middle name)</small></label
                >
                <input
                  id="middle_name"
                  v-model="form.beneficiary.middle_name"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.middle_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.middle_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="ext_name"
                  >Ext <small>(Sr.,Jr., II, III)</small></label
                ><br />
                <select
                  id="ext_name"
                  v-model="form.beneficiary.ext_name"
                  type="text"
                  class="form-control"
                  :class="{
                    'is-invalid':
                      validationErrors.ext_name &&
                      validationErrors.beneficiary.ext_name,
                  }"
                >
                  <option value=""></option>
                  <option value="JR">JR</option>
                  <option value="SR">SR</option>
                  <option value="I">I</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="IV">IV</option>
                  <option value="V">V</option>
                  <option value="VI">VI</option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.ext_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.ext_name[0] }}
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-12">
                <label for="street_number"
                  >House No./Street/Purok
                  <small>(Ex. 123 Sun St.)</small>
                </label>
                <input
                  id="street_number"
                  v-model="form.beneficiary.street_number"
                  class="form-control"
                  type="text"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.street_number
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.street_number[0] }}
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-3">
                <label>Region <small>(Ex. NCR)</small></label>
                <select
                  id="psgc_id"
                  name=""
                  v-model="beneficiary_region_selector"
                  v-if="regions"
                  class="form-control"
                  @change="getBeneficiaryPsgc"
                >
                  <option :value="e" v-for="(e, i) in regions" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label>Province/District <small>(Ex. Dis. III)</small> </label>
                <select
                  id="psgc_id"
                  name=""
                  v-model="beneficiary_province_selector"
                  v-if="beneficiary_provinces"
                  class="form-control"
                >
                  <option :value="e" v-for="(e, i) in beneficiary_provinces" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label
                  >City/Municipality <small>(Ex. Quezon City)</small></label
                >

                <select
                  name=""
                  v-model="beneficiary_city_selector"
                  v-if="beneficiary_cities"
                  class="form-control"
                >
                  <option :value="e" v-for="(e, i) in beneficiary_cities" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label>Barangay <small>(Ex. Batasan Hills)</small></label>
                <select
                  id="psgc_id"
                  name=""
                  v-model="form.beneficiary.psgc_id"
                  v-if="beneficiary_cities"
                  class="form-control"
                >
                  <option :value="e[0].id" v-for="(e, i) in beneficiary_barangays" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.psgc_id[0] }}
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-3">
                <label for="mobile_number"
                  >Telepono <small>(Mobile Number Ex. 091234567890)</small>
                </label>

                <input
                  id="mobile_number"
                  v-model="form.beneficiary.mobile_number"
                  type="text"
                  class="form-control"
                  placeholder="091234567890"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.mobile_number
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.mobile_number[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="birth_date"
                  >Kapanganakan <small>(Birthdate)</small></label
                >
                <input
                  id="birth_date"
                  v-model="form.beneficiary.birth_date"
                  type="date"
                  class="form-control"
                  :max="max_date"
                  @input="calculateAge"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.birth_date
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.birth_date[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="age">Edad <small>(Age)</small></label>

                <input
                  id="age"
                  type="text"
                  class="form-control"
                  :value="form.beneficiary.age"
                  readonly
                />
              </div>

              <div class="col-md-3">
                <label for="gender">Kasarian <small>(gender)</small></label>
                <select
                  name=""
                  id=""
                  class="form-control"
                  v-model="form.beneficiary.gender"
                >
                  <option
                    :value="gender"
                    v-for="gender in ['Babae', 'Lalake']"
                    :key="gender"
                  >
                    {{ gender }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.gender
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.gender[0] }}
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-3">
                <label for="occupation"
                  >Trabaho <small> (Occupation)</small></label
                >
                <input
                  id="occupation"
                  v-model="form.beneficiary.occupation"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.occupation
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.occupation[0] }}
                </div>
              </div>
              <div class="col-md-3">
                <label for="monthly_salary"
                  >Buwanang Kita <small> (Monthly Salary) </small></label
                >
                <input
                  id="monthly_salary"
                  v-model="form.beneficiary.monthly_salary"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.beneficiary.monthly_salary
                  "
                  style="color: red"
                >
                  {{ validationErrors.beneficiary.monthly_salary[0] }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-2" v-if="is_beneficiary == false">
        <div class="card-title">
          IMPORMASYON NG KINATAWAN (Representative's Identifying Information)
        </div>

        <div class="card-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <label for="last_name">
                  Apelyido <small>(Last name)</small>
                </label>
                <input
                  id="last_name"
                  v-model="form.client.last_name"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.beneficiary &&
                    validationErrors.client.last_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.last_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="first_name">
                  Unang Pangalan <small>(First name)</small></label
                >
                <input
                  id="first_name"
                  v-model="form.client.first_name"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.first_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.first_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="middle_name"
                  >Gitnang Pangalan <small>(Middle name)</small></label
                >
                <input
                  id="middle_name"
                  v-model="form.client.middle_name"
                  type="text"
                  class="form-control"
                />
                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.middle_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.middle_name[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="ext_name"
                  >Ext <small>(Sr.,Jr., II, III)</small></label
                ><br />
                <select
                  id="ext_name"
                  v-model="form.client.ext_name"
                  type="text"
                  class="form-control"
                >
                  <option value=""></option>
                  <option value="JR">JR</option>
                  <option value="SR">SR</option>
                  <option value="I">I</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="IV">IV</option>
                  <option value="V">V</option>
                  <option value="VI">VI</option>
                </select>

                <div
                  v-if="
                    validationErrors.client && validationErrors.client.ext_name
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.ext_name[0] }}
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-12">
                <label for="street_number"
                  >House No./Street/Purok
                  <small>(Ex. 123 Sun St.)</small>
                </label>
                <input
                  id="street_number"
                  v-model="form.client.street_number"
                  class="form-control"
                  type="text"
                />

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.street_number
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.street_number[0] }}
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-3">
                <label for="psgc_id">Region <small>(Ex. NCR)</small></label>
                <select
                  id="psgc_id"
                  name=""
                  v-model="client_region_selector"
                  v-if="regions"
                  class="form-control"
                  @change="getClientPsgc"
                >
                  <option :value="e" v-for="(e, i) in regions" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="psgc_id"
                  >Province/District <small>(Ex. Dis. III)</small>
                </label>
                <select
                  id="psgc_id"
                  name=""
                  v-model="client_province_selector"
                  v-if="client_provinces"
                  class="form-control"
                >
                  <option :value="e" v-for="(e, i) in client_provinces" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.client && validationErrors.client.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="psgc_id"
                  >City/Municipality <small>(Ex. Quezon City)</small></label
                >

                <select
                  id="psgc_id"
                  name=""
                  v-model="client_city_selector"
                  v-if="client_cities"
                  class="form-control"
                >
                  <option :value="e" v-for="(e, i) in client_cities" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.client && validationErrors.client.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.psgc_id[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="psgc_id"
                  >Barangay <small>(Ex. Batasan Hills)</small></label
                >

                <select
                  name=""
                  v-model="form.client.psgc_id"
                  v-if="beneficiary_cities"
                  class="form-control"
                >
                  <option :value="e[0].id" v-for="(e, i) in client_barangays" :key="i">
                    {{ i }}
                  </option>
                </select>

                <div
                  v-if="
                    validationErrors.client && validationErrors.client.psgc_id
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.psgc_id[0] }}
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-3">
                <label for="mobile_number"
                  >Telepono <small>(Mobile Number)</small>
                </label>

                <input
                  id="mobile_number"
                  v-model="form.client.mobile_number"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.mobile_number
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.mobile_number[0] }}
                </div>
              </div>

              <div class="col-md-3">
                <label for="birth_date"
                  >Kapanganakan <small>(Birthdate)</small></label
                >
                <input
                  id="birth_date"
                  v-model="form.client.birth_date"
                  type="date"
                  :max="max_date"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.birth_date
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.birth_date[0] }}
                </div>
              </div>

              <div class="col-md-6">
                <label for="relasyon"
                  >Relasyon sa Benepisyaryo
                  <small> (Relationship to Beneficiary) </small></label
                >
                <input
                  id="relasyon"
                  v-model="form.client.rel_beneficiary"
                  type="text"
                  class="form-control"
                />

                <div
                  v-if="
                    validationErrors.client &&
                    validationErrors.client.rel_beneficiary
                  "
                  style="color: red"
                >
                  {{ validationErrors.client.rel_beneficiary[0] }}
                </div>
              </div>

              <div class="col-md-3"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-2" v-if="requirements">
        <div class="card-title">Requirements <span></span></div>

        <div class="card-body">
          <div v-if="!isEmpty(validationErrors.assistance)" class="alert alert-danger">
            <ul>
              <li v-for="(e, i) in validationErrors.assistance" :key="i">
                {{ e[0] }}
              </li>
            </ul>
          </div>
          <ul
            v-if="requirements[0]"
            style="list-style: decimal; display: block"
            class="ml-3 list-group list-group-flush"
          >
            <li
              v-for="(r, i) in requirements[0].requirements.filter(i => i.is_required == 1)"
              :key="r.id"
              class="list-group-item"
            >
              <p>{{ r.name }}</p>
              <div class="alert alert-primary">
                <input type="file" @input="onFileChange(i, $event)" accept="application/pdf,image/jpeg,image/png" />
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="text-center col-md-12" style="padding: 10px 0px">
        <button type="submit" class="btn btn-primary btn-lg">SUBMIT</button>
      </div>
    </div>
  </form>
</template>

<style>
.card-title {
  background: #001997;
  color: #fff;
  padding: 1pc;
}
</style>

<script>
export default {
  data() {
    return {
      /*form: this.$inertia.form({
        beneficiary: {},
        client: {},
        assistance: {},
      }),*/
      form: {
        beneficiary: {
          region: "XI",
        },
        client: {
          rel_beneficiary: "",
        },
        assistance: {
          documents: {},
        },
      },
      // form: {},
      assistance_types: {},
      psgc: {},
      regions: {},
      client_provinces: {},
      client_cities: {},
      client_barangays: {},
      client_region_selector: {},
      client_province_selector: {},
      client_city_selector: {},
      beneficiary_provinces: {},
      beneficiary_cities: {},
      beneficiary_barangays: {},
      beneficiary_region_selector: {},
      beneficiary_province_selector: {},
      beneficiary_city_selector: {},
      is_beneficiary: true,
      requirements: {},
      errors: {},
      validationErrors: {
        client: {},
        beneficiary: {},
        assistance: {},
      },
      max_date: new Date().toISOString().split("T")[0],

      //logo:  location.protocol + "//" + location.host +  "/" + process.env.MIX_BASE_NAME +"/images/DSWD-DVO-LOGO.png",
      logo:
        location.protocol + "//" + location.host + "/images/DSWD-DVO-LOGO.png",
    };
  },
  watch: {
    beneficiary_region_selector(newVal, oldVal) {
      (this.beneficiary_provinces = {}, this.beneficiary_cities = {}, this.beneficiary_barangays = {}), (this.beneficiary_provinces = this.groupByKey(newVal, "province_name"));
    },

    beneficiary_province_selector(newVal, oldVal) {
      (this.beneficiary_cities = {}, this.beneficiary_barangays = {}), (this.beneficiary_cities = this.groupByKey(newVal, "city_name"));
    },

    beneficiary_city_selector(newVal, oldVal) {
      (this.beneficiary_barangays = {}),
        (this.beneficiary_barangays = this.groupByKey(newVal, "brgy_name"));
    },
    client_region_selector(newVal, oldVal) {
      (this.client_provinces = {}, this.client_cities = {}, this.client_barangays = {}), (this.client_provinces = this.groupByKey(newVal, "province_name"));
    },

    client_province_selector(newVal, oldVal) {
      (this.client_cities = {}, this.client_barangays = {}), (this.client_cities = this.groupByKey(newVal, "city_name"));
    },

    client_city_selector(newVal, oldVal) {
      (this.client_barangays = {}),
        (this.client_barangays = this.groupByKey(newVal, "brgy_name"));
    },
    is_beneficiary(newVal, oldVal) {
      console.log(newVal);
      if (newVal === true) {
        this.form.client = this.form.beneficiary;
        this.form.client.rel_beneficiary = "Myself";
      } else {
        this.form.client = {};
        this.form.client.rel_beneficiary = "";
      }
    },
  },

  methods: {
    submit() {
      if (this.form.assistance.aics_type_id) {
        if (this.is_beneficiary == true) {
          this.form.client = this.form.beneficiary;
          this.form.client.rel_beneficiary = "Myself";
        }

        const config = {
          headers: {
            "content-type": "multipart/form-data",
          },
        };

        let formData = new FormData();

        _.each(this.form.client, (value, key) => {
          formData.append("client[" + key + "]", value);
        });

        _.each(this.form.beneficiary, (value, key) => {
          formData.append("beneficiary[" + key + "]", value);
        });

        _.each(this.form.assistance, (value, key) => {
          if (typeof value === "object") {
            _.each(value, (v, k) => {
              formData.append("assistance[" + key + "][" + k + "]", v);
            });
          } else {
            formData.append("assistance[" + key + "]", value);
          }
        });

        const headers = {
          "Content-Type": "multipart/form-data;",
        };

        console.log(formData);

        axios
          .post(route("assistances.store"), formData, headers)
          .then((response) => {
            console.log(response.data);
            if(response.data.aics_beneficiary_id)
            {
              alert("Naisumite na ang Form. Isang kinatawan ng DSWD ang makikipag-ugnayan sa iyo, mayat-maya. \nForm submitted. A DSWD representative will contact you shortly.")
            }

          })
          .catch((error) => {
            if (error.response.status == 422) {
              alert("Kumpletohin ang form. \nPlease complete the form.");
              this.validationErrors = error.response.data.errors;
            }
          });
      }else
      {
        alert("Pumili ng nais hingiin na tulong. \nPlease select assistance request.")
      }
    },
    onFileChange(i, e) {
      
      this.form.assistance.documents[i] = e.target.files[0];
    },

    getRequirements() {
      this.form.assistance.documents = {};
      if(this.validationErrors.assistance)
      {
        this.validationErrors.assistance= {};
      };

      this.requirements = this.assistance_types.filter((x) => {
        if (x.id === this.form.assistance.aics_type_id) {
          return x.requirements;
        }
      });
    },

    getBeneficiaryPsgc(){
      axios.get(route("api.psgc.show", "brgy"),{
        params: {
          field: "region_psgc",
          value: this.beneficiary_region_selector[0].region_psgc
        }
      }).then((response) => {
        this.beneficiary_psgc = response.data;
        this.beneficiary_provinces = this.groupByKey(this.beneficiary_psgc, "province_name");
      });
    },

    getClientPsgc(){
      axios.get(route("api.psgc.show", "brgy"),{
        params: {
          field: "region_psgc",
          value: this.client_region_selector[0].region_psgc
        }
      }).then((response) => {
        this.client_psgc = response.data;
        this.client_provinces = this.groupByKey(this.client_psgc, "province_name");
      });
    },

    calculateAge: function () {
      if (!this.form.beneficiary.birth_date) {
        this.form.age = 0;
      } else {
        let currentDate = new Date();
        let birthDate = new Date(this.form.beneficiary.birth_date);
        let difference = currentDate - birthDate;
        let age = Math.floor(difference / 31557600000);
        this.form.beneficiary.age = age;
      }
    },

    groupByKey(array, key) {
      return array.reduce((hash, obj) => {
        if (obj[key] === undefined) return hash;
        return Object.assign(hash, {
          [obj[key]]: (hash[obj[key]] || []).concat(obj),
        });
      }, {});
    },

    isEmpty(value){
      return _.isEmpty(value);
    }
  },
  mounted() {
    axios.get(route("api.aics.assistance-types")).then((response) => {
      this.assistance_types = response.data;
    });
    axios.get(route("api.psgc.show","region")).then((response) => {
      this.regions = this.groupByKey(response.data, "region_name");
    });
  },
};
</script>

<style>
</style>


