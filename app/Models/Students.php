<?php

namespace App\Models;

use DateTime;
use DomainException;
use App\Models\Communes;
use App\Models\Villages;
use App\Helpers\QRHelper;
use App\Models\Districts;
use App\Models\Provinces;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Models\StudentsGuardians;
use App\Http\Requests\FormStudents;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Students extends Model
{
    public static $path = [
        'image'   => 'student',
        'url'     => 'student',
        'view'    => 'Student',
        'role'    => 'student',
        'roleId'  => 6,
    ];


    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Students::$path['url'] . '/add?ref=' . request('ref')),
            ),
        );



        $response = array(
            'success'   => false,
            'data'      => [],
            'pages'     => $pages,
            'gender'    => Students::gender('null'),
            'type'      => Students::$path['role'],
            'message'   => Translator::phrase('no_data'),
        );



        $data = array();
        $orderBy = 'ASC';
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

        $get = Students::select((new Students())->getTable() . '.*')
            ->orderBy((new Students())->getTable() . '.id', $orderBy);


        if ($id) {
            $get = $get->whereIn((new Students())->getTable() . '.id', $id);
        }else{

            if(request('instituteId')){
                $get = $get->where('institute_id',request('instituteId'));
            }
        }

        $gender = Students::gender($get);

        if ($search) {
            $get = Students::searchName($get, $search);
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
                $place_of_birth         = json_decode($row['place_of_birth'], true);
                $current_resident       = json_decode($row['current_resident'], true);
                $student_request        = StudentsRequest::where('student_id', $row['id'])->where('status', 1)->latest('id')->first();
                $account = Users::where('email', $row['email'])->where('node_id', $row['id'])->first();
                $socail_auth = SocialAuth::getData(null, $row['id']);


                $photo = null;
                if ($row['photo']) {
                    $photo = ImageHelper::site(Students::$path['image'], $row['photo']);
                } elseif ($account) {
                    if ($account->profile) {
                        $photo = ImageHelper::site('profile', $account->profile);
                    } elseif ($socail_auth) {
                        $photo = $socail_auth['_avatar'];
                    }
                }


                if (request('ref') == Users::$path['url']) {
                    $data[$key]              = [
                        'id'                 => $row['id'],
                        'name'    => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
                        'photo'     => $photo,
                    ];
                } else {
                    $data[$key]              = array(
                        'id'                 => $row['id'],
                        'first_name'         => array_key_exists('first_name_' . app()->getLocale(), $row) ? $row['first_name_' . app()->getLocale()] : $row['first_name_en'],
                        'last_name'          => array_key_exists('last_name_' . app()->getLocale(), $row) ? $row['last_name_' . app()->getLocale()] : $row['last_name_en'],
                        '_fullname'          => $row['first_name_en'] . ' ' . $row['last_name_en'],
                        'nationality'        => $row['nationality_id'] ? (Nationality::getData($row['nationality_id'])['data'][0]) : null,
                        'mother_tong'        => $row['mother_tong_id'] ? (MotherTong::getData($row['mother_tong_id'])['data'][0]) : null,
                        'national_id'        => $row['national_id'],
                        'gender'             => $row['gender_id'] ? (Gender::getData($row['gender_id'])['data'][0]) : null,
                        'date_of_birth'      => DateHelper::convert($row['date_of_birth'], 'd-m-Y'),

                        'marital'            => $row['marital_id'] ? (Marital::getData($row['marital_id'])['data'][0]) : null,
                        'blood_group'        => $row['blood_group_id'] ? (BloodGroup::getData($row['blood_group_id'])['data'][0]) : null,
                        'place_of_birth'     => array(
                            'province'       => ($place_of_birth['province']) ? (Provinces::getData($place_of_birth['province'])['data'][0]) : null,
                            'district'       => ($place_of_birth['district']) ? (Districts::getData(null, $place_of_birth['district'])['data'][0]) : null,
                            'commune'        => ($place_of_birth['commune']) ? (Communes::getData(null, $place_of_birth['commune'])['data'][0]) : null,
                            'village'        => ($place_of_birth['village']) ? (Villages::getData(null, $place_of_birth['village'])['data'][0]) : null,
                        ),
                        'current_resident'   => array(
                            'province'       => ($current_resident['province']) ? (Provinces::getData($current_resident['province'])['data'][0]) : null,
                            'district'       => ($current_resident['district']) ? (Districts::getData(null, $current_resident['district'])['data'][0]) : null,
                            'commune'        => ($current_resident['commune']) ? (Communes::getData(null, $current_resident['commune'])['data'][0]) : null,
                            'village'        => ($current_resident['village']) ? (Villages::getData(null, $current_resident['village'])['data'][0]) : null,
                        ),
                        'permanent_address'  => $row['permanent_address'],
                        'temporaray_address' => $row['temporaray_address'],
                        'phone'              => $row['phone'],
                        'email'              => $row['email'],
                        'extra_info'         => $row['extra_info'],
                        'photo'              => $photo,
                        'student_guardian'   => StudentsGuardians::getData($row['id'])['data'][0],
                        'account'            => $account,
                        'register_date'      => DateHelper::convert($row['created_at'], 'd-F-Y'),
                        'action'             => [
                            'edit'           => url(Users::role() . '/' . Students::$path['url'] . '/edit/' . $row['id']),
                            'view'           => url(Users::role() . '/' . Students::$path['url'] . '/view/' . $row['id']),
                            'delete'         => url(Users::role() . '/' . Students::$path['url'] . '/delete/' . $row['id']),
                        ],
                    );

                    if ($edit) {
                        $data[$key]['first_name_km'] = $row['first_name_km'];
                        $data[$key]['last_name_km']  = $row['last_name_km'];
                        $data[$key]['first_name_en'] = $row['first_name_en'];
                        $data[$key]['last_name_en']  = $row['last_name_en'];
                    }

                    $pages['listData'][] = array(
                        'id'     => $data[$key]['id'],
                        'name'   => $data[$key]['first_name'] . ' ' . $data[$key]['last_name'],
                        'image'  => $data[$key]['photo'],
                        'action' => $data[$key]['action'],
                    );
                }
            }

            $response = array(
                'success'   => true,
                'type'      => Students::$path['role'],
                'pages'     => $pages,
                'data'      => $data,
                'gender'    => $gender,
            );
        }
        return $response;
    }
    public static function getDataTable()
    {

        $model = Students::select([
            'id',
            'first_name_km',
            'last_name_km',
            'first_name_en',
            'last_name_en',
            'gender_id',
            'date_of_birth',
            'email',
            'phone',
            'photo',
        ]);
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $account = Users::where('email', $row['email'])->where('node_id', $row['id'])->first();
                $socail_auth = SocialAuth::getData(null, $row['id']);

                $photo = null;
                if ($row['photo']) {
                    $photo = ImageHelper::site(Students::$path['image'], $row['photo']);
                } elseif ($account) {
                    if ($account->profile) {
                        $photo = ImageHelper::site('profile', $account->profile);
                    } elseif ($socail_auth) {
                        $photo = $socail_auth['_avatar'];
                    }
                }


                return [
                    'id'      => $row['id'],
                    'name'    => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
                    'gender'             =>  Gender::where('id',$row['gender_id'])->pluck(app()->getLocale())->first(),
                    'date_of_birth'      => DateHelper::convert($row['date_of_birth'], 'd-m-Y'),
                    'account'            => $account ? Users::getData($account->id)['data'][0] : null,
                    'photo'             =>  $photo,
                    'email'      => $row['email'],
                    'phone'      => $row['phone'],
                    'action'                   => [
                        'edit'                 => url(Users::role() . '/' . Students::$path['url'] . '/edit/' . $row['id']), //?id
                        'view'                 => url(Users::role() . '/' . Students::$path['url'] . '/view/' . $row['id']), //?id
                        'account'              => url(Users::role() . '/' . Students::$path['url'] . '/account/create/' . $row['id']), //?id
                        'delete'               => url(Users::role() . '/' . Students::$path['url'] . '/delete/' . $row['id']), //?id
                    ],

                ];
            })
            ->filter(function ($query) {
                if(request('instituteId')){
                    $query = $query->where('institute_id',request('instituteId'));
                }
                foreach (request('columns') as $i => $value) {
                    if ($value['searchable']) {
                        if ($value['data'] == 'name') {
                            $query  = Students::searchName($query, request('search.value'));
                        }
                    }
                }
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
    public static function searchName($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name_en', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name_en', 'LIKE', '%' . $search . '%')
                ->orWhere('first_name_km', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name_km', 'LIKE', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`first_name_en`, \'\', `last_name_en`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`last_name_en`, \'\', `first_name_en`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`first_name_km`, \'\', `last_name_km`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`last_name_km`, \'\', `first_name_km`) LIKE ?', '%' . $search . '%')

                ->orWhereRaw('CONCAT(`first_name_en`, \' \', `last_name_en`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`last_name_en`, \' \', `first_name_en`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`first_name_km`, \' \', `last_name_km`) LIKE ?', '%' . $search . '%')
                ->orWhereRaw('CONCAT(`last_name_km`, \' \', `first_name_km`) LIKE ?', '%' . $search . '%');
        });
    }
    public static function gender($query)
    {

        if (gettype($query) == 'object' && $query->count()) {
            $male   = [];
            $female = [];
            foreach ($query->get()->toArray() as  $row) {
                if ($row['gender_id']  == 1) {
                    if (isset($row['student_id'])) {
                        $male[$row['student_id']] = $row['student_id'];
                    } else {
                        $male[$row['id']] = $row['id'];
                    }
                } elseif ($row['gender_id']  == 2) {
                    if (isset($row['student_id'])) {
                        $female[$row['student_id']] = $row['student_id'];
                    } else {
                        $female[$row['id']] = $row['id'];
                    }
                };
            }

            return array(
                'male'      => [
                    'title' => Translator::phrase('student.male'),
                    'text'  => count($male) . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
                ],
                'female'    => [
                    'title' => Translator::phrase('student.female'),
                    'text'  => count($female) . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
                ],
                'total'      => [
                    'title' => Translator::phrase('student.total'),
                    'text'  => count($male) + count($female) . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
                ],
            );
        } else {
            return array(
                'male'      => [
                    'title' => Translator::phrase('student.male'),
                    'text'  => ((app()->getLocale() == 'km') ? '0 នាក់' : '0 Poeple'),
                ],
                'female'    => [
                    'title' => Translator::phrase('student.female'),
                    'text'  => ((app()->getLocale() == 'km') ? '0 នាក់' : '0 Poeple'),
                ],
                'total'      => [
                    'title' => Translator::phrase('student.total'),
                    'text'  => ((app()->getLocale() == 'km') ? '0 នាក់' : '0 Poeple'),
                ],
            );
        }
    }

    public static function addToTable()
    {
        $response           = array();
        $rules = [];
        if (strtolower(trim(request('guardian'))) == 'other') {
            $rules += [
                'guardian_fullname'    => 'required|only_string',
                'guardian_occupation'  => 'required',
                'guardian_phone'       => 'required',
            ];
        } elseif (strtolower(trim(request('guardian'))) == 'father' || strtolower(trim(request('guardian'))) == 'mother') {
            $rules = [];
        }

        // if(request('permanent_address')){
        //     $rules += [
        //         'permanent_address'    => 'required'
        //     ];
        // }else{
        //     $rules += [
        //         'pob_province_fk'         => 'required',
        //         'pob_district_fk'         => 'required',
        //         'pob_commune_fk'          => 'required',
        //         'pob_village_fk'          => 'required',
        //     ];
        // }



        // if(request('temporaray_address')){
        //     $rules += [
        //         'temporaray_address'    => 'required',
        //     ];
        // }else{
        //     $rules += [
        //         'curr_province_fk'         => 'required',
        //         'curr_district_fk'         => 'required',
        //         'curr_commune_fk'          => 'required',
        //         'curr_village_fk'          => 'required',
        //     ];
        // }
        // if(request()->hasFile('photo')){
        //     $rules = [
        //         'photo'         => 'required',
        //     ];
        // }


        $rules += FormStudents::rulesField();

        $validator          = Validator::make(request()->all(), $rules, FormStudents::customMessages(), FormStudents::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $add = Students::insertGetId([
                    'institute_id'      => trim(request('institute')),
                    'first_name_km'    => trim(request('first_name_km')),
                    'last_name_km'     => trim(request('last_name_km')),
                    'first_name_en'    => trim(request('first_name_en')),
                    'last_name_en'     => trim(request('last_name_en')),
                    'nationality_id'   => request('nationality'),
                    'mother_tong_id'   => request('mother_tong'),
                    'national_id'      => trim(request('national_id')),
                    'gender_id'        => request('gender'),
                    'date_of_birth'    => DateHelper::convert(trim(request('date_of_birth'))),
                    'marital_id'       => request('marital'),
                    'blood_group_id'   => request('blood_group'),

                    'place_of_birth' => json_encode(array(
                        'province' => request('pob_province_fk'),
                        'district' => request('pob_district_fk'),
                        'commune'  => request('pob_commune_fk'),
                        'village'  => request('pob_village_fk'),
                    ), JSON_UNESCAPED_UNICODE),

                    'current_resident' => json_encode(array(
                        'province' => request('curr_province_fk'),
                        'district' => request('curr_district_fk'),
                        'commune'  => request('curr_commune_fk'),
                        'village'  => request('curr_village_fk'),
                    ), JSON_UNESCAPED_UNICODE),

                    'permanent_address'  => trim(request('permanent_address')),
                    'temporaray_address' => trim(request('temporaray_address')),
                    'phone'              => trim(request('phone')),
                    'email'              => strtolower(trim(request('email'))),
                    'extra_info'         => trim(request('student_extra_info')),
                    'photo'              => (request('gender') == '1') ? 'male.jpg' : 'female.jpg',

                ]);

                if ($add && StudentsGuardians::addToTable($add)) {
                    if (request()->hasFile('photo')) {
                        $photo      = request()->file('photo');
                        Students::updateImageToTable($add, ImageHelper::uploadImage($photo, Students::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, Students::$path['image'], (request('gender') == '1') ? 'male' : 'female', public_path('/assets/img/user/' . ((request('gender') == '1') ? 'male.jpg' : 'female.jpg')), true);
                    }

                    $response       = array(
                        'success'   => true,
                        // 'data'      => Students::getData($add)['data'][0],
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
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }

    public static function register()
    {

        $rules = FormStudents::rulesField();

        unset($rules['pob_province_fk']);
        unset($rules['pob_district_fk']);
        unset($rules['pob_commune_fk']);
        unset($rules['pob_village_fk']);
        unset($rules['curr_province_fk']);
        unset($rules['curr_district_fk']);
        unset($rules['curr_commune_fk']);
        unset($rules['curr_village_fk']);
        unset($rules['father_fullname']);
        unset($rules['father_occupation']);
        unset($rules['father_phone']);
        unset($rules['mother_fullname']);
        unset($rules['mother_occupation']);
        unset($rules['mother_phone']);
        unset($rules['guardian']);
        unset($rules['__guardian']);
        $rules['phone'] = 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9|unique:students,phone';
        $rules['email'] = 'required|email|unique:students,email';

        $validator          = Validator::make(request()->all(), $rules, FormStudents::customMessages(), FormStudents::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            $values = [
                'institute_id'     => trim(request('institute')),
                'first_name_km'    => trim(request('first_name_km')),
                'last_name_km'     => trim(request('last_name_km')),
                'first_name_en'    => trim(request('first_name_en')),
                'last_name_en'     => trim(request('last_name_en')),
                'nationality_id'   => request('nationality'),
                'mother_tong_id'   => request('mother_tong'),
                'national_id'      => trim(request('national_id')),
                'gender_id'        => request('gender'),
                'date_of_birth'    => DateHelper::convert(trim(request('date_of_birth'))),
                'marital_id'       => request('marital'),

                'permanent_address'  => trim(request('permanent_address')),
                'temporaray_address' => trim(request('temporaray_address')),
                'phone'              => trim(request('phone')),
                'email'              => strtolower(trim(request('email'))),
                'extra_info'         => trim(request('student_extra_info')),
                'photo'              => (request('gender') == '1') ? 'male.jpg' : 'female.jpg',
            ];
            $add = Students::insertGetId($values);

            if ($add) {
                StudentsGuardians::insert(['student_id' => $add]);
                if (request()->hasFile('photo')) {
                    $photo      = request()->file('photo');
                    Students::updateImageToTable($add, ImageHelper::uploadImage($photo, Students::$path['image']));
                }

                $response       = array(
                    'success'   => true,
                    'type'      => 'add',
                    'message'   => array(
                        'title' => Translator::phrase('success'),
                        'text'  => Translator::phrase('register.successfully'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        }

        return $response;
    }


    public static function updateToTable($id)
    {
        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudents::rulesField(), FormStudents::customMessages(), FormStudents::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {

                $update = Students::where('id', $id)->update([
                    'institute_id'      => trim(request('institute')),
                    'first_name_km'    => trim(request('first_name_km')),
                    'last_name_km'     => trim(request('last_name_km')),
                    'first_name_en'    => trim(request('first_name_en')),
                    'last_name_en'     => trim(request('last_name_en')),
                    'nationality_id'   => request('nationality'),
                    'mother_tong_id'   => request('mother_tong'),
                    'national_id'      => trim(request('national_id')),
                    'gender_id'        => request('gender'),
                    'date_of_birth'    => DateHelper::convert(trim(request('date_of_birth'))),
                    'marital_id'       => request('marital'),
                    'blood_group_id'   => request('blood_group'),

                    'place_of_birth' => json_encode(array(
                        'province' => is_numeric(request('pob_province_fk')) ? request('pob_province_fk') : null,
                        'district' => is_numeric(request('pob_district_fk')) ? request('pob_district_fk') : null,
                        'commune'  => is_numeric(request('pob_commune_fk')) ? request('pob_commune_fk') : null,
                        'village'  => is_numeric(request('pob_village_fk')) ? request('pob_village_fk') : null,
                    ), JSON_UNESCAPED_UNICODE),

                    'current_resident' => json_encode(array(
                        'province' => is_numeric(request('curr_province_fk')) ? request('curr_province_fk') : null,
                        'district' => is_numeric(request('curr_district_fk')) ? request('curr_district_fk') : null,
                        'commune'  => is_numeric(request('curr_commune_fk')) ? request('curr_commune_fk') : null,
                        'village'  => is_numeric(request('curr_village_fk')) ? request('curr_village_fk') : null,
                    ), JSON_UNESCAPED_UNICODE),

                    'permanent_address'  => trim(request('permanent_address')),
                    'temporaray_address' => trim(request('temporaray_address')),
                    'phone'              => trim(request('phone')),
                    'email'              => trim(request('email')),
                    'extra_info'         => trim(request('student_extra_info')),
                ]);

                if ($update &&  StudentsGuardians::updateToTable($id)) {

                    if (request()->hasFile('photo')) {
                        $photo      = request()->file('photo');
                        Students::updateImageToTable($id, ImageHelper::uploadImage($photo, Students::$path['image']));
                    }

                    $response       = array(
                        'success'   => true,
                        'data'      => Students::getData($id)['data'][0],
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

    public static function updateImageToTable($student_id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  Students::where('id', $student_id)->update([
                    'photo'    => $image,
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


    public static function makeQrCodeToTable($id = null, $options = null)
    {
        $response = array(
            'success'   => false,
            'type'   => 'makeQRCode',
            'data'   => [],
        );


        if ($id) {
            $make = Students::getData($id, true);
        } else {
            $make = Students::getData(null, true);
        }

        if ($make['success']) {
            $data = array();
            foreach ($make['data'] as $row) {
                $oldQrcode = $row['qrcode']['image'];
                if ($oldQrcode) {
                    if (file_exists(storage_path(ImageHelper::$path['image'] . '/' . Students::$path['image'] . '/' . QRHelper::$path['image'] . '/' . $oldQrcode))) {
                        unlink(storage_path(ImageHelper::$path['image'] . '/' . Students::$path['image'] . '/' . QRHelper::$path['image'] . '/' . $oldQrcode));
                    }
                }

                $date = new DateTime();
                $date->modify('+1 year');
                $q['size'] = $options && $options['code'] ? $options['code'] : 100;
                $q['code']  = Qrcode::encryptQrcode([
                    'id'    => $row['id'],
                    'type'  => Students::$path['role'],
                    'aYear'  =>  $row['study_academic_year_id']['id'],
                    'exp'  =>  $date->format('Y-m-d'),
                ]);

                if ($options && $options['image'] > 0) {
                    $q['center']  = array(
                        'image' => $row['photo'] . '?type=larg', //ImageHelper::getImage($row['photoName'], Students::$path['image'], true), //storage_path(ImageHelper::$path['image'] . '/' . Students::$path['image'] . '/' . ImageHelper::$path['resize'][0] . '/' . $row['photoName']),
                        'percentage' => $options && $options['image'] ? $options['image'] / $options['code']  : .19
                    );
                }

                $qrCode  = QRHelper::make($q, true);
                $qrCode_image = ImageHelper::uploadImage($qrCode, ImageHelper::$path['image'] . '/' . Students::$path['image'] . '/' . QRHelper::$path['image']);
                if ($qrCode_image) {

                    try {
                        Students::where('id', $row['id'])->update([
                            'qrcode'        => Qrcode::decryptQrcode($q['code']),
                            'qrcode_image'  => $qrCode_image,
                        ]);
                    } catch (DomainException $e) {
                        $response       = Exception::exception($e);
                    }

                    $data[] = ImageHelper::site(QRHelper::$path['image'], $qrCode_image);
                }
            }

            $response       = array(
                'success'   => true,
                'type'   => 'makeQRCode',
                'data'   => $data,
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


        return $response;
    }


    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (Students::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Students::whereIn('id', $id)->delete();
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
