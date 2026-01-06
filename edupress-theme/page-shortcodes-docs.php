<?php
/**
 * Template Name: Shortcodes Documentation
 * Description: Complete documentation for all EduPress shortcodes
 *
 * @package EduPress
 */

get_header();
?>

<style>
.shortcodes-docs {
    padding: 4rem 0;
    background: #f8fafc;
}

.shortcode-section {
    background: #fff;
    border-radius: 1rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.shortcode-section h2 {
    color: #2563eb;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 3px solid #e2e8f0;
    font-size: 2rem;
}

.shortcode-item {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.shortcode-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.shortcode-title {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.shortcode-code {
    background: #1e293b;
    color: #22d3ee;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    font-family: 'Courier New', monospace;
    margin: 1rem 0;
    direction: ltr;
    text-align: left;
    overflow-x: auto;
}

.shortcode-params {
    background: #f1f5f9;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.shortcode-params h4 {
    color: #475569;
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.param-item {
    margin-bottom: 0.75rem;
    padding: 0.5rem;
}

.param-name {
    color: #2563eb;
    font-weight: 700;
    font-family: monospace;
}

.param-default {
    color: #64748b;
    font-size: 0.875rem;
    font-style: italic;
}

.shortcode-example {
    background: #ecfdf5;
    border-right: 4px solid #10b981;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.shortcode-example h4 {
    color: #059669;
    margin-bottom: 1rem;
}

.example-code {
    background: #064e3b;
    color: #6ee7b7;
    padding: 1rem;
    border-radius: 0.5rem;
    font-family: 'Courier New', monospace;
    margin: 0.5rem 0;
    direction: ltr;
    text-align: left;
    overflow-x: auto;
}

.table-of-contents {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: #fff;
    padding: 2.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
}

.table-of-contents h2 {
    color: #fff;
    border: none;
    margin-bottom: 1.5rem;
}

.table-of-contents ul {
    list-style: none;
    padding: 0;
}

.table-of-contents li {
    margin-bottom: 0.75rem;
}

.table-of-contents a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0.9;
    transition: opacity 0.3s;
}

.table-of-contents a:hover {
    opacity: 1;
}

.docs-intro {
    text-align: center;
    margin-bottom: 3rem;
}

.docs-intro h1 {
    font-size: 3rem;
    color: #1e293b;
    margin-bottom: 1rem;
}

.docs-intro p {
    font-size: 1.25rem;
    color: #64748b;
}
</style>

<section class="shortcodes-docs">
    <div class="container">
        <!-- Introduction -->
        <div class="docs-intro">
            <h1>📖 دليل الـ Shortcodes</h1>
            <p>جميع الـ Shortcodes المتاحة في ثيم EduPress مع أمثلة الاستخدام</p>
        </div>

        <!-- Table of Contents -->
        <div class="table-of-contents">
            <h2><i class="fas fa-list"></i> المحتويات</h2>
            <ul>
                <li><a href="#account-shortcodes"><i class="fas fa-user"></i> Shortcodes الحساب الشخصي</a></li>
                <li><a href="#courses-shortcodes"><i class="fas fa-graduation-cap"></i> Shortcodes الكورسات</a></li>
                <li><a href="#instructors-shortcodes"><i class="fas fa-chalkboard-teacher"></i> Shortcodes المدربين</a></li>
                <li><a href="#stats-shortcodes"><i class="fas fa-chart-line"></i> Shortcodes الإحصائيات</a></li>
                <li><a href="#ui-shortcodes"><i class="fas fa-palette"></i> Shortcodes واجهة المستخدم</a></li>
            </ul>
        </div>

        <!-- Account Shortcodes -->
        <div class="shortcode-section" id="account-shortcodes">
            <h2><i class="fas fa-user"></i> Shortcodes الحساب الشخصي</h2>

            <!-- My Account -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">لوحة تحكم المستخدم</h3>
                <div class="shortcode-code">[edupress_my_account]</div>
                <p>يعرض لوحة تحكم شاملة للمستخدم تحتوي على إحصائيات الكورسات والتقدم.</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_my_account]</div>
                </div>
            </div>

            <!-- Profile -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">ملف المستخدم الشخصي</h3>
                <div class="shortcode-code">[edupress_profile]</div>
                <p>يعرض معلومات الملف الشخصي للمستخدم.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">user_id</span> - معرف المستخدم
                        <span class="param-default">(افتراضي: المستخدم الحالي)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_profile]</div>
                    <div class="example-code">[edupress_profile user_id="5"]</div>
                </div>
            </div>

            <!-- Logout -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">زر تسجيل الخروج</h3>
                <div class="shortcode-code">[edupress_logout text="نص الزر" redirect="رابط التحويل"]</div>
                <p>يعرض زر لتسجيل خروج المستخدم.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">text</span> - نص الزر
                        <span class="param-default">(افتراضي: "تسجيل الخروج")</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">redirect</span> - صفحة التحويل بعد الخروج
                        <span class="param-default">(افتراضي: الصفحة الرئيسية)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_logout]</div>
                    <div class="example-code">[edupress_logout text="خروج" redirect="/"]</div>
                </div>
            </div>

            <!-- Login Form -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">نموذج تسجيل الدخول</h3>
                <div class="shortcode-code">[edupress_login_form]</div>
                <p>يعرض نموذج تسجيل دخول WordPress الافتراضي.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">redirect</span> - صفحة التحويل بعد الدخول
                        <span class="param-default">(افتراضي: الصفحة الحالية)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_login_form]</div>
                    <div class="example-code">[edupress_login_form redirect="/my-courses"]</div>
                </div>
            </div>
        </div>

        <!-- Courses Shortcodes -->
        <div class="shortcode-section" id="courses-shortcodes">
            <h2><i class="fas fa-graduation-cap"></i> Shortcodes الكورسات</h2>

            <!-- Courses Grid -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">عرض الكورسات</h3>
                <div class="shortcode-code">[edupress_courses number="6" columns="3" category="" level="" orderby="date" order="DESC"]</div>
                <p>يعرض شبكة من الكورسات مع إمكانية التصفية والترتيب.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">number</span> - عدد الكورسات
                        <span class="param-default">(افتراضي: 6)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">columns</span> - عدد الأعمدة
                        <span class="param-default">(افتراضي: 3)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">category</span> - slug التصنيف
                        <span class="param-default">(افتراضي: الكل)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">level</span> - slug المستوى
                        <span class="param-default">(افتراضي: الكل)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">orderby</span> - الترتيب حسب (date, title, rand)
                        <span class="param-default">(افتراضي: date)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">order</span> - اتجاه الترتيب (ASC, DESC)
                        <span class="param-default">(افتراضي: DESC)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_courses]</div>
                    <div class="example-code">[edupress_courses number="9" columns="3"]</div>
                    <div class="example-code">[edupress_courses category="programming" level="beginner"]</div>
                    <div class="example-code">[edupress_courses orderby="rand" number="6"]</div>
                </div>
            </div>

            <!-- My Courses -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">كورساتي</h3>
                <div class="shortcode-code">[edupress_my_courses]</div>
                <p>يعرض قائمة بالكورسات المسجل فيها المستخدم الحالي مع شريط التقدم.</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_my_courses]</div>
                </div>
            </div>

            <!-- Course Progress -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">شريط تقدم الكورس</h3>
                <div class="shortcode-code">[edupress_course_progress course_id="123"]</div>
                <p>يعرض شريط التقدم لكورس معين.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">course_id</span> - معرف الكورس
                        <span class="param-default">(مطلوب)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_course_progress course_id="42"]</div>
                </div>
            </div>

            <!-- Search Form -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">نموذج البحث عن الكورسات</h3>
                <div class="shortcode-code">[edupress_search]</div>
                <p>يعرض نموذج بحث مخصص للكورسات.</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_search]</div>
                </div>
            </div>
        </div>

        <!-- Instructors Shortcodes -->
        <div class="shortcode-section" id="instructors-shortcodes">
            <h2><i class="fas fa-chalkboard-teacher"></i> Shortcodes المدربين</h2>

            <!-- Instructors Grid -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">عرض المدربين</h3>
                <div class="shortcode-code">[edupress_instructors number="6" columns="3" orderby="date" order="DESC"]</div>
                <p>يعرض شبكة من المدربين.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">number</span> - عدد المدربين
                        <span class="param-default">(افتراضي: 6)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">columns</span> - عدد الأعمدة
                        <span class="param-default">(افتراضي: 3)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">orderby</span> - الترتيب حسب (date, title, rand)
                        <span class="param-default">(افتراضي: date)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">order</span> - اتجاه الترتيب (ASC, DESC)
                        <span class="param-default">(افتراضي: DESC)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_instructors]</div>
                    <div class="example-code">[edupress_instructors number="8" columns="4"]</div>
                    <div class="example-code">[edupress_instructors orderby="rand" number="3"]</div>
                </div>
            </div>
        </div>

        <!-- Stats Shortcodes -->
        <div class="shortcode-section" id="stats-shortcodes">
            <h2><i class="fas fa-chart-line"></i> Shortcodes الإحصائيات</h2>

            <!-- Stats -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">عرض الإحصائيات</h3>
                <div class="shortcode-code">[edupress_stats]</div>
                <p>يعرض إحصائيات الموقع (عدد الكورسات، الطلاب، المدربين، وغيرها).</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_stats]</div>
                </div>
            </div>
        </div>

        <!-- UI Shortcodes -->
        <div class="shortcode-section" id="ui-shortcodes">
            <h2><i class="fas fa-palette"></i> Shortcodes واجهة المستخدم</h2>

            <!-- Button -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">زر مخصص</h3>
                <div class="shortcode-code">[edupress_button text="نص الزر" url="#" style="primary" icon="fas fa-arrow-left"]</div>
                <p>يعرض زر مخصص بتصميم احترافي.</p>

                <div class="shortcode-params">
                    <h4>المعاملات:</h4>
                    <div class="param-item">
                        <span class="param-name">text</span> - نص الزر
                        <span class="param-default">(افتراضي: "اضغط هنا")</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">url</span> - رابط الزر
                        <span class="param-default">(افتراضي: #)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">style</span> - نمط الزر (primary, secondary, outline)
                        <span class="param-default">(افتراضي: primary)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">icon</span> - أيقونة FontAwesome
                        <span class="param-default">(اختياري)</span>
                    </div>
                    <div class="param-item">
                        <span class="param-name">target</span> - فتح في نافذة جديدة (_blank)
                        <span class="param-default">(اختياري)</span>
                    </div>
                </div>

                <div class="shortcode-example">
                    <h4>أمثلة:</h4>
                    <div class="example-code">[edupress_button text="ابدأ الآن" url="/courses"]</div>
                    <div class="example-code">[edupress_button text="تواصل معنا" url="/contact" style="secondary" icon="fas fa-envelope"]</div>
                    <div class="example-code">[edupress_button text="زيارة الموقع" url="https://example.com" target="_blank" icon="fas fa-external-link-alt"]</div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">معلومات الاتصال</h3>
                <div class="shortcode-code">[edupress_contact_info]</div>
                <p>يعرض معلومات الاتصال المحفوظة في إعدادات الثيم.</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_contact_info]</div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="shortcode-item">
                <h3 class="shortcode-title">روابط السوشيال ميديا</h3>
                <div class="shortcode-code">[edupress_social_links]</div>
                <p>يعرض أيقونات روابط وسائل التواصل الاجتماعي المحفوظة في إعدادات الثيم.</p>

                <div class="shortcode-example">
                    <h4>مثال:</h4>
                    <div class="example-code">[edupress_social_links]</div>
                </div>
            </div>
        </div>

        <!-- Usage Tips -->
        <div class="shortcode-section">
            <h2><i class="fas fa-lightbulb"></i> نصائح الاستخدام</h2>

            <div style="background: #fef3c7; border-right: 4px solid #f59e0b; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <h3 style="color: #92400e; margin-bottom: 1rem;"><i class="fas fa-info-circle"></i> كيفية الاستخدام</h3>
                <ol style="color: #78350f;">
                    <li style="margin-bottom: 0.5rem;">انسخ الـ shortcode المطلوب من الأمثلة أعلاه</li>
                    <li style="margin-bottom: 0.5rem;">الصق الكود في محرر الصفحة أو المقال</li>
                    <li style="margin-bottom: 0.5rem;">عدّل المعاملات حسب احتياجك</li>
                    <li style="margin-bottom: 0.5rem;">احفظ ثم عاين الصفحة</li>
                </ol>
            </div>

            <div style="background: #dbeafe; border-right: 4px solid #2563eb; padding: 1.5rem; border-radius: 0.5rem;">
                <h3 style="color: #1e3a8a; margin-bottom: 1rem;"><i class="fas fa-graduation-cap"></i> ملاحظات مهمة</h3>
                <ul style="color: #1e40af;">
                    <li style="margin-bottom: 0.5rem;">يمكن استخدام الـ shortcodes في الصفحات والمقالات والـ widgets</li>
                    <li style="margin-bottom: 0.5rem;">بعض الـ shortcodes تتطلب تسجيل دخول المستخدم</li>
                    <li style="margin-bottom: 0.5rem;">يمكن الجمع بين عدة shortcodes في نفس الصفحة</li>
                    <li style="margin-bottom: 0.5rem;">المعاملات الاختيارية يمكن حذفها لاستخدام القيم الافتراضية</li>
                </ul>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>
