<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to seed and enrich Arabic translations for production data.
     */
    public function up(): void
    {
        DB::transaction(function () {
            $now = now();

            // 1. SECTION CONTENTS (Arabic rows)
            if (Schema::hasTable('section_contents')) {
                $sectionContents = [
                    // Hero
                    ['section' => 'hero', 'key' => 'hero_title', 'value' => 'معاً، نبني مستقبلكم', 'language' => 'ar'],
                    ['section' => 'hero', 'key' => 'hero_subtitle', 'value' => 'رؤيتكم، خبرتنا', 'language' => 'ar'],

                    // Our Approach
                    ['section' => 'our_approach', 'key' => 'our_approach_title', 'value' => 'قطاع يشهد نمواً متسارعاً وتحولاً مستمراً', 'language' => 'ar'],

                    // About
                    ['section' => 'about', 'key' => 'about_title', 'value' => 'نبذة عن CITABIC', 'language' => 'ar'],
                    ['section' => 'about', 'key' => 'about_subtitle', 'value' => 'من نحن', 'language' => 'ar'],
                    ['section' => 'about', 'key' => 'about_text', 'value' => '<p>تأسست شركة <strong>CITABIC</strong> في عام 2021، وهي شركة ديناميكية في قطاع البناء والأشغال العامة تعيد ابتكار معايير البناء والتجديد والهندسة المدنية من خلال مفهوم مبتكر. بالاعتماد على خبرة وكفاءة مهنيين مؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة ومفتاحية بأعلى مستويات الجودة. يرتكز نهجنا على التميز في الخدمة والإدارة المحكمة، مما يضمن إنجاز مشاريع تلبي بدقة أكثر المتطلبات تطلباً.</p>', 'language' => 'ar'],

                    // About Page
                    ['section' => 'about_page', 'key' => 'about_title', 'value' => 'نبذة عن CITABIC', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'about_text', 'value' => '<p>تأسست شركة <strong>CITABIC</strong> في عام 2021، وهي شركة ديناميكية في قطاع البناء والأشغال العامة تعيد ابتكار معايير البناء والتجديد والهندسة المدنية من خلال مفهوم مبتكر. بالاعتماد على خبرة وكفاءة مهنيين مؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة ومفتاحية بأعلى مستويات الجودة. يرتكز نهجنا على التميز في الخدمة والإدارة المحكمة، مما يضمن إنجاز مشاريع تلبي بدقة أكثر المتطلبات تطلباً.</p>', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'rounded_text', 'value' => 'خبرة وجودة • ثقة ودقة •', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'mission_title', 'value' => 'مهمتنا', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'mission_text', 'value' => '<p>تتمحور مهمة <strong>CITABIC</strong> حول تحقيق رضا العملاء، وجودة الإدارة، والتنفيذ المنظم لجميع مراحل العمليات والأنشطة.</p>', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'why_us_title', 'value' => 'لماذا تختار CITABIC؟', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'why_us_text', 'value' => '<p>خبرة معتمدة في قطاع البناء وفق معايير <strong>ISO 9001 و 45001</strong>. تقدم فرقنا حلولاً مبتكرة ومخصصة، تضمن السلامة والشفافية (ERP) والاستدامة لكل مشروع، مع الالتزام الصارم بمتطلباتكم.</p>', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'why_us_cards', 'value' => 'خبرة شاملة في قطاع البناء والأشغال العامة;الالتزام بالجودة والسلامة;حلول مخصصة ومبتكرة;فريق من المهنيين ذوي الخبرة العالية;بنية تحتية وتكنولوجيا متطورة', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'organigrame_title', 'value' => 'الهيكل التنظيمي', 'language' => 'ar'],
                    ['section' => 'about_page', 'key' => 'cartographie_title', 'value' => 'خريطة عمليات CITABIC', 'language' => 'ar'],

                    // Contact
                    ['section' => 'contact', 'key' => 'contact_title', 'value' => 'اتصل بنا', 'language' => 'ar'],
                    ['section' => 'contact', 'key' => 'contact_form_text', 'value' => 'تواصل مع CITABIC', 'language' => 'ar'],

                    // Domain
                    ['section' => 'domain', 'key' => 'domain_title', 'value' => 'تغطية شاملة لكافة مراحل دورة البناء والأشغال العامة.', 'language' => 'ar'],
                    ['section' => 'domain', 'key' => 'domain_subtitle', 'value' => 'مجالات الأنشطة', 'language' => 'ar'],
                    ['section' => 'domain', 'key' => 'domain_text', 'value' => '<p>تغطي أنشطة CITABIC الهندسة المدنية، البناء، التطوير العقاري، ومهام التنسيق والإشراف على المشاريع.</p>', 'language' => 'ar'],

                    // Why Choose Us
                    ['section' => 'why_choose_us', 'key' => 'why_title', 'value' => 'حيث تلتقي الرؤية بالبناء والإنجاز.', 'language' => 'ar'],
                    ['section' => 'why_choose_us', 'key' => 'why_subtitle', 'value' => 'لماذا تختارنا', 'language' => 'ar'],
                    ['section' => 'why_choose_us', 'key' => 'why_text', 'value' => 'خبرة في البناء معتمدة بشهادات ISO 9001 و 45001. توفر فرقنا حلولاً مبتكرة ومخصصة تضمن الأمان والشفافية (ERP) والاستدامة لكل مشاريعكم، مع الامتثال الدقيق لمعاييركم.', 'language' => 'ar'],
                    ['section' => 'why_choose_us', 'key' => 'why_features', 'value' => json_encode([
                        ['title' => 'خبرة شاملة في قطاع البناء', 'text' => 'تحكم كامل في جميع جوانب البناء والأشغال العامة، من الهندسة المدنية إلى التسليم على المفتاح، مروراً بالتجديد والتهيئة الخارجية.'],
                        ['title' => 'الالتزام بالجودة والسلامة', 'text' => 'معايير عالية تضمنها شهادات ISO 9001 و ISO 45001، مما يضمن الجودة والأمان الأمثل في جميع مواقع العمل.'],
                        ['title' => 'حلول مخصصة ومبتكرة', 'text' => 'نهج مصمم خصيصاً يتكيف مع خصوصيات كل مشروع ويدمج حلولاً مبتكرة لتحقيق نتائج فعالة ومستدامة.'],
                        ['title' => 'فريق من المهنيين ذوي الخبرة', 'text' => 'خبراء مؤهلون وملتزمون في خدمتكم لضمان سير المشاريع بسلاسة مع احترام الآجال والميزانيات.'],
                        ['title' => 'بنية تحتية وتكنولوجيا متطورة', 'text' => 'إدارة متطورة بفضل نظام ERP المتقدم، مما يوفر شفافية وكفاءة معززة في كل مرحلة من مراحل خدماتنا.'],
                    ], JSON_UNESCAPED_UNICODE), 'language' => 'ar'],

                    // Projects
                    ['section' => 'projects', 'key' => 'projects_subtitle', 'value' => 'مشاريعنا', 'language' => 'ar'],
                    ['section' => 'projects', 'key' => 'projects_title', 'value' => 'اكتشف أحدث مشاريعنا', 'language' => 'ar'],
                    ['section' => 'projects', 'key' => 'projects_text', 'value' => '<p>يشمل البناء التجاري والصناعي تصميم وتطوير وتشييد المنشآت المخصصة للشركات والمؤسسات.</p>', 'language' => 'ar'],

                    // Home blog & values
                    ['section' => 'home', 'key' => 'blog_subtitle', 'value' => 'الأخبار والمدونة', 'language' => 'ar'],
                    ['section' => 'home', 'key' => 'blog_title', 'value' => 'اكتشف رؤانا ومقالاتنا', 'language' => 'ar'],
                    ['section' => 'home', 'key' => 'blog_text', 'value' => '<p>يشمل قطاع البناء التجاري والصناعي تصميم وتطوير وتشييد البنى التحتية الاستراتيجية الموجهة لدعم كفاءة وأداء الشركات.</p>', 'language' => 'ar'],
                    ['section' => 'home', 'key' => 'values_subtitle', 'value' => 'قيمنا', 'language' => 'ar'],
                    ['section' => 'home', 'key' => 'values_title', 'value' => 'المبادئ التي نلتزم بها', 'language' => 'ar'],
                ];

                foreach ($sectionContents as $item) {
                    DB::table('section_contents')->updateOrInsert(
                        ['section' => $item['section'], 'key' => $item['key'], 'language' => $item['language']],
                        ['value' => $item['value'], 'updated_at' => $now]
                    );
                }
            }

            // 2. MISSION TRANSLATIONS
            if (Schema::hasTable('mission_translations') && Schema::hasTable('missions')) {
                $missionTranslations = [
                    1 => [
                        'title' => 'التميز التشغيلي',
                        'description' => 'ضمان رضا عملائنا من خلال تقديم خدمات بناء وأشغال عامة عالية الجودة وخدمات متكاملة مصممة حسب الطلب.',
                    ],
                    2 => [
                        'title' => 'المعايير الدولية',
                        'description' => 'خبرة معتمدة وأنظمة إدارة محكمة مطبقة في جميع مستويات مؤسستنا.',
                    ],
                    3 => [
                        'title' => 'حلول متكاملة (مفتاح في اليد)',
                        'description' => 'مجموعة شاملة من الأنشطة (الهندسة المدنية، الواجهات، أعمال متنوعة) توفر تكاملاً مثالياً لمشاريعكم.',
                    ],
                    4 => [
                        'title' => 'الإدارة والاستدامة',
                        'description' => 'إدارة مشاريع مثالية تضمن استدامة وقوة جميع منشآتنا وإنجازاتنا.',
                    ],
                ];

                foreach ($missionTranslations as $missionId => $trans) {
                    if (DB::table('missions')->where('id', $missionId)->exists()) {
                        DB::table('mission_translations')->updateOrInsert(
                            ['mission_id' => $missionId, 'locale' => 'ar'],
                            [
                                'title' => $trans['title'],
                                'description' => $trans['description'],
                                'updated_at' => $now,
                            ]
                        );
                    }
                }
            }

            // 3. CERTIFICATIONS
            if (Schema::hasTable('certifications')) {
                $certifications = [
                    [
                        'slug' => 'certifie-iso-9001-v-2015',
                        'name' => 'معتمد ISO 9001 إصدار 2015',
                        'language' => 'ar',
                        'description' => 'نظام إدارة الجودة',
                        'image' => 'certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg',
                    ],
                    [
                        'slug' => 'certifie-iso-45001-v-2018',
                        'name' => 'معتمد ISO 45001 إصدار 2018',
                        'language' => 'ar',
                        'description' => 'نظام إدارة الصحة والسلامة المهنية',
                        'image' => 'certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg',
                    ],
                ];

                foreach ($certifications as $cert) {
                    DB::table('certifications')->updateOrInsert(
                        ['slug' => $cert['slug'], 'language' => $cert['language']],
                        [
                            'name' => $cert['name'],
                            'description' => $cert['description'],
                            'image' => $cert['image'],
                            'updated_at' => $now,
                        ]
                    );
                }
            }

            // 4. CITABIC DOMAINS
            if (Schema::hasTable('citabic_domains')) {
                $domainTranslations = [
                    1 => [
                        'title' => 'الهندسة المدنية',
                        'items' => ['أشغال البنية التحتية', 'شبكات الصرف الصحي والتطهير (VRD)', 'المنشآت ذاتية الدعم', 'المنشآت الفنية والجسور', 'التطهير الصحي', 'تدعيم وتقوية الهياكل الإنشائية'],
                    ],
                    2 => [
                        'title' => 'البناء والتشييد',
                        'items' => ['مشاريع تسليم مفتاح', 'المقاولات العامة', 'الهياكل الخرسانية والأشغال الكبرى', 'التجديد والتحويل', 'التهيئة الخارجية (أرضيات صناعية، خرسانة مطبوعة...)', 'أشغال الواجهات'],
                    ],
                    3 => [
                        'title' => 'التطوير العقاري',
                        'items' => ['البرمجة والجدولة، القيادة والتنسيق (OPC)', 'المحاكاة والدراسات المالية', 'اقتناء وتطوير المشاريع العقارية'],
                    ],
                ];

                foreach ($domainTranslations as $id => $arData) {
                    $record = DB::table('citabic_domains')->where('id', $id)->first();
                    if ($record) {
                        $existing = json_decode($record->translations ?? '{}', true) ?: [];
                        $existing['ar'] = $arData;
                        DB::table('citabic_domains')->where('id', $id)->update([
                            'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // 5. CITABIC FIGURES
            if (Schema::hasTable('citabic_figures')) {
                $figureLabels = [
                    1 => 'رقم المعاملات التراكمي',
                    2 => 'إجمالي الكفاءات العاملة',
                    3 => 'إجمالي المساحة المشيدة',
                    4 => 'الالتزام بالمواعيد والآجال',
                    5 => 'الامتثال للمعايير والمواصفات',
                    6 => 'موردون موثوقون',
                    7 => 'فريق عمل متخصص',
                ];

                foreach ($figureLabels as $id => $labelAr) {
                    $record = DB::table('citabic_figures')->where('id', $id)->first();
                    if ($record) {
                        $existing = json_decode($record->translations ?? '{}', true) ?: [];
                        $existing['ar'] = array_merge($existing['ar'] ?? [], ['label' => $labelAr]);
                        DB::table('citabic_figures')->where('id', $id)->update([
                            'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // 6. CITABIC PROCESSES
            if (Schema::hasTable('citabic_processes')) {
                $processTranslations = [
                    1 => [
                        'ar' => ['title' => 'إدارة المخاطر', 'description' => 'إرضاء العملاء من خلال تقديم خدمات بناء وتشييد متكاملة وعالية الجودة.'],
                        'en' => ['title' => 'Risk Management', 'description' => 'Satisfying clients through high-quality construction and integrated services.'],
                    ],
                    2 => [
                        'ar' => ['title' => 'الإدارة والتوجيه', 'description' => 'توفير الخبرة وأنظمة الإدارة المتوافقة مع أرقى المعايير الدولية.'],
                        'en' => ['title' => 'Management & Direction', 'description' => 'Providing expertise and management systems aligned with international standards.'],
                    ],
                    3 => [
                        'ar' => ['title' => 'إدارة الورش والمواقع', 'description' => 'تقديم مجموعة أنشطة قياسية ومنهجية ضمن رؤية تسليم المفتاح.'],
                        'en' => ['title' => 'Site Management', 'description' => 'Offering a standardized and systematic range of activities for a turnkey approach.'],
                    ],
                    4 => [
                        'ar' => ['title' => 'إدارة الموارد البشرية', 'description' => 'ضمان جودة تدبير مثلى واستدامة المشاريع والمنجزات.'],
                        'en' => ['title' => 'Human Resources Management', 'description' => 'Ensuring optimal management quality and project durability.'],
                    ],
                    5 => [
                        'ar' => ['title' => 'إدارة العتاد واللوجستيك', 'description' => 'توفير المعدات والآليات الحديثة وضمان صيانتها الفعالة لدعم الإنتاجية.'],
                        'en' => ['title' => 'Equipment & Logistics Management', 'description' => 'Providing modern machinery and maintenance to guarantee site continuity and efficiency.'],
                    ],
                    6 => [
                        'ar' => ['title' => 'إدارة الأداء والتحسين المستمر', 'description' => 'متابعة مؤشرات الجودة والأداء بانتظام والارتقاء المستمر بمستوى الخدمات.'],
                        'en' => ['title' => 'Performance Management & Continuous Improvement', 'description' => 'Continuous monitoring of KPIs and refining methodologies to enhance service quality.'],
                    ],
                ];

                foreach ($processTranslations as $id => $t) {
                    $record = DB::table('citabic_processes')->where('id', $id)->first();
                    if ($record) {
                        $existing = json_decode($record->translations ?? '{}', true) ?: [];
                        $existing['ar'] = $t['ar'];
                        if (! isset($existing['en'])) {
                            $existing['en'] = $t['en'];
                        }
                        DB::table('citabic_processes')->where('id', $id)->update([
                            'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // 7. CITABIC VALUES
            if (Schema::hasTable('citabic_values')) {
                $valueTranslations = [
                    1 => ['title' => 'الالتزام', 'text' => '<p>نتبنى ثقافة نقرن فيها القول بالعمل، ونفي بالتزاماتنا تجاه عملائنا ومجتمعنا وفريق عملنا.</p>'],
                    2 => ['title' => 'الجودة', 'text' => '<p>في كل مرحلة من مراحل مشروعكم، تسهر سيتابيك (CITABIC) على ضمان جودة الأعمال المنفذة بواسطة مهنيينا ذوي الخبرة العالية.</p>'],
                    3 => ['title' => 'الابتكار', 'text' => '<p>نؤمن بأن كل مشروع فريد ويتطلب حلولاً مصممة خصيصاً. نبذل قصارى جهدنا لتقديم الحلول التشغيلية الأكثر ابتكاراً لعملائنا.</p>'],
                    4 => ['title' => 'الأخلاقيات المهنية', 'text' => '<p>احترام الأخلاقيات المهنية هو أساس أنشطتنا. نسترشد بمبادئ راسخة تضمن العدالة والاحترام والشفافية الكاملة مع جميع الشركاء.</p>'],
                    5 => ['title' => 'السلامة', 'text' => '<p>إدراكاً منا للأهمية الإنسانية والاقتصادية المرتبطة بالسلامة، نلتزم بالمبادئ الأساسية للوقاية والأمان في جميع مواقع مشاريعنا.</p>'],
                    6 => ['title' => 'النزاهة', 'text' => '<p>تستند أنشطتنا وعلاقاتنا المهنية إلى الثقة والصدق والوضوح. نفي بوعودنا ونحرص دائماً على التصرف بأعلى درجات المسؤولية.</p>'],
                ];

                foreach ($valueTranslations as $id => $arData) {
                    $record = DB::table('citabic_values')->where('id', $id)->first();
                    if ($record) {
                        $existing = json_decode($record->translations ?? '{}', true) ?: [];
                        $existing['ar'] = $arData;
                        DB::table('citabic_values')->where('id', $id)->update([
                            'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // 8. CITABIC INFOS
            if (Schema::hasTable('citabic_infos')) {
                $infoArabicMap = [
                    162 => 'تعتبر سيتابيك (CITABIC) شركة يرتكز نشاطها الأساسي على قطاع البناء والأشغال العامة. تتسم خدماتها بالاستجابة السريعة والخبرة الميدانية والديناميكية العالية في مرافقة عملائها عبر كافة مراحل مشاريعهم.',
                    163 => 'تأسست الشركة سنة 2021 لتقدم مفهوماً جديداً في قطاع البناء بالسوق المغربي، من خلال عروض متكاملة مفتاح في اليد تشمل البناء، والتجديد، والهندسة المدنية، والاستشارة الهندسية.',
                    164 => 'تعتمد الشركة على نخبة من المهنيين ذوي الكفاءة العالية لتقديم خدمات متميزة تضمن راحة البال، وانضباطاً صارماً في التنفيذ، وأعلى المعايير في احترام الآجال والسلامة والاستدامة.',
                    165 => 'يواصل النمو الاقتصادي والتوسع العمراني في المغرب دفع الطلب المتزايد على البنى التحتية الحديثة والسكن عالي الجودة.',
                    166 => 'تفرض المعايير البيئية والتطلعات المجتمعية تبني حلول بناء مستدامة وصديقة للبيئة.',
                    167 => 'ضرورة امتثال المشاريع للمعايير الدولية للجودة والسلامة لضمان القيمة طويلة الأمد للأصول العقارية.',
                    168 => 'يظل التحكم في التكاليف والالتزام بالجداول الزمنية أمراً حاسماً في سوق يتسم بالتنافسية العالية.',
                    169 => 'أصبحت الأدوات الرقمية المتقدمة مثل نمذجة معلومات المباني (BIM) ونظام إدارة الموارد (ERP) ضرورية لتعزيز الدقة والشفافية وكفاءة التسليم.',
                    170 => 'تقديم خدمات بناء وأشغال عامة عالية الجودة ومرافقة متكاملة تضمن الرضا التام لعملائنا.',
                    171 => 'توفير خبرة وأنظمة تدبير وإدارة متوافقة مع أرقى المعايير الدولية في جميع مستويات المؤسسة.',
                    172 => 'اقتراح مجموعة أنشطة معيارية ومنهجية لنموذج إنجاز متكامل (مفتاح في اليد).',
                    173 => 'ضمان جودة تدبير صارمة للمشاريع واستدامة متميزة لجميع المنشآت.',
                    174 => 'ISO 9001:2015 - نظام إدارة الجودة',
                    175 => 'ISO 45001:2018 - نظام إدارة الصحة والسلامة المهنية',
                    176 => '5 مكاتب هندسة معمارية شريكة ومرموقة',
                    177 => '5 مكاتب دراسات تقنية متخصصة',
                    178 => '4 مختبرات معتمدة للتحاليل ومراقبة الجودة',
                    179 => 'الفحص الدوري والتقني للعتاد بما في ذلك الرافعات البرجية والرافعات التلسكوبية',
                    180 => 'شهادات تأهيل وتدريب سائقي ومشغلي الرافعات الشوكية والآليات',
                    181 => 'معايرة وضبط أدوات القياس وأجهزة التسوية الطوبوغرافية',
                    182 => 'تأمين شامل لكافة أخطار الورش (TRC)، التصريح لدى الضمان الاجتماعي (CNSS)، وتغطية حوادث الشغل والمسؤولية المدنية',
                    183 => 'شهادات الانتظام الضريبي والضمان الاجتماعي بما فيها شواهد 1007 و 1220',
                    184 => 'الإدارة العامة والتطوير الاستراتيجي',
                    185 => 'إدارة الجودة والسلامة والبيئة (QHS)، واللوجستيك، والمشتريات، والنقل والصيانة',
                    186 => 'إدارة العمليات، والدراسات وحساب الكميات، وتتبع ومراقبة الأوراش',
                    187 => 'الإدارة المالية والإدارية، وتدبير الموارد البشرية والمالية',
                    188 => 'تطوير الأعمال والتنسيق مع الشركاء',
                    189 => 'خبرة شاملة في قطاع البناء والأشغال العامة',
                    190 => 'الالتزام بالجودة والسلامة المهنية',
                    191 => 'حلول مبتكرة ومصممة حسب الطلب',
                    192 => 'فريق متكامل من المهنيين ذوي الكفاءة العالية',
                    193 => 'بنية تحتية وتكنولوجيا متطورة',
                ];

                foreach ($infoArabicMap as $id => $textAr) {
                    $record = DB::table('citabic_infos')->where('id', $id)->first();
                    if ($record) {
                        $existing = json_decode($record->translations ?? '{}', true) ?: [];
                        $existing['ar'] = $textAr;
                        DB::table('citabic_infos')->where('id', $id)->update([
                            'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // 9. CITABIC PROFILES
            if (Schema::hasTable('citabic_profiles')) {
                $profile = DB::table('citabic_profiles')->where('id', 1)->first();
                if ($profile) {
                    $existing = json_decode($profile->translations ?? '{}', true) ?: [];
                    $existing['ar'] = [
                        'tagline' => 'معاً، نبني مستقبلكم!',
                        'full_name' => 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة',
                        'legal_form' => 'شركة ذات مسؤولية محدودة بشريك وحيد (SARL AU)',
                        'status' => 'في نشاط مستمر',
                        'head_office' => '26 زنقة الأندلس، عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة',
                        'intro' => "تعتبر سيتابيك (CITABIC) شركة يرتكز نشاطها الأساسي على قطاع البناء والأشغال العامة. تتسم خدماتها بالاستجابة السريعة والخبرة الميدانية والديناميكية العالية في مرافقة عملائها عبر كافة مراحل مشاريعهم.\r\nتأسست الشركة سنة 2021 لتقدم مفهوماً جديداً في قطاع البناء بالسوق المغربي، من خلال عروض متكاملة مفتاح في اليد تشمل البناء، والتجديد، والهندسة المدنية، والاستشارة الهندسية.\r\nتعتمد الشركة على نخبة من المهنيين ذوي الكفاءة العالية لتقديم خدمات متميزة تضمن راحة البال، وانضباطاً صارماً في التنفيذ، وأعلى المعايير في احترام الآجال والسلامة والاستدامة.",
                        'mission' => "تقديم خدمات بناء وأشغال عامة عالية الجودة ومرافقة متكاملة تضمن الرضا التام لعملائنا.\r\nتوفير خبرة وأنظمة تدبير وإدارة متوافقة مع أرقى المعايير الدولية في جميع مستويات المؤسسة.\r\nاقتراح مجموعة أنشطة معيارية ومنهجية لنموذج إنجاز متكامل (مفتاح في اليد).\r\nضمان جودة تدبير صارمة للمشاريع واستدامة متميزة لجميع المنشآت.",
                        'compliance' => "الفحص الدوري والتقني للعتاد بما في ذلك الرافعات البرجية والرافعات التلسكوبية\r\nشهادات تأهيل وتدريب سائقي ومشغلي الرافعات الشوكية والآليات\r\nمعايرة وضبط أدوات القياس وأجهزة التسوية الطوبوغرافية\r\nتأمين شامل لكافة أخطار الورش (TRC)، التصريح لدى الضمان الاجتماعي (CNSS)، وتغطية حوادث الشغل والمسؤولية المدنية\r\nشهادات الانتظام الضريبي والضمان الاجتماعي بما فيها شواهد 1007 و 1220",
                        'organization' => "الإدارة العامة والتطوير الاستراتيجي\r\nإدارة الجودة والسلامة والبيئة (QHS)، واللوجستيك، والمشتريات، والنقل والصيانة\r\nإدارة العمليات، والدراسات وحساب الكميات، وتتبع ومراقبة الأوراش\r\nالإدارة المالية والإدارية، وتدبير الموارد البشرية والمالية\r\nتطوير الأعمال والتنسيق مع الشركاء",
                        'partnerships' => "5 مكاتب هندسة معمارية شريكة ومرموقة\r\n5 مكاتب دراسات تقنية متخصصة\r\n4 مختبرات معتمدة للتحاليل ومراقبة الجودة",
                        'why_choose_us' => "خبرة شاملة في قطاع البناء والأشغال العامة\r\nالالتزام بالجودة والسلامة المهنية\r\nحلول مبتكرة ومصممة حسب الطلب\r\nفريق متكامل من المهنيين ذوي الكفاءة العالية\r\nبنية تحتية وتكنولوجيا متطورة",
                        'certifications' => "ISO 9001:2015 - نظام إدارة الجودة\r\nISO 45001:2018 - نظام إدارة الصحة والسلامة المهنية",
                        'market_context' => "يواصل النمو الاقتصادي والتوسع العمراني في المغرب دفع الطلب المتزايد على البنى التحتية الحديثة والسكن عالي الجودة.\r\nتفرض المعايير البيئية والتطلعات المجتمعية تبني حلول بناء مستدامة وصديقة للبيئة.\r\nضرورة امتثال المشاريع للمعايير الدولية للجودة والسلامة لضمان القيمة طويلة الأمد للأصول العقارية.\r\nيظل التحكم في التكاليف والالتزام بالجداول الزمنية أمراً حاسماً في سوق يتسم بالتنافسية العالية.\r\nأصبحت الأدوات الرقمية المتقدمة مثل نمذجة معلومات المباني (BIM) ونظام إدارة الموارد (ERP) ضرورية لتعزيز الدقة والشفافية وكفاءة التسليم.",
                        'information_system' => 'اعتمدت CITABIC بنية تحتية معلوماتية متطورة مدعومة بنظام ERP (Odoo) لتحسين جاهزية وسرية ونزاهة البيانات. تعكس هذه الهندسة نضجها التنظيمي وانضباطها المهني العالي.',
                        'company' => [
                            'tagline' => 'معاً، نبني مستقبلكم!',
                            'full_name' => 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة',
                            'legal_form' => 'شركة ذات مسؤولية محدودة بشريك وحيد (SARL AU)',
                            'status' => 'في نشاط مستمر',
                            'head_office' => '26 زنقة الأندلس، عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة',
                        ],
                    ];

                    DB::table('citabic_profiles')->where('id', 1)->update([
                        'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                        'updated_at' => $now,
                    ]);
                }
            }

            // 10. CITABIC REFERENCES
            if (Schema::hasTable('citabic_references')) {
                $reference = DB::table('citabic_references')->where('id', 6)->first();
                if ($reference) {
                    $existing = json_decode($reference->translations ?? '{}', true) ?: [];
                    $existing['ar'] = [
                        'title' => 'بناء وحدة صناعية لإنتاج بلاط الديكور التقليدي',
                        'summary' => '<p>شركة PJLP SARL AU هي شركة متخصصة في إنتاج وتصنيع وتسويق البلاط التزييني بمختلف الأشكال والمواد. تأسست على يد مؤسس MOSAIC Factory، وهي جزء من مجموعة صناعية أنشئت سنة 2002 في طنجة، متخصصة في صناعة البلاط والألواح وعناصر الأثاث من المواد المعدنية الطبيعية.</p>',
                        'description' => '<p>شركة PJLP SARL AU هي شركة متخصصة في إنتاج وتصنيع وتسويق البلاط التزييني بمختلف الأشكال والمواد. تأسست على يد مؤسس MOSAIC Factory، وهي جزء من مجموعة صناعية أنشئت سنة 2002 في طنجة، متخصصة في صناعة البلاط والألواح وعناصر الأثاث من المواد المعدنية الطبيعية.</p>',
                        'items' => [],
                    ];

                    $blocks = json_decode($reference->blocks ?? '[]', true);
                    if (is_array($blocks) && ! empty($blocks)) {
                        foreach ($blocks as &$b) {
                            if (! is_array($b)) continue;
                            if (($b['type'] ?? '') === 'heading') {
                                $b['content_ar'] = 'بناء وحدة صناعية لإنتاج بلاط الديكور التقليدي';
                            } elseif (($b['type'] ?? '') === 'text') {
                                $b['content_ar'] = '<p>شركة PJLP SARL AU هي شركة متخصصة في إنتاج وتصنيع وتسويق البلاط التزييني بمختلف الأشكال والمواد. تأسست على يد مؤسس MOSAIC Factory، وهي جزء من مجموعة صناعية أنشئت سنة 2002 في طنجة، متخصصة في صناعة البلاط والألواح وعناصر الأثاث من المواد المعدنية الطبيعية.</p>';
                            } elseif (($b['type'] ?? '') === 'subheading') {
                                $b['content_ar'] = 'الإنجازات والأشغال المنفذة';
                            } elseif (($b['type'] ?? '') === 'list') {
                                $b['content_ar'] = "إنجاز الهيكل الخرساني مع تغطية ذاتية الدعم بمدى يبلغ 36 متراً\nإنجاز أسقف خرسانية مسبقة الإجهاد بألواح مجوفة D.A.S (12*1.2)\nإنجاز هيكل حديدي كلاسيكي متكامل\nإنجاز أسقف من الخرسانة والهوردي بالروافد المزدوجة\nإنجاز أشغال التشطيب والأشغال الثانوية (جميع التخصصات T.C.E)\nإنجاز أرضيات صناعية، والتهيئة الخارجية، وأشغال العزل المائي، وشبكات الصرف الصحي تحت الأرضيات، وخدمات متنوعة";
                            }
                        }
                        unset($b);
                    }

                    DB::table('citabic_references')->where('id', 6)->update([
                        'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                        'blocks' => is_array($blocks) ? json_encode($blocks, JSON_UNESCAPED_UNICODE) : $reference->blocks,
                        'updated_at' => $now,
                    ]);
                }
            }

            // 11. BLOG POSTS
            if (Schema::hasTable('posts')) {
                $post = DB::table('posts')->where('id', 2)->first();
                if ($post) {
                    $existing = json_decode($post->translations ?? '{}', true) ?: [];
                    $existing['ar'] = [
                        'title' => 'المغرب: ورش بناء مفتوح نحو أفق 2030',
                        'excerpt' => 'يشهد قطاع البناء والأشغال العامة في المغرب طفرة كبرى مع كأس إفريقيا 2025 وكأس العالم 2030، مع استثمارات تفوق 140 مليار درهم. ورش مستقبلي يمثل 6% من الناتج المحلي الإجمالي و10% من فرص الشغل.',
                        'meta_title' => 'قطاع البناء في المغرب: أفق 2030 وازدهار القطاع | CITABIC',
                        'meta_description' => 'اكتشف كيف تدفع استضافة كأس إفريقيا 2025 ومونديال 2030 قطاع البناء في المغرب، مع استثمارات تفوق 140 مليار درهم وخبرة سيتابيك المعتمدة.',
                    ];

                    $blocks = json_decode($post->blocks ?? '[]', true);
                    if (is_array($blocks) && ! empty($blocks)) {
                        foreach ($blocks as &$b) {
                            if (! is_array($b)) continue;
                            $type = $b['type'] ?? '';
                            if ($type === 'paragraph' && str_contains($b['content'] ?? '', 'm&eacute;tamorphose')) {
                                $b['content_ar'] = '<p>يعيش قطاع البناء والأشغال العامة في المغرب تحولاً تاريخياً شاملاً. مدعوماً برؤية ملكية سامية واستحقاقات دولية كبرى، لم تعد المملكة تكتفي ببناء المنشآت فقط، بل تصنع مستقبل أمة بأكملها.</p>';
                            } elseif ($type === 'quote') {
                                $b['content_ar'] = 'المغرب لا يستعد لاستقبال العالم فحسب، بل يتحول ليمنح مواطنيه إطار حياة متوافقاً مع أعلى المعايير الدولية.';
                            } elseif ($type === 'subheading' && str_contains($b['content'] ?? '', '1. L’Ambition')) {
                                $b['content_ar'] = '1. الطموح الرياضي: رافعة لتسريع البنى التحتية';
                            } elseif ($type === 'paragraph' && str_contains($b['content'] ?? '', 'CAN 2025')) {
                                $b['content_ar'] = "<p>إن استضافة كأس إفريقيا للأمم 2025 والاشتراك في تنظيم كأس العالم 2030 ليست مجرد تظاهرات رياضية، بل هي محفزات استراتيجية للتنمية والتطوير الشامل.</p>\n<p>من طنجة إلى أكادير، يتجاوز تأهيل وتطوير الملاعب مجرد مباريات كرة القدم؛ إنه خلق أقطاب حياة وثقافة وترفيه متصلة، تتطلب دقة تقنية وسرعة تنفيذ تجعل من الخبرة المعتمدة مفتاح النجاح.</p>";
                            } elseif ($type === 'subheading' && str_contains($b['content'] ?? '', '2. Modernisation')) {
                                $b['content_ar'] = '2. التحديث المتكامل: أبعد من مجرد الخرسانة';
                            } elseif ($type === 'paragraph' && str_contains($b['content'] ?? '', '140 milliards')) {
                                $b['content_ar'] = '<p>ترتكز التنمية في المغرب على رؤية شاملة. ومع استثمارات ضخمة تتجاوز 140 مليار درهم بحلول 2025، تطلق المملكة مشاريع استراتيجية مهيكلة:</p>';
                            } elseif ($type === 'list') {
                                $b['items_ar'] = [
                                    'التنقل: توسيع شبكة القطار فائق السرعة (TGV) وخطوط الترامواي.',
                                    'السيادة المائية والطاقية: بناء محطات تحلية مياه البحر والمجمعات الشمسية.',
                                    'اللوجستيك: توسعة الموانئ والمطارات لضمان ربط قاري ودولي متميز.',
                                ];
                            }
                        }
                        unset($b);
                    }

                    DB::table('posts')->where('id', 2)->update([
                        'translations' => json_encode($existing, JSON_UNESCAPED_UNICODE),
                        'blocks' => is_array($blocks) ? json_encode($blocks, JSON_UNESCAPED_UNICODE) : $post->blocks,
                        'updated_at' => $now,
                    ]);
                }
            }

            // 12. COMPANY INFOS
            if (Schema::hasTable('company_infos')) {
                $companyInfos = [
                    ['key' => 'full_name', 'value' => 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة'],
                    ['key' => 'legal_name', 'value' => 'سيتابيك'],
                    ['key' => 'status', 'value' => 'نشط'],
                    ['key' => 'legal_form', 'value' => 'شركة ذات مسؤولية محدودة بشريك وحيد'],
                    ['key' => 'address', 'value' => 'عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة'],
                ];

                foreach ($companyInfos as $ci) {
                    DB::table('company_infos')->updateOrInsert(
                        ['key' => $ci['key'], 'lang' => 'ar'],
                        ['value' => $ci['value'], 'updated_at' => $now]
                    );
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('section_contents')) {
            DB::table('section_contents')->where('language', 'ar')->delete();
        }

        if (Schema::hasTable('mission_translations')) {
            DB::table('mission_translations')->where('locale', 'ar')->delete();
        }

        if (Schema::hasTable('certifications')) {
            DB::table('certifications')->where('language', 'ar')->delete();
        }

        if (Schema::hasTable('company_infos')) {
            DB::table('company_infos')->where('lang', 'ar')->delete();
        }
    }
};
