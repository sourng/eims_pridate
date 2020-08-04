<?php

namespace App\Http\Controllers\Student;

use App\Exports\StudentsRegisterTemplateExport;
use App\Models\App;
use App\Models\Users;
use App\Models\Gender;
use App\Models\Marital;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\MotherTong;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStudents;
use App\Imports\StudentsImport;
use App\Models\Students;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class StudentRegisterController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null)
    {

        $data['institute']           = Institute::getData();
        $data['mother_tong']         = MotherTong::getData();
        $data['gender']              = Gender::getData();
        $data['nationality']         = Nationality::getData();
        $data['marital']             = Marital::getData();
        $data['formAction']          = 'add';
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['formName']            = '';
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);


        $data['listData']            = array();

        if ($param1 == null || $param1 == 'add') {
            if (request()->method() == 'POST') {
                return Students::register();
            } else {
                $data = $this->add($data);
            }
        } elseif ($param1 == 'excel') {
            if ($param2 == 'import') {
                if (request()->method() == 'POST') {
                    if (request()->hasFile('file')) {
                        $file = request()->file('file');
                        $fileExtension    = pathinfo(str_replace('/', '.', $file->getClientOriginalName()), PATHINFO_EXTENSION);
                        if (preg_match("/{$fileExtension}/i", '.xls,.xlsx')) {
                            $import = new StudentsImport;
                            $import->import($file);
                            return [
                                'success'   => true,
                                'message'   => 'ប្រតិបត្តិនេះត្រូវបានបញ្ចប់',
                            ];
                        } else {
                            return [
                                'success'   => false,
                                'message'   => 'ឯកសារដែលអ្នកបញ្ចូលមិនត្រឹមត្រូវទេ (.xls,.xlsx)!!',
                            ];
                        }
                    } else {
                        return array(
                            'success'   => false,
                            'type'      => 'import',
                            'message'   => array(
                                'title' => Translator::phrase('error'),
                                'text'  => Translator::phrase('import.unsuccessful') . PHP_EOL
                                    . Translator::phrase('( .excel. ) .empty'),
                                'button'   => array(
                                    'confirm' => Translator::phrase('ok'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        );
                    }
                }
            } elseif ($param2 == 'template') {
                return Excel::download(new StudentsRegisterTemplateExport, 'ទម្រង់បញ្ចូលទិន្នន័យសិស្ស.xlsx');
            }

            $data = $this->excel($data);
        } else {
            abort(404);
        }



        MetaHelper::setConfig(
            [
                'title'       => $data['title'],
                'author'      => config('app.name'),
                'keywords'    => '',
                'description' => '',
                'link'        => $data['metaLink'],
                'image'       => $data['metaImage']
            ]
        );

        $pages = array(
            'host'       => url('/'),
            'path'       => '/' . Users::role(),
            'pathview'   => '/' . $data['formName'] . '/',
            'parameters' => array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction'], 'student-register'),
            'parent'     => 'StudentRegister',
            'modal'      => 'StudentRegister.includes.modal.index',
            'view'       => $data['view'],
        );

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

        $pages['form']['validate'] = [
            'rules'       => $param1 == 'excel' ? ['file' => 'required'] : $rules,
            'attributes'  => $param1 == 'excel' ? ['file' => 'File Excel'] : FormStudents::attributeField(),
            'messages'    => $param1 == 'excel' ? [] : FormStudents::customMessages(),
            'questions'   => $param1 == 'excel' ? [] : FormStudents::questionField(),
        ];


        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);


        return view('StudentRegister.index', $data);
    }



    public function add($data)
    {
        $data['view']  = 'StudentRegister.includes.form.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . $data['formName']);
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }
    public function excel($data)
    {
        $export = new StudentsRegisterTemplateExport;

        $data['response'] = [
            'data' => $export->collection()->toArray(),
            'heading' => $export->headings(),
        ];

        $data['institute'] = Institute::pluck('km')->toArray();
        $data['gender'] = Gender::pluck('km')->toArray();
        $data['marital'] = Marital::pluck('km')->toArray();
        $data['view']  = 'StudentRegister.includes.excel.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . $data['formName']);
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }
}
