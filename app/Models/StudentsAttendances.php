<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Students;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Encryption;
use App\Helpers\ImageHelper;
use App\Helpers\Translator;
use App\Models\AttendancesType;
use Illuminate\Database\Eloquent\Model;

class StudentsAttendances extends Model
{
    public static $path = [
        'image' =>  'attendance',
        'url'   =>  'attendance',
        'view'  =>  'StudentsAttendance',
    ];


    public static function getData($year = null, $month = null, $date = null, $student_study_course_id = null, $paginate = null)
    {

        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . StudentsAttendances::$path['url'] . '/add/'),
            ),
        );

        $response = array(
            'success'   => false,
            'data'      => [],
            'pages'     => $pages,
            'message'   => Translator::phrase('no_data'),
            'gender'    => Students::gender(null),
        );



        $data = array();

        $get = StudentsAttendances::select((new StudentsAttendances())->getTable() . '.*', (new Students())->getTable() . '.gender_id')
            ->join((new StudentsStudyCourse())->getTable(), (new StudentsStudyCourse())->getTable() . '.id', '=', (new StudentsAttendances())->getTable() . '.student_study_course_id')
            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', '=', (new StudyCourseSchedule())->getTable() . '.institute_id')
            ->whereNotIn('study_status_id', [7])
            ->groupBy('student_study_course_id')
            ->orderBy('nid', 'ASC');

        if ($year) {
            $get = $get->where('year', $year);
        }
        if ($month) {
            $get = $get->where('month', $month);
        }
        if ($student_study_course_id) {
            $get = $get->where('student_study_course_id', $student_study_course_id);

        } else {
            if (request('course-sessionId')) {
                $get = $get->where('study_course_session_id', request('course-sessionId'));
            }
            if (request('instituteId')) {
                $get = $get->where((new StudyCourseSchedule())->getTable() . '.institute_id', request('instituteId'));
            }
        }




        $gender = Students::gender($get);
        $node = StudentsStudyCourse::whereNotIn('study_status_id', [7]);

        if ($student_study_course_id == null) {
            if (request('course-sessionId')) {
                $node = StudentsStudyCourse::where('study_course_session_id',request('course-sessionId'))->whereNotIn('study_status_id', [7]);
            }
        }




        if ($student_study_course_id == null && count($get->get()->toArray()) < $node->count()) {
            $get      = false;
        } else {
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
        }

        //StudentsAttendances::updateHolidayToTable($year, $month);
        $recall = false;

        if ($get) {
            foreach ($get as $key => $row) {

                $node = StudentsStudyCourse::getData($row['student_study_course_id'])['data'][0];

                $schedule = StudyCourseSession::where('id', $node['study_course_session']['id'])
                    ->first()->toArray();

                $attenType = StudentsAttendances::getAtten(($year ? $year : $row['year']), ($month ? $month : $row['month']), $row['student_study_course_id'], $date);
                $generateId = array(
                    'attendance_id'           => $row['id'],
                    'student_study_course_id' => $row['student_study_course_id'],
                );

                $generateId = Encryption::encode($generateId);
                $data[] = array(
                    'id'           => $row['id'],
                    'node'         => $node,
                    'year'         => $row['year'],
                    'month'        => $row['month'],
                    'date'         => $attenType['date'],
                    'total_p'      => $attenType['total_p'],
                    'total_a'      => $attenType['total_a'],
                    'total_all'    => $attenType['total_all'],
                    'schedule'     => $schedule,
                    'action'                   => [
                        'edit' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsAttendances::$path['url'] . '/edit/' . $generateId), //?id
                    ],
                );
            }


            // for($i = count($data);$i < 50;$i++){
            //     $data[$i] = $data[0];
            // }
            $response = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages,
                'gender'    => $gender,
            );
        } else {
            $schedule = StudyCourseSession::getData(request('course-sessionId'), true)['data'];
            if ($student_study_course_id) {
                $studyCourse = StudentsStudyCourse::find($student_study_course_id);
                $schedule = StudyCourseSession::where('id', $studyCourse->study_course_session_id)
                    ->get()->toArray();
            }

            if ($schedule) {
                $study_start = new Carbon(DateHelper::convert($schedule[0]['study_start']));
                $study_end   = new Carbon(DateHelper::convert($schedule[0]['study_end']));
                $modify =  request('year') . '-' . request('month') . '-' . date('d');

                if ($study_start->diff($modify)->invert == 0) {
                    $modify = new Carbon($modify);

                    if ($modify->diff(DateHelper::convert($study_end))->invert == 0) {

                        if ($student_study_course_id) {
                            $node = StudentsStudyCourse::where('id', $student_study_course_id)->get()->toArray();
                            if ($node) {
                                if (array_key_exists($date ? $date : date('d'), Holidays::getHoliday($year, $month, $node[0]['study_course_session_id'])['data'])) {
                                    $add = StudentsAttendances::addToTable($year, $month, $date ? $date : date('d'), $student_study_course_id, 6);
                                } else {
                                    $add = StudentsAttendances::addToTable($year, $month, $date ? $date : date('d'), $student_study_course_id, 2);
                                }
                                if ($add['success']) {
                                    $recall = true;
                                }
                            }
                        } else {

                            if ($node->get()->toArray()) {
                                foreach ($node->get()->toArray() as $n) {
                                    if (array_key_exists($date ? $date : date('d'), Holidays::getHoliday($year, $month, $n['study_course_session_id'])['data'])) {

                                        $add = StudentsAttendances::addToTable($year, $month, $date ? $date : date('d'), $n['id'], 6);
                                    } else {
                                        $add = StudentsAttendances::addToTable($year, $month, $date ? $date : date('d'), $n['id'], 2);
                                    }

                                    if ($add['success']) {
                                        $recall = true;
                                    }
                                }
                            } else {
                                $routine = StudyCourseRoutine::where('study_course_session_id', $schedule[0]['id'])->get()->toArray();
                                if ($routine) {
                                    $response['message'] = Translator::phrase('no_data') . PHP_EOL .
                                        PHP_EOL . Translator::phrase('no_student_study_course');
                                } else {
                                    $study_session = StudySession::getData(request('sessionId'))['data'][0];
                                    $response['message'] = Translator::phrase('no_data') . PHP_EOL .
                                        PHP_EOL . Translator::phrase('no_study_course_schedule.for.' . $study_session['name']);
                                }
                            }
                        }
                    } else {
                        $study_start = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($study_start->day . '-' . $study_start->monthName . '-' . $study_start->year);
                        $study_end = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($study_end->day . '-' . $study_end->monthName . '-' . $study_end->year);

                        $response['message'] = Translator::phrase('no_data.for.month.' . DateHelper::getDate($modify)->monthName) . ' ' . request('year') . PHP_EOL .
                            Translator::phrase('study_start') . ' ' . $study_start . ' - ' . $study_end;
                    }
                } else {
                    $study_start = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($study_start->day . '-' . $study_start->monthName . '-' . $study_start->year);
                    $study_end = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($study_end->day . '-' . $study_end->monthName . '-' . $study_end->year);

                    $response['message'] = Translator::phrase('no_data.for.month.' . DateHelper::getDate($modify)->monthName) . ' ' . request('year') . PHP_EOL .
                        Translator::phrase('study_start') . ' ' . $study_start . ' ' . Translator::phrase('to') . ' ' . $study_end;
                }
            } else {
                $response['message'] = Translator::phrase('no_data') . PHP_EOL .
                    Translator::phrase('study_course_session') . PHP_EOL . Translator::phrase('no_study_course_schedule');
            }
        }
        if ($recall) {
            return StudentsAttendances::getData($year, $month, $date, $student_study_course_id, $paginate);
        }
        return $response;
    }

    public static function updateHolidayToTable($year, $month)
    {
        if ($year && $month) {
            $holiday = Holidays::getHoliday($year, $month)['data'];
            foreach ($holiday as $row) {
                StudentsAttendances::where('date', $row['date'])->update([
                    'attendance_type_id' => 6
                ]);
            }
        }
    }






    public static function getAtten($year, $month, $student_study_course_id, $date = null)
    {
        $data = [];
        $get = StudentsAttendances::orderBy('date', 'ASC');
        if ($student_study_course_id && $year && $month) {
            $get = $get->where('student_study_course_id', $student_study_course_id)->where('year', $year)->where('month', $month);

            if ($date != null) {
                $get = $get->where('date', $date);
            }
            $get = $get->get()->toArray();
            $data = array();
            $date = array();

            $adsentLetter = 0;
            $adsent = 0;

            foreach ($get as $key => $row) {
                $atten = AttendancesType::getData($row['attendance_type_id'])['data'][0];
                $date[$row['date']] = array(
                    'date' => $row['date'],
                    'attendance'  => $atten,
                );

                if ($row['attendance_type_id'] == 3) {
                    $adsentLetter += $atten['credit_absent'];
                } else {
                    $adsent += $atten['credit_absent'];
                }

                if (count($get) === ($key + 1)) {
                    $total_p = StudentsAttendances::countAtten($year, $month, $student_study_course_id, [3]);
                    $total_a = StudentsAttendances::countAtten($year, $month, $student_study_course_id, [2, 4, 5]);
                    $data =  array(
                        'student_study_course_id' => $student_study_course_id,
                        'year' => $year,
                        'month' => $month,
                        'date' => $date,
                        'total_p' => $total_p,
                        'total_a' => $total_a,
                        'total_all' => $total_p + $total_a,
                    );
                }
            }
        }
        return $data;
    }

    public static function countAtten($year, $month, $student_study_course_id, $attendance_type_id)
    {
        if ($student_study_course_id && $year && $month) {
            $get = StudentsAttendances::where('student_study_course_id', $student_study_course_id)->where('year', $year)->where('month', $month)->whereIn('attendance_type_id', $attendance_type_id)->orderBy('date', 'ASC')->get()->toArray();
            $count = 0;
            if ($get) {

                foreach ($get as $row) {
                    $atten = AttendancesType::getData($row['attendance_type_id'])['data'][0];
                    $count += $atten['credit_absent'];
                }
            }

            return $count;
        }
    }
    public static function existsToTable($year, $month, $date, $student_study_course_id)
    {
        return StudentsAttendances::where('year', $year)
            ->where('month', $month)
            ->where('date', $date)
            ->where('student_study_course_id', $student_study_course_id)
            ->first();
    }

    public static function getData1($student_study_course_id)
    {
        if ($student_study_course_id) {
            $student_study_course = StudentsStudyCourse::where('id', $student_study_course_id)->first()->toArray();
            $student_request = StudentsRequest::where('id', $student_study_course['student_request_id'])->first()->toArray();

            $student    = Students::where('id', $student_request['student_id'])->first()->toArray();
            $atten = StudentsAttendances::getAtten(request('year'), request('month'), $student_study_course_id, request('date'));
            $photo = $student_study_course['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $student_study_course['photo'])) :  ImageHelper::site(Students::$path['image'], $student['photo']);
            $data[] = [
                'id'                      => $student_study_course['id'],
                'fullname'                => (array_key_exists('first_name_' . app()->getLocale(), $student) ? $student['first_name_' . app()->getLocale()] : $student['first_name_en']) . ' ' . (array_key_exists('last_name_' . app()->getLocale(), $student) ? $student['last_name_' . app()->getLocale()] : $student['last_name_en']),
                'photo'                   => $photo,
                'study_course_session'    => StudyCourseSession::getData($student_study_course['study_course_session_id'])['data'][0]['name'],
                'date'                    => $atten['date'],
                'total_p'                 => $atten['total_p'],
                'total_a'                 => $atten['total_a'],
                'total_all'               => $atten['total_p'] + $atten['total_a'],
            ];

            return $data;
        }
    }

    public static function addToTable($year, $month, $date, $student_study_course_id, $attendance_type_id)
    {

        $response       = array(
            'success'   => false,
            'errors'    => []
        );
        $year = $year ? $year : Years::now();
        $month = $month ? $month : Months::now();
        $date = $date ? $date : date('d');

        if (StudentsAttendances::existsToTable($year, $month, $date, $student_study_course_id)) {
            $response       = array(
                'success'   => false,
                'message'   => Translator::phrase('already_exists'),
                'errors'    => []
            );
        } else {
            $add = StudentsAttendances::insertGetId([
                'year'                      => $year,
                'month'                     => $month,
                'date'                      => $date,
                'student_study_course_id'   => $student_study_course_id,
                'attendance_type_id'        => $attendance_type_id
            ]);

            if ($add) {

                $date = new Carbon($year . '-' . $month . '-' . $date);
                $absent = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($date->day . '-' . $date->monthName . '-' . $date->year);
                $response = array(
                    'success'   => true,
                    'data'      => StudentsAttendances::getData1($student_study_course_id),
                    'sound'     => asset('assets/sounds/' . app()->getLocale() . '/thank_you.mp3'),
                    'message'   => $absent . PHP_EOL . ' ' . Translator::attendance('present'),
                    'type'      => 'add',
                );
            }
        }
        return $response;
    }
    public static function updateToTable($year, $month, $date, $student_study_course_id, $attendance_type_id)
    {
        $response       = array(
            'success'   => false,
            'errors'    => []
        );
        if ($year && $month && $date && $student_study_course_id && $attendance_type_id) {
            if (StudentsAttendances::existsToTable($year, $month, $date, $student_study_course_id)) {
                try {

                    $update = StudentsAttendances::where('year', $year)
                        ->where('month', $month)
                        ->where('date', $date)
                        ->where('student_study_course_id', $student_study_course_id)
                        ->update([
                            'attendance_type_id' => $attendance_type_id
                        ]);
                    if ($update) {
                        $date = new Carbon($year . '-' . $month . '-' . $date);
                        $absent = (app()->getLocale() == 'km' ? ' ថ្ងៃទី ' : '') . ($date->day . '-' . $date->monthName . '-' . $date->year);
                        $response       = array(
                            'success'   => true,
                            'data'      => StudentsAttendances::getData1($student_study_course_id),
                            'type'      => 'update',
                            'sound'     => asset('assets/sounds/' . app()->getLocale() . '/thank_you.mp3'),
                            'message'   => $absent . PHP_EOL . ' ' . AttendancesType::getData($attendance_type_id)['data'][0]['name'],
                        );
                    }
                } catch (\Exception $e) {
                    $response       = Exception::exception($e);
                }
            }
        }
        return $response;
    }
}
