<?php

use App\Models\StudyCourse;
use Illuminate\Database\Seeder;

class StudyCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 2 - 3 months
        StudyCourse::insert([
            [
                'name'                            =>  'ត-បណ្តាញអគ្គិសនីក្នុងអាគារ',
                'en'                              =>  'ត-បណ្តាញអគ្គិសនីក្នុងអាគារ',
                'km'                              =>  'ត-បណ្តាញអគ្គិសនីក្នុងអាគារ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'ជួសជុលបរិក្ខារត្រជាក់',
                'en'                              =>  'ជួសជុលបរិក្ខារត្រជាក់',
                'km'                              =>  'ជួសជុលបរិក្ខារត្រជាក់',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ជួសជុលបរិក្ខារអេឡិចត្រូនិច',
                'en'                              =>  'ជួសជុលបរិក្ខារអេឡិចត្រូនិច',
                'km'                              =>  'ជួសជុលបរិក្ខារអេឡិចត្រូនិច',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ត-តម្លើងបណ្តាញទឹក',
                'en'                              =>  'ត-តម្លើងបណ្តាញទឹក',
                'km'                              =>  'ត-តម្លើងបណ្តាញទឹក',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 2,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ជួសជុលម៉ាស៊ីនបោកគត់',
                'en'                              =>  'ជួសជុលម៉ាស៊ីនបោកគត់',
                'km'                              =>  'ជួសជុលម៉ាស៊ីនបោកគត់',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'កាត់ដេរសម្លៀកបំពាក់',
                'en'                              =>  'កាត់ដេរសម្លៀកបំពាក់',
                'km'                              =>  'កាត់ដេរសម្លៀកបំពាក់',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ធ្វើម្ហូម',
                'en'                              =>  'ធ្វើម្ហូម',
                'km'                              =>  'ធ្វើម្ហូម',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'កុំព្យូទ័រ',
                'en'                              =>  'កុំព្យូទ័រ',
                'km'                              =>  'កុំព្យូទ័រ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 5,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'បដិសណ្ធារកិច្ច',
                'en'                              =>  'បដិសណ្ធារកិច្ច',
                'km'                              =>  'បដិសណ្ធារកិច្ច',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ភាសាអង់គ្លេស',
                'en'                              =>  'ភាសាអង់គ្លេស',
                'km'                              =>  'ភាសាអង់គ្លេស',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ភាសាកូរ៉េ',
                'en'                              =>  'ភាសាកូរ៉េ',
                'km'                              =>  'ភាសាកូរ៉េ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

        ]);

        // C1
        StudyCourse::insert([
            [
                'name'                            =>  'សេវាកម្មរដ្ធបាល',
                'en'                              =>  'សេវាកម្មរដ្ធបាល',
                'km'                              =>  'សេវាកម្មរដ្ធបាល',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => 1,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'ត-តម្លើងអគ្គិសនីក្នុងអាគារ',
                'en'                              =>  'ត-តម្លើងអគ្គិសនីក្នុងអាគារ',
                'km'                              =>  'ត-តម្លើងអគ្គិសនីក្នុងអាគារ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => 1,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ជាងកំបោរ',
                'en'                              =>  'ជាងកំបោរ',
                'km'                              =>  'ជាងកំបោរ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => 1,
                'study_faculty_id'                => 1,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ជាងម៉ាស៊ីនត្រជាក់រថយន្ត',
                'en'                              =>  'ជាងម៉ាស៊ីនត្រជាក់រថយន្ត',
                'km'                              =>  'ជាងម៉ាស៊ីនត្រជាក់រថយន្ត',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => 1,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ជាងផ្សារលោហៈ',
                'en'                              =>  'ជាងផ្សារលោហៈ',
                'km'                              =>  'ជាងផ្សារលោហៈ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => 1,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
        ]);

        // 1 year
        StudyCourse::insert([
            [
                'name'                            =>  'ព័ត៌មានវិទ្យាសម្រាប់បដិសណ្ធារកិច្ច',
                'en'                              =>  'ព័ត៌មានវិទ្យាសម្រាប់បដិសណ្ធារកិច្ច',
                'km'                              =>  'ព័ត៌មានវិទ្យាសម្រាប់បដិសណ្ធារកិច្ច',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 5,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'en'                              =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'km'                              =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មសត្វ',
                'en'                              =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មសត្វ',
                'km'                              =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មសត្វ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មដំណាំ',
                'en'                              =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មដំណាំ',
                'km'                              =>  'គ្រប់គ្រងប្រព័ន្ធផលិតកម្មដំណាំ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ផលិតកម្មនិងកសិកម្មចំរុះ',
                'en'                              =>  'ផលិតកម្មនិងកសិកម្មចំរុះ',
                'km'                              =>  'ផលិតកម្មនិងកសិកម្មចំរុះ',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'សិក្សានិងប៉ានប្រមាណតម្លៃសំណង់ធុនស្រាល',
                'en'                              =>  'សិក្សានិងប៉ានប្រមាណតម្លៃសំណង់ធុនស្រាល',
                'km'                              =>  'សិក្សានិងប៉ានប្រមាណតម្លៃសំណង់ធុនស្រាល',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'អគ្កិសនី អេឡិចត្រនិច បរិក្ចារត្រជាក់ និងបណ្តាញទឹក',
                'en'                              =>  'អគ្កិសនី អេឡិចត្រនិច បរិក្ចារត្រជាក់ និងបណ្តាញទឹក',
                'km'                              =>  'អគ្កិសនី អេឡិចត្រនិច បរិក្ចារត្រជាក់ និងបណ្តាញទឹក',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'អគ្កិសនីរថយន្ត',
                'en'                              =>  'អគ្កិសនីរថយន្ត',
                'km'                              =>  'អគ្កិសនីរថយន្ត',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'បរិក្ចារត្រជាក់',
                'en'                              =>  'បរិក្ចារត្រជាក់',
                'km'                              =>  'បរិក្ចារត្រជាក់',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'អ្នកជំនាញអគ្គិសនីក្នុងអាគារ និងគេហដ្ធាន',
                'en'                              =>  'អ្នកជំនាញអគ្គិសនីក្នុងអាគារ និងគេហដ្ធាន',
                'km'                              =>  'អ្នកជំនាញអគ្គិសនីក្នុងអាគារ និងគេហដ្ធាន',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'អេឡិចត្រូនិច',
                'en'                              =>  'អេឡិចត្រូនិច',
                'km'                              =>  'អេឡិចត្រូនិច',
                'course_type_id'                  => 1,
                'institute_id'                    => 1,
                'study_program_id'                => null,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
        ]);

        // 2 years
        StudyCourse::insert([
            [
                'name'                            =>  'វិទ្យាសាស្រ្តកំព្យួទ័រ',
                'en'                              =>  'វិទ្យាសាស្រ្តកំព្យួទ័រ',
                'km'                              =>  'វិទ្យាសាស្រ្តកំព្យួទ័រ',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => 5,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'វិស្វកម្មអគ្គិសនី',
                'en'                              =>  'វិស្វកម្មអគ្គិសនី',
                'km'                              =>  'វិស្វកម្មអគ្គិសនី',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
            [
                'name'                            =>  'វិស្វកម្មសំណង់ស៊ីវិល',
                'en'                              =>  'វិស្វកម្មសំណង់ស៊ីវិល',
                'km'                              =>  'វិស្វកម្មសំណង់ស៊ីវិល',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => 1,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'វិស្វកម្មអេឡិចត្រនិច',
                'en'                              =>  'វិស្វកម្មអេឡិចត្រនិច',
                'km'                              =>  'វិស្វកម្មអេឡិចត្រនិច',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'វិស្វកម្មបរិក្ខារត្រជាក់',
                'en'                              =>  'វិស្វកម្មបរិក្ខារត្រជាក់',
                'km'                              =>  'វិស្វកម្មបរិក្ខារត្រជាក់',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => 4,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'en'                              =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'km'                              =>  'សណ្ធាគារនិងបដិសណ្ធារកិច្ច',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'វិទ្យាសាស្ត្រគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'en'                              =>  'វិទ្យាសាស្ត្រគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'km'                              =>  'វិទ្យាសាស្ត្រគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 4,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],
        ]);

        // 4 years
        StudyCourse::insert([
            [
                'name'                            =>  'អគ្គិសនីនិងអេឡិចត្រនិច',
                'en'                              =>  'អគ្គិសនីនិងអេឡិចត្រនិច',
                'km'                              =>  'អគ្គិសនីនិងអេឡិចត្រនិច',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => 3,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'វិទ្យាសាស្ត្រកុំព្យូទ័រ',
                'en'                              =>  'វិទ្យាសាស្ត្រកុំព្យូទ័រ',
                'km'                              =>  'វិទ្យាសាស្ត្រកុំព្យូទ័រ',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => 5,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'គណនេយ្យ',
                'en'                              =>  'គណនេយ្យ',
                'km'                              =>  'គណនេយ្យ',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ធនាគារនិងហិរញ្ញវត្ថុ',
                'en'                              =>  'ធនាគារនិងហិរញ្ញវត្ថុ',
                'km'                              =>  'ធនាគារនិងហិរញ្ញវត្ថុ',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'វិទ្យាសាស្រ្តគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'en'                              =>  'វិទ្យាសាស្រ្តគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'km'                              =>  'វិទ្យាសាស្រ្តគ្រប់គ្រងកសិកម្ម និងអភិវឍ្ឍសេដ្ធកិច្ច',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'គ្រប់គ្រង់',
                'en'                              =>  'គ្រប់គ្រង់',
                'km'                              =>  'គ្រប់គ្រង់',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

            [
                'name'                            =>  'ទីផ្សារ',
                'en'                              =>  'ទីផ្សារ',
                'km'                              =>  'ទីផ្សារ',
                'course_type_id'                  => 2,
                'institute_id'                    => 1,
                'study_program_id'                => 5,
                'study_faculty_id'                => null,
                'study_modality_id'               => 3,
                'study_overall_fund_id'           => 1,
                'curriculum_author_id'            => 2,
                'curriculum_endorsement_id'       => 2,

            ],

        ]);
    }
}
