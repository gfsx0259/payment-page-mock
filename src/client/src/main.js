import { createApp } from "vue";
import { CIcon } from "@coreui/icons-vue";
import {
  cilFlagAlt,
  cilX,
  cilTrash,
  cilPencil,
  cilCompass,
  cilCopy,
  cilCursorMove,
} from "@coreui/icons";
import * as Components from "@coreui/vue";
import { SnackbarPlugin } from "snackbar-vue";

import VueHighlightJS from "vue3-highlightjs";
import "highlight.js/styles/solarized-light.css";

import VueClipboard from "vue3-clipboard";

import App from "./App";
import Router from "@/router/router";
import Store from "@/store";
import SnackbarConfig from "@/config/snackbar";

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
  Components.CFormSelect,
  Components.CSpinner,
  Components.CPlaceholder,
  Components.CBadge,
  Components.COffcanvas,
  Components.COffcanvasHeader,
  Components.COffcanvasBody,
  Components.COffcanvasTitle,
  CIcon,
];

const UIDirectives = [Components.vcplaceholder];

UIDirectives.forEach((directive) => {
  app.directive(directive.name, directive);
});

UIComponents.forEach((component) => {
  app.component(component.name, component);
});

app.provide("icons", {
  cilFlagAlt,
  cilX,
  cilTrash,
  cilPencil,
  cilCompass,
  cilCopy,
  cilCursorMove,
});

app.use(SnackbarPlugin, SnackbarConfig);
app.use(VueHighlightJS);
app.use(VueClipboard, {
  autoSetContainer: true,
  appendToBody: true,
});

app.use(Store);
app.use(Router);

app.mount("#app");
