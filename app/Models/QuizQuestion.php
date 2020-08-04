<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormQuizAnswer;
use App\Http\Requests\FormQuizQuestion;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class QuizQuestion extends Model
{
    public static $path = [
        'image'  => 'question',
        'url'    => 'question',
        'view'   => 'QuizQuestion'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . QuizQuestion::$path['url'] . '/add/'),
            ),
        );



        $orderBy = 'DESC';
        $data = array();
        if ($id) {
            $id  =  gettype($id) == 'array' ? $id : explode(',', $id);
            $sorted = array_values($id);
            sort($sorted);
            if ($id === $sorted) {
                $orderBy = 'ASC';
            } else {
                $orderBy = 'DESC';
            }
        }
        $get = QuizQuestion::select((new QuizQuestion())->getTable() . '.*')
            ->join((new Quiz())->getTable(), (new Quiz())->getTable() . '.id', (new QuizQuestion())->getTable() . '.quiz_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', (new Quiz())->getTable() . '.institute_id')
            ->orderBy((new QuizQuestion())->getTable() . '.id', $orderBy);

        if ($id) {
            $get = $get->whereIn((new QuizQuestion())->getTable() . '.id', $id);
        } else {
            if (request('institute')) {
                $get = $get->where('institute_id', request('institute'));
            }
            if (request('quizId')) {
                $get = $get->where('quiz_id', request('quizId'));
            }

            if (Auth::user()->role_id == 8) {
                $get = $get->where('staff_id', Auth::user()->node_id);
            }
        }





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

        if ($get) {

            foreach ($get as $key => $row) {
                $data[$key]         = array(
                    'id'            => $row['id'],
                    'quiz'          => Quiz::getData($row['quiz_id'])['data'][0],
                    'quiz_type'     => QuizQuestionType::getData($row['quiz_question_type_id'])['data'][0],
                    'quiz_answer_type'  => QuizAnswerType::getData($row['quiz_answer_type_id'])['data'][0],
                    'question'      => $row['question'],
                    'answer_limit'  => QuizAnswer::where('quiz_question_id', $row['id'])->where('correct_answer', 1)->count(),
                    'answer'        => QuizAnswer::getData($row['id'])['data'],
                    'marks'         => $row['marks'],

                    'action'        => [
                        'edit' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['question'],
                    'image'   => null,
                    'action' => $data[$key]['action'],

                );
            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages,
            );
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'pages'     => $pages,
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function getDataTable()
    {
        $model = QuizQuestion::select((new QuizQuestion())->getTable() . '.*')
            ->join((new Quiz())->getTable(), (new Quiz())->getTable() . '.id', (new QuizQuestion())->getTable() . '.quiz_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', (new Quiz())->getTable() . '.institute_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'quiz'          => Quiz::getData($row['quiz_id'])['data'][0],
                    'quiz_type'     => QuizQuestionType::getData($row['quiz_question_type_id'])['data'][0],
                    'quiz_answer_type'  => QuizAnswerType::getData($row['quiz_answer_type_id'])['data'][0],
                    'question'      => $row['question'],
                    'answer_limit'  => QuizAnswer::where('quiz_question_id', $row['id'])->where('correct_answer', 1)->count(),
                    'answer'        => QuizAnswer::getData($row['id'])['data'],
                    'marks'         => $row['marks'],

                    'action'        => [
                        'edit' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {
                if (Auth::user()->role_id == 8) {
                    $query = $query->where('staff_id', Auth::user()->node_id);
                } elseif (Auth::user()->role_id == 2) {
                    $query =  $query->where('institute_id', Auth::user()->institute_id);
                }

                if (request('quizId')) {
                    $query = $query->where((new QuizQuestion())->getTable().'.quiz_id', request('quizId'));
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'quiz.name') {
                                $query =  $query->where(function ($q) {
                                    $q->where((new Quiz())->getTable().'.name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere((new Quiz())->getTable().'.'.$lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
                            } elseif ($value['data'] == 'question') {
                                $query->orWhere('question', 'LIKE', '%' . request('search.value') . '%');

                            }
                        }
                    }
                }

                return $query;
            })
            ->order(function ($query) {
                if (request('order')) {
                    foreach (request('order') as $order) {
                        $col = request('columns')[$order['column']];
                        if ($col['data'] == 'id') {
                            $query->orderBy('id', $order['dir']);
                        }
                    }
                }
            })
            ->toJson();
    }

    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(
            request()->all(),
            FormQuizQuestion::rulesField() + FormQuizAnswer::rulesField('.*'),
            FormQuizQuestion::customMessages() + FormQuizAnswer::customMessages(),
            FormQuizQuestion::attributeField() + FormQuizAnswer::attributeField('.*')
        );

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $add = QuizQuestion::insertGetId([
                    'quiz_id'        => trim(request('quiz')),
                    'quiz_question_type_id' => trim(request('quiz_type')),
                    'quiz_answer_type_id' => trim(request('quiz_answer_type')),
                    'question'       => trim(request('question')),
                    'marks'       => trim(request('marks')),
                ]);
                if ($add && QuizAnswer::addToTable($add)['success']) {

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => QuizQuestion::getData($add)['data'],
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
        $newAnswer = [];
        foreach (request('answer') as $key => $value) {
            if ($value) {
                $newAnswer[$key] = $value;
            }
        }
        request()->merge(['answer' => $newAnswer]);
        $response           = array();
        $validator          = Validator::make(
            request()->all(),
            FormQuizQuestion::rulesField() + FormQuizAnswer::rulesField('.*'),
            FormQuizQuestion::customMessages() + FormQuizAnswer::customMessages(),
            FormQuizQuestion::attributeField() + FormQuizAnswer::attributeField('.*')
        );

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $update = QuizQuestion::where('id', $id)->update([
                    'quiz_id'        => trim(request('quiz')),
                    'quiz_question_type_id' => trim(request('quiz_type')),
                    'quiz_answer_type_id' => trim(request('quiz_answer_type')),
                    'question'       => trim(request('question')),
                    'marks'       => trim(request('marks')),
                ]);

                if ($update && QuizAnswer::updateToTable($id)['success']) {

                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        //'data'      => QuizQuestion::getData($id),
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
        return $response;
    }


    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (QuizQuestion::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = QuizQuestion::whereIn('id', $id)->delete();
                        if ($delete) {
                            $response       =  array(
                                'success'   => true,
                                'message'   => array(
                                    'title' => Translator::phrase('deleted.!'),
                                    'text'  => Translator::phrase('delete.successfully'),
                                    'button'   => array(
                                        'confirm' => Translator::phrase('ok'),
                                        'cancel'  => Translator::phrase('cancel'),
                                    ),
                                ),
                            );
                        }
                    } catch (\Exception $e) {
                        $response       = Exception::exception($e);
                    }
                } else {
                    $response = response(
                        array(
                            'success'   => true,
                            'message'   => array(
                                'title' => Translator::phrase('are_you_sure.?'),
                                'text'  => Translator::phrase('you_wont_be_able_to_revert_this.!') . PHP_EOL .
                                    'ID : (' . implode(',', $id) . ')',
                                'button'   => array(
                                    'confirm' => Translator::phrase('yes_delete_it.!'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        )
                    );
                }
            } else {
                $response = response(
                    array(
                        'success'   => false,
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('no_data'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    )
                );
            }
        } else {
            $response = response(
                array(
                    'success'   => false,
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('please_select_data.!'),
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
}
