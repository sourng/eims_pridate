<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
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
use App\Models\StaffGuardians;
use App\Models\StaffInstitutes;
use App\Http\Requests\FormStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Staff extends Model
{



    public static $path = [
        'image'   => 'staff',
        'url'     => 'staff',
        'view'    => 'Staff',
        'role'    => 'staff',
        'roleId'  => 5,
    ];


    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {

        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Staff::$path['url'] . '/add?ref=' . request('ref')),
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
        $get = Staff::select((new Staff())->getTable() . '.*')
            ->join((new StaffInstitutes())->getTable(), (new StaffInstitutes())->getTable() . '.staff_id', (new Staff())->getTable() . '.id')
            ->orderBy((new Staff())->getTable() . '.id', $orderBy);
        if ($id) {
            $get = $get->whereIn((new Staff())->getTable() . '.id', $id);
        } else {
            if (request('ref') == Users::$path['url']) {
                $get = $get->whereNotIn((new Staff())->getTable() . '.id', Users::select('node_id')->whereNotNull('node_id')->whereNotIn('role_id', [1, 6, 7, 9])->get());
            }

            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'))
                    ->whereNotIn('designation_id', [1]);
            }
        }

        $gender = Staff::gender($get);
        $staffStatus = Staff::staffStatus($get);


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

                $place_of_birth     = json_decode($row['place_of_birth'], true);
                $current_resident   = json_decode($row['current_resident'], true);

                $account = Users::where('email', $row['email'])->where('node_id', $row['id'])->first();
                $first_name         = array_key_exists('first_name_' . app()->getLocale(), $row) ? $row['first_name_' . app()->getLocale()] : $row['first_name_en'];
                $last_name          = array_key_exists('last_name_' . app()->getLocale(), $row) ? $row['last_name_' . app()->getLocale()] : $row['last_name_en'];


                if (request('ref') == Users::$path['url']) {
                    $data[$key]              = [
                        'id'                 => $row['id'],
                        'name'    => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
                        'photo'     => ImageHelper::site(Staff::$path['image'], $row['photo']),
                    ];
                } else {
                    $data[$key]        = array(
                        'id'                 => $row['id'],
                        'first_name'         => $first_name,
                        'last_name'          => $last_name,
                        'name'               => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
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
                        'photo'                   => ImageHelper::site(Staff::$path['image'], $row['photo']),
                        'staff_institute'         => StaffInstitutes::getData($row['id'])['data'][0],
                        'staff_experience'        => StaffExperience::getData($row['id'])['data'],
                        'staff_guardian'          => StaffGuardians::getData($row['id'])['data'][0],
                        'staff_qualification'     => StaffQualifications::getData($row['id'])['data'][0],
                        'staff_status'            => StaffStatus::getData($row['staff_status_id'])['data'][0],
                        'account'                 => $account ? Users::getData($account->id)['data'][0] : null,
                        'action'                   => [
                            'edit'                 => url(Users::role() . '/' . Staff::$path['url'] . '/edit/' . $row['id']), //?id
                            'view'                 => url(Users::role() . '/' . Staff::$path['url'] . '/view/' . $row['id']), //?id
                            'account'              => url(Users::role() . '/' . Staff::$path['url'] . '/account/create/' . $row['id']), //?id
                            'delete'               => url(Users::role() . '/' . Staff::$path['url'] . '/delete/' . $row['id']), //?id
                        ],
                    );

                    if (in_array($row['staff_status_id'], [1, 4])) {
                        if ($row['created_at']) {
                            $created = Carbon::createFromDate($row['created_at']);
                            $created->addMonths(3);
                            $now = Carbon::now();
                            $diff = $created->diffInDays($now);
                            if ($diff > 90) {
                                if (Staff::updateStaffStatus($row['id'], 3)) {
                                    $data[$key]['staff_status']  = StaffStatus::getData(3)['data'][0];
                                };
                            };
                        }
                    };

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
                'success'     => true,
                'type'        => Staff::$path['role'],
                'gender'      => $gender,
                'staffStatus' => $staffStatus,
                'pages'       => $pages,
                'data'        => $data,
            );
        } else {


            $response = array(
                'success'   => false,
                'data'      => [],
                'pages'     => $pages,
                'gender'      => Staff::gender('null'),
                'staffStatus' =>  Staff::staffStatus('null'),
                'type'      => Staff::$path['role'],
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function getDataTable()
    {
        $_staff = (new Staff)->getTable();
        $_staff_institute = (new StaffInstitutes)->getTable();

        $model = Staff::select([
            $_staff . '.id',
            $_staff . '.first_name_km',
            $_staff . '.last_name_km',
            $_staff . '.first_name_en',
            $_staff . '.last_name_en',
            $_staff . '.gender_id',
            $_staff . '.date_of_birth',
            $_staff . '.email',
            $_staff . '.phone',
            $_staff . '.photo',
            $_staff . '.staff_status_id',
            $_staff_institute . '.institute_id',
            $_staff_institute . '.designation_id',

        ])
            ->join($_staff_institute, $_staff_institute . '.staff_id', $_staff . '.id');


        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $account = Users::where('email', $row['email'])->where('node_id', $row['id'])->first();
                return [
                    'id'      => $row['id'],
                    'name'    => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
                    'gender'             =>  Gender::where('id', $row['gender_id'])->pluck(app()->getLocale())->first(),
                    'date_of_birth'      => DateHelper::convert($row['date_of_birth'], 'd-m-Y'),
                    'account'            => $account ? Users::getData($account->id)['data'][0] : null,
                    'status'            => Gender::where('id', $row['staff_status_id'])->pluck(app()->getLocale())->first(),
                    'photo'             => ImageHelper::site(Staff::$path['image'], $row['photo']),
                    'email'      => $row['email'],
                    'phone'      => $row['phone'],
                    'staff_institute'         => [
                        'institute' =>  Institute::where('id', $row['institute_id'])->pluck(app()->getLocale())->first(),
                        'designation' =>  StaffDesignations::where('id', $row['designation_id'])->pluck(app()->getLocale())->first(),
                    ],
                    'action'                   => [
                        'edit'                 => url(Users::role() . '/' . Staff::$path['url'] . '/edit/' . $row['id']), //?id
                        'view'                 => url(Users::role() . '/' . Staff::$path['url'] . '/view/' . $row['id']), //?id
                        'account'              => url(Users::role() . '/' . Staff::$path['url'] . '/account/create/' . $row['id']), //?id
                        'delete'               => url(Users::role() . '/' . Staff::$path['url'] . '/delete/' . $row['id']), //?id
                    ],

                ];
            })
            ->filter(function ($query) {

                if (Auth::user()->role_id == 2) {
                    $query = $query->where((new StaffInstitutes())->getTable() . '.institute_id', Auth::user()->institute_id)
                        ->whereNotIn((new StaffInstitutes())->getTable() . '.designation_id', [1]);
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query  = Staff::searchName($query, request('search.value'));
                            }
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

    public static function staffDetail($id = null)
    {
        $get = Staff::orderBY('id');

        if ($id) {
            $get = $get->where('id', $id);
        }

        $get = $get->get()->toArray();

        if ($get) {
            $data = [];
            foreach ($get as $key => $row) {

                $data[$key] = [
                    'id'    => $row['id'],
                    'first_name'   => $row['first_name_km'],
                    'gender'    => Gender::getData($row['gender_id'])['data'][0],
                ];
            }
            return $data;
        }
    }


    public static function gender($query)
    {

        if (gettype($query) == 'object' && $query->count()) {
            $male   = 0;
            $female = 0;
            foreach ($query->get()->toArray() as  $row) {
                if ($row['gender_id']  == 1) {
                    $male++;
                } elseif ($row['gender_id']  == 2) {
                    $female++;
                };
            }
            return array(
                'male'      => [
                    'title' => Translator::phrase('staff.male'),
                    'text'  => $male . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
                ],
                'female'    => [
                    'title' => Translator::phrase('staff.female'),
                    'text'  => $female . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
                ],
                'total'      => [
                    'title' => Translator::phrase('staff.total'),
                    'text'  => $query->count() . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple'),
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

    public static function staffStatus($query)
    {
        $data = [];
        if (gettype($query) == 'object' && $query->count()) {
            $staffStatus = StaffStatus::getData();
            if ($staffStatus['success']) {
                foreach ($staffStatus['data'] as  $status) {
                    $data[$status['id']] = [
                        'title' => in_array($status['id'], [2, 3]) ? $status['name'] :  Translator::phrase('staff.' . $status['name']),
                        'color' => $status['color'],
                        'text' => 0,
                    ];
                    foreach ($query->get()->toArray() as  $row) {

                        if ($status['id'] == $row['staff_status_id']) {
                            $data[$status['id']]['text']++;
                        }

                        if (strpos($query->toSql(), 'institute_id') > 0) {
                            $value = $query->getBindings();
                            $data[$status['id']]['link'] = url(Users::role() . '/' . Staff::$path['url'] . '/list/?instituteId=' . $value[0] . '&statusId=' . $status['id']);
                        } else {
                            $data[$status['id']]['link'] = url(Users::role() . '/' . Staff::$path['url'] . '/list/?statusId=' . $status['id']);
                        }
                    }
                }
            }
        }
        $newData = [];
        foreach ($data as $key => $value) {
            $newData[$key] = $value;
            $newData[$key]['text'] = $value['text'] . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple');
        }
        return $newData;
    }

    public static function updatestaffStatus($staff_id, $staff_status_id)
    {
        return Staff::where('id', $staff_id)->update([
            'staff_status_id' => $staff_status_id
        ]);
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


        $rules += FormStaff::rulesField();

        $validator          = Validator::make(request()->all(), $rules, FormStaff::customMessages(), FormStaff::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {


            try {
                $add = Staff::insertGetId([
                    'first_name_km' => trim(request('first_name_km')),
                    'last_name_km'  => trim(request('last_name_km')),
                    'first_name_en' => trim(request('first_name_en')),
                    'last_name_en'  => trim(request('last_name_en')),

                    'nationality_id'   => request('nationality'),
                    'mother_tong_id'   => request('mother_tong'),
                    'national_id'   => trim(request('national_id')),
                    'gender_id'        => request('gender'),
                    'date_of_birth' => DateHelper::convert(trim(request('date_of_birth'))),
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
                    'email'              => trim(request('email')),
                    'password'           => trim(request('password')),
                    'extra_info'         => trim(request('staff_extra_info')),
                    'photo'              => (request('gender') == '1') ? 'male.jpg' : 'female.jpg',
                ]);


                if (
                    $add && StaffInstitutes::addToTable($add)['success']  &&
                    StaffGuardians::addToTable($add)['success'] &&
                    StaffQualifications::addToTable($add)['success'] &&
                    StaffExperience::addToTable($add)['success']
                ) {

                    if (request('status')) {
                        Staff::updatestaffStatus($add, request('status'));
                    }
                    if (request()->hasFile('photo')) {
                        $photo      = request()->file('photo');
                        Staff::updateImageToTable($add, ImageHelper::uploadImage($photo, Staff::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, Staff::$path['image'], (request('gender') == '1') ? 'male' : 'female', public_path('/assets/img/user/' . ((request('gender') == '1') ? 'male.jpg' : 'female.jpg')));
                    }


                    $response       = array(
                        'success'   => true,
                        'data'      => Staff::getData($add)['data'][0],
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

        $rules = FormStaff::rulesField();

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
        $rules['phone'] = 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9|unique:staff,phone';
        $rules['email'] = 'required|email|unique:staff,email';

        $validator          = Validator::make(request()->all(), $rules, FormStaff::customMessages(), FormStaff::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            $values = [
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
            $add = Staff::insertGetId($values);

            if ($add) {
                StaffInstitutes::addToTable($add);
                StaffGuardians::addToTable($add);
                StaffQualifications::addToTable($add);
                StaffExperience::insert([
                    'staff_id'  => $add
                ]);

                if (request()->hasFile('photo')) {
                    $photo      = request()->file('photo');
                    Staff::updateImageToTable($add, ImageHelper::uploadImage($photo, Staff::$path['image']));
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
        $validator          = Validator::make(request()->all(), FormStaff::rulesField(), FormStaff::customMessages(), FormStaff::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {

                $update = Staff::where('id', $id)->update([
                    'first_name_km' => trim(request('first_name_km')),
                    'last_name_km'  => trim(request('last_name_km')),
                    'first_name_en' => trim(request('first_name_en')),
                    'last_name_en'  => trim(request('last_name_en')),

                    'nationality_id'   => request('nationality'),
                    'mother_tong_id'   => request('mother_tong'),
                    'national_id'   => trim(request('national_id')),
                    'gender_id'        => request('gender'),
                    'date_of_birth' => DateHelper::convert(trim(request('date_of_birth'))),
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
                    'email'              => trim(request('email')),
                    'password'           => trim(request('password')),
                    'extra_info'         => trim(request('staff_extra_info')),
                ]);

                if (
                    $update &&  StaffInstitutes::updateToTable($id)['success']  &&
                    StaffGuardians::updateToTable($id)['success'] &&
                    StaffQualifications::updateToTable($id)['success'] &&
                    StaffExperience::updateToTable($id)['success']
                ) {

                    if (request()->hasFile('photo')) {
                        $photo      = request()->file('photo');
                        Staff::updateImageToTable($id, ImageHelper::uploadImage($photo, Staff::$path['image']));
                    }


                    if (request('status')) {
                        Staff::updatestaffStatus($id, request('status'));
                    }

                    $response       = array(
                        'success'   => true,
                        //'data'      => Staff::getData($id)['data'][0],
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



    public static function updateImageToTable($add, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  Staff::where('id', $add)->update([
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
            $make = Staff::getData($id, true);
        } else {
            $make = Staff::getData(null, true);
        }

        if ($make['success']) {
            $data = array();
            foreach ($make['data'] as $row) {
                $oldQrcode = $row['qrcode']['image'];
                if ($oldQrcode) {
                    if (file_exists(storage_path(ImageHelper::$path['image'] . '/' . Staff::$path['image'] . '/' . QRHelper::$path['image'] . '/' . $oldQrcode))) {
                        unlink(storage_path(ImageHelper::$path['image'] . '/' . Staff::$path['image'] . '/' . QRHelper::$path['image'] . '/' . $oldQrcode));
                    }
                }

                $date = new DateTime();
                $date->modify('+1 year');
                $q['size'] = $options && $options['code'] ? $options['code'] : 100;
                $q['code']  = Qrcode::encryptQrcode([
                    'id'    => $row['id'],
                    'type'  => Staff::$path['role'],
                    'aYear'  =>  $row['study_academic_year_id']['id'],
                    'exp'  =>  $date->format('Y-m-d'),
                ]);

                if ($options && $options['image'] > 0) {
                    $q['center']  = array(
                        'image' => $row['photo'] . '?type=larg', //ImageHelper::getImage($row['photoName'], Staff::$path['image'], true), //storage_path(ImageHelper::$path['image'] . '/' . Staff::$path['image'] . '/' . ImageHelper::$path['resize'][0] . '/' . $row['photoName']),
                        'percentage' => $options && $options['image'] ? $options['image'] / $options['code']  : .19
                    );
                }

                $qrCode  = QRHelper::make($q, true);
                $qrCode_image = ImageHelper::uploadImage($qrCode, ImageHelper::$path['image'] . '/' . Staff::$path['image'] . '/' . QRHelper::$path['image']);
                if ($qrCode_image) {

                    try {
                        Staff::where('id', $row['id'])->update([
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

    public static function createAccountToTable($id)
    {
        $staff = Staff::where('id', $id)->first()->toArray();

        if ($staff) {
            $account = Users::where('email', $staff['email'])->where('node_id', $staff['id'])->first();
            $staffInstitute = StaffInstitutes::where('staff_id', $staff['id'])->first()->toArray();
            if ($account) {
                return [
                    'success' => false,
                    'data'    => [],
                    'message'   => array(
                        'title' => Translator::phrase('account'),
                        'text'  => Translator::phrase('already_exists'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                ];
            }

            $folder  = 'public/' . ImageHelper::$path['image'] . '/' . Staff::$path['image'];
            $filePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;

            if (request('password')) {
                $first_name = array_key_exists('first_name_' . app()->getLocale(), $staff) ? $staff['first_name_' . app()->getLocale()] : $staff['first_name_en'];
                $last_name  = array_key_exists('last_name_' . app()->getLocale(), $staff) ? $staff['last_name_' . app()->getLocale()] : $staff['last_name_en'];
                $create = Users::insertGetId([
                    'name'          => $first_name . ' ' . $last_name,
                    'email'         => $staff['email'],
                    'password'      => Hash::make(request('password')),
                    'phone'         => $staff['phone'],
                    'address'       => $staff['permanent_address'],
                    'role_id'       => request('role', Staff::$path['roleId']),
                    'node_id'       => $staff['id'],
                    'institute_id'  => $staffInstitute['institute_id'],
                ]);
                if ($create) {

                    if ($staff['photo'] && File::exists($filePath . '/original/' . $staff['photo'])) {
                        $profile = ImageHelper::uploadImage(null, Users::$path['image'], null, $filePath  . '/original/' . $staff['photo']);
                        Users::updateImageToTable($create, $profile);
                    } else {
                        $profile = ($staff['gender_id'] == 1) ? 'male.jpg' : 'female.jpg';
                        Users::updateImageToTable($create, $profile);
                    }

                    $response = [
                        'success' => true,
                        'data'    => Users::getData($create),
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('create.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'data'    => [],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('no_password'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                ];
            }
        }

        return $response;
    }
    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (Staff::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Staff::whereIn('id', $id)->delete();
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

    public static function getTeaching($teacher_id)
    {
        $course_routine = StudyCourseRoutine::where('teacher_id', $teacher_id)->groupBy('study_course_session_id')->get()->toArray();
        $study_course_session_id = [];
        if ($course_routine) {
            foreach ($course_routine as $key => $value) {
                $study_course_session_id[] = $value['study_course_session_id'];
            }
        }
        return StudyCourseSession::getData($study_course_session_id);
    }

    /** Get Teacher teaching classes and subjects.
     * GroupBy classes
     * @param int $teacher_id
     */
    public static function getClassTeaching($teacher_id)
    {
        $course_routine = StudyCourseRoutine::where('teacher_id', $teacher_id)->groupBy(['study_course_session_id','study_class_id'])->get()->toArray();
        if($course_routine){            
           $data = [];
           foreach($course_routine as $row){
            $class = StudyClass::where('id',$row['study_class_id'])->first(['id', app()->getLocale().' as name' ,'image']);

            $data[] = [
                'class' => [
                        'id'    => $class->id,
                        'name'    => $class->name,
                        'image'    => $class->image? ImageHelper::site(StudyClass::$path['image'], $class->image) : ImageHelper::prefix(),
                    ],
                'subjects' => Staff::getSubjectsTeaching($teacher_id,$row['study_class_id']),
            ] ;
           }
           return [
               'success'    => true,
               'data'       => $data
           ];
        }
    }

    public static function getSubjectsTeaching($teacher_id,$study_class_id)
    {
        $course_routine = StudyCourseRoutine::where('teacher_id', $teacher_id)->where('teacher_id', $teacher_id)->groupBy(['study_course_session_id','study_class_id','study_subject_id'])->get()->toArray();
        if($course_routine){
           $data = [];
           foreach($course_routine as $row){
                $subject = StudySubjects::where('id',$row['study_subject_id'])->first(['id', app()->getLocale().' as name' ,'image']);
                $data[] =   [
                    'id'    => $subject->id,
                    'name'    => $subject->name,
                    'image'    => $subject->image? ImageHelper::site(StudySubjects::$path['image'], $subject->image) : ImageHelper::prefix(),
                ];         
           }
           return $data;
        }
    }
}
