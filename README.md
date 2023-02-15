#AgReFed FAIR Assessment Tool

<a href="https://laravel.com" target="_blank"><img src="https://www.agrefed.org.au/images/AgReFed-Logo.jpg?v2" alt="AgReFed logo" width="400"></a>

## About this tool
The vision of the Australian Agricultural Research Federation (AgReFed) is **"to enable FAIR Agricultural data to accelerate innovation in and increase profitability and sustainability of Australian Agriculture"**

To help realise this vision, the [AgReFed Fair Assessment tool](http://assessment.agrefed.org.au) is free to use online, however it requires a user registration (email, organisation, role). It is an application that allows data custodians and others to check datasets against the AgReFed FAIR data metrics. As a secondary integrated automated assessment, it runs the dataset's URL against the API of the F-UJI (FAIRsFAIR Research Data Object Assessment Service)<sup>[1](#references)</sup>.

The assessment tool is a Laravel/Vue application. The F-UJI API, which needs to be hosted alongside, is a Python application. Note that the AgReFed FAIR assessment tool will run without the F-UJI integration, but F-UJI scores won't be obtained. 

### Prerequisites
- PostgreSQL
- Php 8
- node/npm


### Installation
- clone the repo
- create a postgres database
- install the F-UJI API, all instructions are provided in the [F-UJI tool's GitHub repo](https://github.com/pangaea-data-publisher/fuji).
- copy .env.example as .env, update database settings, APP_URL, (note: this must be a full url including the protocol) as per your hosting setup 
- check settings in database/seeders/DatabaseSeeder.php, which populates the Configurations table, in particular, check the fuji_url setting (amend with your FUJI API url) and update the other fields as necessary. 
- key:generate
- composer install
- npm install
- npm run dev (or production) if required (note: source includes compiled js assets to avoid running npm on prod server)
- php artisan migrate
- php artisan db:seed

### Notes
This software is an alpha version. Please report bugs, problems or suggestions to c.bahlo@federation.edu.a



Naming: A standard is a set of metrics to apply to a digital resource. An assessment compares a digital resource against a standard. Currently, only one standard (for datasets) has been developed for AgReFed.

The database seeder will add a record for a default assessment standard (datasets, AgReFed standards) to the standards table. This will normally have an id of 1.

The set of questions, selectable answers and rankings are for each standard are contained within a json field in the standards table.

The responses are collected as json and saved in the assessment table and the results table.



This software is version 2 of the AgReFed FAIR assessment tool, and provides a number of upgrade from the first version, such as:
- Scores were added so that improvements made to the FAIRness of a digital resource are shown even if the resource still does not meet the required standard
- Bar graphs were added to the assessment results page, for both the assessment scores and the F-UJI scores
- Ability to re-assess at digital resource, which will pref-fill all form entries in a new form 
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

### References
Anusuriya Devaraju, & Robert Huber. (2020). F-UJI - An Automated FAIR Data Assessment Tool (v1.0.0). Zenodo. [https://doi.org/10.5281/zenodo.4063720](https://doi.org/10.5281/zenodo.4063720)
