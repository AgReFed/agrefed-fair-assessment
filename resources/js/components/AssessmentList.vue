<template>
    <div>
<!--        <table class="table">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>ID</th>-->
<!--                <th>Name</th>-->
<!--                <th>Url</th>-->
<!--                <th>Created</th>-->
<!--                <th>Reason</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr v-for="assessment in assessments" :key="assessment.id">-->
<!--                <td>{{ assessment.id }}</td>-->
<!--                <td><a :href="'assessments/' + assessment.id">{{ assessment.resource_name }}</a></td>-->
<!--                <td><a :href="assessment.url" target="_blank">{{ assessment.resource_url }}</a></td>-->
<!--                <td>{{ assessment.created_at | niceDate }}</td>-->
<!--                <td>{{ assessment.assessment_reason }}</td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        </table>-->

        <!-- display questions and results array-->
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
<!--                <a :href="'assessments/' + data.item.id">{{ data.item.resource_name }}</a><br>-->
<!--                <b-link :href="data.item.resource_url" target="_blank">{{ data.item.resource_url }}</b-link>-->
            </template>

            <template #cell(actions)="data">
                <div v-if="data.item.submitted" class="mt-2">
                    <b-btn variant="primary" class="btn btn-sm" :href="'assessments/' + data.item.id">Show</b-btn>
<!--                    <b-btn variant="info" class="btn btn-sm">Reassess</b-btn>-->
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
