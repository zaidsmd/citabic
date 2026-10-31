<?php

namespace Database\Seeders;

use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use Illuminate\Database\Seeder;

class CitabicSeeder extends Seeder
{
    public function run(): void
    {
        $data = config('citabic');
        $company = $data['company'];
        $profileTranslations = $this->profileTranslations();
        $referenceTranslations = $this->referenceTranslations();

        CitabicProfile::query()->updateOrCreate(
            ['name' => $company['name']],
            [
                'tagline' => $company['tagline'],
                'full_name' => $company['full_name'],
                'legal_name' => $company['legal_name'],
                'legal_form' => $company['legal_form'],
                'capital' => $company['capital'],
                'head_office' => $company['head_office'],
                'ice' => $company['ice'],
                'company_created_at' => $company['created_at'],
                'rc' => $company['rc'],
                'status' => $company['status'],
                'phone' => $company['phone'],
                'email' => $company['email'],
                'hero_video_path' => 'guest/assets/video/citabic-hero.mp4',
                'intro' => $data['intro'],
                'market_context' => $data['market_context'],
                'mission' => $data['mission'],
                'values' => $data['values'],
                'human_values' => $data['human_values'],
                'domains' => $data['domains'],
                'certifications' => $data['certifications'],
                'information_system' => $data['information_system'],
                'figures' => $data['figures'],
                'partnerships' => $data['partnerships'],
                'compliance' => $data['compliance'],
                'organization' => $data['organization'],
                'processes' => $data['processes'],
                'why_choose_us' => $data['why_choose_us'],
                'translations' => $profileTranslations,
            ]
        );

        foreach ($data['references'] as $index => $reference) {
            CitabicReference::query()->updateOrCreate(
                ['slug' => $reference['slug']],
                [
                    'title' => $reference['title'],
                    'client' => $reference['client'],
                    'image' => $reference['image'] ?? null,
                    'summary' => $reference['summary'],
                    'description' => $reference['description'],
                    'surface' => $reference['surface'] ?? null,
                    'budget' => $reference['budget'] ?? null,
                    'items' => $reference['items'],
                    'translations' => $referenceTranslations[$reference['slug']] ?? [],
                    'sort_order' => $index + 1,
                ]
            );
        }
    }

    private function profileTranslations(): array
    {
        return [
            'ar' => [
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
            ],
            'en' => [
                'company' => [
                    'tagline' => 'Together we build your future!',
                    'full_name' => 'International Company for Development Works - Building, Real Estate and Consulting',
                    'legal_form' => 'Single-member limited liability company',
                    'status' => 'Active',
                ],
                'intro' => [
                    'CITABIC is a company whose core business is construction and public works. Responsiveness, experience and dynamism define the way it supports clients across their projects.',
                    'Founded in 2021, CITABIC brings a new construction concept to the Moroccan market through a turnkey offer covering construction, renovation, civil engineering and consulting.',
                    'The company relies on experienced building professionals to deliver quality services with peace of mind, strong execution discipline, and high standards for deadlines, safety and long-term durability.',
                ],
                'market_context' => [
                    'Economic growth and urbanization continue to drive demand for modern infrastructure and quality housing in Morocco.',
                    'Environmental standards and social expectations require sustainable construction solutions.',
                    'Projects must comply with international quality and safety standards to ensure long-term asset value.',
                    'Cost and schedule control remains essential in a highly competitive market.',
                    'Advanced tools such as BIM and ERP systems are becoming critical for accuracy, transparency and delivery efficiency.',
                ],
                'mission' => [
                    'Deliver high-quality construction services and integrated support that fully satisfy clients.',
                    'Provide expertise and management systems aligned with international standards across every level of the organization.',
                    'Offer a standardized and systematic range of activities for a turnkey delivery model.',
                    'Guarantee strong project management quality and long-lasting project durability.',
                ],
                'values' => [
                    ['title' => 'Commitment', 'text' => 'We do what we say and honor our commitments to clients, communities and teams.'],
                    ['title' => 'Quality', 'text' => 'At every stage of a project, CITABIC verifies the quality of work carried out by experienced trades.'],
                    ['title' => 'Innovation', 'text' => 'Each project requires an adapted response, so we pursue practical and high-performing solutions.'],
                    ['title' => 'Ethics', 'text' => 'Our work is guided by fairness, respect and full transparency with stakeholders.'],
                    ['title' => 'Safety', 'text' => 'Aware of the human and economic stakes, CITABIC applies core prevention principles on every site.'],
                    ['title' => 'Integrity', 'text' => 'Trust, honesty and openness shape the way we work and make decisions.'],
                ],
                'human_values' => [
                    ['title' => 'Collaboration', 'text' => 'We prioritize teamwork and collective mobilization to reach shared objectives.'],
                    ['title' => 'Belonging and support', 'text' => 'We cultivate belonging, mutual support, trust and shared values with stakeholders.'],
                    ['title' => 'Transparency', 'text' => 'From the first meeting, we build a clear relationship and a shared roadmap around the project.'],
                    ['title' => 'Well-being', 'text' => 'We encourage healthy habits, convinced that a healthy employee is a committed employee.'],
                    ['title' => 'Mutual respect', 'text' => 'Mutual respect and trust create the basis for collective intelligence and sustainable performance.'],
                ],
                'domains' => [
                    [
                        'title' => 'Civil engineering',
                        'items' => [
                            'Infrastructure works',
                            'Roads and utility networks',
                            'Self-supporting structures',
                            'Engineering structures',
                            'Sanitation',
                            'Structural strengthening',
                        ],
                    ],
                    [
                        'title' => 'Building construction',
                        'items' => [
                            'Turnkey delivery',
                            'General contracting',
                            'Structural works',
                            'Renovation and transformation',
                            'External works including industrial slabs and stamped concrete',
                            'Facades',
                        ],
                    ],
                    [
                        'title' => 'Real estate and OPC',
                        'items' => [
                            'Scheduling, steering and coordination',
                            'Financial simulations',
                            'Real-estate project acquisition and development',
                        ],
                    ],
                ],
                'certifications' => [
                    'ISO 9001:2015 - Quality management system',
                    'ISO 45001:2018 - Occupational health and safety management system',
                ],
                'information_system' => 'CITABIC has implemented a robust IT infrastructure powered by Odoo ERP to improve data availability, confidentiality and integrity. This architecture reflects organizational maturity and strong operational discipline.',
                'figures' => [
                    ['label' => 'People hired', 'value' => '1000+'],
                    ['label' => 'Built surface area', 'value' => '250 000 m2+'],
                    ['label' => 'Standards compliance', 'value' => '100 %'],
                    ['label' => 'Qualified suppliers', 'value' => '50+'],
                    ['label' => 'Dedicated professionals', 'value' => '70+'],
                    ['label' => 'Cumulative revenue', 'value' => '65 M MAD ex VAT+'],
                    ['label' => 'Projects delivered on time', 'value' => '92 %'],
                    ['label' => 'Technical partners', 'value' => '14'],
                ],
                'partnerships' => [
                    '5 renowned partner architects',
                    '5 specialized technical design offices',
                    '4 certified laboratories for analysis and quality testing',
                ],
                'compliance' => [
                    'Regulatory inspections for equipment including tower cranes and telescopic handlers',
                    'Forklift operator training certification',
                    'Calibration of equipment such as leveling devices and measuring tools',
                    'All-risk construction insurance, CNSS declarations, workplace accident coverage and civil liability insurance',
                    'Tax and CNSS regularity certificates, including 1007 and 1220 attestations',
                ],
                'organization' => [
                    'General management and strategic development',
                    'QHS, logistics, purchasing, transport and maintenance',
                    'Operations, studies/quantity surveying, site execution and control',
                    'Administrative and financial management, HR and finance',
                    'Business development and partner coordination',
                ],
                'processes' => [
                    'Risk management',
                    'Leadership and direction',
                    'Site management',
                    'Human resources management',
                    'Material resources management',
                    'Performance management and continuous improvement',
                ],
                'why_choose_us' => [
                    'Comprehensive construction expertise',
                    'Commitment to quality and safety',
                    'Tailored and innovative solutions',
                    'Experienced professional team',
                    'Advanced infrastructure and technology',
                ],
            ],
        ];
    }

    private function referenceTranslations(): array
    {
        return [
            'unite-industrielle-pjlp' => [
                'en' => [
                    'title' => 'Construction of an industrial unit',
                    'client' => 'PJLP SARL AU',
                    'summary' => 'Construction of an industrial unit dedicated to the production of traditional decorative tiles.',
                    'description' => 'PJLP SARL AU specializes in the production, manufacturing and sale of decorative tiles. CITABIC supported the delivery of this industrial unit within a long-established industrial group based in Tangier.',
                    'items' => [
                        'Self-supporting roof with a 36 m span',
                        'Prestressed concrete hollow-core slab floors',
                        'Conventional steel frame structure',
                        'Twin joist-and-block floors',
                        'Finishing works package (TCE)',
                        'Industrial slab, exterior works, waterproofing and under-slab networks',
                    ],
                ],
            ],
            'riad-ajdir' => [
                'en' => [
                    'title' => 'Riad Ajdir housing complex',
                    'client' => 'Residential development in Al Hoceima',
                    'summary' => 'Residential program located near the provincial hospital center and the beaches of Souani and Sfiha.',
                    'description' => 'The apartments, with two to three bedrooms, include bathrooms, modern kitchens, living areas and supporting amenities. The development also includes nearby services and complementary facilities designed to improve residents’ quality of life.',
                    'items' => [
                        'Sector 2 finishing works',
                        'Seismic floor structures',
                        'Sector 3 finishing works',
                        'Multi-sports court with industrial flooring and epoxy resin finish',
                        'Nursery, facades, external works and fire safety system',
                        'Sanitation networks, drip irrigation, waterproofing and retaining structures',
                    ],
                ],
            ],
            'entree-immeuble-r10-tanger' => [
                'en' => [
                    'title' => 'Main entrance refurbishment for a 10-storey building',
                    'client' => 'Downtown Tangier building',
                    'summary' => 'Transformation of the main entrance to deliver a premium and contemporary image.',
                    'description' => 'The project modernized the building’s appearance and improved the overall user experience through a full intervention on finishes, technical networks and lighting.',
                    'items' => [
                        'Modernization of the entrance facade',
                        'Replacement of floor and wall finishes',
                        'Wall cladding with premium materials',
                        'Addition of decorative elements',
                        'Custom LED lighting installation',
                        'Complete refurbishment of plumbing, sanitary and electrical systems',
                    ],
                ],
            ],
            'renforcement-immeuble-almaghreb-al-arabi' => [
                'en' => [
                    'title' => 'Renovation, restructuring and strengthening of SS+R+9 building',
                    'client' => 'ALMAGHREB AL ARABI',
                    'summary' => 'Structural treatment and reinforcement of reinforced-concrete elements through a rigorous and compliant process.',
                    'description' => 'CITABIC is responsible for restoring critical load-bearing elements and securing service networks in order to extend the building’s service life.',
                    'items' => [
                        'Reinforcement of columns, perimeter shear walls and parts of the slab',
                        'Structural safety upgrades in line with applicable standards',
                        'Full replacement of suspended sanitation networks',
                        'Additional works to adapt spaces to current uses',
                        'Execution based on a technical report from a specialized consultancy',
                    ],
                ],
            ],
            'opc-almisk-building' => [
                'en' => [
                    'title' => 'Scheduling, steering and coordination with ALMISK BUILDING',
                    'client' => 'ALMISK BUILDING',
                    'summary' => 'An OPC mission positioned at the center of project delivery success.',
                    'description' => 'The OPC assignment ensures site analysis, planning, coordination of stakeholders and continuity of operations while protecting budgets and delivery schedules.',
                    'items' => [
                        'In-depth site analysis',
                        'Task planning and organization',
                        'Supervision of works',
                        'Coordination with design office, architect, laboratory, inspection office and surveyor',
                        'Liaison with Amendis, land registry, cadastre and urban planning agency',
                    ],
                ],
            ],
        ];
    }
}
