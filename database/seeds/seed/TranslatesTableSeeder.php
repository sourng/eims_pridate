<?php

use App\Models\Translates;
use Illuminate\Database\Seeder;

class TranslatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Translates::insert([
            [
                'phrase' => 'about',
                'en' => 'About Institute',
                'km' => 'អំពីវិទ្យាស្ថាន'
            ],
            [
                'phrase' => 'absent',
                'en' => 'Absent',
                'km' => 'អវត្តមាន'
            ],
            [
                'phrase' => 'absent_was_not_record_day',
                'en' => 'Absent was not record day',
                'km' => 'ពុំទាន់ដល់ថ្ងៃចុះអវត្តមានទេ'
            ],
            [
                'phrase' => 'absent_was_not_recorded',
                'en' => 'Absent was not recorded',
                'km' => 'ពុំទាន់បានចុះអវត្តមាន'
            ],
            [
                'phrase' => 'account',
                'en' => 'Account',
                'km' => 'គណនី'
            ],
            [
                'phrase' => 'account_status',
                'en' => 'Account Status',
                'km' => 'ស្ថានភាពគណនី'
            ],
            [
                'phrase' => 'add',
                'en' => 'Add',
                'km' => 'បន្ថែម'
            ],
            [
                'phrase' => 'add_absent',
                'en' => 'Add Absent',
                'km' => 'ចុះវត្តមាន'
            ],
            [
                'phrase' => 'add_by',
                'en' => 'Add By',
                'km' => 'បញ្ចូលតាម'
            ],
            [
                'phrase' => 'add_new_option',
                'en' => 'Add New Option',
                'km' => 'បន្ថែមជម្រើសថ្មី'
            ],
            [
                'phrase' => 'add_this_to_your_saved_items',
                'en' => 'Add this to your saved items',
                'km' => 'បញ្ចូល​វា​ទៅក្នុង​ធាតុដែលអ្នកបានរក្សាទុក'
            ],
            [
                'phrase' => 'address',
                'en' => 'Address',
                'km' => 'អាស័យដ្ឋាន'
            ],
            [
                'phrase' => 'admin',
                'en' => 'Admin',
                'km' => 'អ្នកគ្រប់គ្រង'
            ],
            [
                'phrase' => 'administrator',
                'en' => 'Administrator',
                'km' => 'អ្នកគ្រប់គ្រង'
            ],
            [
                'phrase' => 'after_after_tomorrow',
                'en' => 'After After Tomorrow',
                'km' => 'បន្ទាប់ពីថ្ងៃស្អែក'
            ],
            [
                'phrase' => 'after_tomorrow',
                'en' => 'After Tomorrow',
                'km' => 'ខានស្អែក'
            ],
            [
                'phrase' => 'age',
                'en' => 'Age',
                'km' => 'អាយុ'
            ],
            [
                'phrase' => 'all',
                'en' => 'All',
                'km' => 'ទាំងអស់'
            ],
            [
                'phrase' => 'all_day',
                'en' => 'All Day',
                'km' => 'ពេញមួយថ្ងៃ'
            ],
            [
                'phrase' => 'already_exists',
                'en' => 'already exists',
                'km' => 'មាន​រួចហើយ'
            ],
            [
                'phrase' => 'and',
                'en' => 'and',
                'km' => 'និង'
            ],
            [
                'phrase' => 'angry',
                'en' => 'Angry',
                'km' => 'ខឹង'
            ],
            [
                'phrase' => 'answer',
                'en' => 'Answer',
                'km' => 'ចម្លើយ'
            ],
            [
                'phrase' => 'answer_again',
                'en' => 'Answer Again',
                'km' => 'អោយឆ្លើយម្តងទៀត'
            ],
            [
                'phrase' => 'answered',
                'en' => 'Answered',
                'km' => 'បានឆ្លើយ'
            ],
            [
                'phrase' => 'app',
                'en' => 'App',
                'km' => 'កម្មវិធី'
            ],
            [
                'phrase' => 'app_name',
                'en' => 'App Name',
                'km' => 'ឈ្មោះកម្មវិធី'
            ],
            [
                'phrase' => 'application',
                'en' => 'Application',
                'km' => 'កម្មវិធី'
            ],
            [
                'phrase' => 'apply_now',
                'en' => 'Apply Now',
                'km' => 'ដាក់ពាក្យ​ឥឡូវនេះ'
            ],
            [
                'phrase' => 'approved',
                'en' => 'approved',
                'km' => 'បានអនុម័ត'
            ],
            [
                'phrase' => 'are_you_sure',
                'en' => 'Are you sure',
                'km' => 'តើ​អ្នក​ប្រាកដ​ឬ​អត់'
            ],
            [
                'phrase' => 'as',
                'en' => 'as',
                'km' => 'ជា'
            ],
            [
                'phrase' => 'attendance',
                'en' => 'Attendance',
                'km' => 'វត្តមាន'
            ],
            [
                'phrase' => 'attendance_marks',
                'en' => 'Attendance marks',
                'km' => 'ពិន្ទុចូលរួម'
            ],
            [
                'phrase' => 'attendance_score​',
                'en' => 'Attendance Score​',
                'km' => 'ពិន្ទុចូលរួម'
            ],
            [
                'phrase' => 'attendance_type',
                'en' => 'Attendance Type',
                'km' => 'ប្រភេទវត្តមាន'
            ],
            [
                'phrase' => 'avatar',
                'en' => 'Avatar',
                'km' => 'រូបភាព'
            ],
            [
                'phrase' => 'average',
                'en' => 'Average',
                'km' => 'មធ្យម'
            ],
            [
                'phrase' => 'back',
                'en' => 'Back',
                'km' => 'ថយក្រោយ'
            ],
            [
                'phrase' => 'background',
                'en' => 'Background',
                'km' => 'ផ្ទៃខាងក្រោយ'
            ],
            [
                'phrase' => 'below',
                'en' => 'below',
                'km' => 'ខាងក្រោម'
            ],
            [
                'phrase' => 'big_image',
                'en' => 'Big image',
                'km' => 'រូបភាពធំ'
            ],
            [
                'phrase' => 'biography',
                'en' => 'Biography',
                'km' => 'ជីវប្រវត្ត'
            ],
            [
                'phrase' => 'black',
                'en' => 'Black',
                'km' => 'ខ្មៅ'
            ],
            [
                'phrase' => 'blood_group',
                'en' => 'blood_group',
                'km' => 'ក្រុមឈាម'
            ],
            [
                'phrase' => 'calendar',
                'en' => 'Calendar',
                'km' => 'ប្រតិទិន'
            ],
            [
                'phrase' => 'call_use',
                'en' => 'call',
                'km' => 'ហៅមកប្រើ'
            ],
            [
                'phrase' => 'can_not',
                'en' => 'can\'t',
                'km' => 'មិនអាច'
            ],
            [
                'phrase' => 'cancel',
                'en' => 'Cancel',
                'km' => 'បោះបង់'
            ],
            [
                'phrase' => 'card',
                'en' => 'Card',
                'km' => 'កាត'
            ],
            [
                'phrase' => 'certificate',
                'en' => 'Certificate',
                'km' => 'វិញ្ញាបនបត្រ'
            ],
            [
                'phrase' => 'characters',
                'en' => 'characters',
                'km' => 'តួអក្សរ'
            ],
            [
                'phrase' => 'choose',
                'en' => 'Choose',
                'km' => 'ជ្រើសរើស'
            ],
            [
                'phrase' => 'class',
                'en' => 'Class',
                'km' => 'ថ្នាក់'
            ],
            [
                'phrase' => 'close',
                'en' => 'Close',
                'km' => 'បិទ'
            ],
            [
                'phrase' => 'cn',
                'en' => '中国',
                'km' => 'ភាសាចិន'
            ],
            [
                'phrase' => 'code',
                'en' => 'code',
                'km' => 'កូដ'
            ],
            [
                'phrase' => 'code_name​',
                'en' => 'Code Name​',
                'km' => 'ឈ្មោះកូដ'
            ],
            [
                'phrase' => 'color',
                'en' => 'Color',
                'km' => 'ពណ៌'
            ],
            [
                'phrase' => 'comment',
                'en' => 'Comment',
                'km' => 'មតិ'
            ],
            [
                'phrase' => 'commented',
                'en' => 'Commented',
                'km' => 'បានផ្តល់យោបល់'
            ],
            [
                'phrase' => 'commune',
                'en' => 'Commune',
                'km' => 'ឃុំ'
            ],
            [
                'phrase' => 'contact',
                'en' => 'Contact',
                'km' => 'ទំនាក់ទំនង'
            ],
            [
                'phrase' => 'continues_later',
                'en' => 'Continues Later',
                'km' => 'បន្តនៅពេលក្រោយ'
            ],
            [
                'phrase' => 'correct_answer',
                'en' => 'Correct Answer',
                'km' => 'ជាចម្លើយ​ត្រឹមត្រូវ'
            ],
            [
                'phrase' => 'country_code',
                'en' => 'Country Code',
                'km' => 'លេខកូដប្រទេស'
            ],
            [
                'phrase' => 'course',
                'en' => 'Course',
                'km' => 'មុខជំនាញ'
            ],
            [
                'phrase' => 'course_type​',
                'en' => 'Course Type​',
                'km' => 'ប្រភេទវគ្គសិក្សា'
            ],
            [
                'phrase' => 'course_type​_name',
                'en' => 'Course Type​ Name',
                'km' => 'ឈ្មោះប្រភេទវគ្គសិក្សា'
            ],
            [
                'phrase' => 'create',
                'en' => 'Create',
                'km' => 'បង្កើត'
            ],
            [
                'phrase' => 'create_account',
                'en' => 'Create account',
                'km' => 'បង្កើតគណនី'
            ],
            [
                'phrase' => 'create_new_account',
                'en' => 'Create new account',
                'km' => 'បង្កើតគណនីថ្មី'
            ],
            [
                'phrase' => 'create_post',
                'en' => 'Create Post',
                'km' => 'បង្កើតការបង្ហោះសារ'
            ],
            [
                'phrase' => 'credit_absent',
                'en' => 'Credit Absent',
                'km' => 'ស្តង់ដារវត្តមាន'
            ],
            [
                'phrase' => 'credit_hour',
                'en' => 'Credit Hour',
                'km' => 'ម៉ោង'
            ],
            [
                'phrase' => 'current_resident',
                'en' => 'Current Resident',
                'km' => 'រស់នៅបច្ចុប្បន្ន'
            ],
            [
                'phrase' => 'curriculum_author​',
                'en' => 'Curriculum Author​',
                'km' => 'អ្នកនិពន្ធកម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'curriculum_author_name',
                'en' => 'Curriculum Author Name',
                'km' => 'ឈ្មោះអ្នកនិពន្ធកម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'curriculum_endorsement​',
                'en' => 'Curriculum Endorsement​',
                'km' => 'ការយល់ព្រមតាមកម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'curriculum_endorsement_name',
                'en' => 'Curriculum Endorsement Name',
                'km' => 'ឈ្មោះការយល់ព្រមកម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'dashboard',
                'en' => 'Dashboards',
                'km' => 'ផ្ទាំងគ្រប់គ្រង'
            ],
            [
                'phrase' => 'date',
                'en' => 'Date',
                'km' => 'កាលបរិច្ឆេទ'
            ],
            [
                'phrase' => 'date_of_birth',
                'en' => 'Date of Birth',
                'km' => 'ថ្ងៃខែឆ្នាំកំណើត'
            ],
            [
                'phrase' => 'day',
                'en' => 'Day',
                'km' => 'ថ្ងៃ'
            ],
            [
                'phrase' => 'dd_mm_yyyy',
                'en' => 'dd-mm-yyyy',
                'km' => 'ថ្ងៃទី-ខែ-ឆ្នាំ'
            ],
            [
                'phrase' => 'default',
                'en' => 'default',
                'km' => 'លំនាំដើម'
            ],
            [
                'phrase' => 'delete',
                'en' => 'Delete',
                'km' => 'លុប'
            ],
            [
                'phrase' => 'deleted',
                'en' => 'Deleted',
                'km' => 'បានលុប'
            ],
            [
                'phrase' => 'description',
                'en' => 'Description',
                'km' => 'ពិពណ៌នា'
            ],
            [
                'phrase' => 'designation',
                'en' => 'Designation',
                'km' => 'ផ្នែក & តួនាទី'
            ],
            [
                'phrase' => 'detail_of',
                'en' => 'Detail of',
                'km' => 'ពត៌មានរបស់'
            ],
            [
                'phrase' => 'district',
                'en' => 'District',
                'km' => 'ស្រុក'
            ],
            [
                'phrase' => 'divorced',
                'en' => 'Divorced',
                'km' => 'លែងលះ'
            ],
            [
                'phrase' => 'dob',
                'en' => 'Birth Date',
                'km' => 'ថ្ងៃខែឆ្នាំកំណើត'
            ],
            [
                'phrase' => 'drop_image_here',
                'en' => 'Drop Image here',
                'km' => 'ទម្លាក់រូបភាពនៅទីនេះ'
            ],
            [
                'phrase' => 'drop_photo_here',
                'en' => 'Drop photo here',
                'km' => 'ទម្លាក់រូបថតនៅទីនេះ'
            ],
            [
                'phrase' => 'edit',
                'en' => 'Edit',
                'km' => 'កែប្រែ'
            ],
            [
                'phrase' => 'edit_post',
                'en' => 'Edit post',
                'km' => 'កែសម្រួលការបង្ហោះសារនេះ'
            ],
            [
                'phrase' => 'email',
                'en' => 'Email',
                'km' => 'អ៊ីម៉ែល'
            ],
            [
                'phrase' => 'Embed',
                'en' => 'Embed',
                'km' => 'បង្កប់'
            ],
            [
                'phrase' => 'emergency_name',
                'en' => 'Emergency Name',
                'km' => 'ឈ្មោះទំនាក់ទំនងបន្ទាន់'
            ],
            [
                'phrase' => 'emergency_phone',
                'en' => 'Emergency Phone',
                'km' => 'ទូរស័ព្ទទំនាក់ទំនងបន្ទាន់'
            ],
            [
                'phrase' => 'empty',
                'en' => 'Empty',
                'km' => 'ទទេ'
            ],
            [
                'phrase' => 'en',
                'en' => 'English',
                'km' => 'ភាសាអង់គ្លេស'
            ],
            [
                'phrase' => 'end_time',
                'en' => 'End Time',
                'km' => 'ពេលវេលាបញ្ចប់'
            ],
            [
                'phrase' => 'enter_all_fields_above_before_continue',
                'en' => 'Enter all fields above before continue',
                'km' => 'បញ្ចូលទិន្នន័យទាំងអស់ខាងលើសិនមុនពេលបន្តទៀត'
            ],
            [
                'phrase' => 'entries',
                'en' => 'entries',
                'km' => 'ធាតុ'
            ],
            [
                'phrase' => 'error',
                'en' => 'Error',
                'km' => 'កំហុស'
            ],
            [
                'phrase' => 'even',
                'en' => 'Even',
                'km' => 'ព្រឹតិ្តការណ៍'
            ],
            [
                'phrase' => 'excel',
                'en' => 'Excel',
                'km' => 'អ៊ីហ្សែល'
            ],
            [
                'phrase' => 'exists_absent',
                'en' => 'Exists Absent',
                'km' => 'វត្តមានបានចុះរួចហើយ'
            ],
            [
                'phrase' => 'experience',
                'en' => 'Experience',
                'km' => 'បទពិសោធន៍'
            ],
            [
                'phrase' => 'experience_info',
                'en' => 'Experience Information',
                'km' => 'ព័ត៌មានបទពិសោធន៍'
            ],
            [
                'phrase' => 'expired',
                'en' => 'Expired',
                'km' => 'ផុតកំណត់'
            ],
            [
                'phrase' => 'extra_info',
                'en' => 'Extra Information',
                'km' => 'ព័ត៌មានបន្ថែម'
            ],
            [
                'phrase' => 'facebook',
                'en' => 'facebook',
                'km' => 'ហ្វេសប៊ុក'
            ],
            [
                'phrase' => 'faculty',
                'en' => 'Faculty',
                'km' => 'មហាវិទ្យាល័យ'
            ],
            [
                'phrase' => 'fail',
                'en' => 'Fail',
                'km' => 'បរាជ័យ'
            ],
            [
                'phrase' => 'father',
                'en' => 'Father',
                'km' => 'ឳពុក'
            ],
            [
                'phrase' => 'father_email',
                'en' => 'Father Email',
                'km' => 'អ៊ីម៉ែលឳពុក'
            ],
            [
                'phrase' => 'father_fullname',
                'en' => 'Father Full Name',
                'km' => 'ឈ្មោះឳពុក'
            ],
            [
                'phrase' => 'father_info',
                'en' => 'Father Information',
                'km' => 'ព័ត៌មានរបស់ឳពុក'
            ],
            [
                'phrase' => 'father_is_guardian',
                'en' => 'Father is Guardian',
                'km' => 'ឳពុកគឺជាអាណាព្យាបាល'
            ],
            [
                'phrase' => 'father_phone',
                'en' => 'Father Phone',
                'km' => 'លេខទូរស័ព្ទឳពុក'
            ],
            [
                'phrase' => 'feature',
                'en' => 'Feature',
                'km' => 'លក្ខណៈពិសេស (រូបភាព Slide)'
            ],
            [
                'phrase' => 'female',
                'en' => 'Female',
                'km' => 'ស្រី'
            ],
            [
                'phrase' => 'field_list',
                'en' => 'in field list',
                'km' => 'បញ្ចីតារាង (table)'
            ],
            [
                'phrase' => 'field_required',
                'en' => 'Field required input.',
                'km' => 'តម្រូវអោយអ្នកបញ្ចូល'
            ],
            [
                'phrase' => 'File',
                'en' => 'File',
                'km' => 'File'
            ],
            [
                'phrase' => 'filter',
                'en' => 'Filter',
                'km' => 'ចំរុះទិន្នន័យ'
            ],
            [
                'phrase' => 'first_name',
                'en' => 'First Name',
                'km' => 'នាមត្រកូល'
            ],
            [
                'phrase' => 'first_name_en',
                'en' => 'First Name( EN)',
                'km' => 'នាមត្រកូល (ឡាតាំង)'
            ],
            [
                'phrase' => 'first_name_km',
                'en' => 'First Name (KM)',
                'km' => 'នាមត្រកូល (ខ្មែរ)'
            ],
            [
                'phrase' => 'for',
                'en' => 'for',
                'km' => 'សម្រាប់'
            ],
            [
                'phrase' => 'forbidden',
                'en' => 'Forbidden',
                'km' => 'ហាមឃាត់'
            ],
            [
                'phrase' => 'forgot',
                'en' => 'forgot',
                'km' => 'ភ្លេច'
            ],
            [
                'phrase' => 'fr',
                'en' => 'Français',
                'km' => 'ភាសាបារាំង'
            ],
            [
                'phrase' => 'frame',
                'en' => 'Frame',
                'km' => 'ស៊ុម'
            ],
            [
                'phrase' => 'frame_background',
                'en' => 'Frame Background',
                'km' => 'ផ្ទៃខាងក្រោយស៊ុម'
            ],
            [
                'phrase' => 'frame_front',
                'en' => 'Frame Front',
                'km' => 'ផ្ទៃខាងមុខស៊ុម'
            ],
            [
                'phrase' => 'full_mark_practical',
                'en' => 'Full mark practical',
                'km' => 'ពិន្ទុពេញរបស់អនុវត្ត'
            ],
            [
                'phrase' => 'full_mark_theory',
                'en' => 'Full mark theory',
                'km' => 'ពិន្ទុពេញរបស់ទ្រីស្តី'
            ],
            [
                'phrase' => 'fullname',
                'en' => 'Fullname',
                'km' => 'ឈ្មោះពេញ'
            ],
            [
                'phrase' => 'gallery',
                'en' => 'Gallery',
                'km' => 'វិចិត្រសាល'
            ],
            [
                'phrase' => 'gender',
                'en' => 'Gender',
                'km' => 'ភេទ'
            ],
            [
                'phrase' => 'general',
                'en' => 'General',
                'km' => 'ទូទៅ'
            ],
            [
                'phrase' => 'google',
                'en' => 'google',
                'km' => 'ហ្គូហ្គោល'
            ],
            [
                'phrase' => 'goto',
                'en' => 'Goto',
                'km' => 'ទៅកាន់'
            ],
            [
                'phrase' => 'government_official_id',
                'en' => 'Government Official Id',
                'km' => 'លេខសម្គាល់ផ្លូវការរបស់រដ្ឋាភិបាល'
            ],
            [
                'phrase' => 'grade',
                'en' => 'Grade',
                'km' => 'ចំណាត់ថ្នាក់'
            ],
            [
                'phrase' => 'grid',
                'en' => 'Grid',
                'km' => 'ក្រឡាចត្រង្គ'
            ],
            [
                'phrase' => 'guardian',
                'en' => 'Guardian',
                'km' => 'អាណាព្យាបាល'
            ],
            [
                'phrase' => 'guardian_email',
                'en' => 'Guardian Email',
                'km' => 'អ៊ីម៉ែលអាណាព្យាបាល'
            ],
            [
                'phrase' => 'guardian_fullname',
                'en' => 'Guardian Full Name',
                'km' => 'ឈ្មោះអាណាព្យាបាល'
            ],
            [
                'phrase' => 'guardian_phone',
                'en' => 'Guardian Phone',
                'km' => 'លេខទូរស័ព្ទអាណាព្យាបាល'
            ],
            [
                'phrase' => 'haha',
                'en' => 'Haha',
                'km' => 'ហាហា'
            ],
            [
                'phrase' => 'has_account',
                'en' => 'Has account',
                'km' => 'មានគណនី'
            ],
            [
                'phrase' => 'holiday',
                'en' => 'Holiday',
                'km' => 'ថ្ងៃឈប់សម្រាក'
            ],
            [
                'phrase' => 'home',
                'en' => 'Home',
                'km' => 'ទំព័រដើម'
            ],
            [
                'phrase' => 'horizontal',
                'en' => 'Horizontal',
                'km' => 'ផ្ដេក'
            ],
            [
                'phrase' => 'hour',
                'en' => 'hour',
                'km' => 'ម៉ោង'
            ],
            [
                'phrase' => 'I\'m_concerned_about_this_post',
                'en' => 'I\'m concerned about this post',
                'km' => 'ខ្ញុំមានការព្រួយបារម្ភអំពីការបង្ហោះនេះ'
            ],
            [
                'phrase' => 'id',
                'en' => 'ID',
                'km' => 'អត្តលេខ'
            ],
            [
                'phrase' => 'image',
                'en' => 'Image',
                'km' => 'រូបភាព'
            ],
            [
                'phrase' => 'in',
                'en' => 'in',
                'km' => 'នៅក្នុង'
            ],
            [
                'phrase' => 'incrrent',
                'en' => 'incrrent',
                'km' => 'មិនត្រឹមត្រូវ'
            ],
            [
                'phrase' => 'institute',
                'en' => 'Institute',
                'km' => 'វិទ្យាស្ថាន'
            ],
            [
                'phrase' => 'institute_info',
                'en' => 'Institute Information',
                'km' => 'ព័ត៌មានវិទ្យាស្ថាន'
            ],
            [
                'phrase' => 'institution_staff_id',
                'en' => 'Institution Staff Id',
                'km' => 'លេខាធិការបុគ្គលិក'
            ],
            [
                'phrase' => 'is',
                'en' => 'is',
                'km' => 'គឺជា'
            ],
            [
                'phrase' => 'items',
                'en' => 'items',
                'km' => 'ធាតុ'
            ],
            [
                'phrase' => 'jp',
                'en' => '日本',
                'km' => 'ភាសាជប៉ុន'
            ],
            [
                'phrase' => 'kilobytes',
                'en' => 'kilobytes',
                'km' => 'គីឡូបៃ'
            ],
            [
                'phrase' => 'km',
                'en' => 'ភាសាខ្មែរ',
                'km' => 'ភាសាខ្មែរ'
            ],
            [
                'phrase' => 'kr',
                'en' => '한국어',
                'km' => 'ភាសាកូរ៉េ'
            ],
            [
                'phrase' => 'la',
                'en' => 'ພາສາລາວ',
                'km' => 'ភាសាឡាវ'
            ],
            [
                'phrase' => 'landscape',
                'en' => 'Landscape',
                'km' => 'ផ្តេក'
            ],
            [
                'phrase' => 'language',
                'en' => 'Language',
                'km' => 'ភាសា'
            ],
            [
                'phrase' => 'language_name',
                'en' => 'Language Name',
                'km' => 'ឈ្មោះភាសា'
            ],
            [
                'phrase' => 'last_name',
                'en' => 'Last Name',
                'km' => 'នាមខ្លួន'
            ],
            [
                'phrase' => 'last_name_en',
                'en' => 'Last Name (EN)',
                'km' => 'នាមខ្លួន (ឡាតាំង)'
            ],
            [
                'phrase' => 'last_name_km',
                'en' => 'Last Name (KM)',
                'km' => 'នាមខ្លួន (ខ្មែរ)'
            ],
            [
                'phrase' => 'layout',
                'en' => 'Layout',
                'km' => 'ទម្រង់'
            ],
            [
                'phrase' => 'lesson',
                'en' => 'Lesson',
                'km' => 'មេរៀន'
            ],
            [
                'phrase' => 'like',
                'en' => 'Like',
                'km' => 'ចូលចិត្ត'
            ],
            [
                'phrase' => 'link',
                'en' => 'Link',
                'km' => 'តំណ'
            ],
            [
                'phrase' => 'list',
                'en' => 'List',
                'km' => 'បញ្ចី'
            ],
            [
                'phrase' => 'loading',
                'en' => 'Loading',
                'km' => 'កំពុងដំណើរការ'
            ],
            [
                'phrase' => 'location​',
                'en' => 'Location​',
                'km' => 'ទីតាំង'
            ],
            [
                'phrase' => 'login',
                'en' => 'Login',
                'km' => 'ចូលប្រើ'
            ],
            [
                'phrase' => 'logo',
                'en' => 'Logo',
                'km' => 'រូបសញ្ញា'
            ],
            [
                'phrase' => 'logout',
                'en' => 'Logout',
                'km' => 'ចាកចេញ'
            ],
            [
                'phrase' => 'long',
                'en' => 'Long',
                'km' => 'វគ្គវែង'
            ],
            [
                'phrase' => 'long_course',
                'en' => 'Long course',
                'km' => 'សិក្សាវគ្គវែង'
            ],
            [
                'phrase' => 'love',
                'en' => 'Love',
                'km' => 'ស្រលាញ់​'
            ],
            [
                'phrase' => 'make',
                'en' => 'Make',
                'km' => 'បង្កើត'
            ],
            [
                'phrase' => 'male',
                'en' => 'Male',
                'km' => 'ប្រុស'
            ],
            [
                'phrase' => 'marital',
                'en' => 'Marital',
                'km' => 'ស្ថានភាពគ្រួសារ'
            ],
            [
                'phrase' => 'marks',
                'en' => 'marks',
                'km' => 'ពិន្ទុ'
            ],
            [
                'phrase' => 'marksed',
                'en' => 'Marksed',
                'km' => 'បានពិន្ទុ'
            ],
            [
                'phrase' => 'married',
                'en' => 'Married',
                'km' => 'រៀបការ'
            ],
            [
                'phrase' => 'max_array',
                'en' => 'may not have more than',
                'km' => 'ប្រហែលជាមិនមានច្រើនជាង'
            ],
            [
                'phrase' => 'max_file',
                'en' => 'may not be greater than',
                'km' => 'ប្រហែលជាមិនធំជាង'
            ],
            [
                'phrase' => 'max_numeric',
                'en' => 'may not be greater than',
                'km' => 'ប្រហែលជាមិនធំជាង'
            ],
            [
                'phrase' => 'max_string',
                'en' => 'may not be greater than',
                'km' => 'ច្រើនបំផុត'
            ],
            [
                'phrase' => 'message',
                'en' => 'Message',
                'km' => 'សារ'
            ],
            [
                'phrase' => 'min_array',
                'en' => 'must have at least',
                'km' => 'ត្រូវតែមានយ៉ាងហោចណាស់'
            ],
            [
                'phrase' => 'min_file',
                'en' => 'must be at least',
                'km' => 'ត្រូវតែយ៉ាងហោចណាស់គឺ'
            ],
            [
                'phrase' => 'min_numeric',
                'en' => 'must be at least',
                'km' => 'តិចបំផុត​​​​​​'
            ],
            [
                'phrase' => 'min_string',
                'en' => 'must be at least',
                'km' => 'តិចបំផុត​​​​​​'
            ],
            [
                'phrase' => 'modality​',
                'en' => 'Modality​',
                'km' => 'គំរូ'
            ],
            [
                'phrase' => 'month',
                'en' => 'Month',
                'km' => 'ខែ'
            ],
            [
                'phrase' => 'more',
                'en' => 'more',
                'km' => 'បន្ថែមទៀត'
            ],
            [
                'phrase' => 'More_options',
                'en' => 'More options',
                'km' => '​ជម្រើស​​ច្រើន​ទៀត'
            ],
            [
                'phrase' => 'most_absent',
                'en' => 'Most Absent',
                'km' => 'អវត្តមានច្រើន'
            ],
            [
                'phrase' => 'mother',
                'en' => 'Mother',
                'km' => 'ម្តាយ'
            ],
            [
                'phrase' => 'mother_email',
                'en' => 'Mother Email',
                'km' => 'អ៊ីម៉ែលម្តាយ'
            ],
            [
                'phrase' => 'mother_fullname',
                'en' => 'Mother Full Name',
                'km' => 'ឈ្មោះម្តាយ'
            ],
            [
                'phrase' => 'mother_info',
                'en' => 'Mother Information',
                'km' => 'ព័ត៌មានរបស់ម្តាយ'
            ],
            [
                'phrase' => 'mother_is_guardian',
                'en' => 'Mother is Guardian',
                'km' => 'ម្តាយគឺជាអាណាព្យាបាល'
            ],
            [
                'phrase' => 'mother_phone',
                'en' => 'Mother Phone',
                'km' => 'លេខទូរស័ព្ទម្តាយ'
            ],
            [
                'phrase' => 'mother_tong',
                'en' => 'Mother Tong',
                'km' => 'ភាសាកំណើត'
            ],
            [
                'phrase' => 'my_profile',
                'en' => 'My profile',
                'km' => 'គណនីរបស់ខ្ញុំ'
            ],
            [
                'phrase' => 'name',
                'en' => 'Name',
                'km' => 'ឈ្មោះ'
            ],
            [
                'phrase' => 'national_holiday',
                'en' => 'National Holiday',
                'km' => 'ថ្ងៃឈប់សម្រាកជាតិ'
            ],
            [
                'phrase' => 'national_id',
                'en' => 'National Id',
                'km' => 'អត្ថ​សញ្ញាណ​​ជាតិ'
            ],
            [
                'phrase' => 'nationality',
                'en' => 'nationality',
                'km' => 'សញ្ជាតិ'
            ],
            [
                'phrase' => 'new',
                'en' => 'New',
                'km' => 'ថ្មី'
            ],
            [
                'phrase' => 'new_account',
                'en' => 'New Account',
                'km' => 'គណនីថ្មី'
            ],
            [
                'phrase' => 'new_password',
                'en' => 'New Password',
                'km' => 'ពាក្យសម្ងាត់ថ្មី'
            ],
            [
                'phrase' => 'news',
                'en' => 'News',
                'km' => 'ដំណឹង'
            ],
            [
                'phrase' => 'no_account',
                'en' => 'No account',
                'km' => 'គ្មានគណនី'
            ],
            [
                'phrase' => 'no_cameras_found',
                'en' => 'No cameras found',
                'km' => 'រកមិនឃើញម៉ាស៊ីនថតទេ'
            ],
            [
                'phrase' => 'no_data',
                'en' => 'No Data',
                'km' => 'គ្មាន​ទិន្នន័យ'
            ],
            [
                'phrase' => 'no_password',
                'en' => 'No Password',
                'km' => 'គ្មានពាក្យសម្ងាត់'
            ],
            [
                'phrase' => 'no_student_study_course',
                'en' => 'No student study course',
                'km' => 'គ្មានសិស្សរៀនជំនាញនេះទេ'
            ],
            [
                'phrase' => 'no_study_course_schedule ',
                'en' => 'No Study Course Schedule ',
                'km' => 'ពុំទាន់មានកាលវិភាគជំនាញសិក្សាទេ'
            ],
            [
                'phrase' => 'not_found',
                'en' => 'Not Found',
                'km' => 'រក​មិន​ឃើញ'
            ],
            [
                'phrase' => 'not_match',
                'en' => 'not match',
                'km' => 'មិនត្រឹមត្រូវ'
            ],
            [
                'phrase' => 'not_yet_learned',
                'en' => 'Not yet learned',
                'km' => 'ពុំទាន់មានការសិក្សាទេ'
            ],
            [
                'phrase' => 'note',
                'en' => 'Note',
                'km' => 'ចំណាំ'
            ],
            [
                'phrase' => 'number_of_dependants',
                'en' => 'Number Of Dependants',
                'km' => 'ចំនួនអ្នកអាស្រ័យ'
            ],
            [
                'phrase' => 'numbering',
                'en' => ' Nº',
                'km' => 'ល.រ'
            ],
            [
                'phrase' => 'numeric_only',
                'en' => 'must be a number',
                'km' => 'ត្រូវតែជាលេខ'
            ],
            [
                'phrase' => 'occupation',
                'en' => 'Occupation',
                'km' => 'មុខរបរ'
            ],
            [
                'phrase' => 'of',
                'en' => 'of',
                'km' => 'សម្រាប់'
            ],
            [
                'phrase' => 'offline',
                'en' => 'Offline',
                'km' => 'ក្រៅបណ្តាញ'
            ],
            [
                'phrase' => 'ok',
                'en' => 'Ok',
                'km' => 'យល់ព្រម'
            ],
            [
                'phrase' => 'old_account',
                'en' => 'Old Account',
                'km' => 'គណនីចាស់'
            ],
            [
                'phrase' => 'old_password',
                'en' => 'Old Password',
                'km' => 'ពាក្យសម្ងាត់ចាស់'
            ],
            [
                'phrase' => 'old_password_will_be_use_if_field_password_is_not_input',
                'en' => 'old password will be use if field password is not input',
                'km' => 'ពាក្យសម្ងាត់ចាស់នឹងត្រូវបានប្រើ បើសិនទម្រងពាក្យសម្ងាត់មិនត្រូវបានបញ្ចូល'
            ],
            [
                'phrase' => 'online',
                'en' => 'Online',
                'km' => 'លើបណ្តាញ'
            ],
            [
                'phrase' => 'only_me',
                'en' => 'Only_me',
                'km' => 'ខ្ញុំម្នាក់ប៉ុណ្ណោះ'
            ],
            [
                'phrase' => 'or',
                'en' => 'or',
                'km' => 'រឺ'
            ],
            [
                'phrase' => 'other',
                'en' => 'other',
                'km' => 'ផ្សេងទៀត'
            ],
            [
                'phrase' => 'other_info',
                'en' => 'other information',
                'km' => 'ព័ត៌មាន​ផ្សេងទៀត'
            ],
            [
                'phrase' => 'other_marks',
                'en' => 'Other marks',
                'km' => 'ពិន្ទុផ្សេងទៀត'
            ],
            [
                'phrase' => 'other_score​',
                'en' => 'Other score​',
                'km' => 'ពិន្ទុផ្សេងទៀត'
            ],
            [
                'phrase' => 'p',
                'en' => 'P',
                'km' => 'នាក់'
            ],
            [
                'phrase' => 'page_expired',
                'en' => 'Page Expired',
                'km' => 'ទំព័របានផុតកំណត់'
            ],
            [
                'phrase' => 'pass_mark_practical',
                'en' => 'Pass mark practical',
                'km' => 'ពិន្ទុជាប់របស់អនុវត្ត'
            ],
            [
                'phrase' => 'pass_mark_theory',
                'en' => 'Pass mark theory',
                'km' => 'ពិន្ទុជាប់របស់ទ្រីស្តី'
            ],
            [
                'phrase' => 'password',
                'en' => 'Password',
                'km' => 'ពាក្យសម្ងាត់'
            ],
            [
                'phrase' => 'password_confirm',
                'en' => 'Password confirm',
                'km' => 'បញ្ជាក់​ពាក្យ​សម្ងាត់ម្តងទៀត'
            ],
            [
                'phrase' => 'password_confirmation',
                'en' => 'Password confirmation',
                'km' => 'បញ្ជាក់​ពាក្យ​សម្ងាត់ម្តងទៀត'
            ],
            [
                'phrase' => 'PDF',
                'en' => 'PDF',
                'km' => 'PDF'
            ],
            [
                'phrase' => 'permanent_address',
                'en' => 'Permanent Address',
                'km' => 'អាស័យ​ដ្ឋាន​អ​ចិ​ន្រ្តៃ​យ៍'
            ],
            [
                'phrase' => 'personal_contact',
                'en' => 'Personal Contact',
                'km' => 'ទំនាក់ទំនងផ្ទាល់ខ្លួន'
            ],
            [
                'phrase' => 'phone',
                'en' => 'Phone',
                'km' => 'លេខទូរស័ព្ទ'
            ],
            [
                'phrase' => 'photo',
                'en' => 'Photo',
                'km' => 'រូបថត'
            ],
            [
                'phrase' => 'phrase',
                'en' => 'Phrase',
                'km' => 'ឃ្លា'
            ],
            [
                'phrase' => 'picture',
                'en' => 'Picture',
                'km' => 'រូបភាព'
            ],
            [
                'phrase' => 'place_of_birth',
                'en' => 'place of birth',
                'km' => 'ទីកន្លែងកំណើត'
            ],
            [
                'phrase' => 'please_wait',
                'en' => 'Please wait...',
                'km' => 'សូមរង់ចាំបន្ទិច...'
            ],
            [
                'phrase' => 'pob',
                'en' => 'Place Of Birth',
                'km' => 'ទីកន្លែងកំណើត'
            ],
            [
                'phrase' => 'points',
                'en' => 'points',
                'km' => 'ពិន្ទុ'
            ],
            [
                'phrase' => 'portrait',
                'en' => 'Portrait',
                'km' => 'បញ្ឈរ'
            ],
            [
                'phrase' => 'post',
                'en' => 'Post',
                'km' => 'បង្ហោះសារ'
            ],
            [
                'phrase' => 'print',
                'en' => 'Print',
                'km' => 'ព្រីន'
            ],
            [
                'phrase' => 'processing',
                'en' => 'Processing',
                'km' => 'កំពុងទាញទិន្នន័យ'
            ],
            [
                'phrase' => 'profile',
                'en' => 'Profile',
                'km' => 'គណនី'
            ],
            [
                'phrase' => 'province',
                'en' => 'Province',
                'km' => 'ខេត្ត'
            ],
            [
                'phrase' => 'public',
                'en' => 'Public',
                'km' => 'សាធារណៈ'
            ],
            [
                'phrase' => 'qrcode',
                'en' => 'QR Code',
                'km' => 'QR កូដ'
            ],
            [
                'phrase' => 'qrcode_expired',
                'en' => 'QR code Expired',
                'km' => 'QR កូដបានផុតកំណាត់'
            ],
            [
                'phrase' => 'qualiftion',
                'en' => 'Qualiftion',
                'km' => 'គុណវុឌ្ឍិ'
            ],
            [
                'phrase' => 'question',
                'en' => 'Question',
                'km' => 'សំនួរ'
            ],
            [
                'phrase' => 'quick_links',
                'en' => 'Quick links',
                'km' => 'តំណ​ភ្ជាប់​រហ័ស'
            ],
            [
                'phrase' => 'quiz',
                'en' => 'Quiz',
                'km' => 'ក្រុមសំនួរ'
            ],
            [
                'phrase' => 'quiz_answer',
                'en' => 'Quiz Answer',
                'km' => 'បានឆ្លើយសំណួរ'
            ],
            [
                'phrase' => 'quiz_answer_type',
                'en' => 'Quiz Answer Type',
                'km' => 'ប្រភេទចម្លើយ'
            ],
            [
                'phrase' => 'quiz_group',
                'en' => 'Quiz Group',
                'km' => 'ក្រុមសំនួរ'
            ],
            [
                'phrase' => 'quiz_name',
                'en' => 'Quiz Name',
                'km' => 'ឈ្មោះក្រុមសំនួរ'
            ],
            [
                'phrase' => 'quiz_question',
                'en' => 'Quiz Question',
                'km' => 'សំនួរចំលើយ'
            ],
            [
                'phrase' => 'quiz_question_type',
                'en' => 'Quiz Question Type',
                'km' => 'ប្រភេទសំនួរ'
            ],
            [
                'phrase' => 'quiz_student',
                'en' => 'Quiz Student',
                'km' => 'សំនួរចម្លើយរបស់សិស្ស'
            ],
            [
                'phrase' => 'quiz_type',
                'en' => 'Quiz Type',
                'km' => 'ប្រភេទសំនួរ'
            ],
            [
                'phrase' => 'register',
                'en' => 'Register',
                'km' => 'ចុះឈ្មោះ'
            ],
            [
                'phrase' => 'register_date',
                'en' => 'Register Date',
                'km' => 'ថ្ងៃចុះឈ្មោះ'
            ],
            [
                'phrase' => 'register_number_id',
                'en' => 'Register Number ID',
                'km' => 'លេខចុះឈ្មោះ'
            ],
            [
                'phrase' => 'remember_me',
                'en' => 'Remember me',
                'km' => 'ធ្វើការចងចាំ'
            ],
            [
                'phrase' => 'replied',
                'en' => 'Replied',
                'km' => 'បានឆ្លើយតប'
            ],
            [
                'phrase' => 'reply',
                'en' => 'Reply',
                'km' => 'ឆ្លើយតប'
            ],
            [
                'phrase' => 'report',
                'en' => 'Report',
                'km' => 'របាយការណ៍'
            ],
            [
                'phrase' => 'Report_post',
                'en' => 'Report post',
                'km' => 'រាយការណ៍​អំពើការបង្ហោះសារនេះ'
            ],
            [
                'phrase' => 'request',
                'en' => 'request',
                'km' => 'ស្នើសុំ'
            ],
            [
                'phrase' => 'request_study',
                'en' => 'Request study',
                'km' => 'ស្នើសុំការសិក្សា'
            ],
            [
                'phrase' => 'requesting',
                'en' => 'requesting',
                'km' => 'កំពុងស្នើសុំ'
            ],
            [
                'phrase' => 'required',
                'en' => 'field required',
                'km' => 'ត្រូវតែបញ្ចូល'
            ],
            [
                'phrase' => 'reset_password',
                'en' => 'Reset Password',
                'km' => 'កំណត់ពាក្យសម្ងាត់ឡើងវិញ'
            ],
            [
                'phrase' => 'role',
                'en' => 'Role',
                'km' => 'តួនាទី'
            ],
            [
                'phrase' => 'role_name',
                'en' => 'Role Name',
                'km' => 'ឈ្មោះតួនាទី'
            ],
            [
                'phrase' => 'sad',
                'en' => 'Sad',
                'km' => 'ក្រៀមក្រំ'
            ],
            [
                'phrase' => 'same',
                'en' => 'Same',
                'km' => 'ដូចគ្នាទៅនឹង'
            ],
            [
                'phrase' => 'save',
                'en' => 'Save',
                'km' => 'រក្សាទុក'
            ],
            [
                'phrase' => 'save_post',
                'en' => 'Save Post',
                'km' => 'រក្សាទុកការបង្ហោះសារនេះ'
            ],
            [
                'phrase' => 'schedule',
                'en' => 'Schedule',
                'km' => 'កាលវិភាគសិក្សា'
            ],
            [
                'phrase' => 'score',
                'en' => 'Score',
                'km' => 'ពិន្ទុ'
            ],
            [
                'phrase' => 'search',
                'en' => 'search',
                'km' => 'ស្វែងរក'
            ],
            [
                'phrase' => 'search_filter',
                'en' => 'Search Filter',
                'km' => 'ស្វែងរកតាមការចំរុះទិន្នន័យ'
            ],
            [
                'phrase' => 'search_results',
                'en' => 'search results',
                'km' => 'លទ្ធផលស្វែងរក'
            ],
            [
                'phrase' => 'select',
                'en' => 'Select',
                'km' => 'ជ្រើសរើស'
            ],
            [
                'phrase' => 'selected',
                'en' => 'Selected',
                'km' => 'បានជ្រើសរើស'
            ],
            [
                'phrase' => 'semester',
                'en' => 'Semester',
                'km' => 'ឆមាស'
            ],
            [
                'phrase' => 'send_message',
                'en' => 'Send Message',
                'km' => 'ផ្ញើសារ'
            ],
            [
                'phrase' => 'send_password_reset_link',
                'en' => 'Send password reset link',
                'km' => 'ផ្ញើតំណកំណត់ពាក្យសម្ងាត់ឡើងវិញ'
            ],
            [
                'phrase' => 'server_error',
                'en' => 'Server Error',
                'km' => 'កំហុសម៉ាស៊ីនមេ'
            ],
            [
                'phrase' => 'service_unavailable',
                'en' => 'Service Unavailable',
                'km' => 'មិនមានសេវាកម្ម'
            ],
            [
                'phrase' => 'set',
                'en' => 'Set',
                'km' => 'កំណត់'
            ],
            [
                'phrase' => 'settings',
                'en' => 'Settings',
                'km' => 'ការកំណត់'
            ],
            [
                'phrase' => 'sex',
                'en' => 'Sex',
                'km' => 'ភេទ'
            ],
            [
                'phrase' => 'share',
                'en' => 'Share',
                'km' => 'ចែករំលែក'
            ],
            [
                'phrase' => 'short',
                'en' => 'Short',
                'km' => 'វគ្គខ្លី'
            ],
            [
                'phrase' => 'short_course',
                'en' => 'Short Course',
                'km' => 'សិក្សាវគ្គខ្លី'
            ],
            [
                'phrase' => 'short_course_approved',
                'en' => 'Short course approved',
                'km' => 'សិក្សាវគ្គខ្លីបានអនុម័ត'
            ],
            [
                'phrase' => 'short_course_request',
                'en' => 'Short course request',
                'km' => 'ស្នើសុំសិក្សាវគ្គខ្លី'
            ],
            [
                'phrase' => 'short_course_schedule',
                'en' => 'Short course schedule',
                'km' => 'កាលវិភាគសិក្សាវគ្គខ្លី'
            ],
            [
                'phrase' => 'short_course_session',
                'en' => 'Short Course Session',
                'km' => 'វេននៃការសិក្សាខ្លី'
            ],
            [
                'phrase' => 'short_form',
                'en' => 'Short form',
                'km' => 'ទម្រង់ខ្លី'
            ],
            [
                'phrase' => 'short_name',
                'en' => 'Short name',
                'km' => 'ហៅកាត់(ទម្រងឈ្មោះខ្លី)'
            ],
            [
                'phrase' => 'show',
                'en' => 'Show',
                'km' => 'បង្ហាញ'
            ],
            [
                'phrase' => 'show_video',
                'en' => 'Show video',
                'km' => 'បង្ហាញវីដេអូ'
            ],
            [
                'phrase' => 'showing',
                'en' => 'Showing',
                'km' => 'កំពុងបង្ហាញ'
            ],
            [
                'phrase' => 'single',
                'en' => 'Single',
                'km' => 'លីវ'
            ],
            [
                'phrase' => 'size',
                'en' => 'Size',
                'km' => 'ទំហំ'
            ],
            [
                'phrase' => 'small_image',
                'en' => 'Small image',
                'km' => 'រូបភាពតូច'
            ],
            [
                'phrase' => 'social_media',
                'en' => 'Social Media',
                'km' => 'ប្រព័ន្ធ​ផ្សព្វផ្សាយ​សង្គម'
            ],
            [
                'phrase' => 'sponsored',
                'en' => 'Sponsored',
                'km' => 'អ្នកឧបត្ថម្ភ'
            ],
            [
                'phrase' => 'sponsored_by',
                'en' => 'Sponsored by',
                'km' => 'គាំទ្រ និងកិច្ចសហប្រតិបត្តិការ'
            ],
            [
                'phrase' => 'staff',
                'en' => 'Staff',
                'km' => 'បុគ្គលិក'
            ],
            [
                'phrase' => 'staff_certificate',
                'en' => 'Staff Certificate',
                'km' => 'សញ្ញាបត្រគរុកោសល្យ'
            ],
            [
                'phrase' => 'staff_exam',
                'en' => 'Staff Exam',
                'km' => 'សញ្ញាបត្រគរុកោសល្យ'
            ],
            [
                'phrase' => 'staff_status',
                'en' => 'Staff Status',
                'km' => 'ស្ថានភាពបុគ្គលិក'
            ],
            [
                'phrase' => 'staff_teach_subject',
                'en' => 'Staff Teach Subject',
                'km' => 'បុគ្គលិកបង្រៀនមុខវិជ្ជា'
            ],
            [
                'phrase' => 'start_time',
                'en' => 'Start Time',
                'km' => 'ពេលវេលាចាប់ផ្តើម'
            ],
            [
                'phrase' => 'status',
                'en' => 'Status',
                'km' => 'ស្ថានភាព'
            ],
            [
                'phrase' => 'string_only',
                'en' => 'must be a string',
                'km' => 'ត្រូវតែជាអក្សរ'
            ],
            [
                'phrase' => 'student',
                'en' => 'Student',
                'km' => 'សិស្ស'
            ],
            [
                'phrase' => 'student_attendance',
                'en' => 'Student Attendance',
                'km' => 'វត្តមានសិស្ស'
            ],
            [
                'phrase' => 'student_request',
                'en' => 'Student request',
                'km' => 'ការស្នើសុំរបស់និស្សិត'
            ],
            [
                'phrase' => 'student_score',
                'en' => 'Student score',
                'km' => 'ពិន្ទុសិស្ស'
            ],
            [
                'phrase' => 'student_short_course_request',
                'en' => 'Student short course request',
                'km' => 'សិស្សស្នើសុំសិក្សាវគ្គខ្លី'
            ],
            [
                'phrase' => 'student_study_course',
                'en' => 'Student Study Course',
                'km' => 'សិស្សដែលរៀនជំនាញ'
            ],
            [
                'phrase' => 'student_study_short_course',
                'en' => 'Student study short course',
                'km' => 'សិស្សសិក្សាវគ្គខ្លី'
            ],
            [
                'phrase' => 'study',
                'en' => 'Study',
                'km' => 'ការសិក្សា'
            ],
            [
                'phrase' => 'study_academic_year',
                'en' => 'Academic Year',
                'km' => 'ឆ្នាំសិក្សា'
            ],
            [
                'phrase' => 'study_class',
                'en' => 'Study Class',
                'km' => 'ថ្នាក់រៀន'
            ],
            [
                'phrase' => 'study_course',
                'en' => 'Study Course',
                'km' => 'មុខជំនាញសិក្សា'
            ],
            [
                'phrase' => 'study_course_name',
                'en' => 'Study Course Name',
                'km' => 'ឈ្មោះមុខជំនាញសិក្សា'
            ],
            [
                'phrase' => 'study_course_routine',
                'en' => 'Study Course Routine',
                'km' => 'ទម្លាប់នៃការសិក្សា'
            ],
            [
                'phrase' => 'study_course_schedule',
                'en' => 'Study Course Schedule',
                'km' => 'កាលវិភាគមុខជំនាញសិក្សា'
            ],
            [
                'phrase' => 'study_course_session',
                'en' => 'Study Course Session',
                'km' => 'វេននៃការសិក្សា'
            ],
            [
                'phrase' => 'study_end',
                'en' => 'Study End',
                'km' => 'បញ្ចប់ការសិក្សា'
            ],
            [
                'phrase' => 'study_faculty',
                'en' => 'Study Faculty',
                'km' => 'មហាវិទ្យាល័យសិក្សា'
            ],
            [
                'phrase' => 'study_faculty_name',
                'en' => 'Study Faculty Name',
                'km' => 'ឈ្មោះមហាវិទ្យាល័យសិក្សា'
            ],
            [
                'phrase' => 'study_generation',
                'en' => 'Study Generation',
                'km' => 'ជំនាន់សិក្សា'
            ],
            [
                'phrase' => 'study_generation_name',
                'en' => 'Study Generation Name',
                'km' => 'ឈ្មោះជំនាន់សិក្សា'
            ],
            [
                'phrase' => 'study_grade',
                'en' => 'Study Grade',
                'km' => 'ចំណាប់ថ្នាក់'
            ],
            [
                'phrase' => 'study_lesson',
                'en' => 'Study Lesson',
                'km' => 'មេរៀនសិក្សា'
            ],
            [
                'phrase' => 'study_modality',
                'en' => 'Study Modality',
                'km' => 'គំរូសិក្សា'
            ],
            [
                'phrase' => 'study_modality_name',
                'en' => 'Study Modality Name',
                'km' => 'ឈ្មោះគំរូសិក្សា'
            ],
            [
                'phrase' => 'study_overall_fund​',
                'en' => 'Study Overall Fund​',
                'km' => 'មូលនិធិសិក្សា'
            ],
            [
                'phrase' => 'study_program',
                'en' => 'Study Program',
                'km' => 'កម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'study_program_name',
                'en' => 'Study Program Name',
                'km' => 'ឈ្មោះកម្មវិធីសិក្សា'
            ],
            [
                'phrase' => 'study_semester',
                'en' => 'Study Semester',
                'km' => 'ឆមាសសិក្សា'
            ],
            [
                'phrase' => 'study_session',
                'en' => 'Study Session',
                'km' => 'កាលសិក្សា'
            ],
            [
                'phrase' => 'study_start',
                'en' => 'Study Start',
                'km' => 'ការសិក្សាចាប់ផ្តើម'
            ],
            [
                'phrase' => 'study_status',
                'en' => 'Study Status',
                'km' => 'ស្ថានភាពសិក្សា'
            ],
            [
                'phrase' => 'study_subject',
                'en' => 'Study Subject',
                'km' => 'មុខវិជ្ជាសិក្សា'
            ],
            [
                'phrase' => 'study_subject_lesson',
                'en' => 'Study Subject Lesson',
                'km' => 'មេរៀនមុខវិជ្ជាសិក្សា'
            ],
            [
                'phrase' => 'study_time',
                'en' => 'Study Time',
                'km' => 'ម៉ោងសិក្សា'
            ],
            [
                'phrase' => 'subject',
                'en' => 'Subject',
                'km' => 'មុខវិជ្ជា'
            ],
            [
                'phrase' => 'subject_lesson',
                'en' => 'Subject Lesson',
                'km' => 'មេរៀនមុខវិជ្ជា'
            ],
            [
                'phrase' => 'subject_name',
                'en' => 'Subject Name',
                'km' => 'ឈ្មោះមុខវិជ្ជា'
            ],
            [
                'phrase' => 'success',
                'en' => 'Success',
                'km' => 'ជោគជ័យ'
            ],
            [
                'phrase' => 'successfully',
                'en' => 'Successfully',
                'km' => 'បានជោគជ័យ'
            ],
            [
                'phrase' => 'teach_subject',
                'en' => 'Teach Subject',
                'km' => 'មុខវិជ្ជាបង្រៀន'
            ],
            [
                'phrase' => 'teacher',
                'en' => 'Teacher',
                'km' => 'គ្រូបង្រៀន'
            ],
            [
                'phrase' => 'teaching',
                'en' => 'Teaching',
                'km' => 'ការបង្រៀន'
            ],
            [
                'phrase' => 'telescope',
                'en' => 'Telescope',
                'km' => 'តេឡេស្កុប'
            ],
            [
                'phrase' => 'temporaray_address',
                'en' => 'Temporaray Address',
                'km' => 'អាស័យដ្ឋានបណ្តោះអាសន្ន'
            ],
            [
                'phrase' => 'text',
                'en' => 'Text',
                'km' => 'អត្ថបទ'
            ],
            [
                'phrase' => 'th',
                'en' => 'ภาษาไทย',
                'km' => 'ភាសាថៃ'
            ],
            [
                'phrase' => 'theme_background',
                'en' => 'Theme Background (Login & Register)',
                'km' => 'រូបភាពផ្ទៃខាងក្រោយ (Login & Register)'
            ],
            [
                'phrase' => 'there_was_a_problem_with_your_camera',
                'en' => 'There was a problem with your camera',
                'km' => 'មានបញ្ហាជាមួយកាមេរ៉ារបស់អ្នក'
            ],
            [
                'phrase' => 'this_question_can_answer',
                'en' => 'This question can answer',
                'km' => 'សំណួរនេះអាចឆ្លើយបាន'
            ],
            [
                'phrase' => 'time',
                'en' => 'Time',
                'km' => 'ម៉ោង'
            ],
            [
                'phrase' => 'title',
                'en' => 'Title',
                'km' => 'ចំណងជើង'
            ],
            [
                'phrase' => 'to',
                'en' => 'To',
                'km' => 'ដល់'
            ],
            [
                'phrase' => 'today',
                'en' => 'Today',
                'km' => 'ថ្ងៃនេះ'
            ],
            [
                'phrase' => 'tomorrow',
                'en' => 'Tomorrow',
                'km' => 'ថ្ងៃស្អែក'
            ],
            [
                'phrase' => 'too_many_requests',
                'en' => 'Too Many Requests',
                'km' => 'សំណើច្រើនពេក'
            ],
            [
                'phrase' => 'total',
                'en' => 'Total',
                'km' => 'សរុប'
            ],
            [
                'phrase' => 'training',
                'en' => 'Training',
                'km' => 'វគ្គបណ្តុះបណ្តាល'
            ],
            [
                'phrase' => 'transform',
                'en' => 'Transform',
                'km' => 'ផ្លាស់ប្តូរទម្រង់'
            ],
            [
                'phrase' => 'translate',
                'en' => 'Translate',
                'km' => 'បកប្រែ'
            ],
            [
                'phrase' => 'translation',
                'en' => 'translation',
                'km' => 'ការបកប្រែ'
            ],
            [
                'phrase' => 'translator',
                'en' => 'Translator',
                'km' => 'ការបកប្រែ'
            ],
            [
                'phrase' => 'type',
                'en' => 'Type',
                'km' => 'ប្រភេទ'
            ],
            [
                'phrase' => 'uasge',
                'en' => 'uasge',
                'km' => 'របៀបប្រើប្រាស់'
            ],
            [
                'phrase' => 'unauthorized',
                'en' => 'Unauthorized',
                'km' => 'គ្មានការអនុញ្ញាត'
            ],
            [
                'phrase' => 'unknown_column',
                'en' => 'Unknown column',
                'km' => 'មិនស្គាល់ជួរឈរ (column)'
            ],
            [
                'phrase' => 'unsuccessful',
                'en' => 'unsuccessful',
                'km' => 'មិនបានជោគជ័យ'
            ],
            [
                'phrase' => 'update',
                'en' => 'Update',
                'km' => 'ធ្វើការកែប្រែ'
            ],
            [
                'phrase' => 'user',
                'en' => 'User',
                'km' => 'អ្នកប្រើប្រាស់'
            ],
            [
                'phrase' => 'user_name',
                'en' => 'User Name',
                'km' => 'ឈ្មោះអ្នកប្រើប្រាស់'
            ],
            [
                'phrase' => 'vertical',
                'en' => 'Vertical',
                'km' => 'បញ្ឈរ'
            ],
            [
                'phrase' => 'vi',
                'en' => 'Tiếng Việt',
                'km' => 'ភាសាវៀតណាម'
            ],
            [
                'phrase' => 'video',
                'en' => 'Video',
                'km' => 'វីដេអូ'
            ],
            [
                'phrase' => 'view',
                'en' => 'View',
                'km' => 'បង្ហញ'
            ],
            [
                'phrase' => 'village',
                'en' => 'Village',
                'km' => 'ភូមិ'
            ],
            [
                'phrase' => 'website',
                'en' => 'Website',
                'km' => 'គេហទំព័រ'
            ],
            [
                'phrase' => 'week',
                'en' => 'Week',
                'km' => 'សប្តាហ៍'
            ],
            [
                'phrase' => 'welcome',
                'en' => 'Welcome',
                'km' => 'ស្វាគមន៌មកកាន់កម្មវិធី'
            ],
            [
                'phrase' => 'what_on_your_mind',
                'en' => 'What\'s on your mind?',
                'km' => 'តើអ្នកមានយោលបល់អ្វីដែរ?'
            ],
            [
                'phrase' => 'where_clause',
                'en' => 'where clause',
                'km' => 'កន្លែងស្វែងរក (where)'
            ],
            [
                'phrase' => 'white',
                'en' => 'White',
                'km' => 'ស'
            ],
            [
                'phrase' => 'who_should_see_this_post',
                'en' => 'Who should see this Post?',
                'km' => 'តើអ្នកណាគួរមើលឃើញការបង្ហោះសារនេះ?'
            ],
            [
                'phrase' => 'widow',
                'en' => 'Widow',
                'km' => 'មេម៉ាយ'
            ],
            [
                'phrase' => 'with',
                'en' => 'with',
                'km' => 'ជាមួយ'
            ],
            [
                'phrase' => 'word',
                'en' => 'Word',
                'km' => 'ពាក្យ'
            ],
            [
                'phrase' => 'wow',
                'en' => 'Wow',
                'km' => 'វ៉ោ​'
            ],
            [
                'phrase' => 'write_a_comment',
                'en' => 'Write a comment...',
                'km' => 'សរសេរមួយវិចារ...'
            ],
            [
                'phrase' => 'write_a_reply',
                'en' => 'Write a reply...',
                'km' => 'សរសេរឆ្លើយតប...'
            ],
            [
                'phrase' => 'wrong',
                'en' => 'wrong',
                'km' => 'ខុស'
            ],
            [
                'phrase' => 'year',
                'en' => 'Year',
                'km' => 'ឆ្នាំ'
            ],
            [
                'phrase' => 'yes_delete_it',
                'en' => 'Yes, delete it',
                'km' => 'បាទ / ចាសលុបវាចោល'
            ],
            [
                'phrase' => 'you',
                'en' => 'You',
                'km' => 'អ្នក'
            ],
            [
                'phrase' => 'you_wont_be_able_to_revert_this',
                'en' => 'You won\'t be able to revert this',
                'km' => 'អ្នកនឹងមិនអាចត្រឡប់វាវិញបានទេ'
            ],
        ]);
    }
}
