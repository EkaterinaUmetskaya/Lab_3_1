<template>
  <div class="container py-5">
    <div
      class="upload-box p-5 text-center border rounded"
      @dragover.prevent
      @drop.prevent="handleDrop"
    >
      <h3>Загрузка Excel</h3>
      <p>Перетащите .xls или .xlsx сюда либо выберите файл вручную</p>

      <input
        type="file"
        ref="fileInput"
        class="d-none"
        @change="handleSelect"
        accept=".xls,.xlsx"
      >

      <button
        class="btn btn-primary"
        :disabled="isUploading"
        @click="$refs.fileInput.click()"
      >
        {{ isUploading ? 'Загрузка...' : 'Выбрать файл' }}
      </button>
    </div>

    <div v-if="isUploading" class="mt-4">
      <div class="d-flex justify-content-between mb-2">
        <span>Загрузка файла</span>
        <span>{{ uploadProgress }}%</span>
      </div>

      <div class="progress custom-progress">
        <div
          class="progress-bar progress-bar-striped progress-bar-animated"
          role="progressbar"
          :style="{ width: uploadProgress + '%' }"
          :aria-valuenow="uploadProgress"
          aria-valuemin="0"
          aria-valuemax="100"
        >
          {{ uploadProgress }}%
        </div>
      </div>
    </div>

    <div v-if="error" class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ошибка загрузки</h5>
          </div>
          <div class="modal-body">
            <p>{{ error }}</p>
            <p>Разрешены только файлы Excel: .xls и .xlsx</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="error = ''">Закрыть</button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="success" class="alert alert-success mt-3">
      {{ success }}
    </div>

    <div v-if="redirectUrl" class="mt-3">
      <button class="btn btn-success" @click="goToLoads">
        Перейти к данным
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      error: '',
      success: '',
      redirectUrl: '',
      uploadProgress: 0,
      isUploading: false
    };
  },
  methods: {
    isExcel(file) {
      return /\.(xls|xlsx)$/i.test(file.name);
    },

    async upload(file) {
      if (!this.isExcel(file)) {
        this.error = 'Неверный формат файла';
        return;
      }

      const formData = new FormData();
      formData.append('file', file);

      this.isUploading = true;
      this.uploadProgress = 0;
      this.error = '';
      this.success = '';
      this.redirectUrl = '';

      try {
        const response = await axios.post('/upload-excel', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          },
          onUploadProgress: (progressEvent) => {
            if (progressEvent.total) {
              this.uploadProgress = Math.round(
                (progressEvent.loaded * 100) / progressEvent.total
              );
            }
          }
        });

        this.uploadProgress = 100;
        this.success = response.data.message;
        this.redirectUrl = response.data.redirect || '/loads';
      } catch (error) {
        this.uploadProgress = 0;

        if (error.response?.data?.message) {
          this.error = error.response.data.message;
        } else if (error.response?.data?.errors?.file?.length) {
          this.error = error.response.data.errors.file[0];
        } else {
          this.error = 'Ошибка загрузки файла';
        }
      } finally {
        this.isUploading = false;
      }
    },

    handleDrop(e) {
      const file = e.dataTransfer.files[0];
      if (file) this.upload(file);
    },

    handleSelect(e) {
      const file = e.target.files[0];
      if (file) this.upload(file);
    },

    goToLoads() {
      window.location.href = this.redirectUrl;
    }
  }
};
</script>

<style scoped lang="scss">
.upload-box {
  background: #f8f9fa;
  border: 2px dashed #6c757d !important;
  cursor: pointer;
  transition: .3s;
}

.upload-box:hover {
  background: #e9ecef;
}

.custom-progress {
  height: 28px;
  border-radius: 14px;
  overflow: hidden;
  background-color: #e9ecef;
}

.progress-bar {
  font-weight: 600;
}
</style>