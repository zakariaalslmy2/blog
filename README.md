📰 Multi-Language Blog – Laravel 11

📖 About the Project | حول المشروع
مرحبًا بك في توثيق نظام المدونة متعددة اللغات (Multi-Language Blog) المبني باستخدام Laravel 11.
يُقدم هذا المشروع نظام مدونة احترافي يدعم ثلاث لغات (العربية – الإنجليزية – الفرنسية)، مع لوحة تحكم (Dashboard) لإدارة المقالات، الأقسام، والمستخدمين، إضافة إلى واجهة موقع عامة (Website) ونظام API متكامل.

Multi-Language Blog هو نظام مدونة متعددة اللغات مبني على Laravel 11.
يتيح إدارة المقالات، الأقسام (الرئيسية والفرعية)، والمستخدمين من خلال لوحة تحكم (Dashboard) احترافية.
كما يدعم المشروع تعدد اللغات (العربية – الإنجليزية – الفرنسية)، مع واجهة موقع عامة (Website) وواجهة API لتكامل البيانات


🧩 المميزات (Features)

🌍 دعم ثلاث لغات (العربية، الإنجليزية، الفرنسية) باستخدام حزمة mcamara/laravel-localization.

🧭 لوحة تحكم متكاملة لإدارة:

🏷️ الأقسام والفروع الفرعية

📰 المقالات

👤 المستخدمين والصلاحيات

⚙️ إعدادات الموقع العامة

💬 نظام ترجمة للنماذج باستخدام astrotomic/laravel-translatable.

📊 جداول تفاعلية عبر yajra/laravel-datatables.

🔐 تسجيل الدخول وحماية متقدمة عبر laravel/sanctum.

🧩 نقاط نهاية RESTful API لتكامل البيانات مع تطبيقات خارجية.

🎨 واجهة أمامية حديثة باستخدام Bootstrap 4.

🛠️ مراقبة وتحليل الأداء عبر laravel/telescope.

🧱 نظام تصنيفات متداخل (أقسام رئيسية وفرعية)..

| المكون             | التقنية                      |
| ------------------ | ---------------------------- |
| **Backend**        | Laravel 11                   |
| **Frontend**       | Blade + Bootstrap 4          |
| **Database**       | MySQL                        |
| **Authentication** | Laravel Sanctum              |
| **Localization**   | Laravel Localization         |
| **DataTables**     | yajra/laravel-datatables     |
| **Debugging**      | Laravel Telescope / Debugbar |

⚙️ الإعداد والتشغيل (Setup and Installation)

للبدء باستخدام المشروع، اتبع الخطوات التالية:

1️⃣ استنسخ المستودع:

git clone https://github.com/yourusername/multilang-blog.git


2️⃣ ادخل إلى مجلد المشروع:

cd multilang-blog


3️⃣ ثبّت الاعتمادات:

composer install
npm install && npm run dev


4️⃣ انسخ ملف البيئة:

cp .env.example .env


5️⃣ حدّث إعدادات قاعدة البيانات في .env:

DB_CONNECTION=mysql
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=


6️⃣ شغّل الهجرات مع البيانات الافتراضية:

php artisan migrate --seed


7️⃣ أنشئ مفتاح التشفير:

php artisan key:generate


8️⃣ شغّل السيرفر المحلي:

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

🌐 واجهات الـ API (API Endpoints)
| الطريقة    | المسار            | الوصف             |
| ---------- | ----------------- | ----------------- |
| **GET**    | `/api/posts`      | جلب جميع المقالات |
| **GET**    | `/api/posts/{id}` | عرض مقال محدد     |
| **POST**   | `/api/posts`      | إنشاء مقال جديد   |
| **PUT**    | `/api/posts/{id}` | تعديل مقال        |
| **DELETE** | `/api/posts/{id}` | حذف مقال          |
| **GET**    | `/api/categories` | جلب الأقسام       |
| **POST**   | `/api/login`      | تسجيل الدخول      |


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
