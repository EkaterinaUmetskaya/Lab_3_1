<template>
  <div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
      <h2>Данные нагрузки</h2>
      <button class="btn btn-success" @click="downloadExcel">Сохранить таблицу</button>
      <button class="btn btn-success" @click="openCreate">Добавить</button>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Дисциплина</th>
          <th>Курс</th>
          <th>Студенты</th>
          <th>Шифр</th>
          <th>Всего часов</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in loads.data" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.discipline_name }}</td>
          <td>{{ item.course }}</td>
          <td>{{ item.students_count }}</td>
          <td>{{ item.specialty_code }}</td>
          <td>{{ item.total_hours }}</td>
          <td>
            <button class="btn btn-primary btn-sm me-2" @click="openEdit(item)">Редактировать</button>
            <button class="btn btn-danger btn-sm" @click="remove(item.id)">Удалить</button>
          </td>
        </tr>
      </tbody>
    </table>

    <button
      v-if="loads.next_page_url"
      class="btn btn-outline-primary"
      @click="load(loads.current_page + 1, true)"
    >
      Лениво подгрузить ещё
    </button>

    <workload-modal
      :show="showModal"
      :form="form"
      @close="showModal = false"
      @saved="afterSave"
    />
  </div>
</template>

<script>
import axios from 'axios';
import WorkloadModal from './WorkloadModal.vue';

export default {
  components: { WorkloadModal },
  data() {
    return {
      loads: { data: [] },
      showModal: false,
      form: {}
    }
  },
  mounted() {
    this.load();
  },
  methods: {
    async load(page = 1, append = false) {
      const { data } = await axios.get(`/study-loads?page=${page}`);
      if (append) {
        data.data = [...this.loads.data, ...data.data];
      }
      this.loads = data;
    },
    openCreate() {
      this.form = {
        teacher_id: 1,
        semester: 1,
        funding_type: 'budget',
        discipline_name: '',
        course: '',
        students_count: null,
        specialty_code: '',
        groups_count: null,
        education_form: '',
        total_hours: 0
      };
      this.showModal = true;
    },
    openEdit(item) {
      this.form = { ...item };
      this.showModal = true;
    },
    async remove(id) {
      await axios.delete(`/study-loads/${id}`);
      this.load();
    },
    afterSave() {
      this.showModal = false;
      this.load();
    },
   async downloadExcel() {
      try {
        const response = await axios.get('/study-loads/export', {
          responseType: 'blob',
          headers: {
            Accept: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
          }
        });

        const blob = new Blob(
          [response.data],
          { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }
        );

        const href = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = href;
        link.download = 'study-loads.xlsx';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.URL.revokeObjectURL(href);
      } catch (error) {
        console.error(error);
        alert('Не удалось сохранить таблицу');
      }
    }
  }
}
</script>