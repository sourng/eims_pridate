<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Quiz extends Model
{
    public static $path = [
        'image'  => 'quiz',
        'url'    => 'quiz',
        'view'   => 'Quiz'
    ];

    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Quiz::$path['url'] . '/add/'),
            ),
        );


        $orderBy = 'ASC';
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
        $get = Quiz::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'));
            }
            if (Auth::user()->role_id == 8) {
                $get = $get->where('staff_id', Auth::user()->node_id);
            }
        }


        if ($search) {
            $get = $get->where('name', 'LIKE', '%' . $search . '%');
            if (config('app.languages')) {
                foreach (config('app.languages') as $lang) {
                    $get = $get->orWhere($lang['code_name'], 'LIKE', '%' . $search . '%');
                }
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
                // if( $row['id'] == 1 && Auth::user()->role_id != 1){
                //     continue;
                // }

                $data[$key]         = array(
                    'id'            => $row['id'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(Quiz::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/' . Quiz::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . Quiz::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Quiz::$path['url'] . '/delete/' . $row['id']),
                        'question_answer'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/list/?quizId=' . $row['id']),
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'   => $data[$key]['image'],
                    'action' => $data[$key]['action'],
                );

                if ($edit) {
                    $data[$key]['name'] =  $row['name'];
                    if (config('app.languages')) {
                        foreach (config('app.languages') as $lang) {
                            $data[$key][$lang['code_name']] = $row[$lang['code_name']];
                        }
                    }
                }
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

        $model = Quiz::query();

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $student = QuizStudent::where('quiz_id', $row['id'])->count();
                $question = QuizQuestion::where('quiz_id', $row['id'])->count();
                return [
                    'id'            => $row['id'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'question'      => [
                        'total' => '(' . Translator::phrase($question . '.question') . ')',
                        'link_view' => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/list/?quizId=' . $row['id']),
                    ],
                    'student'       => [
                        'total'  => Translator::phrase('student') . '(' . $student . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple') . ')',
                        'link_view'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizStudent::$path['url'] . '/list?quizId=' . $row['id']),
                    ],
                    'image'         => $row['image'] ? (ImageHelper::site(Quiz::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/' . Quiz::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . Quiz::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Quiz::$path['url'] . '/delete/' . $row['id']),
                        'question_answer'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/list/?quizId=' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {
                if (Auth::user()->role_id == 8) {
                    $query = $query->where('staff_id', Auth::user()->node_id);
                } elseif (Auth::user()->role_id == 2) {
                    $query =  $query->where('institute_id', Auth::user()->institute_id);
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name,question.total') {
                                $query =  $query->where(function ($q) {
                                    $q->where('name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere($lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
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
        $validator          = Validator::make(request()->all(), FormQuiz::rulesField(), FormQuiz::customMessages(), FormQuiz::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $add = Quiz::insertGetId([
                    'staff_id'    => Auth::user()->id,
                    'institute_id' => trim(request('institute')),
                    'name'        => trim(request('name')),
                    'description' => request('description'),
                    'en'          => trim(request('en')),
                    'km'          => trim(request('km')),
                ]);
                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Quiz::updateImageToTable($add, ImageHelper::uploadImage($image, Quiz::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, Quiz::$path['image'], Quiz::$path['image'], public_path('/assets/img/icons/image.jpg'), null, true);
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => Quiz::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormQuiz::rulesField(), FormQuiz::customMessages(), FormQuiz::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $update = Quiz::where('id', $id)->update([
                    'institute_id' => trim(request('institute')),
                    'name'        => trim(request('name')),
                    'description' =>  request('description'),
                    'en'          => trim(request('en')),
                    'km'          => trim(request('km')),
                ]);
                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Quiz::updateImageToTable($id, ImageHelper::uploadImage($image, Quiz::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => Quiz::getData($id),
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

    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  Quiz::where('id', $id)->update([
                    'image'    => $image,
                ]);

                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
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
            if (Quiz::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Quiz::whereIn('id', $id)->delete();
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
