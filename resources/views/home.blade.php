@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container bg-white p-4">
            <div class="row pb-5">
                <div class="col col-4">
                    <img src="img/AgReFed-Logo-Responsive.jpg" alt="AgReFed Logo" class="p-2"></img>
                </div>
                <div class="cols col-8 mt-3">
                    <h1 class="colour-heading">FAIR Assessment Tool</h1>
                </div>
            </div>
            <b-card title="Assess your agricultural research dataset" class="mb-4">
                <b-card-text>
                    The purpose of this Tool is to assess your agriculture research dataset (or other digital resource) against the AgReFed FAIR metrics laid out in the <a href="pdf/AgReFed-data-policy-and-process-guidelines.pdf" target="_blank">Agricultural Research Federation ( AgReFed ) Data Policy and Process Guidelines</a>.
                </b-card-text>
                <b-card-text>
                    To use this Tool, please sign in or register as a new user. After signing into the Tool, you may view your previous assessment or create a new one. For a new assessment you will be prompted to provide responses to 14 questions about your data set and its metadata.
                </b-card-text>
                <b-card-text>
                    The assessment form contains general help topics as well as help for each question to be completed. Each question is multiple choice, and your answer will provide immediate feedback on your dataset's AgReFed compliance status. You will be asked to enter evidence (Explanations, URLs) to support your answers. Each question/answer also allows you to indicate implementation status and enter other comments. Once you submit your responses, a report will be generated identifying how FAIR (Findable, Accessible, Interoperation and Reusable) your dataset is and whether it complies with the minimum standards set out in the AgReFed FAIR metrics.
                </b-card-text>
                <b-card-text>
                    The assessment tool also allows the re-testing of a dataset, so that any improvement in FAIRness of that dataset can be shown.
                </b-card-text>

                @auth
                    <div class="row text-center p-4">
                        <div class="col">
                            <a class="btn btn-info" href="{{ url('assessment') }}">
                                New assessment
                            </a>
                        </div>
                        <div class="col">
                            <a class="btn btn-info" href="{{ url('assessment_list') }}">
                                View assessments
                            </a>
                        </div>

                    </div>
                @endauth

            </b-card>
            <p><strong>Disclaimer:</strong> By using this tool you agree that your dataset FAIR assessment responses will be recorded for the purposes of the AgReFed project. The data collected will provide usage and frequency metrics to assess the impact of the Tool for users. This data will be used to inform research which is being conducted at Federation University and which is used to inform the planning and development of AgReFed and to assess what ways the platform is facilitating data access, data sharing and data reuse for the agriculture industry. This research has received approval from Federation University Australia's Human Research Ethics Committee (Approval number: A21-046). Important information about this research is contained in the Plain Language Information Statement which is available to review in full <a href="pdf/AgReFed_FAIR_Tool_PLIS.pdf" target="_blank">here</a>.</p>
            <p>For further information about the Assessment Tool or the research, or to provide feedback please <a href="https://www.agrefed.org.au/Contactus">contact the Federation University-AgReFed team</a>. </p>

        </div>
    </div>
@endsection
