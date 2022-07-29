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
        <h5>General</h5>
        <p>To emulate some flow you might need auto generated values or producing some action at third-party service. In these purposes we added template variables and dummy pages. Set of template variables is fixed and fully described below.</p>
        <h5>Example of using template variables in a callback:</h5>
        <p>Let's imagine that there is a flow in which we need to have some unique value accessed by `some_id` key. We have the template variable called `SOME_ID`, for example. Using of this one will look like:</p>
        <pre v-highlightjs><code class="javascript">{
  ...
  "some_id": "&#123;&#123;SOME_ID&#125;&#125;",
  ...
}</code></pre>
        <p>When some service will request this callback, the value accessed by `some_id` key will be automatically replaced on real value by rules of the template variable `SOME_ID`.</p>
        <h5>More details about every template variable and flow they can be used in:</h5>
        <p class="fs-5">Common</p>
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

        <p class="fs-5">ACS 1.0 action flow</p>
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
  ...
  "acs": {
    "pa_req": "string",
    "md": "string",
    "acs_url": "&#123;&#123;ACS_URL&#125;&#125;",
    "term_url": "&#123;&#123;TERM_URL&#125;&#125;"
  }
  ...
}</code></pre>
          </li>
          <li>Payment Page goes to dummy <b>ACS_URL</b> from callback with appropriate data</li>
          <li>User sends form on ACS emulated page to Payment Page <b>TERM_URL</b></li>
          <li>Payment page closes ACS window and sends request to dummy complete endpoint</li>
          <li>Dummy completes action at store and replies with next callback</li>
        </ol>

        <p class="fs-5">ACS 2.0 action flow</p>
        <CTable hover bordered>
          <CTableBody>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>ACS_IFRAME_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>This page emulates waiting of async response from ACS</CTableDataCell>
              <CTableDataCell>threeds2.iframe.url</CTableDataCell>
            </CTableRow>
            <CTableRow>
              <CTableDataCell>
                <CopyElement>ACS_REDIRECT_URL</CopyElement>
              </CTableDataCell>
              <CTableDataCell>This page emulates confirmation ACS form</CTableDataCell>
              <CTableDataCell>threeds2.redirect.url</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>
        <ol>
          <li>Payment Page sends initial request</li>
          <li>Dummy accepts <b>awaiting 3ds result</b> callback and remember action at dummy transaction state</li>
          <li>Dummy replies <b>awaiting 3ds result</b> callback with structure:
          <pre class="m-0" v-highlightjs><code class="javascript">{
  ...
  "threeds2": {
    "iframe": {
      "url": "&#123;&#123;ACS_IFRAME_URL&#125;&#125;",
      "params": {
        "3DSMethodData": "string",
        "threeDSMethodData": "string"
      }
    }
  }
  ...
}</code></pre>
          </li>
          <li>Payment Page opens <b>ACS_IFRAME_URL</b> from callback with `threeds2.iframe.params` data</li>
          <li>Opened page sends notification to Payment Page after few second</li>
          <li>Payment Page sends 3ds_check_iframe request to Dummy when notification is received</li>
          <li>Dummy completes action at store and replies with next callback:
            <pre class="m-0" v-highlightjs><code class="javascript">{
  ...
  "threeds2": {
    "redirect": {
      "url": "&#123;&#123;ACS_REDIRECT_URL&#125;&#125;",
      "params": {
        "creq": "string",
        "threeDSSessionData": "string"
      }
    }
  }
  ...
}</code></pre>
          </li>
          <li>Payment Page opens <b>ACS_REDIRECT_URL</b> from callback with `threeds2.iframe.params` data</li>
          <li>Customer clicks the button `submit` to emulate confirmation</li>
          <li>Dummy opens a page which automatically sends request to Payment Page about completing ACS</li>
          <li>Payment Page sends request to Dummy</li>
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
  ...
  "return_url": {
    "method": "string",
    "body": [],
    "url": "&#123;&#123;APS_URL&#125;&#125;"
  }
  ...
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
                <CopyElement>QR_ACCEPT_LINK</CopyElement>
              </CTableDataCell>
              <CTableDataCell>QR emulated page provided by mock</CTableDataCell>
              <CTableDataCell>display_data[0].data</CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>
        <ol>
          <li>Payment Page sends initial request</li>
          <li>Dummy accepts <b>awaiting customer action</b> callback and remember action at dummy transaction state</li>
          <li>Dummy replies <b>awaiting customer action</b> callback with structure:
            <pre class="m-0" v-highlightjs><code class="javascript">{
  ...
  "display_data": [
    {
      "type": "qr_data",
      "title": "QR code",
      "data": "&#123;&#123;QR_ACCEPT_LINK&#125;&#125;"
    }
  ],
  ...
}</code></pre>
          </li>
          <li>User goes to dummy <b>QR_ACCEPT_LINK</b> from callback</li>
          <li>User sends form on QR emulated page back to yourself</li>
          <li>Dummy completes action at store and make redirect to Payment Page return url</li>
          <li>Payment page closes QR window and await next callback from dummy</li>
        </ol>

        <p class="fs-5">Clarification action flow</p>
        <ol>
          <li>Payment Page sends initial request</li>
          <li>Dummy accepts <b>awaiting clarification</b> callback and remember action at dummy transaction state</li>
          <li>Dummy replies <b>awaiting clarification</b> callback with structure:
            <pre class="m-0" v-highlightjs><code class="javascript">{
  ...
  "clarification_fields": {
    "avs_data": [
      "avs_post_code",
      "avs_street_address"
    ]
  },
  ...
}</code></pre>
          </li>
          <li>Payment Page shows fields <b>avs_post_code</b>, <b>avs_street_address</b> to user</li>
          <li>User fills these fields</li>
          <li>Payment page send them to dummy</li>
          <li>Dummy completes clarification and switches to next callback</li>
          <li>Payment page waits next callback from dummy</li>
        </ol>

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
