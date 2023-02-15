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
            'help' => "Please refer to the Agrefed website.",
            'disclaimer' => "",
            'help_f' => "<h2>What does 'Findable' mean?</h2><p>Making data Findable includes assigning a <a href=https://www.ands.org.au/guides/persistent-identifiers-awareness target=_blank>persistent identifier </a>(like a <a href=https://www.ands.org.au/guides/doi target=_blank>DOI </a>or <a href=https://www.ands.org.au/guides/identify-my-data target=_blank>Handle </a>), having rich <a href=https://www.ands.org.au/working-with-data/metadata target=_blank>metadata </a>to describe the data and making sure it is findable through disciplinary and generalist discovery portals (local and international).</p>",
            'help_a' => "<h2>What does 'Accesssible' mean?</h2><p><a href=https://www.ands.org.au/working-with-data/publishing-and-reusing-data/publishing target=_blank>To make data accessible</a> may include making the data <a href=https://www.ands.org.au/working-with-data/articulating-the-value-of-open-data/open-data target=_blank>open</a> using a standardised protocol. However the data does not necessarily have to be open. There are sometimes good reasons why data <a href=https://www.ands.org.au/working-with-data/sensitive-data target=_blank>cannot be made open</a>, for example privacy concerns, national security or commercial interests. If it is not open there should be clarity and transparency around the conditions governing access and <a href=https://www.ands.org.au/working-with-data/publishing-and-reusing-data/licensing-for-reuse target=_blank>reuse</a>.</p>",
            'help_i' => "<h2>What does 'Interoperable' mean?</h2><p>To be interoperable (i.e. data that is interpretable by a computer, so that they can be automatically combined with other data) the data will need to use community agreed <a href=https://www.ands.org.au/guides/file-formats target=_blank>formats</a>, language and <a href=https://www.ands.org.au/guides/vocabularies-and-research-data target=_blank>vocabularies</a>. The <a href=https://www.ands.org.au/working-with-data/metadata target=_blank>metadata</a> will also need to use a community agreed standards and vocabularies, and contain links to related information using <a href=https://www.ands.org.au/working-with-data/citation-and-identifiers target=_blank>identifiers</a>.</p>",
            'help_r' => "<h2>What does 'Reusable' mean?</h2><p>Reusable data should maintain its initial richness. For example, it should not be abridged for the purpose of explaining the findings in one particular publication. It needs a clear machine-readable <a href=http://www.ands.org.au/working-with-data/publishing-and-reusing-data/licensing-for-reuse target=_blank>licence</a> and <a href=https://www.ands.org.au/partners-and-communities/ands-communities/data-provenance-interest-group target=_blank>provenance</a> information on how the data was formed. It should also use discipline-specific data and <a href=https://www.ands.org.au/working-with-data/metadata target=_blank>metadata</a> standards to give it rich contextual information that will allow for accurate interpretation and reuse.</p>"

        ]);


    }
}
