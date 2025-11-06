Multi-Language Blog – Laravel 11
<p align="center"> <a href="https://laravel.com" target="_blank"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"> </a> </p>
📖 About the Project | حول المشروع

Multi-Language Blog هو نظام مدونة متعددة اللغات مبني على Laravel 11.
يتيح إدارة المقالات، الأقسام (الرئيسية والفرعية)، والمستخدمين من خلال لوحة تحكم (Dashboard) احترافية.
كما يدعم المشروع تعدد اللغات (العربية – الإنجليزية – الفرنسية)، مع واجهة موقع عامة (Website) وواجهة API لتكامل البيانات.

✨ Features | المميزات

🌍 دعم ثلاث لغات (عربية، إنجليزية، فرنسية) باستخدام mcamara/laravel-localization.

🧭 لوحة تحكم متكاملة لإدارة:

🏷️ الأقسام والفروع الفرعية

📰 المقالات

👤 المستخدمين والصلاحيات

⚙️ إعدادات الموقع

💬 نظام ترجمة للنماذج باستخدام astrotomic/laravel-translatable.

📊 جداول تفاعلية باستخدام yajra/laravel-datatables.

🔐 تسجيل الدخول وحماية عبر laravel/sanctum.

🧩 RESTful API لربط المدونة مع تطبيقات خارجية.

🎨 واجهة أمامية بتصميم Bootstrap 4.

🛠️ مراقبة وتحليل الأداء باستخدام laravel/telescope.

🧱 نظام تصنيفات متداخل (أقسام رئيسية وفرعية).

🧰 Tech Stack | تقنيات المشروع
المكون	التقنية
Backend	Laravel 11
Frontend	Blade + Bootstrap 4
Database	MySQL
Authentication	Laravel Sanctum
Localization	Laravel Localization
DataTables	yajra/laravel-datatables
Debugging	Laravel Telescope / Debugbar
⚙️ Installation | التثبيت والتشغيل
# 1️⃣ استنسخ المشروع
git clone https://github.com/yourusername/multilang-blog.git

# 2️⃣ ادخل إلى مجلد المشروع
cd multilang-blog

# 3️⃣ ثبّت الاعتمادات
composer install
npm install && npm run dev

# 4️⃣ انسخ ملف البيئة
cp .env.example .env

# 5️⃣ حدّث إعدادات قاعدة البيانات في .env
DB_CONNECTION=mysql
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=

# 6️⃣ شغّل الهجرات مع البيانات الافتراضية
php artisan migrate --seed

# 7️⃣ أنشئ مفتاح التشفير
php artisan key:generate

# 8️⃣ شغّل السيرفر المحلي
php artisan serve

🗺️ Routes Overview | نظرة على المسارات
🌐 Website Routes
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/categories/{category}', [WebsiteCategoryController::class, 'show'])->name('category');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post');

🧭 Dashboard Routes (Multilingual)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', cheack_login::class]], function () {
        Route::get('/', fn() => view('dashboard.layout.layout'))->name('index');

        Route::resources([
            'users' => UserController::class,
            'settings' => SettingController::class,
            'category' => CategoryController::class,
            'posts' => PostsController::class,
        ]);

        Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
        Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');
    });
});

🌐 API Endpoints
Method	Endpoint	الوصف
GET	/api/posts	جلب جميع المقالات
GET	/api/posts/{id}	عرض مقال محدد
POST	/api/posts	إنشاء مقال جديد
PUT	/api/posts/{id}	تعديل مقال
DELETE	/api/posts/{id}	حذف مقال
GET	/api/categories	جلب الأقسام
POST	/api/login	تسجيل الدخول
🧑‍💻 Dashboard | لوحة التحكم

توفر لوحة التحكم إدارة شاملة لجميع أجزاء الموقع:

إدارة المقالات.

إدارة الأقسام والفروع.

إدارة المستخدمين.

الإعدادات العامة.

دعم تعدد اللغات في كل المحتوى.

🛡️ Security | الأمان

حماية من CSRF وXSS.

توثيق باستخدام Laravel Sanctum.

صلاحيات دخول محددة لكل مستخدم.

📜 License | الرخصة

المشروع مفتوح المصدر تحت رخصة MIT
.

🤝 Contributing | المساهمة

نرحب بمساهماتكم لتحسين المشروع ❤️
قم بعمل fork ثم pull request للتعديل أو إضافة ميزة جديدة.
