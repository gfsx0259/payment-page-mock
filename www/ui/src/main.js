import { createApp } from 'vue'
import App from './App'
import Router from "@/router/router";
import Store from "@/store";

import * as Components from '@coreui/vue';

const app = createApp(App);

const UIComponents = [
    Components.CContainer,
    Components.CCard,
    Components.CCardImage,
    Components.CCardTitle,
    Components.CCardBody,
    Components.CButton,
    Components.CCol,
    Components.CRow,
    Components.CHeader,
    Components.CTable,
    Components.CTableRow,
    Components.CTableBody,
    Components.CTableHead,
    Components.CTableDataCell,
    Components.CTableHeaderCell,
    Components.CNavbar,
    Components.CNavbarNav,
    Components.CNavItem,
    Components.CNavLink,
    Components.CModal,
    Components.CModalBody,
    Components.CModalHeader,
    Components.CModalFooter,
    Components.CModalTitle,
    Components.CForm,
    Components.CFormLabel,
    Components.CFormInput,
    Components.CFormText,
    Components.CFormTextarea,
    Components.CSpinner,
];

UIComponents.forEach((component) => {
    app.component(component.name, component);
})

app.use(Store);
app.use(Router);
app.mount('#app');
