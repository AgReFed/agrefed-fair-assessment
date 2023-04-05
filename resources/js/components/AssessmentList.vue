<template>
    <div>
        <b-table
            :items="assessments"
            :fields="fields"
            :small="true"
            head-variant="light"
            sticky-header="900px"
        >
            <template #cell(id)="data">
                <a :href="'assessments/' + data.item.id">{{ data.item.id }}</a>
            </template>

            <template #cell(date)="data">
                Created: {{ data.item.created_at | niceDate }}<br>
                Updated: {{ data.item.updated_at | niceDate }}
            </template>

            <template #cell(resource)="data">
                {{ data.item.resource_name }}
            </template>

            <template #cell(actions)="data">
                <div v-if="data.item.submitted" class="mt-2">
                    <b-btn variant="primary" class="btn btn-sm" :href="'assessments/' + data.item.id">Show</b-btn>
                </div>
                <div v-else class="mt-2">
                    <b-btn variant="warning" class="btn btn-sm" :href="'assessments/' + data.item.id">Continue to edit</b-btn>

                </div>

            </template>

        </b-table>

    </div>
</template>

<script>
export default {
    data() {
        return {
            assessments: [],
            fields: [
                {
                    key: 'id',
                    label: 'ID',
                    sortable: true,
                    thStyle: {width: "8%"}
                },
                {
                    key: 'date',
                    label: 'Date',
                    sortable: true,
                    thStyle: {width: "12%"}
                },
                {
                    key: 'resource',
                    label: 'Resource',
                    sortable: true,
                    thStyle: {width: "52%"}
                },
                {
                    key: 'actions',
                    label: 'Actions',
                    sortable: true,
                    thStyle: {width: "12%"}
                }
            ]
        }
    },
    filters: {
      niceDate: function (value) {
          if (!value) return ''
          let assess_date = new Date(value); // date is passed as string
          //return (assess_date.getMonth() + 1) + '/' + assess_date.getDate() + '/' +  assess_date.getFullYear() + ' ' +assess_date.getHours()+ ':' +  ("00" + assess_date.getMinutes()).slice(-2);
          return (assess_date.getMonth() + 1) + '/' + assess_date.getDate() + '/' +  assess_date.getFullYear();
      }
    },
    created() {
        this.axios
            .get(this.$apiUrl + "list")
            .then(response => {
                this.assessments = response.data;
            });
    },
    methods: {
    }
}
</script>
