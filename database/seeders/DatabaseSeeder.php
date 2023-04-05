<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Standard;
use App\Models\Configuration;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $questions_json = Storage::disk("local")->get('questions.json');

        Standard::create ([
            'id' => 1,
            'name' => "AgReFed dataset FAIR test",
            'description' => "FAIR test for agricultural datasets based on a spreadsheet developed by Megan Wong and Kerrie Levett.",
            'version' => "1.1",
            'questions_json' => $questions_json,
        ]);

        Configuration::create ([
            'title' => "AgReFed FAIR Assessment Tool",
            'default_test' => 1, // id of test (standard) which is the default
            'fuji_url' => "http://localhost:1071/fuji/api/v1/",
            'licence' => "https://creativecommons.org/licenses/by/4.0/",
            'help' => "<h1>Help for the AgReFed FAIR Assessment Tool</h1> <p> This tool and the metrics used are based on the <a href=https://www.zenodo.org/record/3993784#.YXEVV_pBwuU target=_blank> Agricultural Research Federation (AgReFed) Technical and Information Policy </a>.<br> For details, please refer to Section 1.1.4 and Appendix 4. </p> <p> Help popups throughout the assessment tool contain content sourced from the <a href=https://ardc.edu.au/resource/fair-data/ target=_blank>ARDC's FAIR data</a> resources. </p> <p> You will need to sign in (or sign up) to use the assessment tool. </p> <p> To assess a dataset or other digital resource, click 'New assessment'. This will open the AgReFed FAIR Assessment form. Enter the name and description of the resource you wish to evaluate and provide a reason (e.g.: initial assessment). Then proceed to answer the questions that relate to the attributes of your dataset (or other resource). </p> <p> The assessment metrics are grouped within the four main principles: findable, accessible, interoperable and reusable. For each of these principles, the tool has a heading with a help button, which opens a pop-up with information about the principle. Every question also has a help button to open a popup with additional information and helpful links related to the question. </p> <p> Each question has a dropdown with possible answers, the default answer being 'unknown'. Choose what best describes your digital resource. Depending on the answer selected, a further text input box will appear asking for evidence, which could be a url or other information. Some fields may be pre-filled from previous answers. You can also select an implementation status. </p> <p> Each question has an optional notes field, where you may enter any comments or questions for your own use. These will be saved with your answers. The idea is that the assessment tool can be used as a work list as well as a indicating FAIR compliance where the answers indicate that AgReFed minimum standards have not yet been met. </p> <p> For each question, a status bar will give immediate feedback about the AgReFed compliance level when an answer has been selected. In addition to this visual feedback, the compliance level will also be shown in the report generated when the form is submitted. </p> <p> Question 2 asks for a metadata URL to support your answer. The URL you supply here will be used to populate the answers for the next few questions. Note that if you enter a valid URL in this field, an automated assessment task will be run in the background to check the machine-readability of the resource. For more information about the automated assessment, please visit the <a href=https://www.f-uji.net/index.php target=_blank>F-UJI Automated FAIR Data Assessment Tool</a>, which was developed as part of the <a href=https://www.fairsfair.eu/ target=_blank>FAIRsFair</a> project. </p> <p> You may leave the assessment at any time. All changes are automatically saved and nothing will be lost if you close the form. To go back to the assessment, locate it by name in the assessment list page and select edit on the result page. You can return to edit your assessment until you submit the for. After that, you cannot edit the assessment, but you have the option to re-asssess your dataset. If you click on this option (in the result page of the assessment), the assessment for will open, pre-populated with the entries from your most recent submitted assessment. You may reassess a dataset multiple times. </p> <p> After submitting the assessment form, or by selecting an assessment from the list of your assessments, the assessment report is displayed. This shows at the top the name and description and date assessed, followed by a section with bar graphs indicating how findable, accessible, interoperable and reusable your dataset is, together with an overall FAIR score. If a valid metadata URL was supplied, the machine readable score from the F-UJI assessement is also shown. Please check the embedded help links for further information. The bottom section of the page shows (in one tab per assessment/reassessment) all questions with answers, status and notes as well as the compliance status. This report can be exported as PDF or CSV, to be used for future reference or to serve as a work list to improve the FAIRness of the resource. </p> <p> All assessments for each signed up user can be found in the assessment listing. A 'show' button next to the name indicates that the latest assessment was submitted, while an 'edit' button means that the latest assessment was not submitted and can still be edited. </p> <p> Future versions of this tool will allow specific tests for agricultural research software, services, vocabs, models and algorithms. The current version is primarily aimed at datasets, but can be used to test other resources. </p>",
            'disclaimer' => "<p><strong>Disclaimer:</strong> By using this tool you agree that your dataset FAIR assessment responses will be recorded for the purposes of the AgReFed project. The data collected will provide usage and frequency metrics to assess the impact of the Tool for users. This data will be used to inform research which is being conducted at Federation University and which is used to inform the planning and development of AgReFed and to assess what ways the platform is facilitating data access, data sharing and data reuse for the agriculture industry. This research has received approval from Federation University Australia's Human Research Ethics Committee (Approval number: A21-046). Important information about this research is contained in the Plain Language Information Statement which is available to review in full <a href='pdf/AgReFed_FAIR_Tool_PLIS.pdf' target='_blank'>here</a>.</p><p>For further information about the Assessment Tool or the research, or to provide feedback please <a href='https://www.agrefed.org.au/Contactus'>contact the Federation University-AgReFed team</a>.</p>",
            'help_f' => "<h2>What does 'Findable' mean?</h2><p>Making data Findable includes assigning a <a href='https://ardc.edu.au/resources/working-with-data/citation-identifiers/' target='_blank'>persistent identifier </a>(like a <a href='https://ardc.edu.au/services/identifier/doi/' target='_blank'>DOI </a>or <a href='https://ardc.edu.au/services/identifier/handle/' target='_blank'>Handle </a>), having rich <a href='https://ardc.edu.au/resources/working-with-data/metadata/' target='_blank'>metadata </a>to describe the data and making sure it is findable through disciplinary and generalist discovery portals (local and international).</p><h4>ARDC FAIR data 101 training videos</h4><p><a href='https://ardc.edu.au/resource/fair-data-101-training-findable-1/' target='_blank'>Findable 1</a></p><p><a href='https://ardc.edu.au/resource/fair-data-101-training-findable-2/' target='_blank'>Findable 2</a></p>",
            'help_a' => "<h2>What does 'Interoperable' mean?</h2><p>To be interoperable (i.e. data that is interpretable by a computer, so that they can be automatically combined with other data) the data will need to use community agreed <a href='https://ardc.edu.au/resources/community-endorsed-data-standards/' target='_blank'>formats</a>, language and <a href='https://ardc.edu.au/services/research-vocabularies-australia/' target='_blank'>vocabularies</a>. The <a href='https://ardc.edu.au/resources/working-with-data/metadata/' target='_blank'>metadata</a> will also need to use a community agreed standards and vocabularies, and contain links to related information using <a href='https://ardc.edu.au/resources/working-with-data/citation-identifiers/' target='_blank'>identifiers</a>.</p><h4>ARDC FAIR data 101 training videos</h4><p><a href='https://ardc.edu.au/resource/fair-data-101-training-interoperable-5/' target='_blank'>Interoperable 5</a></p><p><a href='https://ardc.edu.au/resource/fair-data-101-training-interoperable-6/' target='_blank'>Interoperable 6</a></p>",
            'help_i' => "<h2>What does 'Interoperable' mean?</h2><p>To be interoperable (i.e. data that is interpretable by a computer, so that they can be automatically combined with other data) the data will need to use community agreed <a href='https://ardc.edu.au/resources/community-endorsed-data-standards/' target='_blank'>formats</a>, language and <a href='https://ardc.edu.au/services/research-vocabularies-australia/' target='_blank'>vocabularies</a>. The <a href='https://ardc.edu.au/resources/working-with-data/metadata/' target='_blank'>metadata</a> will also need to use a community agreed standards and vocabularies, and contain links to related information using <a href='https://ardc.edu.au/resources/working-with-data/citation-identifiers/' target='_blank'>identifiers</a>.</p><h4>ARDC FAIR data 101 training videos</h4><p><a href='https://ardc.edu.au/resource/fair-data-101-training-interoperable-5/' target='_blank'>Interoperable 5</a></p><p><a href='https://ardc.edu.au/resource/fair-data-101-training-interoperable-6/' target='_blank'>Interoperable 6</a></p>",
            'help_r' => "<h2>What does 'Reusable' mean?</h2><p>Reusable data should maintain its initial richness. For example, it should not be abridged for the purpose of explaining the findings in one particular publication. It needs a clear machine-readable <a href='https://ardc.edu.au/wp-content/uploads/2019/05/Research-Data-Rights-Management-Guide.pdf' target='_blank'>licence</a> and <a href='https://ardc.edu.au/resources/working-with-data/data-provenance/' target='_blank'>provenance</a> information on how the data was formed. It should also use discipline-specific data and <a href='https://ardc.edu.au/resources/working-with-data/metadata/' target='_blank'>metadata</a> standards to give it rich contextual information that will allow for accurate interpretation and reuse.</p><h4>ARDC FAIR data 101 training videos</h4><p><a href='https://ardc.edu.au/resource/fair-data-101-training-reusable-7/' target='_blank'>Reusable 7</a></p><p><a href='https://ardc.edu.au/resource/fair-data-101-training-reusable-8/' target='_blank'>Reusable 8</a></p>"

        ]);


    }
}
