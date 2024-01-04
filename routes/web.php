<?php

use App\Http\Controllers\ActivityCategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityInviteController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BlogCategotyController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryTopicController;
use App\Http\Controllers\ClaimUserController;
use App\Http\Controllers\CourseClassAddController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseGroupController;
use App\Http\Controllers\CourseLessonController;
use App\Http\Controllers\CourseSubController;
use App\Http\Controllers\CourseSubjectController;
use App\Http\Controllers\CourseSupplymentaryController;
use App\Http\Controllers\CourseTeacherController;

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartReportController;
use App\Http\Controllers\DepartUsersController;
use App\Http\Controllers\EditManageUserController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ExtenderController;
use App\Http\Controllers\GenaralController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ManageExamController;
use App\Http\Controllers\ManageQuestionController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PDFcreateController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProviDepartUserController;
use App\Http\Controllers\ReportAllController;
use App\Http\Controllers\ReportJsonController;
use App\Http\Controllers\RolemanageController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolDepartController;
use App\Http\Controllers\SchoolDepartUserController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\SurResponseController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\WedCategoryController;
use App\Ldap\MyLdapModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use LdapRecord\Laravel\Facades\Ldap;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/upload-image', [PDFcreateController::class, 'upload_image'])->name('upload_image');
// Clear application cache:
Route::get('/generatePdfT0101', [PDFcreateController::class, 'generatePdfT0101'])->name('generatePdfT0101');
Route::get('/generatePdf', [PDFcreateController::class, 'generatePdf'])->name('generatePdf');
Route::get('/ReportExp', [ExcelController::class, 'ReportExp'])->name('ReportExp');
Route::get('/exportUsersall', [ExcelController::class, 'exportUsersall'])->name('exportUsersall');
Route::get('/UsersExportDepart/{department_id}', [ExcelController::class, 'exportUsers'])->name('UsersExport');
Route::get('/exportUsersPro/{department_id}/{provicValue}', [ExcelController::class, 'exportUsersPro'])->name('exportUsersPro');

Route::get('/exportSubject', [ExcelController::class, 'exportSubject'])->name('exportSubject');

Route::get('/QuestionExport/{subject_id}', [ExcelController::class, 'questionExport'])->name('questionExport');
Route::post('/importall', [ExcelController::class, 'importall'])->name('importall');
Route::post('/storeregis/{uid?}', [SubmitController::class, 'store'])->name('storeregisRequest');

Route::group(['middleware' => ['web', 'App\Http\Middleware\ClearOptimizeCacheMiddleware']], function () {

    // เส้นทางของคุณที่ต้องการให้ Middleware นี้ทำงาน

    Route::group(['middleware' => 'AlreadyLogIn'], function () {
        Route::get('/aced', [DepartmentController::class, 'aced'])->name('aced');
        Route::get('/login', [CustomAuthController::class, 'login'])->name('homelogin');
        Route::get('/regis', [CustomAuthController::class, 'regis'])->name('homeregis');
        // เส้นทางอื่นๆที่ต้องใช้ middleware เช่นเดียวกัน
    });

    Route::post('/register-user', [CustomAuthController::class, 'registerUser'])->name('register-user');
    Route::post('/login-user', [CustomAuthController::class, 'loginUser'])->name('login-user');

    Route::get('/regisadmin', [CustomAuthController::class, 'homeregis'])->name('homeRegis');
});

// middleware Isloggedin ต้องสมัครก่อนถึงเข้าได้

Route::group(['middleware' => 'IsLoggedIn'], function () {
    Route::middleware(['CheckUserLogin'])->group(function () {
        
        // ...
        Route::get('/edit-profile', [EditProfileController::class, 'edit'])->name('edit-profile');
        Route::put('/update-profile', [EditProfileController::class, 'update'])->name('update-profile');

        // ...
        Route::middleware(['checkUserRole'])->group(function () {
            Route::get('{from}/departmentform', [DepartmentController::class, 'departmentcreate'])->name('departmentcreate');
            Route::post('/departmentform_add', [DepartmentController::class, 'store'])->name('departmentstore');

            Route::middleware(['checkDepartmentLogo'])->group(function () {
                Route::get('{from}/departmentform_edit/{department_id}', [DepartmentController::class, 'departmentedit'])->name('departmentedit');
                Route::put('{from}/departmentform_update/{department_id}', [DepartmentController::class, 'update'])->name('departmentupdate');
            });
        });
        Route::get('/', [NavController::class, 'home'])->name('adminhome');
       
        Route::get('/department', [NavController::class, 'homedepartment'])->name('adminhomedepartment');
        Route::prefix('admin')->group(function () {
            Route::get('/changeStatusDepart', [DepartmentController::class, 'changeStatus'])->name('changeStatusDepart');
            Route::get('/general', [NavController::class, 'dataci'])->name('dataci');
            Route::get('/logo', [GenaralController::class, 'logo'])->name('logo');
            Route::put('/edit/{id}', [GenaralController::class, 'update'])->name('updategen');
            Route::post('/create', [GenaralController::class, 'create'])->name('creategen');
            Route::get('/highlight', [HighlightController::class, 'hightpage'])->name('hightpage');

            Route::get('/wms', [DepartmentController::class, 'departmentwmspage'])->name('departmentwmspage');
            Route::get('/lms', [DepartmentController::class, 'departmentLearnpage'])->name('departmentLearnpage');
            Route::get('/bss', [DepartmentController::class, 'bookif'])->name('bookif');

            Route::middleware(['checkDepartmentLogo'])->group(function () {
                Route::get('{department_id}/homepage', [DepartmentController::class, 'homede'])->name('homede');
                Route::prefix('wms')->group(function () {
                    Route::get('{department_id}/logodepartment', [GenaralController::class, 'logoDP'])->name('logoDP');
                    Route::put('{department_id}/editdepartment/{id}', [GenaralController::class, 'updateDP'])->name('updategenDP');
                    Route::get('{department_id}/home', [NavController::class, 'manage'])->name('manage');

                    Route::get('{department_id}/hight-Dep', [HighlightController::class, 'hightDep'])->name('hightDep');
                    Route::post('{department_id}/storeDep', [HighlightController::class, 'storeDep'])->name('storeDep');
                    Route::put('{department_id}/updateLinkDep/{highlight_id}', [HighlightController::class, 'updateLinkDep'])->name('updateLinkDep');



                    Route::get('{department_id}/Webpage', [WedCategoryController::class, 'Webpage'])->name('Webpage');
                    Route::get('{department_id}/webcategory', [WedCategoryController::class, 'evenpage'])->name('evenpage');
                    Route::get('{department_id}/add_webevencategoryform', [WedCategoryController::class, 'create'])->name('evencreate');
                    Route::post('{department_id}/store_webevencategoryform', [WedCategoryController::class, 'store'])->name('evenstore');
                    Route::get('{department_id}/edit_webcategoryform/{category_id}', [WedCategoryController::class, 'edit'])->name('evenedit');


                    Route::put('{department_id}/update_webcategoryform/{category_id}', [WedCategoryController::class, 'update'])->name('updateeven');


                    Route::get('{department_id}/acteven', [WedCategoryController::class, 'acteven'])->name('acteven');
                    Route::get('{department_id}/add_webactcategoryform', [WedCategoryController::class, 'createact'])->name('createact');
                    Route::post('{department_id}/store_webactcategoryform', [WedCategoryController::class, 'storeact'])->name('storeact');
                    Route::get('{department_id}/edit_webactcategoryform/{category_id}', [WedCategoryController::class, 'editact'])->name('actedit');
                    Route::put('{department_id}/update_webactcategoryform/{category_id}', [WedCategoryController::class, 'updateact'])->name('updateact');


                    Route::get('{department_id}/{category_id}/web', [WebController::class, 'catpage'])->name('catpage');
                    Route::get('{department_id}/{category_id}/add_webform', [WebController::class, 'create'])->name('createcat');
                    Route::post('{department_id}/{category_id}/store_webform', [WebController::class, 'store'])->name('catstore');
                    Route::get('{department_id}/edit_webform/{web_id}', [WebController::class, 'edit'])->name('editcat');
                    Route::put('{department_id}/update_webform/{web_id}', [WebController::class, 'update'])->name('updatecat');




                    Route::get('{department_id}/links', [LinkController::class, 'linkpage'])->name('linkpage');
                    Route::get('{department_id}/linksform', [LinkController::class, 'create'])->name('linkcreate');
                    Route::post('{department_id}/add_linksform', [LinkController::class, 'store'])->name('storelink');
                    Route::get('{department_id}/edit_linksform/{links_id}', [LinkController::class, 'edit'])->name('editlink');
                    Route::put('{department_id}/update_linksform/{links_id}', [LinkController::class, 'update'])->name('updatelink');


                    Route::get('{department_id}/survey', [SurveyController::class, 'surveypage'])->name('surveypage');
                    Route::get('{department_id}/surveyform', [SurveyController::class, 'create'])->name('createsurvey');
                    Route::post('{department_id}/add_surveyform', [SurveyController::class, 'store'])->name('storesurvey');
                    Route::get('{department_id}/edit_surveyform/{survey_id}', [SurveyController::class, 'edit'])->name('editsur');
                    Route::put('{department_id}/update_surveyform/{survey_id}', [SurveyController::class, 'update'])->name('updatesur');

                    Route::get('{department_id}/{survey_id}/surveyquestions', [SurveyQuestionController::class, 'questionpage'])->name('questionpage');
                    Route::get('{department_id}/{survey_id}/surveyquestionform', [SurveyQuestionController::class, 'create'])->name('questionpagecreate');
                    Route::post('{department_id}/{survey_id}/add_surveyquestionform', [SurveyQuestionController::class, 'store'])->name('storequ');
                    Route::get('{department_id}/edit_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'edit'])->name('editque');
                    Route::put('{department_id}/update_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'update'])->name('updateque');
                    Route::get('{department_id}/{survey_id}/surveyreports', [SurveyQuestionController::class, 'reportpage'])->name('wmspage');


                    Route::get('/{survey_id}/responsess', [SurResponseController::class, 'resPonse'])->name('responsess');



                    Route::get('{department_id}/manual', [ManualController::class, 'index'])->name('manualpage');
                    Route::get('{department_id}/manualform', [ManualController::class, 'create'])->name('createmanual');
                    Route::post('{department_id}/add_manualform', [ManualController::class, 'store'])->name('storemanual');
                    Route::get('{department_id}/edit_manualform/{manual_id}', [ManualController::class, 'edit'])->name('editmanual');
                    Route::put('{department_id}/update_manualform/{manual_id}', [ManualController::class, 'update'])->name('updatemanual');
                });

                Route::prefix('dls')->group(function () {
                    Route::get('/{department_id}/home', [NavController::class, 'dls'])->name('dls');

                    Route::get('{department_id}/bookcategory', [BookCategoryController::class, 'bookpage'])->name('bookpage');
                    Route::get('{department_id}/bookcategoryform', [BookCategoryController::class, 'create'])->name('createbook');
                    Route::post('{department_id}/add_bookcategoryform', [BookCategoryController::class, 'store'])->name('storebook');
                    Route::get('{department_id}/edit_bookcategoryform/{category_id}', [BookCategoryController::class, 'edit'])->name('editbook');
                    Route::put('{department_id}/update_bookcategoryform/{category_id}', [BookCategoryController::class, 'update'])->name('bookupdate');

                    Route::get('{department_id}/{category_id}/book', [BookController::class, 'bookcatpage'])->name('bookcatpage');
                    Route::get('{department_id}/{category_id}/bookform', [BookController::class, 'create'])->name('catcreatebook');
                    Route::post('{department_id}/{category_id}/add_bookform', [BookController::class, 'store'])->name('bookcatstore');
                    Route::get('{department_id}/edit_bookform/{book_id}', [BookController::class, 'edit'])->name('editcatbook');
                    Route::put('{department_id}/update_bookform/{book_id}', [BookController::class, 'update'])->name('updatecatbook');
                });
                Route::prefix('cop')->group(function () {
                    Route::get('{department_id}/blogcategory', [BlogCategotyController::class, 'blogpage'])->name('blogpage');
                    Route::get('{department_id}/blogcategoryform', [BlogCategotyController::class, 'create'])->name('createblogcat');
                    Route::post('{department_id}/add_blogcategoryform', [BlogCategotyController::class, 'store'])->name('storeblogcat');
                    Route::get('{department_id}/edit_blogcategoryform/{category_id}', [BlogCategotyController::class, 'edit'])->name('editblogcat');
                    Route::put('{department_id}/update_blogcategoryform/{category_id}', [BlogCategotyController::class, 'update'])->name('updateblogcat');

                    Route::get('{department_id}/{category_id}/blog', [BlogController::class, 'index'])->name('blog');
                    Route::get('{department_id}/{category_id}/blogform', [BlogController::class, 'create'])->name('createblog');
                    Route::post('{department_id}/{category_id}/add_blogform', [BlogController::class, 'store'])->name('storeblog');
                    Route::get('{department_id}/edit_blogform/{blog_id}', [BlogController::class, 'edit'])->name('editblog');
                    Route::put('{department_id}/update_blogform/{blog_id}', [BlogController::class, 'update'])->name('updateblog');
                });

                Route::prefix('cop')->group(function () {
                    Route::get('{department_id}/home', [NavController::class, 'cop'])->name('cop');
                    Route::get('{department_id}/activitycategory', [ActivityCategoryController::class, 'activi'])->name('activi');
                    Route::get('{department_id}/meetingcategory', [ActivityCategoryController::class, 'meeti'])->name('meeti');

                    Route::get('{department_id}/activiFrom/{category_id}', [ActivityCategoryController::class, 'activiFrom'])->name('activiFrom');

                    Route::prefix('acttivity')->group(function () {

                        Route::get('{department_id}/activiList/{category_id}', [ActivityController::class, 'activiList'])->name('activiList');

                        Route::get('{department_id}/activiListForm1/{category_id}', [ActivityController::class, 'activiListForm1'])->name('activiListForm1');
                        Route::post('{department_id}/act1store/{category_id}', [ActivityController::class, 'act1store'])->name('act1stores');
                        Route::get('{department_id}/activiListform1_edit/{activity_id}', [ActivityController::class, 'formacttivityEdit1'])->name('activiListform1_edit');
                        Route::put('{department_id}/act1Update/{activity_id}', [ActivityController::class, 'act1update'])->name('act1Update');


                        Route::get('{department_id}/activiListForm2/{category_id}', [ActivityController::class, 'activiListForm2'])->name('activiListForm2');
                        Route::post('{department_id}/act2store/{category_id}', [ActivityController::class, 'act2store'])->name('act2store');
                        Route::get('{department_id}/activiListform_edit2/{activity_id}', [ActivityController::class, 'formacttivityEdit2'])->name('activiListform2_edit');
                        Route::put('{department_id}/act2Update/{activity_id}', [ActivityController::class, 'act2update'])->name('act2Update');
                    });
                });


                Route::prefix('lms')->group(function () {
                    Route::get('{department_id}/home', [NavController::class, 'learn'])->name('learn');

                    Route::get('{department_id}/group', [CourseGroupController::class, 'courgroup'])->name('courgroup');
                    Route::get('{department_id}/groupform', [CourseGroupController::class, 'create'])->name('createcour');
                    Route::post('{department_id}/add_groupform', [CourseGroupController::class, 'store'])->name('storecour');
                    Route::get('{department_id}/edit_groupform/{group_id}', [CourseGroupController::class, 'edit'])->name('editcour');
                    Route::put('{department_id}/update_groupform/{group_id}', [CourseGroupController::class, 'update'])->name('updatecour');



                    Route::get('{department_id}/{group_id}/course', [CourseController::class, 'courpag'])->name('courpag');
                    Route::get('{department_id}/{group_id}/courseform', [CourseController::class, 'create'])->name('createcor');
                    Route::post('{department_id}/{group_id}/courseform_add', [CourseController::class, 'store'])->name('storecor');
                    Route::get('{department_id}/courseform_edit/{course_id}', [CourseController::class, 'edit'])->name('editcor');

                    Route::get('{department_id}/structure/{course_id}', [CourseController::class, 'structure'])->name('structure_page');
                    Route::get('{department_id}/subject_course/{course_id}', [CourseSubController::class, 'courseSub'])->name('courseSub_page');
                    Route::get('{department_id}/subject_class/{subject_id}', [CourseSubController::class, 'subjecClass'])->name('subjecClass_page');


                    Route::put('{department_id}/courseform_update/{course_id}', [CourseController::class, 'update'])->name('courseform_update');
                    Route::put('{department_id}/courseform_update_structure/{course_id}', [CourseController::class, 'update_structure'])->name('update_structure');

                    Route::get('{department_id}/{course_id}/classroom', [CourseClassController::class, 'classpage'])->name('class_page');
                    Route::get('{department_id}/{course_id}/add_classroomform', [CourseClassController::class, 'create'])->name('class_create');
                    Route::post('{department_id}/{course_id}/store_classroomform', [CourseClassController::class, 'store'])->name('class_store');

                    Route::get('{department_id}/class_edit/{class_id}', [CourseClassController::class, 'edit'])->name('class_edit');
                    Route::put('{department_id}/update_classroomform/{class_id}', [CourseClassController::class, 'update'])->name('class_update');


                    Route::get('{department_id}/{course_id}/registeradd', [CourseClassController::class, 'registeradd'])->name('registeradd_page');
                    Route::get('{department_id}/{course_id}/register/{m}', [CourseClassController::class, 'register'])->name('register_page');
                    Route::get('{department_id}/{course_id}/addusersCour/{m}', [CourseClassAddController::class, 'addusersCour'])->name('addusersCour');
                    Route::post('{department_id}/{course_id}/saveSelectedUsers/{m}', [CourseClassAddController::class, 'saveSelectedUsers'])->name('saveSelectedUsers');


                    Route::match(['get', 'post'], '{department_id}/{course_id}/search-users/{m}', [CourseClassController::class, 'searchUsers'])->name('searchUsers');

                    Route::get('{department_id}/{class_id}/payment', [CourseClassController::class, 'payment'])->name('payment_page');

                    Route::get('{department_id}/{course_id}/gpa/{m}', [CourseClassController::class, 'gpapage'])->name('gpa_page');

                    Route::get('{department_id}/{course_id}/report/{m}', [CourseClassController::class, 'report'])->name('report_page');
                    Route::get('{department_id}/{course_id}/congratuation/{m}', [CourseClassController::class, 'congratuation'])->name('congratuation_page');
                    Route::get('{department_id}/teacherinfo', [CourseClassController::class, 'teacherinfo'])->name('teacherinfo');
                    Route::post('{department_id}/store_teacherinfo', [CourseClassController::class, 'Teacherinfoupdate'])->name('Teacherinfoupdate');
               
               
                });

                Route::prefix('lms')->group(function () {
                    Route::get('{department_id}/gpa', [ScoreController::class, 'gpapage'])->name('gpapage');
                    Route::get('{department_id}/subjectscore', [ScoreController::class, 'subscore'])->name('subscore');
                    Route::get('{department_id}/{subject_id}/listsub', [ScoreController::class, 'listsubject'])->name('listsubjects');
                });
                Route::prefix('lms')->group(function () {
                    Route::get('{department_id}/subject', [CourseSubjectController::class, 'suppage'])->name('suppage');
                    Route::get('{department_id}/subjectform', [CourseSubjectController::class, 'create'])->name('subcreate');
                    Route::post('{department_id}/add_subjectform', [CourseSubjectController::class, 'store'])->name('substore');
                    Route::put('{department_id}/update_subjectform/{subject_id}', [CourseSubjectController::class, 'update'])->name('subupdate');
                    Route::get('{department_id}/edit_subjectform/{subject_id}', [CourseSubjectController::class, 'edit'])->name('editsub');


                    Route::put('{department_id}/add_subjectdetail/{subject_id}', [CourseSubjectController::class, 'updatedetail'])->name('updatedetailsub');
                    Route::get('{department_id}/subjectdetail/{subject_id}', [CourseSubjectController::class, 'editdetailsub'])->name('editdetailsub');
                });

                Route::prefix('lms')->group(function () {
                    Route::get('{department_id}/navless/{subject_id}', [CourseLessonController::class, 'navless'])->name('navless');
                    
                    Route::get('lsn/{department_id}/{subject_id}', [CourseLessonController::class, 'lessonpage'])->name('lessonpage');
                    Route::prefix('lsn')->group(function () { 
                    Route::get('{department_id}/{subject_id}/lessonform', [CourseLessonController::class, 'create'])->name('add_lessonform');
                    Route::post('{department_id}/{subject_id}/add_lessonform', [CourseLessonController::class, 'store'])->name('storeless');
                    Route::get('{department_id}/{subject_id}/edit_lessonform/{lesson_id}', [CourseLessonController::class, 'edit'])->name('edit_lessonform');
                    Route::put('{department_id}/update_lessonform/{lesson_id}', [CourseLessonController::class, 'update'])->name('update_lessonform');

                    Route::get('{department_id}/addsub_lessonsmallform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smallcreate'])->name('smallcreate');
                    Route::post('{department_id}/add_lessonsmallform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smailstore'])->name('smailstore');
                    Route::get('{department_id}/addsub_lessonsmailsmailform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smallsmallcreate'])->name('smallsmallcreate');

                    Route::post('{department_id}/add_lessonsmailsmailform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smailsmailstore'])->name('smailsmailstore');
                    Route::put('{department_id}/uploadfile/{lesson_id}', [CourseLessonController::class, 'uploadfile'])->name('uploadfile');

                    Route::get('{department_id}/{subject_id}/{lesson_id}/supplymentary', [CourseSupplymentaryController::class, 'supplyLess'])->name('Supply_lessonform');
                    Route::get('{department_id}/{subject_id}/{lesson_id}/add_supplymentaryLessform', [CourseSupplymentaryController::class, 'createLess'])->name('add_supplyLessform');
                    Route::post('{department_id}/{subject_id}/{lesson_id}/store_supplymentaryLessform', [CourseSupplymentaryController::class, 'storeLess'])->name('store_supplyLessform');

                    Route::get('{department_id}/{subject_id}/{lesson_id}/edit_supplymentaryLessform/{supplymentary_id}', [CourseSupplymentaryController::class, 'editLess'])->name('edit_supplyLessform');
                    Route::put('{department_id}/{subject_id}/{lesson_id}/update_supplymentaryLessform/{supplymentary_id}', [CourseSupplymentaryController::class, 'updateLess'])->name('update_supplyLessform');
               
                });

                Route::get('spm/{department_id}/{subject_id}', [CourseSupplymentaryController::class, 'supplypage'])->name('supplypage');
                
                Route::prefix('spm')->group(function () {           
                    Route::get('{department_id}/{subject_id}/add_supplymentaryform', [CourseSupplymentaryController::class, 'create'])->name('add_supplyform');
                    Route::post('{department_id}/{subject_id}/store_supplymentaryform', [CourseSupplymentaryController::class, 'store'])->name('store_supplyform');
                    Route::get('{department_id}/{subject_id}/edit_supplymentaryform/{supplymentary_id}', [CourseSupplymentaryController::class, 'edit'])->name('edit_supplyform');
                    Route::put('{department_id}/{subject_id}/update_supplymentaryform/{supplymentary_id}', [CourseSupplymentaryController::class, 'update'])->name('update_supplyform');
                });


                    Route::get('{department_id}/{subject_id}/activity', [NavController::class, 'activitypage'])->name('activitypage');

                    Route::prefix('activity')->group(function () {
                        Route::get('{department_id}/{subject_id}/survey', [SurveyController::class, 'surveyact'])->name('surveyact');
                        Route::get('{department_id}/{subject_id}/surveyform', [SurveyController::class, 'suycreate'])->name('suycreate');

                        Route::post('{department_id}/{subject_id}/add_surveyform', [SurveyController::class, 'storesuySupject'])->name('storesuySupject');

                        Route::get('{department_id}/edit_surveyform/{survey_id}', [SurveyController::class, 'suyedit'])->name('surveyform');
                        Route::put('{department_id}/update_surveyform/{survey_id}', [SurveyController::class, 'Updatesuy'])->name('Updatesuy');

                        Route::get('{department_id}/{subject_id}/{survey_id}/surveyquestion', [SurveyQuestionController::class, 'surveyreport'])->name('surveyquestion');
                        Route::get('{department_id}/{subject_id}/{survey_id}/surveyquestionform', [SurveyQuestionController::class, 'createreport'])->name('createreport');
                        Route::get('{department_id}/edit_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'editreport'])->name('editreport');


                        Route::put('{department_id}/{subject_id}/update_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'updatereport'])->name('updatereport');
                        Route::post('{department_id}/{subject_id}/{survey_id}/add_surveyquestionform', [SurveyQuestionController::class, 'savereport'])->name('savereport');
                        Route::get('{department_id}/{subject_id}/{survey_id}/surveyreportSub', [SurveyQuestionController::class, 'reportpageSubject'])->name('reportpageSubject');



                        Route::get('{department_id}/{subject_id}/category', [CategoryController::class, 'categoryac'])->name('categoryac');
                        Route::get('{department_id}/{subject_id}/categoryform', [CategoryController::class, 'create'])->name('categoryform');
                        Route::post('{department_id}/{subject_id}/categoryform_add', [CategoryController::class, 'store'])->name('categoryform_add');
                        Route::get('{department_id}/{category_id}/categoryform_edit', [CategoryController::class, 'edit'])->name('categoryform_edit');
                        Route::put('{department_id}/{category_id}/categoryform_update', [CategoryController::class, 'update'])->name('categoryform_update');

                        Route::get('{department_id}/topic/{category_id}', [CategoryTopicController::class, 'topicpage'])->name('topic');
                    });


                    Route::get('{department_id}/{subject_id}/teacher', [CourseTeacherController::class, 'teacherspage'])->name('teacherspage');
                    Route::get('{department_id}/{subject_id}/teacher_add{user_id}', [CourseTeacherController::class, 'create'])->name('teacher_add');

                    Route::get('/exam/{department_id}/{subject_id}', [ExamController::class, 'exampage'])->name('exampage');
               
                    Route::prefix('exam')->group(function () {
                        Route::get('{department_id}/{subject_id}/{exam_id}/examreport', [ScoreController::class, 'examlogpage'])->name('examlogpage');
                        Route::post('{department_id}/{subject_id}/Questionimport', [ExcelController::class, 'Questionimport'])->name('Questionimport');

                        Route::get('{department_id}/{subject_id}/add_examform', [ExamController::class, 'createexam'])->name('add_examform');
                        Route::post('{department_id}/{subject_id}/store_examform', [ExamController::class, 'storeexam'])->name('store_examform');
                        Route::get('{department_id}/{subject_id}/edit_examform/{exam_id}', [ExamController::class, 'edit_examform'])->name('edit_examform');
                        Route::put('{department_id}/{subject_id}/update_examform/{exam_id}', [ExamController::class, 'update_examform'])->name('update_examform');



                        Route::get('{department_id}/{subject_id}/pagequess', [ExamController::class, 'pagequess'])->name('pagequess');
                        Route::get('{department_id}/{subject_id}/questionform', [ExamController::class, 'create'])->name('questionform');
                        Route::get('{department_id}/{subject_id}/questionadd', [ExamController::class, 'questionadd'])->name('questionadd');
                        Route::get('{department_id}/{subject_id}/edit_question/{question_id}', [ExamController::class, 'edit'])->name('edit_question');
                        Route::put('{department_id}/{subject_id}/update_question/{question_id}', [ExamController::class, 'update'])->name('update_question');
                        Route::post('{department_id}/{subject_id}/add_questionform', [ExamController::class, 'store'])->name('add_questionform');
                    });
                    Route::get('/booktable', [BookController::class, 'table'])->name('book.table');
                });


                Route::get('/mne/{department_id}', [ManageExamController::class, 'ManageExam'])->name('ManageExam');
                Route::prefix('mne')->group(function () {
                    Route::get('{department_id}/home_mne/', [ManageExamController::class, 'ManageExam'])->name('ManageExam');
                    Route::get('{department_id}/create_mne/', [ManageExamController::class, 'create'])->name('ManageExam_create');
                    Route::post('{department_id}/store_mne/', [ManageExamController::class, 'store'])->name('ManageExam_store');
                    Route::get('{department_id}/edit_mne/', [ManageExamController::class, 'edit'])->name('ManageExam_edit');
                    Route::put('{department_id}/update_mne/', [ManageExamController::class, 'update'])->name('ManageExam_update');
                    Route::prefix('question')->group(function () {
                        Route::get('{department_id}/home_question/', [ManageQuestionController::class, 'index'])->name('ManageQuestion');
                        Route::get('{department_id}/create_question/', [ManageExamController::class, 'create'])->name('ManageQuestion_create');
                        Route::post('{department_id}/store_questione/', [ManageExamController::class, 'store'])->name('ManageQuestion_store');
                        Route::get('{department_id}/edit_question/', [ManageExamController::class, 'edit'])->name('ManageQuestion_edit');
                        Route::put('{department_id}/update_question/', [ManageExamController::class, 'update'])->name('ManageQuestion_update');
                    });
                });



                Route::get('{department_id}/departums/{user_role?}', [DepartUsersController::class, 'DPUserManage'])->name('DPUserManage')->where('user_role', '[0-9]+');

                Route::get('{department_id}/DPUserManagejson/{user_role?}', [DepartUsersController::class, 'DPUserManagejson'])->name('DPUserManagejson')->where('user_role', '[0-9]+');

                Route::prefix('departums')->group(function () {

                    Route::get('/add_dpumsform/{department_id}', [DepartUsersController::class, 'createUser'])->name('DPcreateUser');
                    Route::post('/store_dpumsform/{department_id}', [DepartUsersController::class, 'storeUser'])->name('DPstoreUser');

                    Route::get('{department_id}/edit/{user_id}', [DepartUsersController::class, 'DPeditUser'])->name('DPeditUser');
                    Route::put('{department_id}/DPupdateUser/{user_id}', [DepartUsersController::class, 'DPupdateUser'])->name('DPupdateUser');

                    Route::get('{department_id}/umsschooldepartment', [SchoolDepartController::class, 'indexschool'])->name('umsschooldepartment');
                    Route::get('{department_id}/add_umsschooldepartform', [SchoolDepartController::class, 'create'])->name('createschoolDepart');
                    Route::post('{department_id}/store_umsschooldepartform', [SchoolDepartController::class, 'store'])->name('storeschoolDepart');
                    Route::get('{department_id}/{school_id}/edit_umsschooldepartform', [SchoolDepartController::class, 'edit'])->name('editschoolDepart');
                    Route::put('{department_id}/{school_id}/update_umsschooldepartform', [SchoolDepartController::class, 'update'])->name('updateschoolDepart');

                    Route::get('{department_id}/umslogsuser/{user_id}', [UserLogController::class, 'logusersDP'])->name('logusersDP');
                    Route::get('{department_id}/umsschooluserdepart/{school_code}', [SchoolDepartController::class, 'adduser'])->name('umsschooluserDepart');

                    Route::post('{department_id}/{school_code}/saveSelectedSchooldepart_umsschoolform', [SchoolDepartController::class, 'saveSelectedSchool'])->name('saveSelectedSchoolDepart');

                    Route::get('{department_id}/DPSchoolcreateUser_umsschoolform/{school_code}', [DepartUsersController::class, 'DPSchoolcreateUser'])->name('DPSchoolcreateUser');
                    Route::post('{department_id}/{school_code}/DPSchoolstoreUser_umsschoolform', [DepartUsersController::class, 'DPSchoolstoreUser'])->name('DPSchoolstoreUser');



                    Route::get('{department_id}/{extender_id}/umsschoolDP_add/', [ExtenderController::class, 'adduser'])->name('umsschoolDP_add');
                    Route::get('{department_id}/umsSchoolDP', [ExtenderController::class, 'testumsschool'])->name('testumsschool');
                    Route::get('{department_id}/getExtender', [ExtenderController::class, 'getExtender'])->name('getExtender');
                    Route::post('{department_id}/{extender_id}/saveExtender_umsform', [ExtenderController::class, 'saveExtender'])->name('saveExtender_umsform');
                    
                        Route::get('{department_id}/addextender', [ExtenderController::class, 'addextender'])->name('addextender');
                    
                    Route::post('{department_id}/addextendersubmit', [ExtenderController::class, 'addextendersubmit'])->name('addextendersubmit');
                
                });


                
                Route::get('{department_id}/homeDepart', [DepartReportController::class, 'DepartReportview'])->name('DepartReportview');
                Route::prefix('homeDepart')->group(function () {

                    Route::get('{department_id}/DepartD0100', [DepartReportController::class, 'DepartReportA'])->name('DepartD0100');
                    Route::get('{department_id}/home/dashboard', [DepartReportController::class, 'ReportB'])->name('Departdashboard');
                    Route::get('{department_id}/home/table', [DepartReportController::class, 'ReportC'])->name('Departtable');
                    Route::get('{department_id}/home/T0101', [DepartReportController::class, 'ReportUserAuth'])->name('DepartReportUserAuth');
                    Route::get('{department_id}/home/T0108', [DepartReportController::class, 'trainUserAuth'])->name('DeparttrainUserAuth');
                    Route::get('{department_id}/home/T0103', [DepartReportController::class, 'bookUserAuth'])->name('DepartbookUserAuth');
                    Route::get('{department_id}/home/T0104', [DepartReportController::class, 'LoginUserAuth'])->name('DepartLoginUserAuth');
                    Route::get('{department_id}/home/T0110', [DepartReportController::class, 'BackUserAuth'])->name('DepartBackUserAuth');
                    Route::get('{department_id}/home/T0111', [DepartReportController::class, 'reportMUserAuth'])->name('DepartreportMUserAuth');
                    Route::get('{department_id}/home/T0112', [DepartReportController::class, 'reportYeaAuth'])->name('DepartreportYeaAuth');
                    Route::get('{department_id}/home/T0113', [DepartReportController::class, 'reportQuarterlyAuth'])->name('DepartreportQuarterlyAuth');
                    Route::get('{department_id}/home/T0114', [DepartReportController::class, 'BackupFullUserAuth'])->name('DepartBackupFullUserAuth');
                    Route::get('{department_id}/home/T0115', [DepartReportController::class, 'LogFileUserAuth'])->name('DepartLogFileUserAuth');
                });
            });

            Route::get('/ums/{user_role?}', [EditManageUserController::class, 'UserManage'])->name('UserManage')->where('user_role', '[0-9]+');
            Route::get('/UserManagejson/{user_role?}', [EditManageUserController::class, 'UserManagejson'])->name('UserManagejson')->where('user_role', '[0-9]+');

            Route::prefix('ums')->group(function () {
                Route::get('/deleteUser/{user_id}', [EditManageUserController::class, 'delete'])->name('deleteUser');

                Route::get('/add_umsform', [EditManageUserController::class, 'createUser'])->name('createUser');
                Route::post('/store_umsform', [EditManageUserController::class, 'storeUser'])->name('storeUser');
                Route::get('/ums/{user_role}', [EditManageUserController::class, 'UserManage'])->name('UserManageByRole');

                Route::get('/edit/{user_id}', [EditManageUserController::class, 'edit'])->name('editUser');

                Route::put('/update/{user_id}', [EditManageUserController::class, 'update'])->name('updateUser');

                Route::get('/umslogsuser/{user_id}', [UserLogController::class, 'logusers'])->name('logusers');

                Route::put('/update-role/{user_id}', [EditManageUserController::class, 'updateRoleUser'])->name('updateRoleUser');
                Route::put('/update-password/{user_id}', [EditManageUserController::class, 'updatepassword'])->name('updatePassword');

                Route::get('/changeStatusUser', [EditManageUserController::class, 'changeStatus'])->name('changeStatusUser');

                Route::get('fetchUsersByDepartment', [EditManageUserController::class, 'fetchUsersByDepartment'])->name('fetchUsersByDepartment');



                Route::get('/umsrole', [RolemanageController::class, 'RoleTypes'])->name('RoleTypes');
                Route::get('/umsgroup', [PersonController::class, 'personTypes'])->name('personTypes');
                Route::get('/umsgroupuser/{person_type}', [PersonController::class, 'pageperson'])->name('pageperson');
                Route::put('/umsgroupuser/update_umsgroupuser/{person_type}', [PersonController::class, 'updateusertype'])->name('updateusertype');

                Route::post('/search', [PersonController::class, 'search'])->name('search');



                Route::get('/person_delete/{person_type}', [PersonController::class, 'personDelete'])->name('personDelete');
                Route::get('/umsgroupform/{person_type}', [PersonController::class, 'editname'])->name('editperson');
                Route::put('/update_umsgroupform/{person_type}', [PersonController::class, 'update'])->name('updateperson');

                Route::get('/add_umsgroupform', [PersonController::class, 'create'])->name('createperson');
                Route::post('/store_umsgroupform', [PersonController::class, 'store'])->name('storeperson');


                Route::get('/umsschool', [SchoolController::class, 'schoolManage'])->name('schoolManage');
                Route::get('/add_umsschoolform', [SchoolController::class, 'create'])->name('createschool');
                Route::post('/store_umsschoolform', [SchoolController::class, 'store'])->name('storeschool');
                Route::get('/school_delete/{school_id}', [SchoolController::class, 'delete'])->name('deleteschool');
                Route::get('{school_id}/edit_umsschoolform', [SchoolController::class, 'edit'])->name('editschool');
                Route::put('{school_id}/update_umsschoolform', [SchoolController::class, 'update'])->name('updateschool');


                Route::get('/umsschooluser/{school_code}', [SchoolController::class, 'adduser'])->name('umsschooluser');
                Route::post('{school_code}/saveSelectedSchool_umsschoolform', [SchoolController::class, 'saveSelectedSchool'])->name('saveSelectedSchool');
            });



            Route::prefix('report')->group(function () {
                Route::get('/home', [ReportAllController::class, 'Reportview'])->name('Reportview');
                Route::get('/home/D0100', [ReportAllController::class, 'ReportA'])->name('D0100');
                Route::get('/home/dashboard', [ReportAllController::class, 'ReportB'])->name('dashboard');
                Route::get('/home/table', [ReportAllController::class, 'ReportC'])->name('table');

                Route::get('/home/T0101', [ReportAllController::class, 'ReportUserAuth'])->name('ReportUserAuth');
                Route::get('/home/T0108', [ReportAllController::class, 'trainUserAuth'])->name('trainUserAuth');
                Route::get('/home/T0103', [ReportAllController::class, 'bookUserAuth'])->name('bookUserAuth');
                Route::get('/home/T0104', [ReportAllController::class, 'LoginUserAuth'])->name('LoginUserAuth');
                Route::get('/home/T0110', [ReportAllController::class, 'BackUserAuth'])->name('BackUserAuth');
                Route::get('/home/T0111', [ReportAllController::class, 'reportMUserAuth'])->name('reportMUserAuth');
                Route::get('/home/T0112', [ReportAllController::class, 'reportYeaAuth'])->name('reportYeaAuth');
                Route::get('/home/T0113', [ReportAllController::class, 'reportQuarterlyAuth'])->name('reportQuarterlyAuth');
                Route::get('/home/T0114', [ReportAllController::class, 'BackupFullUserAuth'])->name('BackupFullUserAuth');
                Route::get('/home/T0115', [ReportAllController::class, 'LogFileUserAuth'])->name('LogFileUserAuth');
                Route::get('/home/T0116', [ReportAllController::class, 't0116'])->name('t0116');
                Route::get('/home/T0117', [ReportAllController::class, 't0117'])->name('t0117');
                Route::get('/home/T0118', [ReportAllController::class, 't0118'])->name('t0118');
                Route::get('/home/T0119', [ReportAllController::class, 't0119'])->name('t0119');
                Route::get('/home/T0120', [ReportAllController::class, 't0120'])->name('t0120');
                Route::get('/home/T0121', [ReportAllController::class, 't0121'])->name('t0121');
                Route::get('/home/T0122', [ReportAllController::class, 't0122'])->name('t0122');
                Route::get('/home/T0123', [ReportAllController::class, 't0123'])->name('t0123');
                Route::get('/home/T0124', [ReportAllController::class, 't0124'])->name('t0124');
                Route::get('/home/T0125', [ReportAllController::class, 't0125'])->name('t0125');
                Route::post('/get-user-data', [ReportAllController::class, 'getUserData'])->name('get-Uata');
            });
            Route::prefix('datareport')->group(function () {
                Route::get('/T0103', [ReportJsonController::class, 't0103'])->name('t0103json');
            });
            Route::get('/getSchools', [SchoolController::class, 'getSchools'])->name('getSchools');
            
            Route::get('/req', [NavController::class, 'pageRequest'])->name('pageRequest');
            Route::prefix('req')->group(function () {
                Route::get('/amreq', [SubmitController::class, 'requestSchool'])->name('requestSchool');
                Route::get('/requestup', [SchoolDepartUserController::class, 'requestSchool'])->name('requestup');             
                Route::post('/uploadPdf', [SchoolDepartUserController::class, 'uploadPdf'])->name('uploadPdf');
                Route::get('/requestSchooldataJson', [SubmitController::class, 'requestSchooldataJson'])->name('requestSchooldataJson');
                Route::get('/detaildata/{submit_id}', [SubmitController::class, 'detaildata'])->name('detaildata');
                Route::put('admin/rad/storeAdminreq/{submit_id}', [SubmitController::class, 'storeAdminreq'])->name('storeAdminreq');
                Route::put('admin/rad/storeAdminreq2/{submit_id}', [SubmitController::class, 'storeAdminreq2'])->name('storeAdminreq2');

                Route::get('/get-department-name/{departmentId}', [ClaimUserController::class, 'getDepartmentName'])->name('getDepartmentName');
                Route::get('/get-claim-data/{claimUserId}', [ClaimUserController::class, 'getClaimData'])->name('getClaimData');
                Route::get('/cau', [ClaimUserController::class, 'Certanddepart'])->name('Certanddepart');
                Route::get('/updateceryes/{certificate_file_id}', [ClaimUserController::class, 'updateyes'])->name('updateceryes');
                Route::get('/updatecerno/{certificate_file_id}', [ClaimUserController::class, 'updateno'])->name('updatecerno');

                Route::get('/updateuserdeyes/{claim_user_id}', [ClaimUserController::class, 'updateuserdeyes'])->name('updateuserdeyes');
                Route::get('/updateuserdeno/{claim_user_id}', [ClaimUserController::class, 'updateuserdeno'])->name('updateuserdeno');
            });

            
            
            Route::prefix('info')->group(function () {
                Route::post('UsersDepartAllImport/{department_id}', [ExcelController::class, 'UsersDepartAllImport'])->name('UsersDepartAllImport');
                Route::post('UsersDepartImport/{department_id}', [ExcelController::class, 'UsersDepartImport'])->name('UsersDepartImport');
                Route::get('/autocomplete-search', [EditManageUserController::class, 'autoschool'])->name('autocompleteSearch');
                Route::post('UsersImport', [ExcelController::class, 'UsersImport'])->name('UsersImport');
                Route::get('exportLeact', [ExcelController::class, 'exportLeact'])->name('exportLeact');
                Route::get('/autocomplete-search/{department_id}', [DepartUsersController::class, 'autoschool'])->name('DPautocompleteSearch');
                Route::post('UsersDepartSchoolImport/{department_id}/{extender_id}', [ExcelController::class, 'UsersDepartSchoolImport'])->name('UsersDepartSchoolImport');
                Route::get('/changeStatus', [HighlightController::class, 'changeStatus'])->name('changeStatus');
                Route::post('/storeban', [HighlightController::class, 'store'])->name('storeban');
                Route::get('/dls', [DepartmentController::class, 'departmentdlspage'])->name('departmentdlspage');
                Route::get('/destoryban/{highlight_id}', [HighlightController::class, 'destory'])->name('destoryban');
                Route::get('delete_question/{question_id}', [ExamController::class, 'destroy'])->name('delete_question');
                Route::get('/queschangeStatus', [ExamController::class, 'queschangeStatus'])->name('queschangeStatus');
                Route::get('destroy_examform/{exam_id}', [ExamController::class, 'destroyexam'])->name('destroy_examform');
                Route::get('/changeStatusExam', [ExamController::class, 'changeStatus'])->name('changeStatusExam');
                Route::get('/{category_id}/categoryform_destroy', [CategoryController::class, 'destroy'])->name('categoryform_destroy');
                Route::get('/changeStatuCategory', [CategoryController::class, 'changeStatuCategory'])->name('changeStatuCategory');
                Route::get('{department_id}/{supplymentary_id}/destroy_supplymentaryLessform', [CourseSupplymentaryController::class, 'destroyLess'])->name('destroy_supplyLessform');
                Route::get('/changeStatusSupplymentary', [CourseSupplymentaryController::class, 'changeStatus'])->name('changeStatusSupplymentary');
                Route::get('/{supplymentary_id}/destroy_supplymentaryform', [CourseSupplymentaryController::class, 'destroy'])->name('destroy_supplyform');
                Route::get('/changeStatusLesson', [CourseLessonController::class, 'changeStatus'])->name('changeStatusLesson');
                Route::get('{department_id}/destroy_lessonform/{lesson_id}', [CourseLessonController::class, 'destroy'])->name('destroy_lessonform');
                Route::get('delete_teacher/{teacher_id}', [CourseTeacherController::class, 'destory'])->name('delete_teacher');

                Route::get('updateTeacherStatus', [CourseTeacherController::class, 'update'])->name('TeacherStatus');
                Route::get('delete_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'destory'])->name('destoryReport');


                Route::get('/ActivityChangeStatus', [ActivityCategoryController::class, 'changeStatus'])->name('ActivityChangeStatus');
                Route::get('/ActChangeStatus', [ActivityController::class, 'changeStatus'])->name('ActChangeStatus');
                Route::get('/delete_blogform/{blog_id}', [BlogController::class, 'destory'])->name('destoryblog');
                Route::get('/changeStatusBlog', [BlogController::class, 'changeStatus'])->name('changeStatusBlog');
                Route::get('{department_id}/delete_bookcategoryform/{category_id}', [BookCategoryController::class, 'destory'])->name('bookdestory');
                Route::get('/changeStatuBookCategory', [BookCategoryController::class, 'changeStatus'])->name('changeStatuBookCategory');
                Route::get('/delete_manualform/{manual_id}', [ManualController::class, 'destory'])->name('destorymanual');
                Route::get('/changeStatusManual', [ManualController::class, 'changeStatus'])->name('changeStatusManual');
                Route::get('/changeStatuQuestion', [SurveyQuestionController::class, 'changeStatus'])->name('changeStatuQuestion');
                Route::get('/delete_surveyform/{survey_id}', [SurveyController::class, 'destory'])->name('dessur');
                Route::get('/changeStatusSurvey', [SurveyController::class, 'changeStatus'])->name('changeStatuSurvey');
                Route::get('/delete_linksform/{links_id}', [LinkController::class, 'destory'])->name('destorylink');
                Route::get('/changeStatusLinks', [LinkController::class, 'changeStatus'])->name('changeStatusLinks');
                Route::get('/changeSortIink', [LinkController::class, 'changeSortIink'])->name('changeSortIink');
                Route::get('{department_id}/destorysub/{subject_id}', [CourseSubjectController::class, 'destory'])->name('destorysub');

                Route::get('/changeStatusSubject', [CourseSubjectController::class, 'changeStatus'])->name('changeStatusSubject');

                Route::get('/changeStatusLearner', [CourseClassAddController::class, 'changeStatusLearner'])->name('changeStatusLearners');
                Route::get('/destroySelectedUsers/{learner_id}', [CourseClassAddController::class, 'destroy'])->name('destroySelectedUsers');

                Route::get('{department_id}/courseform_destroy/{course_id}', [CourseController::class, 'destroy'])->name('courseform_destroy');
                Route::get('/changeStatusCourse', [CourseController::class, 'changeStatus'])->name('changeStatusCourse');
                Route::get('{department_id}/delete_groupform/{group_id}', [CourseGroupController::class, 'destroy'])->name('deletecour');
                Route::get('/changeStatusGroup', [CourseGroupController::class, 'changeStatus'])->name('changeStatusGroup');
                Route::get('/delete_blogcategoryform/{category_id}', [BlogCategotyController::class, 'destroy'])->name('destoryblogcat');
                Route::get('/changeStatusBlogCategory', [BlogCategotyController::class, 'changeStatus'])->name('changeStatusBlogCategory');
                Route::get('/delete_bookform/{book_id}', [BookController::class, 'destroy'])->name('destroycatbook');
                Route::get('/delete_webcategoryform/{category_id}', [WedCategoryController::class, 'destroy'])->name('evendelete');
                Route::get('/changeStatusWebCat', [WedCategoryController::class, 'changeStatus'])->name('changeStatusWebCat');

                Route::get('/delete_webform/{web_id}', [WebController::class, 'destroy'])->name('destroycat');
                Route::get('/changeStatusWeb', [WebController::class, 'changeStatus'])->name('changeStatusWeb');
                Route::get('/changeSortWeb', [WebController::class, 'changeSortWeb'])->name('changeSortWeb');
                Route::get('/changeStatuBook', [BookController::class, 'changeStatus'])->name('changeStatuBook');


                Route::get('/{topic_id}/topic_destroy', [CategoryTopicController::class, 'destroy'])->name('topic_destroy');
                Route::get('/changeStatuCategoryTopic', [CategoryTopicController::class, 'changeStatuCategoryTopic'])->name('changeStatuCategoryTopic');
                Route::get('/schooldepart_delete/{school_id}', [SchoolDepartController::class, 'delete'])->name('deleteschoolDepart');
                Route::get('/department_delete/{department_id}', [DepartmentController::class, 'destroy'])->name('deleteDepart');
            
            });
        });
    });
});

Route::get('/logout', [CustomAuthController::class, 'logoutUser'])->name('logout');
