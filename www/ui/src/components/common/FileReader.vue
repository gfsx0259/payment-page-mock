<template>
    <CFormLabel for="logo">Logo</CFormLabel>
    <CFormInput
        @change="handle"
        id="logo"
        type="file"
    />
</template>

<script>
export default {
    name: "FileReader",
    methods: {
        handle(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            if (
                file.name.includes(".png") ||
                file.name.includes(".jpeg") ||
                file.name.includes(".svg") ||
                file.name.includes(".jpg")
            ) {
                reader.onload = event => this.$emit("load", event.target.result);
                reader.onerror = error => console.log(error);

                reader.readAsDataURL(file);
            }
        },
    }
}
</script>
