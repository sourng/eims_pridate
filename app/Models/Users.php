<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use DomainException;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormStaff;
use App\Http\Requests\FormUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;

class Users extends Model
{
    public static $path = [
        'image'  => 'profile',
        'url'    => 'user',
        'view'   => 'Users'
    ];
    public static function role($get = null)
    {
        if (Auth::user()) {
            $roles = Roles::where('id', Auth::user()->role_id)->get()->toArray();
            if ($get) {
                return $roles[0][$get];
            }
            return $roles[0]['name'];
        }
        return null;
    }
    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {

        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Users::$path['url'] . '/add/'),
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


        if ($id) {
            $get = Users::orderBy('id', $orderBy);
            $get = $get->whereIn('id', $id);
        } else {
            $get = Users::orderBy('id', $orderBy)->where('id', '<>', Auth::user()->id);

            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'));
            }

            if ($search) {
                $get = $get->where('name', 'LIKE', '%' . $search . '%');
            }
            if (request('selected')) {
                $get = $get->whereNotIn('id', request('selected'));
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
                $socail_auth = SocialAuth::getData(null, $row['id']);
                $avatar = new Avatar(config('laravolt.avatar'));

                $profile = $avatar->create($row['name'])
                    ->setFont(public_path('assets/fonts/NiDAKhmerEmpire.ttf'))
                    ->toBase64()->getEncoded();
                if ($row['profile']) {
                    $profile = ImageHelper::site('profile', $row['profile']);
                } elseif ($socail_auth) {
                    $profile = $socail_auth['_avatar'];
                } elseif ($row['role_id'] == 6) {
                    $student = Students::where('id', $row['node_id'])->first();
                    if ($student) {
                        $profile = ImageHelper::site(Students::$path['image'], $student['photo']);
                    }
                } else {
                    $staff = Staff::where('id', $row['node_id'])->first();
                    if ($staff) {
                        $profile = ImageHelper::site(Staff::$path['image'], $staff['photo']);
                    }
                }

                $data[$key]         = array(
                    'id'             => $row['id'],
                    'name'           => $row['name'],
                    'email'          => $row['email'],
                    'phone'          => $row['phone'],
                    'address'        => $row['address'],
                    'location'       => $row['location'],
                    'profile'        => $profile,
                    'role'           => $row['role_id'] == null ? null : Roles::getData($row['role_id'])['data'][0],
                    'institute'      => $row['institute_id'] == null ? null : Institute::getData($row['institute_id'])['data'][0],
                    'status'         => User::find($row['id'])->isOnline(),
                    'account_status'  => [
                        'id'    => 1,
                        'name'  => Translator::phrase('new_account'),
                        'color' => 'bg-yellow text-black'
                    ],
                    'action'         => [
                        'edit'   => url(Users::role() . '/' . Users::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Users::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Users::$path['url'] . '/delete/' . $row['id']),
                    ]
                );


                if ($row['created_at']) {
                    $created = Carbon::createFromDate($row['created_at']);
                    $now = Carbon::now();
                    $diff = $created->diffInDays($now);

                    if ($diff > 90) {
                        $data[$key]['account_status']  = [
                            'id'   => 2,
                            'name' => Translator::phrase('old_account'),
                            'color' => 'bg-secondary'
                        ];
                    };
                }


                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['profile'],
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

        $model = Users::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();

                $socail_auth = SocialAuth::getData(null, $row['id']);

                $avatar = new Avatar(config('laravolt.avatar'));
                $profile = $avatar->create($row['name'])
                    ->setFont(public_path('assets/fonts/NiDAKhmerEmpire.ttf'))
                    ->toBase64()->getEncoded();
                if ($row['profile']) {
                    $profile = ImageHelper::site('profile', $row['profile']);
                } elseif ($socail_auth) {
                    $profile = $socail_auth['_avatar'];
                }
                return [
                    'id'      => $row['id'],
                    'name'     => $row['name'],
                    'email'      => $row['email'],
                    'phone'      => $row['phone'],
                    'role'      => Roles::getData($row['role_id'])['data'][0],
                    'profile'     => $profile,
                    'action'                   => [
                        'edit'                 => url(Users::role() . '/' . Users::$path['url'] . '/edit/' . $row['id']), //?id
                        'view'                 => url(Users::role() . '/' . Users::$path['url'] . '/view/' . $row['id']), //?id
                        'delete'               => url(Users::role() . '/' . Users::$path['url'] . '/delete/' . $row['id']), //?id
                    ],

                ];
            })
            ->filter(function ($query) {
                $query->whereNotIn('id', [ Auth::user()->id]);
                if (request('instituteId')) {
                    $query = $query->where('institute_id', request('instituteId'));
                }
                foreach (request('columns') as $i => $value) {
                    if ($value['searchable']) {
                        if ($value['data'] == 'name') {
                            $query->where('name', 'LIKE', '%' . request('search.value') . '%');
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

    public static function addToTable()
    {

        $response           = array();

        if (request('role') != 1 && request('role') != 9) {
            if (!request('reference')) {
                $empty = (request('role') == 6 || request('role') == 7) ? Translator::phrase('( .student. ) .required') : Translator::phrase('( .staff. ) .required');
                return array(
                    'success'   => false,
                    'type'      => 'add',
                    'data'      => [],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL . $empty,
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        }
        $validator          = Validator::make(request()->all(), FormUsers::rulesField(), FormUsers::customMessages(), FormUsers::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            $existsEmail = Users::existsFromTable(request('email'));
            if ($existsEmail) {
                $response = array(
                    'success'   => false,
                    'type'      => 'add',
                    'data'      => [],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('already_exists. ( .email. )'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            } else {
                try {
                    $add = Users::insertGetId([
                        'institute_id' => trim(request('institute')),
                        'name'        => trim(request('name')),
                        'phone'       => trim(request('phone')),
                        'email'       => trim(request('email')),
                        'password'    => Hash::make(trim(request('password'))),
                        'address'     => trim(request('address')),
                        'location'    => trim(request('location')),
                        'role_id'     => trim(request('role')),
                        'node_id'     => trim(request('reference')),
                        'profile'     => null,
                    ]);

                    if ($add) {



                        if (request()->hasFile('profile')) {
                            $image      = request()->file('profile');
                            Users::updateImageToTable($add, ImageHelper::uploadImage($image, Users::$path['image']));
                        }

                        $response       = array(
                            'success'   => true,
                            'type'      => 'add',
                            'data'      => Users::getData($add),
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
        }
        return $response;
    }

    public static function updateToTable($id)
    {

        $response           = array();

        $rule = [];
        foreach (FormUsers::rulesField() as $key => $value) {
            if ($key != 'password')
                $rule[$key] = $value;
        }


        $validator          = Validator::make(request()->all(), $rule, FormUsers::customMessages(), FormUsers::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $value = [
                    'institute_id' => trim(request('institute')),
                    'name'        => trim(request('name')),
                    'phone'       => trim(request('phone')),
                    'email'       => trim(request('email')),
                    'address'     => trim(request('address')),
                    'location'    => trim(request('location')),
                    'role_id'     => trim(request('role')),
                    'node_id'     => trim(request('reference')),
                ];
                if (request('password')) {
                    $value['password'] += Hash::make(trim(request('password')));
                }

                $update = Users::where('id', $id)->update($value);
                if ($update) {
                    if (request()->hasFile('profile')) {
                        $image      = request()->file('profile');
                        Users::updateImageToTable($id, ImageHelper::uploadImage($image, Users::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => Users::getData($id),
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
                $update =  Users::where('id', $id)->update([
                    'profile'    => $image,
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
            if (Users::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Users::whereIn('id', $id)->delete();
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
    public static function getUsers($id = null)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('no_data')
        );
        if ($id) {
            $get = Users::where('id', $id)->get()->toArray();
        } else {
            $get = Users::get()->toArray();
        }

        if ($get) {
            $data = array();
            foreach ($get as $row) {
                $socail_auth = SocialAuth::getData(null, $row['id']);
                $profile = null;
                if ($row['profile']) {
                    $profile = ImageHelper::site('profile', $row['profile']);
                } elseif ($socail_auth) {
                    $profile = $socail_auth['_avatar'];
                }
                $data[] = array(
                    'id'       => $row['id'],
                    'name'     => $row['name'],
                    'phone'    => $row['phone'],
                    'email'    => $row['email'],
                    'address'  => $row['address'],
                    'location' => $row['location'],
                    'profile'  => $profile,
                );
            }

            $response = array(
                'success'   => true,
                'data'      => $data
            );
        }

        return $response;
    }
    public static function existsFromTable($email, $node_id = null)
    {
        $get  = Users::where('email', $email);
        if ($node_id) {
            $get = $get->where('node_id', $node_id);
        }
        return $get->first();
    }
    public static function register()
    {
        $validator          = Validator::make(request()->all(), FormUsers::rulesField2(), FormStaff::customMessages(), FormStaff::attributeField());
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
                'blood_group_id'   => request('blood_group'),
                //'photo'            => (request('gender') == '1') ? 'male.jpg' : 'female.jpg',
            ];
            $add = Students::insertGetId($values);
            if ($add) {
                StudentsGuardians::insert(['student_id' => $add]);
                Users::where('id', Auth::user()->id)->update([
                    'node_id' => $add,
                    'institute_id' => request('institute'),
                    'role_id' => Students::$path['roleId'],
                ]);
                //ImageHelper::uploadImage(false, Students::$path['image'], (request('gender') == '1') ? 'male' : 'female', public_path('/assets/img/user/' . ((request('gender') == '1') ? 'male.jpg' : 'female.jpg')), true);
            }
            // if (request('teacher_or_student') == 6) {
            // } else {
            //     $add = Students::insertGetId($values);
            //     if ($add) {
            //         StaffInstitutes::insert([
            //             'staff_id' => $add,
            //             'institute_id' => request('institute'),
            //             'designation_id'  => 2
            //         ]);

            //         StaffGuardians::insert([
            //             'staff_id' => $add,
            //         ]);

            //         StaffQualifications::insert([
            //             'staff_id' => $add,
            //         ]);

            //         StaffExperience::insert([
            //             'staff_id' => $add,
            //         ]);

            //         Users::where('id', Auth::user()->id)->update([
            //             'node_id' => $add,
            //             'role_id' => 8,
            //         ]);
            //         //ImageHelper::uploadImage(false, Staff::$path['image'], (request('gender') == '1') ? 'male' : 'female', public_path('/assets/img/user/' . ((request('gender') == '1') ? 'male.jpg' : 'female.jpg')), true);
            //     }
            // }

            if ($add) {
                $response       = array(
                    'success'   => true,
                    'type'      => 'add',
                    'reload'    => true,
                    'message'   => array(
                        'title' => Translator::phrase('success'),
                        'text'  => Translator::phrase('register.successfully') . PHP_EOL
                            . Translator::phrase('( .reload_page. )'),
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
}
