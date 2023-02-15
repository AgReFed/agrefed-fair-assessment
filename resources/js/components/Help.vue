<template>
    <div
        v-html="helpContent"
        class="container bg-white p-4">
    </div>

</template>

<script>
export default {
    name: "Help",
    data() {
        return {
            helpContent: this.$config.help
        }
    }
}
</script>

<style scoped>

</style>
