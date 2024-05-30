<template>
  <v-container>
    <v-form ref="form" v-model="valid">
      <v-file-input
        v-model="file"
        label="Upload QR Code Image"
        required
        accept="image/*"
        prepend-icon="mdi-camera"
      ></v-file-input>
      <v-btn @click="decodeQRCode" :disabled="!file">
        Decode QR Code
      </v-btn>
      <v-alert v-if="decodedText" type="success">
        Decoded Text: {{ decodedText }}
      </v-alert>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      file: null,
      decodedText: null,
      valid: false,
    };
  },
  methods: {
    async decodeQRCode() {
      if (this.$refs.form.validate()) {
        const formData = new FormData();
        formData.append('qr_code_image', this.file);

        try {
          const response = await axios.post(route('qr_code.decode'), formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          this.decodedText = response.data.decoded_text;
        } catch (error) {
          console.error('Error decoding QR code:', error);
        }
      }
    }
  }
};
</script>

<style scoped>
</style>