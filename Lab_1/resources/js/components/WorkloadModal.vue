<template>
  <div v-if="show" class="modal fade show d-block">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ localForm.id ? 'Редактирование' : 'Добавление' }}
          </h5>
        </div>
        <div class="modal-body">
          <input v-model="localForm.teacher_id" class="form-control mb-2" placeholder="ID преподавателя">
          <input v-model="localForm.semester" class="form-control mb-2" placeholder="Семестр">
          <input v-model="localForm.funding_type" class="form-control mb-2" placeholder="Тип финансирования">
          <input v-model="localForm.discipline_name" class="form-control mb-2" placeholder="Дисциплина">
          <input v-model="localForm.course" class="form-control mb-2" placeholder="Курс">
          <input v-model="localForm.students_count" class="form-control mb-2" placeholder="Студенты">
          <input v-model="localForm.specialty_code" class="form-control mb-2" placeholder="Шифр">
          <input v-model="localForm.groups_count" class="form-control mb-2" placeholder="Группы">
          <input v-model="localForm.education_form" class="form-control mb-2" placeholder="Форма обучения">
          <input v-model="localForm.total_hours" class="form-control mb-2" placeholder="Всего часов">
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" @click="$emit('close')">Отмена</button>
          <button class="btn btn-primary" @click="save">Сохранить</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['show', 'form'],
  data() {
    return {
      localForm: {}
    }
  },
  watch: {
    form: {
      immediate: true,
      deep: true,
      handler(val) {
        this.localForm = { ...val };
      }
    }
  },
  methods: {
    async save() {
  try {
    //console.log('LOCAL FORM:', this.localForm); 

    if (this.localForm.id) {
      await axios.put(`/study-loads/${this.localForm.id}`, this.localForm);
    } else {
      await axios.post('/study-loads', this.localForm);
    }

    this.$emit('saved');
  } catch (error) {
    console.error('FULL ERROR:', error);
    console.error('RESPONSE:', error.response);
    console.error('DATA:', error.response?.data);

    if (error.response?.data?.errors) {
      const errors = error.response.data.errors;
      const firstError = Object.values(errors)[0]?.[0];
      alert(firstError || 'Ошибка валидации');
    } else if (error.response?.data?.message) {
      alert(error.response.data.message);
    } else {
      alert('Ошибка при сохранении');
    }
  }
}
    
  }
}
</script>