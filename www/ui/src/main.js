import { createApp } from 'vue'
import App from './App'
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';

const app = createApp(App);

app.component('vue-json-pretty', VueJsonPretty)
app.mount('#app');
