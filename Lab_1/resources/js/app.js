import './bootstrap';
import { createApp } from 'vue';

import ExcelUpload from './components/ExcelUpload.vue';
import StudyLoadTable from './components/StudyLoadTable.vue';

const app = createApp({});

app.component('excel-upload', ExcelUpload);
app.component('study-load-table', StudyLoadTable);

app.mount('#app');