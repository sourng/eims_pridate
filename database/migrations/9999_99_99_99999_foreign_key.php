<?php

use App\Models\ActivityFeed;
use App\Models\ActivityFeedComment;
use App\Models\ActivityFeedCommentsReply;
use App\Models\ActivityFeedLink;
use App\Models\ActivityFeedMedia;
use App\Models\ActivityFeedReaction;
use App\Models\Days;
use App\Models\Staff;
use App\Models\Gender;
use App\Models\Marital;
use App\Models\App;
use App\Models\Students;
use App\Models\Institute;
use App\Models\BloodGroup;
use App\Models\CardFrames;
use App\Models\MotherTong;
use App\Models\StudyClass;
use App\Models\CourseTypes;
use App\Models\Nationality;
use App\Models\StudyOverallFund;
use App\Models\StudyCourse;
use App\Models\StudyStatus;
use App\Models\StudyFaculty;
use App\Models\StudyModality;
use App\Models\StudyPrograms;
use App\Models\StudySubjects;
use App\Models\StudySemesters;
use App\Models\AttendancesType;
use App\Models\Communes;
use App\Models\StudyGeneration;
use App\Models\CurriculumAuthor;
use App\Models\StudentsGuardians;
use App\Models\StudyAcademicYears;
use App\Models\StudyCourseRoutine;
use App\Models\StudentsAttendances;
use App\Models\StudentsStudyCourse;
use App\Models\StudyCourseSchedule;
use App\Models\CurriculumEndorsement;
use App\Models\Districts;
use App\Models\FeatureSlider;
use App\Models\Mailbox;
use App\Models\MailboxImportant;
use App\Models\MailboxRead;
use App\Models\MailboxReply;
use App\Models\MailboxTrash;
use App\Models\Provinces;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAnswerType;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionType;
use App\Models\QuizStudent;
use App\Models\Roles;
use App\Models\SocailsMedia;
use App\Models\SocialAuth;
use App\Models\StaffDesignations;
use App\Models\StaffExperience;
use App\Models\StaffGuardians;
use App\Models\StaffInstitutes;
use App\Models\StaffQualifications;
use App\Models\StaffStatus;
use App\Models\StaffTeachSubject;
use App\Models\StudentsCertificate;
use App\Models\StudentsRequest;
use App\Models\StudentsScore;
use App\Models\StudentsShortCourseRequest;
use App\Models\StudentsStudyCourseScore;
use App\Models\StudentsStudyShortCourse;
use App\Models\StudyCourseSession;
use App\Models\StudySession;
use App\Models\StudyShortCourseSchedule;
use App\Models\StudyShortCourseSession;
use App\Models\StudySubjectLesson;
use App\Models\ThemesColor;
use App\Models\Users;
use App\Models\Villages;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table((new StudyCourse())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('study_faculty_id')->references('id')->on((new StudyFaculty())->getTable())->onDelete('cascade');
            $table->foreign('course_type_id')->references('id')->on((new CourseTypes())->getTable())->onDelete('cascade');
            $table->foreign('study_modality_id')->references('id')->on((new StudyModality())->getTable())->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on((new StudyPrograms())->getTable())->onDelete('cascade');
            $table->foreign('study_overall_fund_id')->references('id')->on((new StudyOverallFund())->getTable())->onDelete('cascade');
            $table->foreign('curriculum_endorsement_id')->references('id')->on((new CurriculumEndorsement())->getTable())->onDelete('cascade');
            $table->foreign('curriculum_author_id')->references('id')->on((new CurriculumAuthor())->getTable())->onDelete('cascade');
            $table->foreign('study_generation_id')->references('id')->on((new StudyGeneration())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudyCourseSchedule())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on((new StudyPrograms())->getTable())->onDelete('cascade');
            $table->foreign('study_course_id')->references('id')->on((new StudyCourse())->getTable())->onDelete('cascade');
            $table->foreign('study_generation_id')->references('id')->on((new StudyGeneration())->getTable())->onDelete('cascade');
            $table->foreign('study_academic_year_id')->references('id')->on((new StudyAcademicYears())->getTable())->onDelete('cascade');
            $table->foreign('study_semester_id')->references('id')->on((new StudySemesters())->getTable())->onDelete('cascade');
        });
        Schema::table((new StudyCourseSession())->getTable(), function (Blueprint $table) {
            $table->foreign('study_course_schedule_id')->references('id')->on((new StudyCourseSchedule())->getTable())->onDelete('cascade');
            $table->foreign('study_session_id')->references('id')->on((new StudySession())->getTable())->onDelete('cascade');
        });
        Schema::table((new StudyCourseRoutine())->getTable(), function (Blueprint $table) {
            $table->foreign('study_course_session_id')->references('id')->on((new StudyCourseSession())->getTable())->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on((new Days())->getTable())->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
            $table->foreign('study_subject_id')->references('id')->on((new StudySubjects())->getTable())->onDelete('cascade');
            $table->foreign('study_class_id')->references('id')->on((new StudyClass())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudyShortCourseSchedule())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('study_generation_id')->references('id')->on((new StudyGeneration())->getTable())->onDelete('cascade');
            $table->foreign('study_subject_id')->references('id')->on((new StudySubjects())->getTable())->onDelete('cascade');
        });
        Schema::table((new StudyShortCourseSession())->getTable(), function (Blueprint $table) {
            $table->foreign('stu_sh_c_schedule_id')->references('id')->on((new StudyShortCourseSchedule())->getTable())->onDelete('cascade');
            $table->foreign('study_session_id')->references('id')->on((new StudySession())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudyStatus())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudySession())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });
        Schema::table((new StudySemesters())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudySubjects())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('course_type_id')->references('id')->on((new CourseTypes())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudySubjectLesson())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_teach_subject_id')->references('id')->on((new StaffTeachSubject())->getTable())->onDelete('cascade');
        });


        Schema::table((new Students())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')->on((new Nationality())->getTable())->onDelete('cascade');
            $table->foreign('mother_tong_id')->references('id')->on((new MotherTong())->getTable())->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on((new Gender())->getTable())->onDelete('cascade');
            $table->foreign('marital_id')->references('id')->on((new Marital())->getTable())->onDelete('cascade');
            $table->foreign('blood_group_id')->references('id')->on((new BloodGroup())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsGuardians())->getTable(), function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on((new Students())->getTable())->onDelete('cascade');
        });




        Schema::table((new StudentsRequest())->getTable(), function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on((new Students())->getTable())->onDelete('cascade');
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on((new StudyPrograms())->getTable())->onDelete('cascade');
            $table->foreign('study_course_id')->references('id')->on((new StudyCourse())->getTable())->onDelete('cascade');
            $table->foreign('study_generation_id')->references('id')->on((new StudyGeneration())->getTable())->onDelete('cascade');
            $table->foreign('study_academic_year_id')->references('id')->on((new StudyAcademicYears())->getTable())->onDelete('cascade');
            $table->foreign('study_semester_id')->references('id')->on((new StudySemesters())->getTable())->onDelete('cascade');
            $table->foreign('study_session_id')->references('id')->on((new StudySession())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsStudyCourse())->getTable(), function (Blueprint $table) {
            $table->foreign('student_request_id')->references('id')->on((new StudentsRequest())->getTable())->onDelete('cascade');
            $table->foreign('study_course_session_id')->references('id')->on((new StudyCourseSession())->getTable())->onDelete('cascade');
            $table->foreign('study_status_id')->references('id')->on((new StudyStatus())->getTable())->onDelete('cascade');
        });


        Schema::table((new StudentsAttendances())->getTable(), function (Blueprint $table) {
            $table->foreign('student_study_course_id')->references('id')->on((new StudentsStudyCourse())->getTable())->onDelete('cascade');
            $table->foreign('attendance_type_id')->references('id')->on((new AttendancesType())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsCertificate())->getTable(), function (Blueprint $table) {
            $table->foreign('student_study_course_id')->references('id')->on((new StudentsStudyCourse())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsStudyCourseScore())->getTable(), function (Blueprint $table) {
            $table->foreign('student_study_course_id')->references('id')->on((new StudentsStudyCourse())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsScore())->getTable(), function (Blueprint $table) {
            $table->foreign('student_study_course_score_id')->references('id')->on((new StudentsStudyCourseScore())->getTable())->onDelete('cascade');
            $table->foreign('study_subject_id')->references('id')->on((new StudySubjects())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsStudyShortCourse())->getTable(), function (Blueprint $table) {
            $table->foreign('stu_sh_c_request_id')->references('id')->on((new StudentsShortCourseRequest())->getTable())->onDelete('cascade');
            $table->foreign('stu_sh_c_session_id')->references('id')->on((new StudyShortCourseSession())->getTable())->onDelete('cascade');
        });

        Schema::table((new StudentsShortCourseRequest())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on((new Students())->getTable())->onDelete('cascade');
            $table->foreign('study_subject_id')->references('id')->on((new StudySubjects())->getTable())->onDelete('cascade');
            $table->foreign('study_session_id')->references('id')->on((new StudySession())->getTable())->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });


        Schema::table((new Staff())->getTable(), function (Blueprint $table) {
            $table->foreign('nationality_id')->references('id')->on((new Nationality())->getTable())->onDelete('cascade');
            $table->foreign('mother_tong_id')->references('id')->on((new MotherTong())->getTable())->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on((new Gender())->getTable())->onDelete('cascade');
            $table->foreign('marital_id')->references('id')->on((new Marital())->getTable())->onDelete('cascade');
            $table->foreign('blood_group_id')->references('id')->on((new BloodGroup())->getTable())->onDelete('cascade');
            $table->foreign('staff_status_id')->references('id')->on((new StaffStatus())->getTable())->onDelete('cascade');
        });

        Schema::table((new StaffInstitutes())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on((new StaffDesignations())->getTable())->onDelete('cascade');
        });
        Schema::table((new StaffGuardians())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
        });

        Schema::table((new StaffQualifications())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
            // $table->foreign('certificate_id')->references('id')->on((new Certificate())->getTable())->onDelete('cascade');
        });
        Schema::table((new StaffExperience())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
        });

        Schema::table((new CardFrames())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });

        Schema::table((new App())->getTable(), function (Blueprint $table) {
            $table->foreign('theme_color_id')->references('id')->on((new ThemesColor())->getTable())->onDelete('cascade');
        });

        Schema::table((new SocailsMedia())->getTable(), function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on((new App())->getTable())->onDelete('cascade');
        });
        Schema::table((new Users())->getTable(), function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on((new Roles())->getTable())->onDelete('cascade');
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });


        Schema::table((new Districts())->getTable(), function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on((new Provinces())->getTable())->onDelete('cascade');
        });

        Schema::table((new Communes())->getTable(), function (Blueprint $table) {
            $table->foreign('district_id')->references('id')->on((new Districts())->getTable())->onDelete('cascade');
        });

        Schema::table((new Villages())->getTable(), function (Blueprint $table) {
            $table->foreign('commune_id')->references('id')->on((new Communes())->getTable())->onDelete('cascade');
        });


        Schema::table((new FeatureSlider())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });

        Schema::table((new ActivityFeed())->getTable(), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('theme_color_id')->references('id')->on((new ThemesColor())->getTable())->onDelete('cascade');
        });
        Schema::table((new ActivityFeedComment())->getTable(), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('activity_feed_id')->references('id')->on((new ActivityFeed())->getTable())->onDelete('cascade');
        });
        Schema::table((new ActivityFeedCommentsReply())->getTable(), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('activity_feed_comment_id')->references('id')->on((new ActivityFeedComment())->getTable())->onDelete('cascade');
        });
        Schema::table((new ActivityFeedMedia())->getTable(), function (Blueprint $table) {
            $table->foreign('activity_feed_id')->references('id')->on((new ActivityFeed())->getTable())->onDelete('cascade');
        });
        Schema::table((new ActivityFeedLink())->getTable(), function (Blueprint $table) {
            $table->foreign('activity_feed_id')->references('id')->on((new ActivityFeed())->getTable())->onDelete('cascade');
        });

        Schema::table((new ActivityFeedReaction())->getTable(), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('activity_feed_id')->references('id')->on((new ActivityFeed())->getTable())->onDelete('cascade');
        });

        Schema::table((new Quiz())->getTable(), function (Blueprint $table) {
            $table->foreign('institute_id')->references('id')->on((new Institute())->getTable())->onDelete('cascade');
        });

        Schema::table((new QuizQuestion())->getTable(), function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on((new Quiz())->getTable())->onDelete('cascade');
            $table->foreign('quiz_answer_type_id')->references('id')->on((new QuizAnswerType())->getTable())->onDelete('cascade');
            $table->foreign('quiz_question_type_id')->references('id')->on((new QuizQuestionType())->getTable())->onDelete('cascade');
        });

        Schema::table((new QuizAnswer())->getTable(), function (Blueprint $table) {
            $table->foreign('quiz_question_id')->references('id')->on((new QuizQuestion())->getTable())->onDelete('cascade');
        });
        Schema::table((new QuizStudent())->getTable(), function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on((new Quiz())->getTable())->onDelete('cascade');
            $table->foreign('student_study_course_id')->references('id')->on((new StudentsStudyCourse())->getTable())->onDelete('cascade');
        });

        Schema::table((new StaffTeachSubject())->getTable(), function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on((new Staff())->getTable())->onDelete('cascade');
            $table->foreign('study_subject_id')->references('id')->on((new StudySubjects())->getTable())->onDelete('cascade');
        });









        Schema::table((new SocialAuth())->getTable(), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });

        Schema::table((new Mailbox())->getTable(), function (Blueprint $table) {
            $table->foreign('from')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('recipient')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });

        Schema::table((new MailboxReply())->getTable(), function (Blueprint $table) {
            $table->foreign('mailbox_id')->references('id')->on((new Mailbox())->getTable())->onDelete('cascade');
            $table->foreign('from')->references('id')->on((new Users())->getTable())->onDelete('cascade');
            $table->foreign('recipient')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });

        Schema::table((new MailboxRead())->getTable(), function (Blueprint $table) {
            $table->foreign('mailbox_id')->references('id')->on((new Mailbox())->getTable())->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });

        Schema::table((new MailboxImportant())->getTable(), function (Blueprint $table) {
            $table->foreign('mailbox_id')->references('id')->on((new Mailbox())->getTable())->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });

        Schema::table((new MailboxTrash())->getTable(), function (Blueprint $table) {
            $table->foreign('mailbox_id')->references('id')->on((new Mailbox())->getTable())->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on((new Users())->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
