<?php

use App\Http\Controllers\ActivityCategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityInviteController;
use App\Http\Controllers\BlogCategotyController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryTopicController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseGroupController;
use App\Http\Controllers\CourseLessonController;
use App\Http\Controllers\CourseSubjectController;
use App\Http\Controllers\CourseSupplymentaryController;
use App\Http\Controllers\CourseTeacherController;

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EditManageUserController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\GenaralController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReportAllController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SurResponseController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\WedCategoryController;
use Illuminate\Support\Facades\Route;

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










Route::get('/exportSubject', [ExcelController::class, 'exportSubject'])->name('exportSubject');
Route::get('/UsersExport', [ExcelController::class, 'exportUsers'])->name('UsersExport');
Route::get('/QuestionExport', [ExcelController::class, 'questionExport'])->name('questionExport');

Route::group(['middleware' => 'AlreadyLogIn'], function () {
    Route::get('/aced', [DepartmentController::class, 'aced'])->name('aced');
    Route::get('/login', [CustomAuthController::class, 'login'])->name('homelogin');
    Route::get('/regis', [CustomAuthController::class, 'regis'])->name('homeregis');

    // เส้นทางอื่นๆที่ต้องใช้ middleware เช่นเดียวกัน
});




Route::post('/register-user', [CustomAuthController::class, 'registerUser'])->name('register-user');
Route::post('/login-user', [CustomAuthController::class, 'loginUser'])->name('login-user');
Route::get('/home', [CustomAuthController::class, 'homeregis'])->name('homeRegis');

// middleware Isloggedin ต้องสมัครก่อนถึงเข้าได้




Route::group(['middleware' => 'IsLoggedIn'], function () {
    Route::middleware(['CheckUserLogin'])->group(function () {

        // ...
        Route::get('/edit-profile', [EditProfileController::class, 'edit'])->name('edit-profile');
        Route::put('/update-profile', [EditProfileController::class, 'update'])->name('update-profile');

        // ...

        Route::get('/', [NavController::class, 'home'])->name('adminhome');
        Route::get('/department', [NavController::class, 'homedepartment'])->name('adminhomedepartment');
        Route::prefix('admin')->group(function () {

            Route::get('/wms', [DepartmentController::class, 'departmentwmspage'])->name('departmentwmspage');
            Route::get('/lms', [DepartmentController::class, 'departmentLearnpage'])->name('departmentLearnpage');
            Route::get('/bss', [DepartmentController::class, 'bookif'])->name('bookif');
         
            Route::get('/dls', [DepartmentController::class, 'departmentdlspage'])->name('departmentdlspage');

            Route::get('{from}/departmentform', [DepartmentController::class, 'departmentcreate'])->name('departmentcreate');
            Route::post('/departmentform_add', [DepartmentController::class, 'store'])->name('departmentstore');
            Route::get('{from}/departmentform_edit/{department_id}', [DepartmentController::class, 'departmentedit'])->name('departmentedit');
            Route::put('{from}/departmentform_update/{department_id}', [DepartmentController::class, 'update'])->name('departmentupdate');
            Route::get('/changeStatusDepart', [DepartmentController::class, 'changeStatus'])->name('changeStatusDepart');


            Route::prefix('wms')->group(function () {
                
                Route::get('{department_id}/home', [NavController::class, 'manage'])->name('manage');
                Route::get('/general', [NavController::class, 'dataci'])->name('dataci');
                Route::get('/logo', [GenaralController::class, 'logo'])->name('logo');
                Route::put('/edit/{id}', [GenaralController::class, 'update'])->name('updategen');
                Route::post('/create', [GenaralController::class, 'create'])->name('creategen');
                Route::get('/highlight', [HighlightController::class, 'hightpage'])->name('hightpage');
                Route::get('/changeStatus', [HighlightController::class, 'changeStatus'])->name('changeStatus');
                Route::get('{department_id}/hightDep', [HighlightController::class, 'hightDep'])->name('hightDep');
                Route::post('{department_id}/storeDep', [HighlightController::class, 'storeDep'])->name('storeDep');
                Route::put('{highlight_id}/updateLinkDep', [HighlightController::class, 'updateLinkDep'])->name('updateLinkDep');
          

                Route::post('/storeban', [HighlightController::class, 'store'])->name('storeban');

                Route::get('/destoryban/{highlight_id}', [HighlightController::class, 'destory'])->name('destoryban');


                Route::get('{department_id}/Webpage', [WedCategoryController::class, 'Webpage'])->name('Webpage');
                Route::get('{department_id}/webcategory', [WedCategoryController::class, 'evenpage'])->name('evenpage');
                  Route::get('{department_id}/add_webevencategoryform', [WedCategoryController::class, 'create'])->name('evencreate');
                Route::post('{department_id}/store_webevencategoryform', [WedCategoryController::class, 'store'])->name('evenstore');
                Route::get('/edit_webcategoryform/{category_id}', [WedCategoryController::class, 'edit'])->name('evenedit');
        
                Route::get('/edit_webcategoryform/{category_id}', [WedCategoryController::class, 'edit'])->name('evenedit');
                Route::put('/update_webcategoryform/{category_id}', [WedCategoryController::class, 'update'])->name('updateeven');
                Route::get('/delete_webcategoryform/{category_id}', [WedCategoryController::class, 'destroy'])->name('evendelete');
                Route::get('/changeStatusWebCat', [WedCategoryController::class, 'changeStatus'])->name('changeStatusWebCat');

      
                Route::get('{department_id}/acteven', [WedCategoryController::class, 'acteven'])->name('acteven');
                Route::get('{department_id}/add_webactcategoryform', [WedCategoryController::class, 'createact'])->name('createact');
                Route::post('{department_id}/store_webactcategoryform', [WedCategoryController::class, 'storeact'])->name('storeact');
                Route::get('/edit_webactcategoryform/{category_id}', [WedCategoryController::class, 'editact'])->name('actedit');
                Route::put('/update_webactcategoryform/{category_id}', [WedCategoryController::class, 'updateact'])->name('updateact');
             

                Route::get('/{category_id}/web', [WebController::class, 'catpage'])->name('catpage');
                Route::get('/{category_id}/add_webform', [WebController::class, 'create'])->name('createcat');
                Route::post('/{category_id}/store_webform', [WebController::class, 'store'])->name('catstore');
                Route::get('/edit_webform/{web_id}', [WebController::class, 'edit'])->name('editcat');
                Route::put('/update_webform/{web_id}', [WebController::class, 'update'])->name('updatecat');
                Route::get('/delete_webform/{web_id}', [WebController::class, 'destroy'])->name('destroycat');
                Route::get('/changeStatusWeb', [WebController::class, 'changeStatus'])->name('changeStatusWeb');
                Route::get('/changeSortWeb', [WebController::class, 'changeSortWeb'])->name('changeSortWeb');



                Route::get('{department_id}/links', [LinkController::class, 'linkpage'])->name('linkpage');
                Route::get('{department_id}/linksform', [LinkController::class, 'create'])->name('linkcreate');
                Route::post('{department_id}/add_linksform', [LinkController::class, 'store'])->name('storelink');
                Route::get('/edit_linksform/{links_id}', [LinkController::class, 'edit'])->name('editlink');
                Route::put('/update_linksform/{links_id}', [LinkController::class, 'update'])->name('updatelink');
                Route::get('/delete_linksform/{links_id}', [LinkController::class, 'destory'])->name('destorylink');
                Route::get('/changeStatusLinks', [LinkController::class, 'changeStatus'])->name('changeStatusLinks');
                Route::get('/changeSortIink', [LinkController::class, 'changeSortIink'])->name('changeSortIink');


                Route::get('{department_id}/survey', [SurveyController::class, 'surveypage'])->name('surveypage');
                Route::get('{department_id}/surveyform', [SurveyController::class, 'create'])->name('createsurvey');
                Route::post('{department_id}/add_surveyform', [SurveyController::class, 'store'])->name('storesurvey');
                Route::get('/edit_surveyform/{survey_id}', [SurveyController::class, 'edit'])->name('editsur');
                Route::put('/update_surveyform/{survey_id}', [SurveyController::class, 'update'])->name('updatesur');
                Route::get('/delete_surveyform/{survey_id}', [SurveyController::class, 'destory'])->name('dessur');
                Route::get('/changeStatusSurvey', [SurveyController::class, 'changeStatus'])->name('changeStatuSurvey');

                Route::get('/{survey_id}/surveyquestions', [SurveyQuestionController::class, 'questionpage'])->name('questionpage');
                Route::get('/{survey_id}/surveyquestionform', [SurveyQuestionController::class, 'create'])->name('questionpagecreate');
                Route::post('/{survey_id}/add_surveyquestionform', [SurveyQuestionController::class, 'store'])->name('storequ');
                Route::get('/edit_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'edit'])->name('editque');
                Route::put('/update_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'update'])->name('updateque');
                Route::get('/{survey_id}/surveyreports', [SurveyQuestionController::class, 'reportpage'])->name('wmspage');
                Route::get('/changeStatuQuestion', [SurveyQuestionController::class, 'changeStatus'])->name('changeStatuQuestion');


                Route::get('/{survey_id}/responsess', [SurResponseController::class, 'resPonse'])->name('responsess');



                Route::get('{department_id}/manual', [ManualController::class, 'index'])->name('manualpage');
                Route::get('{department_id}/manualform', [ManualController::class, 'create'])->name('createmanual');
                Route::post('{department_id}/add_manualform', [ManualController::class, 'store'])->name('storemanual');
                Route::get('/edit_manualform/{manual_id}', [ManualController::class, 'edit'])->name('editmanual');
                Route::put('/update_manualform/{manual_id}', [ManualController::class, 'update'])->name('updatemanual');
                Route::get('/delete_manualform/{manual_id}', [ManualController::class, 'destory'])->name('destorymanual');
                Route::get('/changeStatusManual', [ManualController::class, 'changeStatus'])->name('changeStatusManual');
            });

            Route::prefix('dls')->group(function () {
                Route::get('/{department_id}/home', [NavController::class, 'dls'])->name('dls');

                Route::get('{department_id}/bookcategory', [BookCategoryController::class, 'bookpage'])->name('bookpage');
                Route::get('{department_id}/bookcategoryform', [BookCategoryController::class, 'create'])->name('createbook');
                Route::post('{department_id}/add_bookcategoryform', [BookCategoryController::class, 'store'])->name('storebook');
                Route::get('/edit_bookcategoryform/{category_id}', [BookCategoryController::class, 'edit'])->name('editbook');
                Route::put('/update_bookcategoryform/{category_id}', [BookCategoryController::class, 'update'])->name('bookupdate');
                Route::get('/delete_bookcategoryform/{category_id}', [BookCategoryController::class, 'destory'])->name('bookdestory');
                Route::get('/changeStatuBookCategory', [BookCategoryController::class, 'changeStatus'])->name('changeStatuBookCategory');

                Route::get('/{category_id}/book', [BookController::class, 'bookcatpage'])->name('bookcatpage');
                Route::get('/{category_id}/bookform', [BookController::class, 'create'])->name('catcreatebook');
                Route::post('/{category_id}/add_bookform', [BookController::class, 'store'])->name('bookcatstore');
                Route::get('/edit_bookform/{book_id}', [BookController::class, 'edit'])->name('editcatbook');
                Route::put('/update_bookform/{book_id}', [BookController::class, 'update'])->name('updatecatbook');
                Route::get('/delete_bookform/{book_id}', [BookController::class, 'destroy'])->name('destroycatbook');
                Route::get('/changeStatuBook', [BookController::class, 'changeStatus'])->name('changeStatuBook');
            });
            Route::prefix('cop')->group(function () {
                Route::get('{department_id}/blogcategory', [BlogCategotyController::class, 'blogpage'])->name('blogpage');
                Route::get('{department_id}/blogcategoryform', [BlogCategotyController::class, 'create'])->name('createblogcat');
                Route::post('{department_id}/add_blogcategoryform', [BlogCategotyController::class, 'store'])->name('storeblogcat');
                Route::get('/edit_blogcategoryform/{category_id}', [BlogCategotyController::class, 'edit'])->name('editblogcat');
                Route::put('/update_blogcategoryform/{category_id}', [BlogCategotyController::class, 'update'])->name('updateblogcat');
                Route::get('/delete_blogcategoryform/{category_id}', [BlogCategotyController::class, 'destroy'])->name('destoryblogcat');
                Route::get('/changeStatusBlogCategory', [BlogCategotyController::class, 'changeStatus'])->name('changeStatusBlogCategory');

                Route::get('/{category_id}/blog', [BlogController::class, 'index'])->name('blog');
                Route::get('/{category_id}/blogform', [BlogController::class, 'create'])->name('createblog');
                Route::post('/{category_id}/add_blogform', [BlogController::class, 'store'])->name('storeblog');
                Route::get('/edit_blogform/{blog_id}', [BlogController::class, 'edit'])->name('editblog');
                Route::put('/update_blogform/{blog_id}', [BlogController::class, 'update'])->name('updateblog');
                Route::get('/delete_blogform/{blog_id}', [BlogController::class, 'destory'])->name('destoryblog');
                Route::get('/changeStatusBlog', [BlogController::class, 'changeStatus'])->name('changeStatusBlog');
            });

            Route::prefix('cop')->group(function () {
                Route::get('{department_id}/home', [NavController::class, 'cop'])->name('cop');
                Route::get('{department_id}/activitycategory', [ActivityCategoryController::class, 'activi'])->name('activi');
                Route::get('{department_id}/meetingcategory', [ActivityCategoryController::class, 'meeti'])->name('meeti');

                Route::get('activiFrom/{category_id}', [ActivityCategoryController::class, 'activiFrom'])->name('activiFrom');

                Route::prefix('acttivity')->group(function () {

                    Route::get('activiList/{category_id}', [ActivityController::class, 'activiList'])->name('activiList');

                    Route::get('/activiListForm1/{category_id}', [ActivityController::class, 'activiListForm1'])->name('activiListForm1');
                    Route::post('/act1store/{category_id}', [ActivityController::class, 'act1store'])->name('act1store');
                    Route::get('/activiListform1_edit/{activity_id}', [ActivityController::class, 'formacttivityEdit1'])->name('activiListform1_edit');
                    Route::put('/act1Update/{activity_id}', [ActivityController::class, 'act1update'])->name('act1Update');


                    Route::get('/activiListForm2/{category_id}', [ActivityController::class, 'activiListForm2'])->name('activiListForm2');
                    Route::post('/act2store/{category_id}', [ActivityController::class, 'act2store'])->name('act2store');
                    Route::get('/activiListform_edit2/{activity_id}', [ActivityController::class, 'formacttivityEdit2'])->name('activiListform2_edit');
                    Route::put('/act2Update/{activity_id}', [ActivityController::class, 'act2update'])->name('act2Update');
                });




                Route::get('/ActivityChangeStatus', [ActivityCategoryController::class, 'changeStatus'])->name('ActivityChangeStatus');
                Route::get('/ActChangeStatus', [ActivityController::class, 'changeStatus'])->name('ActChangeStatus');
            });


            Route::prefix('lms')->group(function () {
                Route::get('{department_id}/home', [NavController::class, 'learn'])->name('learn');

                Route::get('{department_id}/group', [CourseGroupController::class, 'courgroup'])->name('courgroup');
                Route::get('{department_id}/groupform', [CourseGroupController::class, 'create'])->name('createcour');
                Route::post('{department_id}/add_groupform', [CourseGroupController::class, 'store'])->name('storecour');
                Route::get('/edit_groupform/{group_id}', [CourseGroupController::class, 'edit'])->name('editcour');
                Route::put('/update_groupform/{group_id}', [CourseGroupController::class, 'update'])->name('updatecour');
                Route::get('/delete_groupform/{group_id}', [CourseGroupController::class, 'destroy'])->name('deletecour');
                Route::get('/changeStatusGroup', [CourseGroupController::class, 'changeStatus'])->name('changeStatusGroup');

                Route::get('/{group_id}/course', [CourseController::class, 'courpag'])->name('courpag');
                Route::get('/{group_id}/courseform', [CourseController::class, 'create'])->name('createcor');
                Route::post('/{group_id}/courseform_add', [CourseController::class, 'store'])->name('storecor');
                Route::get('/courseform_edit/{course_id}', [CourseController::class, 'edit'])->name('editcor');
                Route::get('/structure/{course_id}', [CourseController::class, 'structure'])->name('structure_page');
                Route::put('/courseform_update/{course_id}', [CourseController::class, 'update'])->name('courseform_update');
                Route::put('/courseform_update_structure/{course_id}', [CourseController::class, 'update_structure'])->name('update_structure');
                Route::get('/courseform_destroy/{course_id}', [CourseController::class, 'destroy'])->name('courseform_destroy');
                Route::get('/changeStatusCourse', [CourseController::class, 'changeStatus'])->name('changeStatusCourse');


                Route::get('/{course_id}/classroom', [CourseClassController::class, 'classpage'])->name('class_page');
                Route::get('/{course_id}/add_classroomform', [CourseClassController::class, 'create'])->name('class_create');
                Route::post('/{course_id}/store_classroomform', [CourseClassController::class, 'store'])->name('class_store');

                Route::get('class_edit/{class_id}', [CourseClassController::class, 'edit'])->name('class_edit');
                Route::put('/update_classroomform/{class_id}', [CourseClassController::class, 'update'])->name('class_update');


                Route::get('{course_id}/registeradd', [CourseClassController::class, 'registeradd'])->name('registeradd_page');
                Route::get('{course_id}/register/{m}', [CourseClassController::class, 'register'])->name('register_page');


                Route::get('{class_id}/payment', [CourseClassController::class, 'payment'])->name('payment_page');

                Route::get('{course_id}/report/{m}', [CourseClassController::class, 'report'])->name('report_page');
                Route::get('{course_id}/congratuation/{m}', [CourseClassController::class, 'congratuation'])->name('congratuation_page');
                Route::get('teacherinfo', [CourseClassController::class, 'teacherinfo'])->name('teacherinfo');
                Route::post('/store_teacherinfo', [CourseClassController::class, 'Teacherinfoupdate'])->name('Teacherinfoupdate');
            });


            Route::prefix('lms')->group(function () {
                Route::get('{department_id}/subject', [CourseSubjectController::class, 'suppage'])->name('suppage');
                Route::get('{department_id}/subjectform', [CourseSubjectController::class, 'create'])->name('subcreate');
                Route::post('{department_id}/add_subjectform', [CourseSubjectController::class, 'store'])->name('substore');
                Route::put('/update_subjectform/{subject_id}', [CourseSubjectController::class, 'update'])->name('subupdate');
                Route::get('/edit_subjectform/{subject_id}', [CourseSubjectController::class, 'edit'])->name('editsub');


                Route::put('/add_subjectdetail/{subject_id}', [CourseSubjectController::class, 'updatedetail'])->name('updatedetailsub');
                Route::get('/subjectdetail/{subject_id}', [CourseSubjectController::class, 'editdetailsub'])->name('editdetailsub');
                Route::get('/destorysub/{subject_id}', [CourseSubjectController::class, 'destory'])->name('destorysub');

                Route::get('/changeStatusSubject', [CourseSubjectController::class, 'changeStatus'])->name('changeStatusSubject');
            });
            
            Route::prefix('lms')->group(function () {
                Route::get('/navless/{subject_id}', [CourseLessonController::class, 'navless'])->name('navless');


                Route::get('/lesson/{subject_id}', [CourseLessonController::class, 'lessonpage'])->name('lessonpage');
                Route::get('{subject_id}/lessonform', [CourseLessonController::class, 'create'])->name('add_lessonform');
                Route::post('{subject_id}/add_lessonform', [CourseLessonController::class, 'store'])->name('storeless');
                Route::get('/edit_lessonform/{lesson_id}', [CourseLessonController::class, 'edit'])->name('edit_lessonform');
                Route::put('/update_lessonform/{lesson_id}', [CourseLessonController::class, 'update'])->name('update_lessonform');
                Route::get('/destroy_lessonform/{lesson_id}', [CourseLessonController::class, 'destroy'])->name('destroy_lessonform');
                Route::get('/addsub_lessonsmallform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smallcreate'])->name('smallcreate');
                Route::post('/add_lessonsmallform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smailstore'])->name('smailstore');
                Route::get('/addsub_lessonsmailsmailform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smallsmallcreate'])->name('smallsmallcreate');

                Route::post('/add_lessonsmailsmailform/{subject_id}/{lesson_id}', [CourseLessonController::class, 'smailsmailstore'])->name('smailsmailstore');


                Route::get('/changeStatusLesson', [CourseLessonController::class, 'changeStatus'])->name('changeStatusLesson');


                Route::put('uploadfile/{lesson_id}', [CourseLessonController::class, 'uploadfile'])->name('uploadfile');

                Route::get('/supplymentary/{subject_id}', [CourseSupplymentaryController::class, 'supplypage'])->name('supplypage');

                Route::get('/{subject_id}/add_supplymentaryform', [CourseSupplymentaryController::class, 'create'])->name('add_supplyform');
                Route::post('/{subject_id}/store_supplymentaryform', [CourseSupplymentaryController::class, 'store'])->name('store_supplyform');

                Route::get('/{supplymentary_id}/edit_supplymentaryform', [CourseSupplymentaryController::class, 'edit'])->name('edit_supplyform');
                Route::get('/{supplymentary_id}/destroy_supplymentaryform', [CourseSupplymentaryController::class, 'destroy'])->name('destroy_supplyform');
                Route::put('/{supplymentary_id}/update_supplymentaryform', [CourseSupplymentaryController::class, 'update'])->name('update_supplyform');



                Route::get('/{subject_id}/{lesson_id}/supplymentary', [CourseSupplymentaryController::class, 'supplyLess'])->name('Supply_lessonform');
                Route::get('/{subject_id}/{lesson_id}/add_supplymentaryLessform', [CourseSupplymentaryController::class, 'createLess'])->name('add_supplyLessform');
                Route::post('/{subject_id}/{lesson_id}/store_supplymentaryLessform', [CourseSupplymentaryController::class, 'storeLess'])->name('store_supplyLessform');

                Route::get('/{supplymentary_id}/edit_supplymentaryLessform', [CourseSupplymentaryController::class, 'editLess'])->name('edit_supplyLessform');
                Route::get('/{supplymentary_id}/destroy_supplymentaryLessform', [CourseSupplymentaryController::class, 'destroyLess'])->name('destroy_supplyLessform');
                Route::put('/{supplymentary_id}/update_supplymentaryLessform', [CourseSupplymentaryController::class, 'updateLess'])->name('update_supplyLessform');
                Route::get('/changeStatusSupplymentary', [CourseSupplymentaryController::class, 'changeStatus'])->name('changeStatusSupplymentary');


                Route::get('/{subject_id}/activity', [NavController::class, 'activitypage'])->name('activitypage');

                Route::prefix('activity')->group(function () {
                    Route::get('{subject_id}/survey', [SurveyController::class, 'surveyact'])->name('surveyact');
                    Route::get('{subject_id}/surveyform', [SurveyController::class, 'suycreate'])->name('suycreate');

                    Route::post('{subject_id}/add_surveyform', [SurveyController::class, 'storesuySupject'])->name('storesuySupject');

                    Route::get('edit_surveyform/{survey_id}', [SurveyController::class, 'suyedit'])->name('surveyform');
                    Route::put('update_surveyform/{survey_id}', [SurveyController::class, 'Updatesuy'])->name('Updatesuy');

                    Route::get('/{survey_id}/surveyquestion', [SurveyQuestionController::class, 'surveyreport'])->name('surveyquestion');
                    Route::get('/{survey_id}/surveyquestionform', [SurveyQuestionController::class, 'createreport'])->name('createreport');
                    Route::get('edit_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'editreport'])->name('editreport');
                    Route::get('delete_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'destory'])->name('destoryReport');
                    Route::put('update_surveyquestionform/{question_id}', [SurveyQuestionController::class, 'updatereport'])->name('updatereport');
                    Route::post('/{survey_id}/add_surveyquestionform', [SurveyQuestionController::class, 'savereport'])->name('savereport');
                    Route::get('/{survey_id}/surveyreportSub', [SurveyQuestionController::class, 'reportpageSubject'])->name('reportpageSubject');



                    Route::get('{subject_id}/category', [CategoryController::class, 'categoryac'])->name('categoryac');
                    Route::get('{subject_id}/categoryform', [CategoryController::class, 'create'])->name('categoryform');
                    Route::post('{subject_id}/categoryform_add', [CategoryController::class, 'store'])->name('categoryform_add');
                    Route::get('{category_id}/categoryform_edit', [CategoryController::class, 'edit'])->name('categoryform_edit');
                    Route::put('{category_id}/categoryform_update', [CategoryController::class, 'update'])->name('categoryform_update');
                    Route::get('{category_id}/categoryform_destroy', [CategoryController::class, 'destroy'])->name('categoryform_destroy');
                    Route::get('/changeStatuCategory', [CategoryController::class, 'changeStatuCategory'])->name('changeStatuCategory');



                    Route::get('/topic/{category_id}', [CategoryTopicController::class, 'topicpage'])->name('topic');
                    Route::get('{topic_id}/topic_destroy', [CategoryTopicController::class, 'destroy'])->name('topic_destroy');
                    Route::get('/changeStatuCategoryTopic', [CategoryTopicController::class, 'changeStatuCategoryTopic'])->name('changeStatuCategoryTopic');
                });


                Route::get('{subject_id}/teacher', [CourseTeacherController::class, 'teacherspage'])->name('teacherspage');
                Route::get('delete_teacher/{teacher_id}', [CourseTeacherController::class, 'destory'])->name('delete_teacher');

                Route::get('updateTeacherStatus', [CourseTeacherController::class, 'update'])->name('TeacherStatus');




                Route::get('{subject_id}/exam', [ExamController::class, 'exampage'])->name('exampage');
                Route::get('{exam_id}/examreport', [ScoreController::class, 'examlogpage'])->name('examlogpage');
                Route::prefix('lms')->group(function () {


                    Route::post('{subject_id}/Questionimport', [ExcelController::class, 'Questionimport'])->name('Questionimport');
  
                    Route::get('{subject_id}/add_examform', [ExamController::class, 'createexam'])->name('add_examform');
                    Route::post('{subject_id}/store_examform', [ExamController::class, 'storeexam'])->name('store_examform');
                    Route::get('edit_examform/{exam_id}', [ExamController::class, 'edit_examform'])->name('edit_examform');
                    Route::put('update_examform/{exam_id}', [ExamController::class, 'update_examform'])->name('update_examform');
                    Route::get('destroy_examform/{exam_id}', [ExamController::class, 'destroyexam'])->name('destroy_examform');

                    Route::get('/changeStatusExam', [ExamController::class, 'changeStatus'])->name('changeStatusExam');




                    Route::get('{subject_id}/pagequess', [ExamController::class, 'pagequess'])->name('pagequess');
                    Route::get('{subject_id}/questionform', [ExamController::class, 'create'])->name('questionform');
                    Route::get('{subject_id}/questionadd', [ExamController::class, 'questionadd'])->name('questionadd');
                    Route::get('edit_question/{question_id}', [ExamController::class, 'edit'])->name('edit_question');
                    Route::put('update_question/{question_id}', [ExamController::class, 'update'])->name('update_question');
                    Route::get('delete_question/{question_id}', [ExamController::class, 'destroy'])->name('delete_question');
                    Route::post('{subject_id}/add_questionform', [ExamController::class, 'store'])->name('add_questionform');
                    Route::get('/queschangeStatus', [ExamController::class, 'queschangeStatus'])->name('queschangeStatus');
                });
                Route::get('/booktable', [BookController::class, 'table'])->name('book.table');
            });

            Route::get('/ums/{role?}', [EditManageUserController::class, 'UserManage'])->name('UserManage')->where('role', '[0-9]+');

            Route::prefix('ums')->group(function () {


                Route::get('/add_umsform', [EditManageUserController::class, 'createUser'])->name('createUser');
                Route::post('/store_umsform', [EditManageUserController::class, 'storeUser'])->name('storeUser');
                Route::get('/ums/{role}', [EditManageUserController::class, 'UserManage'])->name('UserManageByRole');

                Route::get('/edit/{uid}', [EditManageUserController::class, 'edit'])->name('editUser');

                Route::put('/update/{uid}', [EditManageUserController::class, 'update'])->name('updateUser');

                Route::get('/umslogsuser/{uid}', [UserLogController::class, 'logusers'])->name('logusers');

                Route::put('/update-role/{uid}', [EditManageUserController::class, 'updateRoleUser'])->name('updateRoleUser');
                Route::put('/update-password/{uid}', [EditManageUserController::class, 'updatepassword'])->name('updatePassword');



                Route::get('changeStatusUser', [EditManageUserController::class, 'changeStatus'])->name('changeStatusUser');
                Route::get('fetchUsersByDepartment', [EditManageUserController::class, 'fetchUsersByDepartment'])->name('fetchUsersByDepartment');




                Route::get('/umsgroup', [PersonController::class, 'personTypes'])->name('personTypes');
                Route::get('/umsgroupuser/{person_type}', [PersonController::class, 'pageperson'])->name('pageperson');
                Route::put('/update_umsgroupuser/{person_type}', [PersonController::class, 'updateusertype'])->name('updateusertype');

                Route::post('/search', [PersonController::class, 'search'])->name('search');
                Route::post('UsersImport', [ExcelController::class, 'UsersImport'])->name('UsersImport');


                Route::get('/person_delete/{person_type}', [PersonController::class, 'personDelete'])->name('personDelete');
                Route::get('/umsgroupform/{person_type}', [PersonController::class, 'editname'])->name('editperson');
                Route::put('/update_umsgroupform/{person_type}', [PersonController::class, 'update'])->name('updateperson');

                Route::get('/add_umsgroupform', [PersonController::class, 'create'])->name('createperson');
                Route::post('/store_umsgroupform', [PersonController::class, 'store'])->name('storeperson');
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

                Route::post('/get-user-data', [ReportAllController::class, 'getUserData'])->name('get-Uata');
            });
        });
    });
});

Route::get('/logout', [CustomAuthController::class, 'logoutUser'])->name('logout');
