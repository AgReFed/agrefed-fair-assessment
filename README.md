# AgReFed FAIR Assessment Tool

<a href="https://agrefed.org.au" target="_blank"><img src="https://www.agrefed.org.au/images/AgReFed-Logo.jpg?v2" alt="AgReFed logo" width="400"></a>

## About this tool
The vision of the [Australian Agricultural Research Federation (AgReFed)](https://www.agrefed.org.au/) is **"to enable FAIR Agricultural data to accelerate innovation in and increase profitability and sustainability of Australian Agriculture"**. The FAIR assessment tool is part of the AgReFed Platform, and was released in early 2023 as one of the work packages of the AgReFed project.

The Assessment tool's background and key functionality is described in the peer-reviewed journal article: Bahlo, C. 2024. Advancing FAIR Agricultural Data: The AgReFed FAIR Assessment Tool. Data Science Journal, 23: 18, pp. 1–11. DOI: [https://doi.org/10.5334/dsj-2024-018](https://doi.org/10.5334/dsj-2024-018)

The [AgReFed Fair Assessment tool](http://assessment.agrefed.org.au) is free to use online, only requiring user registration (email, organisation, role). It is an application that allows data custodians and others to check datasets against the AgReFed FAIR data metrics. 

The AgReFed FAIR assessment tool is a Laravel/Vue application with a PostgreSQL database. For installation instructions, please refer below. The FAIR assessment minimum thresholds which form the basis of the assessment metrics used in the tool are based on AgReFed's Technical and Information Policy Suite<sup>[1](#references)</sup>.

As a secondary integrated automated assessment, it uses the API of the F-UJI (FAIRsFAIR Research Data Object Assessment Service)<sup>[2](#references)</sup> to check each dataset's metadata URL (if supplied) for machine readability. An endpoint to this API must be accessible to the AgReFed FAIR tool, so it will be necessary to install this Python application. Note that the AgReFed FAIR assessment tool will run without the F-UJI integration, but F-UJI scores won't be generated and displayed on the assessment result page. 

### Prerequisites
- PostgreSQL
- Php 8
- node/npm


### Installation
- clone the repo
- create a postgres database
- copy .env.example as .env, update database settings, APP_URL, (note: this must be a full url including the protocol) as per your hosting setup 
- key:generate
- composer install
- npm install
- npm run dev (or production) if required (note: source includes compiled js/css assets to avoid running npm on prod server)
- php artisan migrate
- php artisan db:seed
- check 
- install the F-UJI API, all instructions are provided in the [F-UJI tool's GitHub repo](https://github.com/pangaea-data-publisher/fuji), noting the API's URL
- check settings in the Configurations table of the database, in particular, check the fuji_url setting (amend with your FUJI API url) and update the other fields as necessary.

### Notes
**Database tables and naming**

configurations: This table contains settings such as the title, licence, F-UJI API URL and some static page content. These settings are not user editable.

standards: A standard is a set of metrics to apply to a digital resource. Currently, only one standard (for datasets) has been developed for AgReFed. It contains a set of FAIR metrics in JSON format. These standards are not user editable.

assessments: An assessment compares a digital resource against a standard based on the information entered by a signed in user. This table records the user and resource name.

results: The results of an assessment (and each subsequent re-assessment) are recorded in JSON format (along with the associated F-UJI result - if available), this is a child of the assessments table.


**Database Seeder**

The database seeder will add a record for a default assessment standard (datasets, AgReFed standards) to the standards table. This will normally have an id of 1, while there is only one record in this table (refer also "Next steps" below).


**Changes to previous version**

This software is version 2 of the AgReFed FAIR assessment tool, and provides a number of upgrade from the first version, such as:
- Scores were added so that improvements made to the FAIRness of a digital resource are shown even if the resource still does not meet the required standard
- Bar graphs were added to the assessment results page, for both the assessment scores and the F-UJI scores
- Ability to re-assess at digital resource, presenting the assessment form pref-filled with the last assessment entries
- All assessments and re-assessments are shown on the same page, with tabs for each subsequent assessment, and csv export and printing is available for each set of assessment results
- Auto-save: changes entered in the assessment form will be saved after every change
- A user can exit an assessment and return any time to complete and submit the assessment
- All configuration settings have been moved to the database



### Next steps

It is envisaged that a future version of this software will provide the user with the option to select from more than one standard (ie: datasets, software, others..). It is also possible to substitute the AgReFed standard with another standard, if this softwere were to be adopted by other organisations.


### Contributing

Suggestions are welcome. Please contact c.bahlo@federation.edu.au


### License

This tool is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<hr>

### References

1. MacLeod, A, et al. (2020). The Agricultural Research Federation (AgReFed) Technical and Information Policy Suite. The Agricultural Research Federation. DOI: [https://doi.org/10.5281/ZENODO.3993784](https://doi.org/10.5281/ZENODO.3993784)  

2. Anusuriya Devaraju, & Robert Huber. (2020). F-UJI - An Automated FAIR Data Assessment Tool (v1.0.0). Zenodo. [https://doi.org/10.5281/zenodo.4063720](https://doi.org/10.5281/zenodo.4063720)

