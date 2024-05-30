<template>
  <v-container>

    <v-row>
      <v-col cols="6">
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
      <v-col cols="6">
        <v-card>
          <v-card-title>Result</v-card-title>
          <v-card-text>
            <!--<v-alert v-if="decodedText" type="info">
              Decoded Text: {{ decodedText }}
            </v-alert>
            <v-alert v-if="error" type="error">
              Error: {{ error }}
            </v-alert>-->

            <div v-if="isValidFormat">

              <v-alert v-if="elements" type="info">
                Decoded Text: <div v-for="(element, index) in elements" :key="index">
                  <p>Element {{ index + 1 }}: {{ element }}</p>
                </div>
              </v-alert>


            </div>
            <div v-else>
             
              <v-alert v-if="error" type="error">
              Error: {{ error }}
            </v-alert>

            </div>


          </v-card-text>
        </v-card>






      </v-col>
    </v-row>

  </v-container>
</template>

<script>
import { CameraCodeScanner } from "vue-barcode-qrcode-scanner";

export default {
  components: { CameraCodeScanner },
  data() {
    return {
      showScanner: false,
      decodedText: null,
      error: null,
      valid: false,
      isValidFormat: false,
      showCamera: false
    };
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

      const sanitizedString = this.sanitizeString(result);
      this.isValidFormat = this.validateFormat(sanitizedString);

      if (this.isValidFormat) {
        this.elements = sanitizedString.split('/');
      }else
      {
        this.error = "Invalid Format"
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
    }
  }
};
</script>

<style scoped></style>