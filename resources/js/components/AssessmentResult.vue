<template>
    <div>
        <b-card
            class="mt-4 mb-4"
            header="Resource assessed"
            header-bg-variant="dark"
            header-text-variant="light"
            header-tag="h5"
        >
            <!-- display assessment meta fields -->
            <b-row class="my-2">
                <b-col sm="3">
                    <label>Assessment ID</label>
                </b-col>
                <b-col sm="3">
                    <p class="bold">{{ assessment.id}}</p>
                </b-col>
                <b-col sm="3">
                    <label>Assessment created</label>
                </b-col>
                <b-col sm="3">
                    <p class="bold">{{ assessment.created_at | niceDate }}</p>
                </b-col>
            </b-row>

            <b-row class="my-2">
                <b-col sm="3">
                    <label>Name of digital resource</label>
                </b-col>
                <b-col sm="9">
                    <p class="bold">{{ assessment.resource_name }}</p>
                </b-col>
            </b-row>

            <b-row class="my-2">
                <b-col sm="3">
                    <label>Description of digital resource</label>
                </b-col>
                <b-col sm="9">
                    <p class="bold">{{ assessment.resource_description }}</p>
                </b-col>
            </b-row>

            <hr>

            <b-row class="my-2">
                <b-col sm="6">
                    <b-row>
                        <b-col sm="10">
                            <h4>AgReFed assessment scores</h4>
                        </b-col>
                        <b-col sm="2">
                            <b-button id="agrefed_scores_info_btn" size="sm" variant="white" class="mb-1">
                                <b-icon variant="info" icon="question-circle-fill" aria-label="Help"></b-icon>
                            </b-button>
                            <b-popover target="agrefed_scores_info_btn" triggers="hover" placement="top">
                                <template #title>AgReFed scores</template>
                                The bars in this chart represent percentages calculated from the answers to the questions
                                within each of F, A, I, R and for FAIR overall. <br>
                                Score percentages are <b>not</b> indicative of AgReFed compliance, but they are helpful
                                in showing where progress has been made in the level of FAIRness of a digital resource
                                between an initial and subsequent assessments. Please refer to the assessment results
                                table below to check on compliance levels for each of the AgReFed metrics.<br>
                                Where an assessment has been re-run on a resource, the bars will be stacked in order of
                                the assessments run, with the first assessment at the top and subsequent assessments below.
                            </b-popover>
                        </b-col>
                    </b-row>
                    <div>
                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Findable</label>
                                <b-progress v-for="(percent, index) in assessment_percent_f" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="success"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Accessible</label>

                                <b-progress v-for="(percent, index) in assessment_percent_a" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="success"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Interoperable</label>
                                <b-progress v-for="(percent, index) in assessment_percent_i" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="success"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Reusable</label>
                                <b-progress v-for="(percent, index) in assessment_percent_r" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="success"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>FAIR (overall)</label>

                                <b-progress height="2rem" v-for="(percent, index) in assessment_percent_fair" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="success"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                    </div>


                </b-col>

                <b-col sm="6">
                    <b-row>
                        <b-col sm="10">
                            <h4>F-UJI assessment scores</h4>
                        </b-col>
                        <b-col sm="2">
                            <b-button id="fuji_scores_info_btn" size="sm" variant="white" class="mb-1">
                                <b-icon variant="info" icon="question-circle-fill" aria-label="Help"></b-icon>
                            </b-button>
                            <b-popover target="fuji_scores_info_btn" triggers="hover" placement="top">
                                <template #title>F-UJI scores</template>
                                The bars in this chart represent percentages calculated by the F-UJI assessment tool
                                for each of F, A, I, R and for FAIR overall. They are calculated automatically (if a URL was
                                provided for the digital resource), and are displayed here. They provide an insight into
                                the level of machine-readability of the resource's metadata.<br>
                                Note that the metrics underlying this assessment are slightly different to the AgReFed
                                metrics, so the scores may be different to the AgReFed scores. <br>
                                Where an assessment has been re-run on a resource, the bars will be stacked in order of
                                the assessments run, with the first assessment at the top and subsequent assessments below.
                            </b-popover>
                        </b-col>
                    </b-row>
<!--                    <p-->
<!--                        v-if="fuji_error"-->
<!--                    >-->
<!--                        {{ fuji_error }}-->
<!--                    </p>-->
                    <div>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Findable</label>
                                <b-progress v-for="(percent, index) in fuji_percent_f" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="primary"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Accessible</label>
                                <b-progress v-for="(percent, index) in fuji_percent_a" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="primary"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Interoperable</label>
                                <b-progress v-for="(percent, index) in fuji_percent_i" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="primary"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>Reusable</label>
                                <b-progress v-for="(percent, index) in fuji_percent_r" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="primary"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                        <b-row class="my-1">
                            <b-col sm="12">
                                <label>FAIR (overall)</label>
                                <b-progress height="2rem" v-for="(percent, index) in fuji_percent_fair" :data="percent" :key="index" class="progress">
                                    <b-progress-bar :value="percent" :label="`${percent} %`" variant="primary"></b-progress-bar>
                                </b-progress>
                            </b-col>
                        </b-row>

                    </div>

                </b-col>

            </b-row>

        </b-card>

        <div>
            <b-card
                class="mt-4 mx-0"
                header="Assessment results"
                header-bg-variant="dark"
                header-text-variant="light"
                header-tag="h5"
                no-body
            >
                <b-tabs card content-class="mt-1" >
                    <b-tab v-for="(result, key) in assessment.results"
                           :title="'Assessment ' + (key + 1)"
                           :key="'tab-' + result.id"
                           active
                    >

                        <b-row class="mt-1 mb-3">
                            <b-col sm="3">
                                <label>Assessment date</label>
                                <p class="bold">{{ result.created_at  | niceDate }}</p>
                            </b-col>
                            <b-col sm="3">
                                <label>Assessment Resutl id</label>
                                <p class="bold">{{ result.id }}</p>
                            </b-col>
                            <b-col sm="4">
                                <label>Reason for assessment</label>
                                <p class="bold">{{ result.assessment_reason }}</p>
                            </b-col>

                            <b-col sm="2">

                                <div v-if="result.submitted">
                                    <p>Assessment status:<br><strong>submitted</strong></p>
                                    <b-button
                                        v-if="(key+1) === saved_results_number"
                                        variant="info"
                                        class="btn-sm mt-1 no-print"
                                        block
                                        :href="'/reassessment/'+ result.id"
                                    >
                                        Re-assess resource
                                    </b-button>
                                </div>
                                <div v-else>
                                    <p>Assessment status:<br><strong>not submitted</strong></p>
                                    <b-button
                                        variant="warning"
                                        class="btn-sm mt-1 no-print"
                                        block
                                        :href="'/assessment/' + result.id"
                                    >
                                        Edit assessment
                                    </b-button>
                                </div>

                            </b-col>

                        </b-row>

                        <!-- display questions and results array-->
                        <b-table
                            :items="assessment_results[key]"
                            :fields="fields"
                            :tbody-tr-class="rowClass"
                            :small="true"
                            head-variant="light"
                            class="thick-top-border thick-bottom-border"
                        >
                            <template #cell(compliance_level)="data">
                                <b class="text-dark no-print">{{ data.value }}</b>
                                <h4 class="no-screen">
                                    <b-badge v-if="data.value ==='Not yet'" variant="light">{{ data.value }}</b-badge>
                                    <b-badge v-if="data.value ==='Minimum acceptable'" variant="primary text-light">{{ data.value }}</b-badge>
                                    <b-badge v-if="data.value ==='Acceptable'" variant="info text-light">{{ data.value }}</b-badge>
                                    <b-badge v-if="data.value ==='Acceptable (ideal)'" variant="success">{{ data.value }}</b-badge>
                                </h4>

                            </template>
                        </b-table>

                        <!-- print, download buttons - per tab! -->
                        <b-row
                            class="my-5 no-print"
                        >
                            <b-col sm="3">
                                <b-button
                                    class="bg-primary text-white"
                                    @click="printPage"
                                >
                                    Print results
                                </b-button>
                            </b-col>

                            <b-col sm="3">
                                <download-csv
                                    class="btn bg-primary text-white"
                                    :data="assessment_results[key]"
                                    name="agrefed_assessment.csv"
                                >
                                    Download results (CSV)
                                </download-csv>
                            </b-col>

                            <b-col sm="3">
                                <b-button
                                    v-if="fuji_results[key]"
                                    variant="secondary"
                                    v-b-modal="'show-fuji' + key"
                                    class="btn-sm mt-1 no-print"
                                >
                                    Show full F-UJI JSON
                                </b-button>
                            </b-col>
                        </b-row>

                        <b-modal
                            :id="'show-fuji'+ key"
                            :title="'Full F-UJI result (JSON)'"
                            ok-only
                            hide-backdrop
                            content-class="shadow"
                        >
                            <b-form-textarea
                                :id="'fuji_result' + key"
                                v-model="fuji_results[key]"
                                rows="6"
                                max-rows="12"
                                :disabled="true"
                            />
                        </b-modal>

                    </b-tab>

                </b-tabs>

            </b-card>

        </div>

    </div>
</template>

<style>
label {
    margin-bottom: 0.2rem;
    margin-top: 0.5rem;
}

.thick-top-border {
    border-top: black 2px solid !important;
}

.thick-bottom-border {
    border-bottom: black 2px solid !important;
}

.bold {
    font-weight: bold;
}

.progress {
    margin-bottom: 1px;
}

.progress-bar {
    font-weight: bolder;
    color: black;
    font-family: Arial, Helvetica, sans-serif;
}

@media print{
    .no-print {
        visibility: hidden;
    }
}

@media screen {
    .no-screen {
        visibility: hidden;
    }
}
</style>

<script>
import JsonCSV from 'vue-json-csv';

export default {
    name: 'AssessmentResults',
    components: {
        'downloadCsv': JsonCSV
    },
    data() {
        return {
            assessment: [],
            results: [],
            // work-around because we are not using the vue router
            currentId: window.location.pathname.split('/')[2],
            fuji_score: [],
            fuji_error: [],
            fuji_percent_f: [],
            fuji_percent_a: [],
            fuji_percent_i: [],
            fuji_percent_r: [],
            fuji_percent_fair: [],
            assessment_percent_f: [],
            assessment_percent_a: [],
            assessment_percent_i: [],
            assessment_percent_r: [],
            assessment_percent_fair: [],
            fields: ['question', 'answer', 'compliance_level', 'evidence','status', 'assessment_notes'],
            assessment_results: [],
            fuji_results: [],
            saved_results_number: 0
        }
    },
    filters: {
        niceDate: function (value) {
            if (!value) return ''
            let assess_date = new Date(value); // date is passed as string
            //with time:
            //return assess_date.getDate() + '/' +  (assess_date.getMonth() + 1) + '/' + assess_date.getFullYear() + ' ' +assess_date.getHours()+ ':' +  assess_date.getMinutes();
            return assess_date.getDate() + '/' +  (assess_date.getMonth() + 1) + '/' + assess_date.getFullYear();
        }
    },
    beforeCreate() {
        this.axios
            .get(this.$apiUrl + 'assessments/' + window.location.pathname.split('/')[2])
            .then(response => {
                this.assessment = response.data;

                // temp vars to calculate score percentages for graphs
                let f_score = [], a_score = [], i_score = [], r_score = [], fair_score = [];
                let f_max_score = [], a_max_score = [], i_max_score = [], r_max_score = [], fair_max_score = [];

                // iterate through (re-) assessments
                for (var key in this.assessment.results) {
                    this.saved_results_number += 1;

                    // process agrefed assessment json and fuji json
                    this.assessment_results[key] = this.assessment.results[key].assessment_result;
                    this.fuji_results[key] = this.assessment.results[key].fuji_result;

                    const current_assessment_result = this.assessment_results[key];
                    const current_fuji_result = this.fuji_results[key] ?? null;

                    // temp vars reset
                    f_score[key] = 0;
                    a_score[key] = 0;
                    i_score[key] = 0;
                    r_score[key] = 0;
                    fair_score[key] = 0;
                    f_max_score[key] = 0;
                    a_max_score[key] = 0;
                    i_max_score[key] = 0;
                    r_max_score[key] = 0;
                    fair_max_score[key] = 0;

                    // loop through results array to group scores
                    for (const key2 in current_assessment_result) {
                        let result = current_assessment_result[key2];

                        // calculate total FAIR scores from result
                        fair_score[key] += result.score;
                        fair_max_score[key] += result.max_score;

                        switch (result.id) {
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                                // calculate total for F: Q1 - Q4
                                f_score[key] += result.score;
                                f_max_score[key] += result.max_score;
                                break;

                            case 5:
                            case 6:
                            case 7:
                                //  calculate total for A: Q5 - Q7
                                a_score[key] += result.score;
                                a_max_score[key] += result.max_score;
                                break;

                            case 8:
                            case 9:
                            case 10:
                            case 11:
                                //  calculate total for I: Q8 to Q11
                                i_score[key] += result.score;
                                i_max_score[key] += result.max_score;
                                break;

                            case 12:
                            case 13:
                            case 14:
                                //  calculate total for R: Q9 - Q14
                                r_score[key] += result.score;
                                r_max_score[key] += result.max_score;
                                break;
                        }
                        // save rounded scores for display in progress bars
                        this.assessment_percent_f[key] = Math.round((f_score[key] / f_max_score[key] * 100) * 10) / 10;
                        this.assessment_percent_a[key] = Math.round((a_score[key] / a_max_score[key] * 100) * 10) / 10;
                        this.assessment_percent_i[key] = Math.round((i_score[key] / i_max_score[key] * 100) * 10) / 10;
                        this.assessment_percent_r[key] = Math.round((r_score[key] / r_max_score[key] * 100) * 10) / 10;
                        this.assessment_percent_fair[key] = Math.round((fair_score[key] / fair_max_score[key] * 100) * 10) / 10;

                    } // (const key2 in current_assessment_result)

                    let processFuji = true

                    if (current_fuji_result === null) {
                        // if fuji_results field is empty or null
                        processFuji = false
                    } else {
                        // if fuji_results doesn't have results (fuji api returned an error)
                        if (!('metric_specification' in current_fuji_result)) {
                            processFuji = false
                        }
                    }

                    // show fuji results if available, otherwise zero result so bars show correctly per result
                    if (processFuji === true) {
                        this.fuji_percent_f[key] = current_fuji_result.summary.score_percent.F;
                        this.fuji_percent_a[key] = current_fuji_result.summary.score_percent.A;
                        this.fuji_percent_i[key] = current_fuji_result.summary.score_percent.I;
                        this.fuji_percent_r[key] = current_fuji_result.summary.score_percent.R;
                        this.fuji_percent_fair[key] = current_fuji_result.summary.score_percent.FAIR;
                    } else {
                        this.fuji_error = "F-UJI test result can't be parsed";
                        this.fuji_percent_f[key] = 0;
                        this.fuji_percent_a[key] = 0;
                        this.fuji_percent_i[key] = 0;
                        this.fuji_percent_r[key] = 0;
                        this.fuji_percent_fair[key] = 0;
                    }

                } //(var key in this.assessment.results)

            })
            .catch(err => {
                window.location.href = window.location.origin + '/assessment_list';
            })
    },
    methods: {
        printPage () {
            window.print();
        },
        rowClass(item) {
            // this sets the table row colours
            if (item.compliance_level === "Acceptable (ideal)") return 'compliance-3'
            if (item.compliance_level === "Acceptable") return 'compliance-2'
            if (item.compliance_level === "Minimum acceptable") return 'compliance-1'
        }
    }
}
</script>
