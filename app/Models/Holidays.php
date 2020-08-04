<?php

namespace App\Models;

use Carbon\Carbon;
use DomainException;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormHoliday;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Holidays extends Model
{
    public static $path = [
        'image'  => 'holiday',
        'url'    => 'holiday',
        'view'   => 'Holiday'
    ];
    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Holidays::$path['url'] . '/add/'),
            ),
        );

        $data = array();
        $orderBy = 'DESC';
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
        $get = Holidays::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        }else{
            if(request('instituteId')){
                $get = $get->where('institute_id',request('instituteId'));
            }
        }

        if (request('month')) {
            $get = $get->where('month', request('month'));
        }
        if (request('year')) {
            $get = $get->where('year', request('year'));
        }

        if ($paginate) {
            $get = $get->paginate(30)->toArray();
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
                if (gettype($edit) == 'string' && $edit == 'calendar') {
                    $data[]         = array(
                        'id'            => $row['id'],
                        'title'         => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                        'start'         => $row['year'] . '-' . $row['month'] . '-' . $row['date'],
                        'allDay'        => true,
                        'className'     => 'bg-green',
                        'description'   => $row['description'],
                    );
                } else {
                    $data[$key]         = array(
                        'id'            => $row['id'],
                        'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                        'date'          => $row['date'] . '-' . Months::getData($row['month'])['data'][0]['name'] . '-' . $row['year'],
                        'description'   => $row['description'],
                        'image'         => $row['image'] ? (ImageHelper::site(Holidays::$path['image'], $row['image'])) : ImageHelper::prefix(),
                        'action'        => [
                            'edit' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/edit/' . $row['id']),
                            'view' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/view/' . $row['id']),
                            'delete' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/delete/' . $row['id']),
                        ]
                    );
                    $pages['listData'][] = array(
                        'id'     => $data[$key]['id'],
                        'name'   => $data[$key]['name'],
                        'image'  => null,
                        'action' => $data[$key]['action'],

                    );

                    if ($edit) {
                        $data[$key]['name'] = $row['name'];
                        $data[$key]['date'] = $row['date'] . '-' . $row['month'] . '-' . $row['year'];

                        if (config('app.languages')) {
                            foreach (config('app.languages') as $lang) {
                                $data[$key][$lang['code_name']] = $row[$lang['code_name']];
                            }
                        }
                    }
                }
            }
            if (gettype($edit) == 'string' && $edit == 'calendar') {
                return $data;
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
        $model = Holidays::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'date'          => DateHelper::convert($row['date'] . '-' . $row['month'] . '-' . $row['year'], 'd-M-Y'),
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(Holidays::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/general/' . Holidays::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {

                if(request('instituteId')){
                    $query = $query->where('institute_id',request('instituteId'));
                }
                
                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  $query->where(function ($q) {
                                    $q->where('name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere($lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
                            } elseif ($value['data'] == 'description') {
                                $query->orWhere('description', 'LIKE', '%' . request('search.value') . '%');
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

    public static function getHoliday($year = null, $month = null, $study_course_session_id = null)
    {
        $response = array(
            'success'   => false,
            'data'      => array(),
            'message'   => Translator::phrase('no_data'),
        );
        $data = array();

        if ($year && $month) {
            $get = Holidays::where('year', $year)->where('month', $month)->get()->toArray();
        } else {
            $year = Years::now();
            $month = Months::now();
            $get = Holidays::where('year', $year)->where('month', $month)->get()->toArray();
        }


        if ($get) {
            foreach ($get as $row) {
                $data[$row['date']] = array(
                    'id'    => $row['id'],
                    'day'   =>  Translator::day(DateHelper::dayOfWeek($year . '-' . $month . '-' . $row['date'])['day']),
                    'date'   => $row['date'],
                    'description' => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['description'],
                );
            }


            $scheduleSession = StudyCourseSession::where('id', request('course-sessionId', $study_course_session_id))->get()->toArray();

            if ($scheduleSession) {

                $routine = StudyCourseRoutine::where('study_course_session_id', $scheduleSession[0]['id'])->groupBy('day_id')->get()->toArray();


                if ($routine) {
                    $result  = [];
                    $HolHolidays    = [1, 2, 3, 4, 5, 6, 7];
                    foreach ($routine as $key => $value) {
                        if ($value['teacher_id']) {
                            $result[] =  $value['day_id'];
                        }
                    }


                    foreach ($HolHolidays as $value) {
                        if (in_array($value, $result) == false) {
                            $date = Days::where('id', $value)->first()->toArray();
                            if ($date) {
                                $data += DateHelper::dateOfMonth($year, $month, $date['name']);
                            }
                        }
                    }
                }
            }

            ksort($data);
            $sortArray = array();
            foreach ($data as $key => $val) {
                $sortArray[$key] = $val;
            }

            $response = array(
                'success'   => true,
                'data'      => $sortArray,
            );
        }
        return $response;
    }

    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormHoliday::rulesField(), FormHoliday::customMessages(), FormHoliday::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            $date = new Carbon(trim(request('date')));

            try {
                $values['name']        = trim(request('name'));
                $values['year']        = $date->year;
                $values['month']       = $date->month;
                $values['date']        = $date->day;
                $values['description'] = trim(request('description'));
                $values['image']       = null;

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $add = Holidays::insertGetId($values);
                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Holidays::updateImageToTable($add, ImageHelper::uploadImage($image, Holidays::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, Holidays::$path['image'], Holidays::$path['image'], public_path('/assets/img/icons/image.jpg'), null, true);
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => Holidays::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormHoliday::rulesField(), FormHoliday::customMessages(), FormHoliday::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            $date = new Carbon(trim(request('date')));
            try {
                $values['name']        = trim(request('name'));
                $values['year']        = $date->year;
                $values['month']       = $date->month;
                $values['date']        = $date->day;
                $values['description'] = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $update = Holidays::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Holidays::updateImageToTable($id, ImageHelper::uploadImage($image, Holidays::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => Holidays::getData($id),
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
                $update = Holidays::where('id', $id)->update([
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
            if (Holidays::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Holidays::whereIn('id', $id)->delete();
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
