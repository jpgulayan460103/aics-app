<template>
  <v-container fluid>

    <v-row>
      <v-col cols="4">
        <v-card>
          <v-card-title>
            Scanner <v-spacer></v-spacer> <v-btn @click="showCamera = !showCamera" dark color="primary">
              {{ showCamera ? 'Hide' : 'Open' }} Camera
            </v-btn>
          </v-card-title>
          <v-card-text>
            <CameraCodeScanner @scan="onScan" @load="onLoad" v-if="showCamera"></CameraCodeScanner>
          </v-card-text>
        </v-card>

      </v-col>
      <v-col cols="8">

        <v-card class="mb-2">
          <v-card-title>

            <v-row>
              <v-col>Search</v-col>
              <v-col cols="2" class="pr-0 mr-0">
                <v-text-field outlined dense v-model="form.payroll_id"
                  :error-messages="formErrors.payroll_id"></v-text-field>
              </v-col>
              <v-col class=" ml-0">
                <v-text-field @keyup="Search()" outlined dense v-model="form.aics_client_id"
                  :error-messages="formErrors.aics_client_id">
                  <v-icon slot="prepend">
                    mdi-minus
                  </v-icon>
                </v-text-field>
              </v-col>
            </v-row>






          </v-card-title>
        </v-card>

        <v-card :loading="isLoading">
          <v-card-title>Result <v-spacer></v-spacer>
          </v-card-title>
          <v-card-text>
            <v-alert v-if="error" type="error">
              {{ error }}
            </v-alert>
            <div v-if="client && client.aics_client">
              <v-simple-table v-if="client.aics_client" dense>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in clientData" :key="index">

                    <th>{{ item.title }}</th>
                    <td>
                      <div v-if="item.title == 'Check In Status'">
                       <span v-if="item.value">( {{ item.value }})</span>
                        <v-select small v-model="formData2.checkin_status" outlined dense :items="['', 'Checked In']"
                          @change="UpdateCheckInStatus()"> </v-select>
                      </div>
                      <div v-else>
                        {{ item.value }}
                      </div>

                    </td>

                  </tr>
                  <!--<tr>
                    <th>Check In Status</th>
                    <td> {{client.checkin_status}}
                      <v-select v-model="formData2.checkin_status" outlined dense :items="['', 'Checked In']"  @change="UpdateCheckInStatus()"> </v-select>

                    </td>
                  </tr>-->
                </tbody>
              </v-simple-table>


              <!---<v-list>
                <v-list-item v-for="(item, index) in clientData" :key="index">
                  <v-list-item-content>
                  
                    <v-list-item-subtitle>{{ item.title }}</v-list-item-subtitle>
                    <v-list-item-title>{{ item.value }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>-->



            </div>



          </v-card-text>
        </v-card>






      </v-col>
    </v-row>

  </v-container>
</template>
<style>
.rotated-header {
  transform: rotate(-90deg);
  transform-origin: left bottom;
  white-space: nowrap;
}
</style>
<script>
import axios from "axios";
import { CameraCodeScanner } from "vue-barcode-qrcode-scanner";
import { debounce, cloneDeep, isEmpty } from 'lodash';
import moment from 'moment';
export default {
  components: { CameraCodeScanner },
  data() {
    return {
      showScanner: false,
      error: null,
      isValidFormat: false,
      showCamera: false,
      client: [],
      isLoading: false,
      form: { payroll_id: null, aics_client_id: null },
      formErrors: {},
      formData2: { checkin_status: null }
    };
  },

  watch: {
    client: {
      handler(newValue) {
        if (newValue.aics_client) {
          this.clientData = [
            { title: 'QN', value: newValue.sequence },
            { title: 'Client', value: newValue.aics_client.full_name },
            { title: 'Birth Date', value: newValue.aics_client.birth_date },
            { title: 'Valid ID Presented', value: newValue.aics_client.valid_id_presented },
            { title: 'Address', value: `${newValue.aics_client.psgc.brgy_name} ${newValue.aics_client.psgc.city_name} ${newValue.aics_client.psgc.province_name}` },

            { title: 'Payroll Title', value: newValue.payroll.title },
            { title: 'Validated In', value: `${newValue.payroll.psgc.brgy_name} ${newValue.payroll.psgc.city_name} ${newValue.payroll.psgc.province_name}` },
            { title: 'Validated On ', value: moment(String(newValue.created_at )).format("MM-DD-YYYY HH:mm:ss")},
            { title: 'Date Claimed', value: newValue.date_claimed },
            { title: 'Claim Status', value: newValue.status },
            { title: 'Check In Status', value: newValue.checkin_status },
            { title: 'Check In Date ', value: newValue.date_checkin },


          ];
        }
      },
      deep: true,
    },
  },
  methods: {
    onLoad({
      controls,
      scannerElement,
      browserMultiFormatReader
    }) {
      //console.log(controls)
      // ---- BrowserMultiFormatReader Controls API ----
      // {
      //   stop: f() // Stops the video stream (Basically turns off the camera)
      // }

      //console.log(scannerElement)
      // ---- The ref to the video native element that streams the video-camera output ----
      // <video data-v-73df36b4="" poster="data:image/gif,AAAA" autoplay="true" muted="true" // playsinline="true"></video>

      //console.log(browserMultiFormatReader)
      // ---- A reference to the BrowserMultiFormatReader object. ----
      // hints: Map(0)
      // options: {
      //  delayBetweenScanAttempts: 500
      //  delayBetweenScanSuccess: 500
      //  tryPlayVideoTimeout: 5000
      // }
      // reader: MultiFormatReader

      // Please refer to the [ZXing (Zebra crossing) browser documentation](https://github.com/zxing-js/browser)

    },
    onScan({ result, raw }) {

      this.ResetData()
      this.isLoading = true;
      const sanitizedString = this.sanitizeString(result);
      this.isValidFormat = this.validateFormat(sanitizedString);

      if (this.isValidFormat) {
        this.elements = sanitizedString.split('/');
        this.form.payroll_id = this.elements[4];
        this.form.aics_client_id = this.elements[0];
        this.Search();
      } else {
        this.isLoading = false;
        this.error = "Error: Sorry, the scanned QR Code is not for DSWD AICS App."
      }

      // ---- Scan result ----
      // "http://en.m.wikipedia.org"
      //console.log(raw)
      // ---- Raw BrowserMultiFormatReader.decodeFromVideoDevice result ----
      // format: 11
      // numBits: 272
      // rawBytes: Uint8Array(34) [65, 150, 135, 71, 71, 3, 162, 242, 246, 86, 226, 230, 210, 231, 118, 150, 182, 151, 6, 86, 70, 150, 18, 230, 247, 38, 112, 236, 17, 236, 17, 236, 17, 236, buffer: ArrayBuffer(34), byteLength: 34, byteOffset: 0, length: 34, Symbol(Symbol.toStringTag): 'Uint8Array']
      // resultMetadata: Map(2) {2 => Array(1), 3 => 'Q'}
      // resultPoints: (4) [FinderPattern, FinderPattern, FinderPattern, AlignmentPattern]
      // text: "http://en.m.wikipedia.org"
      // timestamp: 1654535879486
    },
    sanitizeString(str) {
      return str.trim().replace(/[^\w\s\/\-\.]/g, '');
    },
    validateFormat(str) {
      const pattern = /^\d+\/\d+\/[a-zA-Z\s]+\/\d{4}-\d{2}-\d{2}\/\d+$/;
      return pattern.test(str);
    },
    Search: debounce(async function () {
      this.error = null;
      this.formErrors = {};
      this.formData2 = { checkin_status: null };

      axios.post(route("qr_code.search"), this.form).then(res => {

        this.client = cloneDeep(res.data);
        this.isLoading = false;

      }).catch(e => {

        if (e.response.status === 404) {
          this.error = 'No client found. Note: Use the same server where the client was validated. ';
        } else {

          this.error = e.response.data.message ? e.response.data.message : e;
          this.formErrors = e.response.data.errors;
        }

        this.isLoading = false;
        this.client = [];
      });
    }, 250),
    ResetData() {
      this.error = null;
      this.formErrors = {};
      this.client = [];
      this.isLoading = false;
      this.form = { payroll_id: null, aics_client_id: null };
      this.formData2 = { checkin_status: null };
    },
    async UpdateCheckInStatus() {
      await axios.put(route("api.payroll-clients.update", this.client.id), this.formData2).then((res) => {

        if (res.data.message == "saved") {
          alert("Success Checked in:" + this.client.sequence + " " + this.client.aics_client.full_name);
          this.Search();
        }
      

      }).catch(er => console.log(e => {
        this.error = e.response.data.message ? e.response.data.message : e;
        this.isLoading = false;
      }));
    }


  }
};
</script>

<style scoped></style>