<template>
    <CRow :lg="{ cols: 4 }">
        <CCol v-for="_ in 4">
            <CCard style="width: 19rem">
                <CCardImage v-c-placeholder="{animation: 'wave'}" component="svg" orientation="top" width="100%" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#d8dbe0"></rect>
                </CCardImage>
                <CCardBody>
                    <CCardTitle v-c-placeholder="{animation: 'wave', lg: 12}">
                        <CPlaceholder color="light" :xs="6" />
                    </CCardTitle>
                    <CButton v-c-placeholder="{animation: 'wave'}" class="w-25" color="light" aria-hidden="true" disabled href="#" tabindex="-1">
                        &nbsp;
                    </CButton>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>
