<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Http\Requests\FormQuizAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class QuizAnswer extends Model
{
    public static $path = [
        'image'  => 'question',
        'url'    => 'question',
        'view'   => 'QuizAnswer'
    ];

    public static function getData($quiz_question_id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . QuizAnswer::$path['url'] . '/add/'),
            ),
        );



        $data = array();

        $get = QuizAnswer::orderBy('id', 'ASC');

        if ($quiz_question_id) {
            $get = $get->where('quiz_question_id', $quiz_question_id);
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
                // if( $row['id'] == 1 && Auth::user()->role_id != 1){
                //     continue;
                // }

                $data[$key]         = array(
                    'id'            => $row['id'],
                    'answer'        => $row['answer'],
                    'correct_answer' => $row['correct_answer'],
                    'action'        => [
                        'edit' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizAnswer::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizAnswer::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizAnswer::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['answer'],
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

    public static function addToTable($quiz_question_id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormQuizAnswer::rulesField('.*'), FormQuizAnswer::customMessages(), FormQuizAnswer::attributeField('.*'));

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            $values = [];
            foreach (request('answer') as $key => $answer) {
                $values[] = [
                    'quiz_question_id' => $quiz_question_id,
                    'answer'         => trim($answer),
                    'correct_answer' => isset(request('correct_answer')[$key]) ? 1 : 0,
                ];
            }
            try {
                $add = QuizAnswer::insert($values);
                if ($add) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => [],
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

    public static function updateToTable($quiz_question_id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormQuizAnswer::rulesField('.*'), FormQuizAnswer::customMessages(), FormQuizAnswer::attributeField('.*'));

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $ids = [];
                $update = null;
                foreach (request('answer') as $key => $answer) {
                    preg_match('/^id-/', $key, $match);
                    if ($match) {
                        $id = str_replace('id-', '', $key);
                        $ids[] = $id;
                        $update = QuizAnswer::where('id', $id)->update([
                            'answer'         => trim($answer),
                            'correct_answer' => isset(request('correct_answer')[$key]) ? 1 : 0,
                        ]);
                    } else {
                        $update = QuizAnswer::insertGetId([
                            'quiz_question_id' => $quiz_question_id,
                            'answer'         => trim($answer),
                            'correct_answer' => isset(request('correct_answer')[$key]) ? 1 : 0,
                        ]);
                        $ids[] = $update;
                    };
                }

                QuizAnswer::whereNotIn('id', $ids)->where('quiz_question_id', $quiz_question_id)->delete();

                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        //'data'      => QuizAnswer::getData($id),
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
            if (QuizAnswer::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = QuizAnswer::whereIn('id', $id)->delete();
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
