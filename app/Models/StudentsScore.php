<?php

namespace App\Models;

use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class StudentsScore extends Model
{
    public static function getData($student_study_course_score_id, $study_course_session_id)
    {
        $data = array();
        $get = StudyCourseRoutine::getSubject($study_course_session_id);

        if ($get) {
            foreach ($get as $row) {
                $score =  StudentsScore::where('student_study_course_score_id', $student_study_course_score_id)
                    ->where('study_subject_id', $row['subject']['id'])
                    ->get()->toArray();


                if ($score) {
                    $data[$row['subject']['id']] = array(
                        'id'            => $score[0]['id'],
                        'study_subject' => $row['subject'],
                        'marks'         => $score[0]['subject_marks'],
                        'pass_or_fail'  => ($score[0]['subject_marks'] >= $row['subject']['pass_mark_theory']) ? 'pass' : 'fail',
                        'action'        => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsStudyCourseScore::$path['url'] . '/subject/edit/' . $score[0]['id']),
                    );
                } else {
                    $data[$row['subject']['id']] = array(
                        'id'            => null,
                        'study_subject' => $row['subject'],
                        'marks'         => 0,
                        'pass_or_fail'  => 'fail',
                        'action'        => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsStudyCourseScore::$path['url'] . '/subject/add/'),
                    );
                }
            }
        }

        return $data;

    }

    public static function addToTable($student_study_course_score_id, $study_subject_id, $subject_marks)
    {
        $response = [
            'sucess'    => false,
            'error'     => []
        ];
        if ($student_study_course_score_id &&  $study_subject_id && $subject_marks) {
            if (StudentsScore::existsToTable($student_study_course_score_id, $study_subject_id)) {
                $response = StudentsScore::updateToTable($student_study_course_score_id, $study_subject_id, $subject_marks);
            } else {
                $add =  StudentsScore::insertGetId([
                    'student_study_course_score_id' => $student_study_course_score_id,
                    'study_subject_id'              => $study_subject_id,
                    'subject_marks'                  => $subject_marks,
                ]);
                if ($add) {

                    $response       = array(
                        'success'   => true,
                        //'data'      => StudentsStudyCourseScore::getData($student_study_course_score_id)['data'],
                        'type'      => 'add',
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('add.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            }
        }

        return $response;
    }

    public static function updateToTable($student_study_course_score_id, $study_subject_id, $subject_marks)
    {
        $response = [
            'sucess'    => false,
            'error'     => []
        ];
        if ($student_study_course_score_id &&  $study_subject_id && $subject_marks) {
            if (StudentsScore::existsToTable($student_study_course_score_id, $study_subject_id)) {
                $update =  StudentsScore::where('student_study_course_score_id', $student_study_course_score_id)
                    ->where('study_subject_id', $study_subject_id)
                    ->update([
                        'subject_marks'=> $subject_marks,
                    ]);

                if ($update) {

                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        //'data'      => StudentsStudyCourseScore::getData($student_study_course_score_id)['data'],
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('update.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            }
        }

        return $response;
    }

    public static function existsToTable($student_study_course_score_id, $study_subject_id)
    {
        return  StudentsScore::where('student_study_course_score_id', $student_study_course_score_id)
            ->where('study_subject_id', $study_subject_id)
            ->exists();
    }
}
