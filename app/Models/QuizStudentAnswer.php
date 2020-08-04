<?php

namespace App\Models;

use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Http\Requests\FormQuizStudentAnswer;
use App\Http\Requests\FormQuizStudentAnswerMarks;
use DomainException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class QuizStudentAnswer extends Model
{
    public static $path = [
        'url'    => 'answer',
        'view'   => 'QuizStudentAnswer'
    ];
    public static function getData($quiz_student_id, $paginate = null)
    {
        $total_marks = 0;
        $response       = array(
            'success'   => false,
            'data'      => [],
            'total_marks' => $total_marks . ' ' . Translator::phrase('marks'),
        );
        if ($quiz_student_id) {
            $get = QuizStudentAnswer::where('quiz_student_id', $quiz_student_id);
            if ($paginate) {
                $get = $get->paginate($paginate)->toArray();
                foreach ($get as $key => $value) {
                    if ($key == 'data') {
                    } else {
                        $pages[$key] = $value;
                    }
                }

                $get = $get['data'];
            } else {
                $get = $get->get()->toArray();
            }

            $data = [];

            if ($get) {
                foreach ($get  as $key => $row) {
                    $data[$key] = [
                        'id'        => $row['id'],
                        'question'  => QuizQuestion::getData($row['quiz_question_id'])['data'][0],
                        'answered'  => $row['answered'],
                        'correct'   => false,
                        'correct_marks' => 0,
                        'marks'     => $row['marks'],
                    ];

                    if ($data[$key]['question']['quiz_answer_type']['id'] == 1) {
                        $quizAnswer = QuizAnswer::find($data[$key]['answered']);
                        if ($quizAnswer->correct_answer) {
                            $data[$key]['correct'] = true;
                            $data[$key]['correct_marks'] = $data[$key]['question']['marks'];
                        };
                    } elseif ($data[$key]['question']['quiz_answer_type']['id'] == 2) {
                        $correct = [];
                        $correct_marks = 0;
                        $quizAnswerCorrect = QuizAnswer::where('quiz_question_id', $data[$key]['question']['id'])->where('correct_answer', 1)->count();
                        foreach (explode(',', $data[$key]['answered']) as $answer) {
                            $quizAnswer = QuizAnswer::find($answer);
                            if ($quizAnswer->correct_answer) {
                                $correct[] = $quizAnswer->correct_answer;
                                $correct_marks += $data[$key]['question']['marks'] / $quizAnswerCorrect;
                            }
                        }

                        if ($quizAnswerCorrect == count($correct)) {
                            $data[$key]['correct'] = true;
                            $data[$key]['correct_marks'] = $data[$key]['question']['marks'];
                        } else {
                            $data[$key]['correct'] = false;
                            $data[$key]['correct_marks'] = $correct_marks;
                        }
                    } elseif ($data[$key]['question']['quiz_answer_type']['id'] == 3) {
                        if ($data[$key]['question']['answer'][0]['answer'] == $data[$key]['answered']) {
                            $data[$key]['correct'] = true;
                            $data[$key]['correct_marks'] = $data[$key]['question']['marks'];
                        }
                    }

                    $total_marks += $data[$key]['correct_marks'];
                }

                $response       = array(
                    'success'   => true,
                    'data'      => $data,
                    'total_marks' => $total_marks . ' ' . Translator::phrase('marks'),
                );
            }
        }

        return $response;
    }
    public static function getData1($student_study_course_id)
    {

        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . 'study/' . Quiz::$path['url'] . '/' . QuizStudentAnswer::$path['url'] . '/add/'),
            ),
        );

        $a = [];
        $b = [];
        if ($student_study_course_id && gettype($student_study_course_id) == 'string') {
            $student_study_course_id = explode(',', $student_study_course_id);
        }
        $get = QuizStudent::whereIn('student_study_course_id', $student_study_course_id);

        if (request('quizId')) {
            $get = $get->where('quiz_id', request('quizId'));
        }

        $get = $get->get()->toArray();
        if ($get) {
            foreach ($get as $qstu) {
                $countQ = QuizQuestion::where('quiz_id', $qstu['quiz_id'])->count();
                $countA = QuizStudentAnswer::where('quiz_student_id', $qstu['id'])->count();

                if ($countQ != $countA) {
                    $qq = Quiz::getData($qstu['quiz_id'])['data'][0];
                    $a[$qstu['quiz_id']] = [
                        'id'    => $qstu['quiz_id'],
                        'name'  => $qq['name'],
                        'image'  => $qq['image'],
                        'quiz_student'    => $qstu['id'],
                        'children'  => &$b[$qstu['quiz_id']]
                    ];
                    $quizQuestion = QuizQuestion::where('quiz_id', $qstu['quiz_id'])->paginate(5)->toArray();

                    if ($quizQuestion) {
                        foreach ($quizQuestion['data'] as $question) {
                            $answered = QuizStudentAnswer::where('quiz_student_id', $qstu['id'])->where('quiz_question_id', $question['id'])->get()->toArray();
                            $b[$qstu['quiz_id']][] = [
                                'id'    => $question['id'],
                                'quiz_type'    => QuizQuestionType::getData($question['quiz_question_type_id'])['data'][0],
                                'quiz_answer_type'    => QuizAnswerType::getData($question['quiz_answer_type_id'])['data'][0],
                                'question'    => $question['question'],
                                'answer_limit'  => QuizAnswer::where('quiz_question_id', $question['id'])->where('correct_answer', 1)->count(),
                                'answer'      => QuizAnswer::getData($question['id'])['data'],
                                'answered'    => $answered ? [
                                    'id'          => $answered[0]['id'],
                                    'answered'    => $answered[0]['answered'],
                                    'marks'       => $answered[0]['marks'],
                                ] : null,
                                'marks'    => $question['marks'],

                            ];
                        }

                        foreach ($quizQuestion as $key => $value) {
                            if ($key == 'data') {
                            } else {
                                $pages[$key] = $value;
                            }
                        }
                    }
                } else {
                    //Answer All already
                    $response = array(
                        'success'   => false,
                        'data'      => [],
                        'message'   => Translator::phrase('no_data'),
                        'pages'     => $pages
                    );
                }
            }

            if ($a) {
                $response = array(
                    'success'   => true,
                    'data'      => $a,
                    'pages'     => $pages

                );
            }
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'message'   => Translator::phrase('no_data'),
                'pages'     => $pages
            );
        }
        return $response;
    }



    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormQuizStudentAnswer::rulesField('.*'), FormQuizStudentAnswer::customMessages(), FormQuizStudentAnswer::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            if (QuizStudentAnswer::exists(request('quiz_student'), request('quiz_question'))) {
                return array(
                    'success'   => false,
                    'type'      => 'exists',
                    'message'      => Translator::phrase('already_exists'),
                );
            }
            try {
                $quiz_question = QuizQuestion::find(request('quiz_question'));
                $answer = null;
                if ($quiz_question->quiz_answer_type_id == 1) {
                    $answer = request('answer')[0];
                } elseif ($quiz_question->quiz_answer_type_id == 2) {
                    $answer = request('answer');
                    $answer = implode(',', $answer);
                } elseif ($quiz_question->quiz_answer_type_id == 3) {
                    $answer = request('answer')[0];
                }
                $add = QuizStudentAnswer::insertGetId([
                    'quiz_student_id'   => trim(request('quiz_student')),
                    'quiz_question_id'   => trim(request('quiz_question')),
                    'answered'   => $answer,
                ]);
                if ($add) {

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => [
                            'id'          => $add,
                            'answered'    => request('answer'),
                        ],
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
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }

    public static function updateToTable($id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormQuizStudentAnswer::rulesField('.*'), FormQuizStudentAnswer::customMessages(), FormQuizStudentAnswer::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $quiz_student = QuizStudentAnswer::where('id', $id)->first();
                if (!is_null($quiz_student->marks)) {
                    $response       = array(
                        'success'   => false,
                        'type'      => 'update',
                        'data'      => [
                            'id'       => $id,
                            'question'    => QuizQuestion::getData($quiz_student->quiz_question_id),
                        ],
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('update.unsuccessful'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                } else {

                    $quiz_question = QuizQuestion::find($quiz_student->quiz_question_id);
                    $answer = null;
                    if ($quiz_question->quiz_answer_type_id == 1) {
                        $answer = request('answer')[0];
                    } elseif ($quiz_question->quiz_answer_type_id == 2) {
                        $answer = request('answer');
                        $answer = implode(',', $answer);
                    } elseif ($quiz_question->quiz_answer_type_id == 3) {
                        $answer = request('answer')[0];
                    }

                    $update = QuizStudentAnswer::where('id', $id)->update([
                        'answered'   => $answer,
                    ]);
                    if ($update) {

                        $response       = array(
                            'success'   => true,
                            'type'      => 'update',
                            'data'      => [
                                'id'          => $id,
                                'answered'    => request('answer'),
                            ],
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
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }
    public static function updateAnswerAgainToTable($id)
    {
        $update = QuizStudentAnswer::where('id', $id)->update([
            'marks'     => null
        ]);
        if ($update) {
            $response       = array(
                'success'   => true,
                'type'      => 'update',
                'data'      => [
                    'id'       => $id,
                    'marks'       => 0,
                ],
                'message'   => array(
                    'title' => Translator::phrase('success'),
                    'text'  => Translator::phrase('answer_again.successfully'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        } else {
            $response = response(
                array(
                    'success'   => false,
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('No-ID'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                )
            );
        }
        return $response;
    }
    public static function updateMarksToTable($id)
    {
        if ($id) {
            $response           = array();
            $validator          = Validator::make(request()->all(), FormQuizStudentAnswerMarks::rulesField(), FormQuizStudentAnswerMarks::customMessages(), FormQuizStudentAnswerMarks::attributeField());

            if ($validator->fails()) {
                $response       = array(
                    'success'   => false,
                    'errors'    => $validator->getMessageBag(),
                );
            } else {
                try {

                    $update = QuizStudentAnswer::where('id', $id)->update([
                        'marks'     => trim(request('marks'))
                    ]);
                    if ($update) {

                        $response       = array(
                            'success'   => true,
                            'type'      => 'update',
                            'data'      => [
                                'id'       => $id,
                                'marks'       => trim(request('marks')),
                            ],
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
                } catch (DomainException $e) {
                    $response       = Exception::exception($e);
                }
            }
        } else {
            $response = response(
                array(
                    'success'   => false,
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('No-ID'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                )
            );
        }
        return $response;
    }
    public static function exists($quiz_student_id, $quiz_question_id)
    {
        return QuizStudentAnswer::where('quiz_student_id', $quiz_student_id)->where('quiz_question_id', $quiz_question_id)->first();
    }
}
