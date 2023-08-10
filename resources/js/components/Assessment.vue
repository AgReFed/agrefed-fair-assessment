<template>
    <!-- eslint-disable-next-line vue/max-attributes-per-line -->
    <div>

        <h5>Version {{ form.assessment_version }}</h5>

        <b-alert
            :show="dismissCountDown"
            variant="danger"
            dismissible
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged"
        >
            {{ alert_message }}
        </b-alert>

        <b-form
            v-if="show"
            :id="'assessmentForm'"
            @submit.prevent="submitAssessment"
        >
            <slot>
                <!-- CSRF gets injected into this slot -->
            </slot>

            <!-- Input fields for assessment metadata -->
            <b-card
                class="mt-4 mb-4"
                header="Assessment Details"
                header-bg-variant="dark"
                header-text-variant="light"
                header-tag="h5"
            >

                <b-row class="my-2">
                    <b-col sm="3">
                        <label :for="'resource_name'">Name of digital resource</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-input
                            :id="'resource_name'"
                            v-model="form.resource_name"
                            :type="'text'"
                            required
                            @change="createAssessment"
                        />
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col sm="3">
                        <label :for="'resource_description'">Description of digital resource</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-textarea
                            :id="'resource_description'"
                            v-model="form.resource_description"
                            rows="3"
                            max-rows="6"
                            required
                            @change="updateAssessment()"
                        />
                    </b-col>
                </b-row>

                <b-row class="my-2">
                    <b-col sm="3">
                        <label :for="'assessment_reason'">Reason for assessment</label>
                    </b-col>
                    <b-col sm="7">
                        <b-form-input
                            :id="'assessment_reason'"
                            v-model="form.assessment_reason"
                            :type="'text'"
                            required
                            @change="updateAssessment()"
                        />
                    </b-col>
                </b-row>

            </b-card>

            <!-- Assessment questions - loop through array of questions -->
            <div
                v-for="(question, key) in questions"
                :key="question.id"
            >

                <!-- Conditional group Headings to logically split questions into F,A,I,R -->
                <div
                    v-if="question.id === 1"
                    class="alert alert-info py-1 colour-secondary-heading"
                >
                    <b-button
                        v-b-modal.info-f
                        variant="light"
                        class="btn-sm"
                    >
                        <b-icon
                            icon="question"
                            class="rounded-circle bg-info"
                            variant="light"
                            font-scale="2"
                        />
                    </b-button>
                     FINDABLE
                </div>

                <div
                    v-else-if="question.id === 5"
                    class="alert alert-info py-1 colour-secondary-heading"
                >
                    <b-button
                        v-b-modal.info-a
                        variant="light"
                        class="btn-sm"
                    >
                        <b-icon
                            icon="question"
                            class="agrefed-green rounded-circle bg-info"
                            variant="light"
                            font-scale="2"
                        />
                    </b-button>
                     ACCESSIBLE
                </div>

                <div
                    v-else-if="question.id === 8"
                    class="alert alert-info py-1 colour-secondary-heading"
                >
                    <b-button
                        v-b-modal.info-i
                        variant="light"
                        class="btn-sm"
                    >
                        <b-icon
                            icon="question"
                            class="agrefed-green rounded-circle bg-info"
                            variant="light"
                            font-scale="2"
                        />
                    </b-button>
                     INTEROPERABLE
                </div>

                <div
                    v-else-if="question.id === 12"
                    class="alert alert-info py-1 colour-secondary-heading"
                >
                    <b-button
                        v-b-modal.info-r
                        variant="light"
                        class="btn-sm"
                    >
                        <b-icon
                            icon="question"
                            class="agrefed-green rounded-circle bg-info"
                            variant="light"
                            font-scale="2"
                        />
                    </b-button>
                     REUSABLE
                </div>
                <!-- End Group Headings -->

                <!-- Questions with selectable answers and related info (evidence, status, notes)  -->
                <b-container class="bv-example-row">
                    <b-row>
                        <b-col
                            cols="11"
                            class="pl-0"
                        >
                            <b-form-group
                                :label="question.Question"
                                :label-for="'levels-' + question.id"
                                label-size="lg"
                            >

                                <b-form-select
                                    :id="'levels-' + question.id"
                                    v-model="form.assessment_results[key].selection"
                                    :name="question.Number"
                                    :options="question.Options"
                                    required
                                    @change="processSelection(key);updateAssessment()"
                                />

                            </b-form-group>
                        </b-col>

                        <b-col
                            cols="1"
                            align-self="end"
                            class="pr-0"
                        >
                            <!-- Help button to display context-sensitive modal (per question) -->
                            <b-button
                                v-b-modal="'help-' + question.id"
                                variant="light"
                                class="mb-3 float-right btn-sm"
                            >
                                <b-icon
                                    icon="question"
                                    class="agrefed-green rounded-circle bg-info"
                                    variant="light"
                                    font-scale="2"
                                />
                            </b-button>

                            <b-modal
                                :id="'help-' + question.id"
                                :title="'Help - Question ' + question.id"
                                ok-only
                                hide-backdrop
                                content-class="shadow"
                            >
                                <!-- eslint-disable vue/no-v-html -->
                                <div
                                    v-if="question.Help"
                                    class="my-5"
                                    v-html="question.Help"
                                >
                                    {{ question.Help }}
                                </div>
                                <!--eslint-enable-->

                                <!-- display default info in case question has no specific help/info-->
                                <p
                                    v-else
                                    class="my-5"
                                >
                                    Please refer to the
                                    <a
                                        href="https://ardc.edu.au/resources/working-with-data/fair-data/"
                                        target="_blank"
                                    >
                                        ARDC FAIR data resources
                                    </a>.
                                </p>
                            </b-modal>
                        </b-col>

                    </b-row>
                </b-container>

                <!-- Evidence label and input box -->
                <!-- don't display input box before answer is selected and if selection requires no evidence -->
                <b-form-group
                    v-if="(form.assessment_results[key].selection !== null) && (question.Options[form.assessment_results[key].selection].evidence)"
                    :label="question.Options[form.assessment_results[key].selection].evidence"
                    :label-for="'evidence-' + question.id"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    content-cols-sm="8"
                    content-cols-lg="8"
                >
                    <b-form-input
                        :id="'evidence-' + question.id"
                        v-model="form.assessment_results[key].evidence"
                        :type="'text'"
                        class="mt-2"
                        @change="metadataProcessing(question.Number);updateAssessment()"
                    />
                </b-form-group>

                <!-- Status selection -->
                <b-form-group
                    :label="'Status'"
                    :label-for="'status-' + question.id"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    content-cols-sm="8"
                    content-cols-lg="8"
                    class="mb-4"
                >

                    <b-form-select
                        :id="'status-' + question.id"
                        v-model="form.assessment_results[key].status"
                        :name="'status-' + question.id"
                        :options="status_options"
                        @change="updateAssessment()"
                    />

                </b-form-group>

                <!-- Notes text input area -->
                <b-form-group
                    :label="'Notes'"
                    :label-for="'notes-' + question.id"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    content-cols-sm="8"
                    content-cols-lg="8"
                >

                    <b-form-textarea
                        :id="'notes-' + question.id"
                        v-model="form.assessment_results[key].assessment_notes"
                        rows="3"
                        size="sm"
                        @change="updateAssessment()"
                    />
                </b-form-group>

                <!-- coloured bar to give immediate feedback on AgReFed compliance status for each question/answer-->
                <b-progress
                    :id="'compliance-bar-' + question.id"
                    :max="3"
                    class="mb-5 mt-0"
                >
                    <b-progress-bar
                        :value="question.Options[form.assessment_results[key].selection].compliance"
                        :variant="compliance_levels[question.Options[form.assessment_results[key].selection].compliance].class"
                    />
                    <b-tooltip
                        :target="'compliance-bar-' + question.id"
                    >
                        Agrefed compliance level:<br>
                        <b>
                            {{ compliance_levels[question.Options[form.assessment_results[key].selection].compliance].text }}
                        </b><br>
                        Score: {{ question.Options[form.assessment_results[key].selection].score }}
                    </b-tooltip>

                </b-progress>

            </div>
            <!-- end assessment question section -->

            <b-row class="mb-5">
                <b-col sm="3">
                    <b-button
                        type="submit"
                        class="bg-success"
                    >Submit and show results
                    </b-button>
                </b-col>
            </b-row>

        </b-form>

        <!-- Component with modals of info/help on FAIR principles -->
        <InfoModals />

    </div>

</template>

<style>

</style>

<script>
import InfoModals from './InfoModals';

export default {
    name: 'Assessment',
    components: {
        'InfoModals': InfoModals
    },
    data() {
        return {
            current_result: null,
            totalQuestions: null,
            questions: null,
            compliance_levels: null,
            status_options:null,
            form: {
                user_id: this.$userId,
                assessment_id: null,
                result_id: null,
                resource_name: '',
                resource_description: '',
                assessment_reason: '',
                resource_url: '',
                fuji_result: null,
                assessment_results: [],
                assessment_version: null,
                submitted: false
            },
            show: true,
            success: false,
            loaded: true,
            alert_message: '',
            dismissSecs: 20,
            dismissCountDown: 0
        }
    },
    mounted: async function() {
        // first load questions from database
        await this.loadQuestions()

        let self = this // save reference

        // if a route param (result assessment id) was passed, open that for editing
        if (typeof window.location.pathname.split('/')[2] !== 'undefined') {
            // work-around because we are not using the vue router

            self.form.result_id = window.location.pathname.split('/')[2]

            await this.axios
                .get(this.$apiUrl + 'results/' + self.form.result_id)
                .then(response => {

                    self.current_result = response.data[0];

                    // only load assessment if it belongs to the logged in user
                    if (Number(self.form.user_id) === Number(self.current_result.assessment.user_id)) {

                        // only load assessment if it is unsubmitted (unfinished)
                        if (self.current_result.submitted === true) {
                            self.alert_message = "You cannot edit a submitted assessment."
                            self.showAlert()
                            window.location.href = window.location.origin + '/assessment_list'

                        } else {
                            self.form.assessment_id = self.current_result.assessment_id;

                            self.form.resource_name = self.current_result.assessment.resource_name
                            self.form.resource_description = self.current_result.assessment.resource_description
                            self.form.assessment_reason = self.current_result.assessment_reason
                            self.form.assessment_results = self.current_result.assessment_result
                            self.form.fuji_result = self.current_result.fuji_result
                        }

                    } else {
                        self.alert_message = "Unauthorised or assessment not found. Please create a new assessment."
                        self.showAlert()
                        window.location.href = window.location.origin + '/assessment_list'
                    }

                })
                .catch(err => {
                    console.log("Error: " + err);
                    window.location.href = window.location.origin + '/assessment_list'
                })
        }
    },
    methods: {
        async loadQuestions() {  // load set of questions (from standards table)

            let self = this

            await this.axios
                .get(this.$apiUrl + 'standards/' + this.$config.default_test)
                .then(response => {
                    self.standard = response.data;
                    self.form.assessment_version = self.standard.version;

                    // get array of questions/answers etc from json field
                    self.json = JSON.parse(self.standard.questions_json);
                    self.questions = self.json.questions;
                    self.totalQuestions = self.questions.length;

                    self.compliance_levels = self.json.compliance_levels;
                    self.status_options = self.json.status_options;

                    // initialise the array of result values
                    _.forEach(self.questions, function (question, i) {
                        let last_element = question.Options.length -1;
                        self.form.assessment_results.push({
                            id: question.id,
                            question: question.Question,
                            selection: 0,
                            answer: "unknown",
                            compliance_level: self.compliance_levels[0].text,
                            score: 0,
                            evidence: "",
                            status: "",
                            assessment_notes: "",
                            max_score: question.Options[last_element].score
                        });
                    });
                })
                .catch(err => console.log("Load questions error: " + err))
        },
        metadataProcessing(question) {
            // q2 evidence is the metadata url, which is a special case
            // pre-populate metadata urls following completion of Q2 and send url to fuji api

            let self = this

            if (question === "q-2") {

                self.form.resource_url = self.form.assessment_results[1].evidence

                self.form.assessment_results[2].evidence = self.form.resource_url;
                self.form.assessment_results[3].evidence = self.form.resource_url;
                self.form.assessment_results[4].evidence = self.form.resource_url;
                self.form.assessment_results[5].evidence = self.form.resource_url;

                this.runFujiAssessment(self.form.resource_url);
                // can run in the background
            }
        },
        runFujiAssessment(metadata_url) {
            // if user provided valid metadata url, run fuji assessment on it

            if(this.isValidHttpUrl(metadata_url)) {

                var headers = {
                    "Authorization": "Basic bWFydmVsOndvbmRlcndvbWFu",
                    "Content-Type": "application/json",
                    "Access-Control-Allow-Origin": "*"
                }
                var data = {
                    "metadata_service_endpoint": "",
                    "metadata_service_type": "oai_pmh", // options: ogc csw or sparql
                    "object_identifier": metadata_url,
                    "test_debug": true,
                    "use_datacite": true
                }

                this.axios
                    // call the fuji API'S evaluate endpoint (needs auth and header)
                    .post(this.$config.fuji_url + 'evaluate', data, {headers:headers})
                    .then(response => {
                        this.form.fuji_result = response.data;
                    })
                    .catch(err => {
                        this.form.fuji_result = err;
                    })
            }
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        isValidHttpUrl(httpUrl) {
            let url;
            try {
                url = new URL(httpUrl)
            } catch {
                return false
            }
            return true
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        },
        createAssessment(){
            // called when user has selected new assessment and has filled in name field

            if(this.form.result_id === null) {

                // no assessment result id, so create a new assessment

                let self = this

                this.axios
                    .post(this.$apiUrl + 'assessments', this.form)
                    .then(response => {
                        self.form.assessment_id = response.data.assessment_id;
                        self.form.result_id = response.data.id;
                        //post request returns id of new assessment, open view with that id
                    })
                    .catch(err => {
                        console.log(err);
                    })

            } else {

                // if we are editing an existing assessment result, then run update instead
                this.updateAssessment()
            }

        },
        submitAssessment(){
            // mark the assessment as completed and update

            this.form.submitted = true
            this.updateAssessment()

        },
        updateAssessment(){
            // this is called every time a field on the form is updated IF a record exists

            if(this.form.result_id !== null) {
                // if we are editing an existing assessment result, then run update

                this.errors = {};

                this.axios
                    .put(this.$apiUrl + 'assessments', this.form )
                    .then(response => {
                        //console.log("updated record")
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        if (this.form.submitted) {
                            // need to ensure update is done before re-routing when form is submitted
                            window.location.href = window.location.origin + '/assessments/' + this.form.assessment_id;
                        }
                    }
                )
            }
        },
        processSelection(questionIndex) {
          // user has selected answer to a question: set answer, score, compliance level

            let self = this
            const question = self.questions[questionIndex]
            const selection = self.form.assessment_results[questionIndex].selection

            self.form.assessment_results[questionIndex].answer = question.Options[selection].text
            self.form.assessment_results[questionIndex].score = question.Options[selection].score
            self.form.assessment_results[questionIndex].compliance_level = self.compliance_levels[question.Options[selection].compliance].text
        },
        onSubmit(event) {
            event.preventDefault();
        }
    }
}

</script>
