<template>
    <form method="get"
          name="usageTypeForm"
          id="usageTypeForm">
        <label>
            <span class="font-bold">Usage Type:</span>
            <select v-model="usageType"
                    @change="changeUsageType"
                    class="ml-2 py-2 px-3 rounded-md border-2 border-indigo-900 bg-indigo-700 text-white">
                    <option v-for="usageType in usageTypes"
                            v-bind:key="usageType.value"
                            v-bind:value="usageType.value"
                    >{{ usageType.label }}</option>
            </select>
        </label>
    </form>
</template>

<script>
export default {
    name: "UsageTypeForm",
    data() {
        return {
            urlPathBase: '/twilio/usage/',
            recordLimit: 20,
            type: 'last_month',
            usageType: '',
            usageTypes: [
                {
                    'label': 'Last Month',
                    'value': 'last_month'
                },
                {
                    'label': 'Today',
                    'value': 'today'
                },
                {
                    'label': 'All Time',
                    'value': 'all_time'
                },
            ]
        }
    },
    methods: {
        initUsageType() {
            let url = new URL(window.location.href);
            let subPath = url.pathname.replace(this.urlPathBase, '').split('/');
            this.recordLimit = subPath[0];
            this.usageType = subPath[1];
            console.log(this.recordLimit, this.usageType);
        },
        changeUsageType(event) {
            this.usageType = event.target.value;
            window.location.href = `${this.urlPathBase}${this.recordLimit}/${this.usageType}`
        }
    },
    mounted() {
        this.initUsageType()
    }
}
</script>

<style scoped>

</style>
