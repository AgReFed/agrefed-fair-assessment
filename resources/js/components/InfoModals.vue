<template>
    <div>
        <b-modal
            id="info-f"
            title="Help"
            ok-only
            content-class="shadow"
        >
            <div v-html="$config.help_f"></div>
        </b-modal>

        <b-modal
            id="info-a"
            title="Help"
            ok-only
        >
            <div v-html="$config.help_a"></div>
        </b-modal>

        <b-modal
            id="info-i"
            title="Help"
            ok-only
        >
            <div v-html="$config.help_i"></div>
        </b-modal>

        <b-modal
            id="info-r"
            title="Help"
            ok-only
        >
            <div v-html="$config.help_r"></div>
        </b-modal>
    </div>
</template>

<script>
export default{
    name: "InfoModals"
}

</script>
