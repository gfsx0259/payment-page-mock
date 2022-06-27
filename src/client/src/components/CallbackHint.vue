<template>
    <COffcanvas
        placement="start"
        :backdrop="false"
        :visible="disabled"
        scroll
    >
      <COffcanvasHeader>
        <COffcanvasTitle>Quick hint</COffcanvasTitle>
        <CIcon
            icon="cilX"
            size="xl"
            class="m-1"
            @click="hide"
        />
      </COffcanvasHeader>
      <COffcanvasBody>
        <CTable hover bordered>
          <CTableBody>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>REQUEST_ID</CopyElement>
              </CTableDataCell>
              <CTableDataCell>Unique transaction request id provided by mock (important for callback delivery)</CTableDataCell>
              <CTableDataCell>request_id</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>

        <p class="fs-5">ACS action flow</p>
        <CTable hover bordered>
          <CTableBody>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>ACS_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>ACS emulated page provided by mock</CTableDataCell>
              <CTableDataCell>acs.acs_url</CTableDataCell>
            </CTableRow>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>TERM_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>Return url parsed from initial request acs_return_url.return_url</CTableDataCell>
              <CTableDataCell>acs.term_url</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>
        <ol>
          <li>Payment Page sends initial request</li>
          <li>Dummy accepts <b>awaiting 3ds result</b> callback and remember action at dummy transaction state</li>
          <li>Dummy replies <b>awaiting 3ds result</b> callback with structure:
          <pre class="m-0" v-highlightjs><code class="javascript">{
  "acs": {
    "pa_req": "string",
    "md": "string",
    "acs_url": "{{"ACS_URL"}}",
    "term_url": "{{"TERM_URL"}}"
  }
}</code></pre>
          </li>
          <li>Payment Page goes to dummy <b>ACS_URL</b> from callback with appropriate data</li>
          <li>User sends form on ACS emulated page to Payment Page <b>TERM_URL</b></li>
          <li>Payment page closes ACS window and sends request to dummy complete endpoint</li>
          <li>Dummy completes action at store and replies with next callback</li>
        </ol>

        <p class="fs-5">APS action flow</p>
        <CTable hover bordered>
          <CTableBody>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>APS_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>APS emulated page provided by mock</CTableDataCell>
              <CTableDataCell>return_url.url</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>
        <ol>
          <li>Payment Page sends initial request</li>
          <li>Dummy accepts <b>awaiting redirect result</b> callback and remember action at dummy transaction state</li>
          <li>Dummy replies <b>awaiting redirect result</b> callback with structure:
            <pre class="m-0" v-highlightjs><code class="javascript">{
  "return_url": {
    "method": "string",
    "body": [],
    "url": "{{"APS_URL"}}"
  }
}</code></pre>
          </li>
          <li>Payment Page goes to dummy <b>APS_URL</b> from callback with appropriate data</li>
          <li>User sends form on APS emulated page back to yourself</li>
          <li>Dummy completes action at store and make redirect to Payment Page return url</li>
          <li>Payment page closes ACS window and await next callback from dummy</li>
        </ol>

        <p class="fs-5">QR action flow</p>
        <CTable hover bordered>
          <CTableBody>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>QR_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>QR emulated page provided by mock</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>

        <p class="fs-5">Clarification action flow</p>
      </COffcanvasBody>
    </COffcanvas>
</template>

<script>
import CopyElement from "@/components/common/CopyElement";

export default {
  components: {
    CopyElement,
  },
  props: {
    disabled: Boolean,
  },
  methods: {
    hide() {
      this.$emit('hide');
    },
  }
}
</script>

<style>
.offcanvas-start {
  width: 550px;
  font-size: 14px;
}
</style>
