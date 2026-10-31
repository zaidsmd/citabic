<?php

namespace Database\Seeders;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\Certification;
use App\Models\CitabicDomain;
use App\Models\CitabicFigure;
use App\Models\CitabicProcess;
use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use App\Models\CitabicValue;
use App\Models\Mission;
use App\Models\MissionTranslation;
use App\Models\SectionContent;
use Illuminate\Database\Seeder;

class ArabicContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSectionContents();
        $this->seedProfileTranslations();
        $this->seedValuesTranslations();
        $this->seedDomainsTranslations();
        $this->seedFiguresTranslations();
        $this->seedProcessesTranslations();
        $this->seedMissionsTranslations();
        $this->seedReferencesTranslations();
        $this->seedCertificationsTranslations();
    }

    private function seedSectionContents(): void
    {
        $contents = [
            // Our Approach
            [
                'section' => Section::OUR_APPROACH->value,
                'key' => ContentKey::OUR_APPROACH_TITLE->value,
                'value' => 'قطاع يشهد نمواً متسارعاً وتحولاً مستمراً',
            ],
            // Hero
            [
                'section' => Section::HERO->value,
                'key' => ContentKey::HERO_TITLE->value,
                'value' => 'معاً نبني مستقبلكم',
            ],
            [
                'section' => Section::HERO->value,
                'key' => ContentKey::HERO_SUBTITLE->value,
                'value' => 'رؤيتكم ، خبرتنا المتكاملة',
            ],
            // About
            [
                'section' => Section::ABOUT->value,
                'key' => ContentKey::ABOUT_TITLE->value,
                'value' => 'من نحن',
            ],
            [
                'section' => Section::ABOUT->value,
                'key' => ContentKey::ABOUT_SUBTITLE->value,
                'value' => 'نبذة تعريفية',
            ],
            [
                'section' => Section::ABOUT->value,
                'key' => ContentKey::ABOUT_TEXT->value,
                'value' => '<p>تأسست شركة <strong>CITABIC</strong> عام 2021، وهي شركة مقاولات وبناء ديناميكية تعيد ابتكار معايير البناء والترميم والهندسة المدنية من خلال رؤية متطورة. بالاعتماد على خبرة وكفاءة نخبة من المهنيين المؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة (مفتاح في اليد) بأعلى درجات الجودة. يرتكز شعارنا على التميز في الخدمة والإدارة المحكمة، مما يضمن مشاريع تلبي بدقة كافة تطلعاتكم وتوقعاتكم الأكثر تطلباً.</p>',
            ],
            // About Page
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::ABOUT_TITLE->value,
                'value' => 'من نحن',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::ROUNDED_TEXT->value,
                'value' => 'معاً نبني مستقبلكم الواعد !',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::ABOUT_TEXT->value,
                'value' => '<p>تأسست شركة <strong>CITABIC</strong> عام 2021، وهي شركة مقاولات وبناء ديناميكية تعيد ابتكار معايير البناء والترميم والهندسة المدنية من خلال رؤية متطورة. بالاعتماد على خبرة وكفاءة نخبة من المهنيين المؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة (مفتاح في اليد) بأعلى درجات الجودة.</p>',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::MISSION_TITLE->value,
                'value' => 'رسالتنا وأهدافنا',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::MISSION_TEXT->value,
                'value' => 'تبني CITABIC رسالتها على تحقيق الرضا التام لعملائها، وجودة إدارية رصينة، وتنفيذ منضبط عبر مختلف مراحل عملياتها.',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::WHY_US_TITLE->value,
                'value' => 'لماذا تختار CITABIC؟',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::WHY_US_TEXT->value,
                'value' => 'خبرة مقاولات وبناء معتمدة بشهادتي ISO 9001 و 45001، وموجهة نحو الجودة والسلامة والحلول المبتكرة.',
            ],
            [
                'section' => Section::ABOUT_PAGE->value,
                'key' => ContentKey::WHY_US_CARDS->value,
                'value' => 'خبرة شاملة في قطاع البناء;التزام تام بالجودة والسلامة;حلول مخصصة ومبتكرة;فريق عمل محترف ومتمرس;بنية تحتية وتكنولوجيا متطورة',
            ],
            // Domain
            [
                'section' => Section::DOMAIN->value,
                'key' => ContentKey::DOMAIN_TITLE->value,
                'value' => 'تغطية شاملة لكافة مراحل دورة البناء والتشييد.',
            ],
            [
                'section' => Section::DOMAIN->value,
                'key' => ContentKey::DOMAIN_SUBTITLE->value,
                'value' => 'مجالات النشاط',
            ],
            [
                'section' => Section::DOMAIN->value,
                'key' => ContentKey::DOMAIN_TEXT->value,
                'value' => 'تشمل أنشطة CITABIC الهندسة المدنية، وتشييد المباني، والتطوير العقاري، وإدارة وتنسيق المشاريع.',
            ],
            // Projects
            [
                'section' => Section::PROJECTS->value,
                'key' => ContentKey::PROJECTS_SUBTITLE->value,
                'value' => 'مشاريعنا وإنجازاتنا',
            ],
            [
                'section' => Section::PROJECTS->value,
                'key' => ContentKey::PROJECTS_TITLE->value,
                'value' => 'استكشف أحدث مشاريعنا المنجزة',
            ],
            [
                'section' => Section::PROJECTS->value,
                'key' => ContentKey::PROJECTS_TEXT->value,
                'value' => 'نقدم حلولاً هندسية وبنائية متقدمة تغطي القطاعات الصناعية والتجارية والسكنية بأعلى مستويات الإتقان.',
            ],
            // Contact
            [
                'section' => Section::CONTACT->value,
                'key' => ContentKey::CONTACT_TITLE->value,
                'value' => 'تواصل معنا',
            ],
            [
                'section' => Section::CONTACT->value,
                'key' => ContentKey::CONTACT_FORM_TEXT->value,
                'value' => 'تواصل مع CITABIC',
            ],
            // Home & General
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::VALUES_TITLE->value,
                'value' => 'قيمنا الجوهرية',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::VALUES_SUBTITLE->value,
                'value' => 'مبادئنا',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::BLOG_TITLE->value,
                'value' => 'رؤى وتحليلات قطاعية',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::BLOG_SUBTITLE->value,
                'value' => 'الأخبار والمدونة',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::BLOG_TEXT->value,
                'value' => 'يتعاون مهندسونا المعماريون والمدنيون لوضع مخططات تفصيلية تحول الأفكار إلى منشآت متينة وواقعية.',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::META_TITLE->value,
                'value' => 'الرئيسية | مقاولات البناء والهندسة المدنية والعقارات',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::META_DESCRIPTION->value,
                'value' => 'CITABIC تنفذ مشاريع البناء والأشغال العمومية، الهندسة المدنية والتطوير العقاري بأعلى معايير الجودة والسلامة بالمغرب.',
            ],
            [
                'section' => Section::HOME->value,
                'key' => ContentKey::META_KEYWORDS->value,
                'value' => 'citabic, مقاولات, بناء, أشغال عمومية, هندسة مدنية, عقارات, المغرب, طنجة',
            ],
        ];

        foreach ($contents as $item) {
            SectionContent::updateOrCreate(
                [
                    'section' => $item['section'],
                    'key' => $item['key'],
                    'language' => 'ar',
                ],
                [
                    'value' => $item['value'],
                ]
            );
        }
    }

    private function seedProfileTranslations(): void
    {
        $profile = CitabicProfile::first();
        if (! $profile) {
            return;
        }

        $translations = is_array($profile->translations) ? $profile->translations : (json_decode($profile->translations, true) ?? []);

        $translations['ar'] = [
            'company' => [
                'tagline' => 'معاً نبني مستقبلكم !',
                'full_name' => 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارات',
                'legal_form' => 'شركة ذات مسؤولية محدودة ذات الشريك الوحيد',
                'status' => 'في حالة نشاط',
            ],
            'intro' => [
                'CITABIC هي شركة متخصصة في قطاع البناء والأشغال العامة. تُعد سرعة الاستجابة، والخبرة الميدانية، والديناميكية ركائزها الأساسية لمرافقة عملائها في كافة مشاريعهم.',
                'تأسست CITABIC عام 2021 حاملةً رؤية عصرية لقطاع المقاولات والبناء في المغرب من خلال تقديم عروض تسليم متكاملة (مفتاح في اليد) تشمل التشييد، والترميم، والهندسة المدنية، والاستشارات.',
                'تعتمد الشركة على نخب من مهنيي البناء لضمان خدمات عالية الجودة بكل ثقة وطمأنينة، مع التزام صارم بالآجال، والسلامة، والاستدامة.',
            ],
            'market_context' => [
                'النمو الاقتصادي والتوسع العمراني يحفزان الطلب المتزايد على بنية تحتية حديثة ومساكن عالية الجودة في المغرب.',
                'المعايير البيئية وتطلعات المجتمع تفرض حلول بناء بيئية ومستدامة.',
                'الامتثال لمعايير الجودة والسلامة الدولية أمر حيوي لضمان ديمومة المنشآت وقيمتها.',
                'التحكم الدقيق في التكاليف والمواعيد يظل عنصراً حاسماً في ظل المنافسة القوية.',
                'اعتماد أحدث الأدوات التكنولوجية مثل نمذجة معلومات المباني (BIM) ونظم إدارة المؤسسات (ERP) يعزز الدقة والشفافية والكفاءة التشغيلية.',
            ],
            'mission' => [
                'إرضاء العملاء من خلال خدمات بناء وأشغال متكاملة وذات جودة رفيعة.',
                'توفير الخبرات التقنية ونظم الإدارة المتوافقة مع أرقى المعايير الدولية.',
                'تقديم باقة خدمات قياسية وممنهجة لتنفيذ المشاريع بمبدأ التسليم الكامل (مفتاح في اليد).',
                'ضمان الإدارة المثلى واستدامة الإنجازات العمرانية على المدى الطويل.',
            ],
            'values' => [
                ['title' => 'الالتزام', 'text' => 'نفي دائماً بما نعد ونحترم التزاماتنا تجاه عملائنا ومجتمعاتنا وفرق عملنا.'],
                ['title' => 'الجودة', 'text' => 'في كل مرحلة من مراحل الورش، تحرص CITABIC على جودة الأعمال المنجزة من قبل حرفيين وفرق متمرسة.'],
                ['title' => 'الابتكار', 'text' => 'يتطلب كل مشروع حلولاً مصممة خصيصاً. لذلك نسعى لابتكار إجابات تشغيلية ذكية وعالية الأداء.'],
                ['title' => 'الأخلاقيات', 'text' => 'النزاهة، والاحترام المتبادل، والشفافية الكاملة تشكل جوهر علاقاتنا مع جميع الشركاء.'],
                ['title' => 'السلامة', 'text' => 'إدراكاً لأهمية الرهانات الإنسانية والاقتصادية، تطبق CITABIC إجراءات وقائية صارمة في كافة مواقع العمل.'],
                ['title' => 'الموثوقية', 'text' => 'الثقة والصدق والوضوح هي الأساس الذي نبني عليه قراراتنا وممارساتنا اليومية.'],
            ],
            'human_values' => [
                ['title' => 'التعاون الجماعي', 'text' => 'نؤمن بقوة العمل الجماعي وتضافر الجهود المشتركة لبلوغ الأهداف الطموحة.'],
                ['title' => 'الانتماء والتكافل', 'text' => 'نزرع روح الانتماء، والتضامن، والثقة المتبادلة بين جميع أفراد المؤسسة وشركائها.'],
                ['title' => 'الشفافية', 'text' => 'منذ اللقاء الأول، نبني علاقة واضحة ومسار عمل شفاف ومشترك حول المشروع.'],
                ['title' => 'الرفاه في العمل', 'text' => 'نشجع بيئة عمل إيجابية ومحفزة، إيماناً منا بأن سلامة الموظف وسعادته هما سر تفانيه ونجاحه.'],
                ['title' => 'الاحترام المتبادل', 'text' => 'الاحترام المتبادل والثقة يمثلان حجر الزاوية للذكاء الجماعي والأداء المستدام.'],
            ],
            'domains' => [
                [
                    'title' => 'الهندسة المدنية',
                    'items' => [
                        'أشغال البنية التحتية والأساسات',
                        'أشغال الطرق والشبكات المتنوعة (VRD)',
                        'الهياكل والمنشآت ذاتية الدعم',
                        'المنشآت الفنية والجسور',
                        'شبكات التطهير السائل وتصريف المياه',
                        'أعمال التدعيم والتقوية الهيكلية',
                    ],
                ],
                [
                    'title' => 'البناء والتشييد',
                    'items' => [
                        'تسليم المشاريع المتكاملة (مفتاح في اليد)',
                        'المقاولات العامة والإنشاءات الكبرى',
                        'أعمال الهيكل الخرساني والأساسات',
                        'الترميم وإعادة التأهيل الشامل',
                        'التهيئة الخارجية والأرضيات الصناعية والخرسانة المطبوعة',
                        'أشغال الواجهات الحديثة',
                    ],
                ],
                [
                    'title' => 'العقارات وإدارة المشاريع (OPC)',
                    'items' => [
                        'التخطيط والقيادة والتنسيق الميداني (OPC)',
                        'الدراسات والمحاكاة المالية للمشاريع',
                        'اقتناء وتطوير المشاريع العقارية الاستثمارية',
                    ],
                ],
            ],
            'certifications' => [
                'ISO 9001:2015 - نظام إدارة الجودة الشاملة',
                'ISO 45001:2018 - نظام إدارة الصحة والسلامة المهنية',
            ],
            'information_system' => 'طورت CITABIC بنية تحتية رقمية متقدمة تعتمد على نظام Odoo ERP لتحسين إتاحة البيانات، وسريتها، ونزاهتها، مما يعكس نضجاً تنظيمياً وانضباطاً تشغيلياً عالي المستوى.',
            'figures' => [
                ['label' => 'يد عاملة تم توظيفها', 'value' => '1000+'],
                ['label' => 'مساحة مبنية', 'value' => '250 000 م² +'],
                ['label' => 'مطابقة المعايير الدولية', 'value' => '100 %'],
                ['label' => 'موردون مؤهلون', 'value' => '50+'],
                ['label' => 'مهنيون متخصصون', 'value' => '70+'],
                ['label' => 'رقم معاملات تراكمي', 'value' => '65 مليون درهم +'],
                ['label' => 'مشاريع سُلّمت في موعدها', 'value' => '92 %'],
                ['label' => 'شركاء تقنيون وهندسيون', 'value' => '14'],
            ],
            'partnerships' => [
                '5 مهندسين معماريين شركاء مرموقين',
                '5 مكاتب دراسات تقنية وهندسية متخصصة',
                '4 مختبرات معتمدة للتحاليل ومراقبة الجودة',
            ],
            'compliance' => [
                'الفحص الدوري الإجباري للآليات والمعدات (رافعات برجية وآليات تلسكوبية)',
                'شهادات تأهيل وتدريب سائقي الرافعات والآليات الثقيلة',
                'معايرة دورية لأجهزة القياس والتسوية الطبوغرافية',
                'تأمين شامل لجميع أخطار الورش (TRC)، تصريحات CNSS وتأمين حوادث الشغل والمسؤولية المدنية',
                'شهادات الوضعية الجبائية والاجتماعية القانونية (شهادات 1007 و1220)',
            ],
            'organization' => [
                'الإدارة العامة والتطوير الاستراتيجي',
                'إدارة الجودة والسلامة والبيئة (QHS)، واللوجستيات والمشتريات والنقل والصيانة',
                'إدارة العمليات، والدراسات وحساب الكميات، والتنفيذ والمراقبة الميدانية',
                'الإدارة الإدارية والمالية والموارد البشرية',
                'تطوير الأعمال والتنسيق مع الشركاء',
            ],
            'processes' => [
                'إدارة وتقييم المخاطر',
                'القيادة والتوجيه الاستراتيجي',
                'إدارة وضبط أوراش العمل',
                'إدارة وتطوير الموارد البشرية',
                'إدارة الموارد والمعدات اللوجستية',
                'إدارة الأداء والتحسين المستمر',
            ],
            'why_choose_us' => [
                'خبرة هندسية شاملة في البناء والأشغال العامة',
                'التزام صارم بأعلى معايير الجودة والسلامة',
                'حلول مبتكرة ومصممة وفق احتياجات كل مشروع',
                'فريق عمل محترف ومتمرس',
                'بنية تحتية وتجهيزات تكنولوجية متطورة',
            ],
        ];

        $profile->translations = $translations;
        $profile->save();
    }

    private function seedValuesTranslations(): void
    {
        $arabicValues = [
            1 => [
                'title' => 'الالتزام',
                'text' => '<p>نكرس ثقافة الوفاء بما نعد واحترام التزاماتنا تجاه عملائنا ومجتمعاتنا وفرق عملنا.</p>',
            ],
            2 => [
                'title' => 'الجودة',
                'text' => '<p>في كل مرحلة من مراحل الورش، تحرص CITABIC على جودة الأعمال المنجزة من قبل حرفيين وفرق متمرسة.</p>',
            ],
            3 => [
                'title' => 'الابتكار',
                'text' => '<p>يتطلب كل مشروع حلولاً مصممة خصيصاً. لذلك نسعى لابتكار إجابات تشغيلية ذكية وعالية الأداء.</p>',
            ],
            4 => [
                'title' => 'الأخلاقيات',
                'text' => '<p>النزاهة، والاحترام المتبادل، والشفافية الكاملة تشكل جوهر علاقاتنا مع جميع الشركاء.</p>',
            ],
            5 => [
                'title' => 'السلامة',
                'text' => '<p>إدراكاً لأهمية الرهانات الإنسانية والاقتصادية، تطبق CITABIC إجراءات وقائية صارمة في كافة مواقع العمل.</p>',
            ],
            6 => [
                'title' => 'الموثوقية والنزاهة',
                'text' => '<p>الثقة والصدق والوضوح هي الأساس الذي نبني عليه قراراتنا وممارساتنا اليومية.</p>',
            ],
        ];

        foreach ($arabicValues as $id => $data) {
            $value = CitabicValue::find($id);
            if ($value) {
                $translations = is_array($value->translations) ? $value->translations : [];
                $translations['ar'] = $data;
                $value->translations = $translations;
                $value->save();
            }
        }
    }

    private function seedDomainsTranslations(): void
    {
        $arabicDomains = [
            1 => [
                'title' => 'الهندسة المدنية',
                'items' => [
                    'أشغال البنية التحتية والأساسات',
                    'أشغال الطرق والشبكات المتنوعة (VRD)',
                    'الهياكل والمنشآت ذاتية الدعم',
                    'المنشآت الفنية والجسور',
                    'شبكات التطهير السائل وتصريف المياه',
                    'أعمال التدعيم والتقوية الهيكلية',
                ],
            ],
            2 => [
                'title' => 'البناء والتشييد',
                'items' => [
                    'تسليم المشاريع المتكاملة (مفتاح في اليد)',
                    'المقاولات العامة والإنشاءات الكبرى',
                    'أعمال الهيكل الخرساني والأساسات',
                    'الترميم وإعادة التأهيل الشامل',
                    'التهيئة الخارجية والأرضيات الصناعية والخرسانة المطبوعة',
                    'أشغال الواجهات الحديثة',
                ],
            ],
            3 => [
                'title' => 'العقارات وإدارة المشاريع (OPC)',
                'items' => [
                    'التخطيط والقيادة والتنسيق الميداني (OPC)',
                    'الدراسات والمحاكاة المالية للمشاريع',
                    'اقتناء وتطوير المشاريع العقارية الاستثمارية',
                ],
            ],
        ];

        foreach ($arabicDomains as $id => $data) {
            $domain = CitabicDomain::find($id);
            if ($domain) {
                $translations = is_array($domain->translations) ? $domain->translations : [];
                $translations['ar'] = $data;
                $domain->translations = $translations;
                $domain->save();
            }
        }
    }

    private function seedFiguresTranslations(): void
    {
        $arabicFigures = [
            1 => 'رقم معاملات تراكمي',
            2 => 'إجمالي الكفاءات واليد العاملة',
            3 => 'إجمالي المساحة المبنية',
            4 => 'احترام الآجال ومواعيد التسليم',
            5 => 'مطابقة المعايير والمواصفات',
            6 => 'موردون وشركاء موثوقون',
            7 => 'فريق عمل متخصص ومتفانٍ',
        ];

        foreach ($arabicFigures as $id => $label) {
            $figure = CitabicFigure::find($id);
            if ($figure) {
                $translations = is_array($figure->translations) ? $figure->translations : [];
                $translations['ar'] = [
                    'label' => $label,
                    'value' => $figure->value,
                ];
                $figure->translations = $translations;
                $figure->save();
            }
        }
    }

    private function seedProcessesTranslations(): void
    {
        $arabicProcesses = [
            1 => ['title' => 'إدارة المخاطر', 'description' => 'تحديد وتحليل وتدبير المخاطر لضمان سلامة وسير المشاريع.'],
            2 => ['title' => 'القيادة والتوجيه الاستراتيجي', 'description' => 'رؤية واضحة وقيادة ديناميكية لتحقيق أهداف التميز.'],
            3 => ['title' => 'إدارة وضبط أوراش العمل', 'description' => 'تتبع دقيق ويومي لكافة مراحل التنفيذ في الموقع.'],
            4 => ['title' => 'إدارة الموارد البشرية', 'description' => 'تأهيل وتطوير مهارات الكفاءات والفرق الميدانية.'],
            5 => ['title' => 'إدارة المعدات اللوجستية', 'description' => 'صيانة وتشغيل أحدث الآليات والمعدات المعتمدة.'],
            6 => ['title' => 'إدارة الأداء والتحسين المستمر', 'description' => 'قياس دوري للمؤشرات والارتقاء المستمر بمستوى الجودة.'],
        ];

        foreach ($arabicProcesses as $id => $data) {
            $process = CitabicProcess::find($id);
            if ($process) {
                $translations = is_array($process->translations) ? $process->translations : [];
                $translations['ar'] = $data;
                $process->translations = $translations;
                $process->save();
            }
        }
    }

    private function seedMissionsTranslations(): void
    {
        $arabicMissions = [
            1 => [
                'title' => 'التميز التشغيلي',
                'description' => 'تقديم خدمات بناء وأشغال متكاملة تلبي أعلى متطلبات وتطلعات العملاء بدقة وإتقان.',
            ],
            2 => [
                'title' => 'المعايير الدولية',
                'description' => 'تطبيق نظم إدارة وخبرات هندسية متوافقة مع أرقى المعايير العالمية في الجودة والسلامة.',
            ],
            3 => [
                'title' => 'حلول تسليم متكاملة (مفتاح في اليد)',
                'description' => 'مجموعة خدمات شاملة وممنهجة تغطي كافة مراحل المشروع من التخطيط حتى التسليم النهائي.',
            ],
            4 => [
                'title' => 'الإدارة الفعالة والاستدامة',
                'description' => 'ضمان جودة التدبير والتحكم في الموارد لضمان ديمومة واستمرارية المشاريع العمرانية.',
            ],
        ];

        foreach ($arabicMissions as $id => $data) {
            $mission = Mission::find($id);
            if ($mission) {
                MissionTranslation::updateOrCreate(
                    [
                        'mission_id' => $mission->id,
                        'locale' => 'ar',
                    ],
                    [
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ]
                );
            }
        }
    }

    private function seedReferencesTranslations(): void
    {
        $arabicReferences = [
            'unite-industrielle' => [
                'title' => 'تشييد وحدة صناعية لإنتاج الزليج والبلاط الديكوري التقليدي',
                'client' => 'PJLP ش.م.م',
                'summary' => 'بناء وحدة صناعية مخصصة لصناعة وإنتاج الزليج الديكوري التقليدي.',
                'description' => 'رافقت CITABIC إنجاز هذه الوحدة الصناعية المتكاملة ضمن مجمع صناعي عريق مقره في طنجة.',
            ],
            'unite-industrielle-pjlp' => [
                'title' => 'تشييد وحدة صناعية لإنتاج الزليج الديكوري التقليدي',
                'client' => 'PJLP ش.م.م',
                'summary' => 'بناء وحدة صناعية مخصصة لصناعة وإنتاج البلاط والزليج الديكوري.',
                'description' => 'رافقت CITABIC إنجاز هذه الوحدة الصناعية المتكاملة في طنجة.',
            ],
            'riad-ajdir' => [
                'title' => 'المجمع السكني رياض أجدير',
                'client' => 'مشروع سكني بالحسيمة',
                'summary' => 'مشروع سكني بالقرب من المركز الاستشفائي الإقليمي وشواطئ السواني وصفيحة.',
                'description' => 'شقق راقية من غرفتين إلى ثلاث غرف نوم مع كافة المرافق والخدمات المصممة لرفاهية السكان.',
            ],
            'entree-immeuble-r10-tanger' => [
                'title' => 'إعادة تهيئة وتجديد المدخل الرئيسي لعمارة من 10 طوابق',
                'client' => 'عمارة بوسط مدينة طنجة',
                'summary' => 'تحويل وتحديث المدخل الرئيسي لإضفاء مظهر عصري وراقٍ.',
                'description' => 'تحديث شامل للواجهة والأرضيات والإنارة وشبكات الصرف والكهرباء.',
            ],
            'renforcement-immeuble-almaghreb-al-arabi' => [
                'title' => 'تجديد وتقوية وهيكلة عمارة سفلية + طابق أرضي + 9 طوابق',
                'client' => 'المغرب العربي',
                'summary' => 'معالجة وتقوية العناصر الهيكلية الخرسانية وفق دراسات تقنية معتمدة.',
                'description' => 'قامت CITABIC بإصلاح وتقوية الأعمدة والجدران الحاملة لتأمين سلامة المبنى وديمومته.',
            ],
            'opc-almisk-building' => [
                'title' => 'التخطيط والقيادة والتنسيق الميداني (OPC) مع ALMISK BUILDING',
                'client' => 'ALMISK BUILDING',
                'summary' => 'مهمة إدارة وتنسيق تضمن نجاح إنجاز المشروع في أفضل الظروف.',
                'description' => 'تحليل الموقع، جدولة المهام، التنسيق بين مكاتب الدراسات والمختبرات والمقاولين لضمان احترام الميزانية والآجال.',
            ],
        ];

        foreach ($arabicReferences as $slug => $data) {
            $reference = CitabicReference::where('slug', $slug)->first();
            if ($reference) {
                $translations = is_array($reference->translations) ? $reference->translations : [];
                $translations['ar'] = $data;
                $reference->translations = $translations;
                $reference->save();
            }
        }
    }

    private function seedCertificationsTranslations(): void
    {
        $arabicCerts = [
            'certifie-iso-9001-v-2015' => [
                'name' => 'معتمد ISO 9001 إصدار 2015',
                'description' => 'نظام إدارة الجودة الشاملة',
                'image' => 'certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg',
            ],
            'certifie-iso-45001-v-2018' => [
                'name' => 'معتمد ISO 45001 إصدار 2018',
                'description' => 'نظام إدارة الصحة والسلامة المهنية',
                'image' => 'certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg',
            ],
        ];

        foreach ($arabicCerts as $slug => $data) {
            Certification::updateOrCreate(
                [
                    'slug' => $slug,
                    'language' => 'ar',
                ],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'image' => $data['image'],
                ]
            );
        }
    }
}
