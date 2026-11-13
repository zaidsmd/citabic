-- ==============================================================================
-- CITABIC Arabic Translations Migration
-- Target: citabic.sql / Production Database (MySQL 8.0+)
-- ==============================================================================

SET NAMES utf8mb4;
SET @now = NOW();

-- 1. SECTION CONTENTS (Arabic rows)
INSERT INTO `section_contents` (`section`, `key`, `value`, `language`, `created_at`, `updated_at`)
VALUES
('hero', 'hero_title', 'معاً، نبني مستقبلكم', 'ar', @now, @now),
('hero', 'hero_subtitle', 'رؤيتكم، خبرتنا', 'ar', @now, @now),
('our_approach', 'our_approach_title', 'قطاع يشهد نمواً متسارعاً وتحولاً مستمراً', 'ar', @now, @now),
('about', 'about_title', 'نبذة عن CITABIC', 'ar', @now, @now),
('about', 'about_subtitle', 'من نحن', 'ar', @now, @now),
('about', 'about_text', '<p>تأسست شركة <strong>CITABIC</strong> في عام 2021، وهي شركة ديناميكية في قطاع البناء والأشغال العامة تعيد ابتكار معايير البناء والتجديد والهندسة المدنية من خلال مفهوم مبتكر. بالاعتماد على خبرة وكفاءة مهنيين مؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة ومفتاحية بأعلى مستويات الجودة. يرتكز نهجنا على التميز في الخدمة والإدارة المحكمة، مما يضمن إنجاز مشاريع تلبي بدقة أكثر المتطلبات تطلباً.</p>', 'ar', @now, @now),
('about_page', 'about_title', 'نبذة عن CITABIC', 'ar', @now, @now),
('about_page', 'about_text', '<p>تأسست شركة <strong>CITABIC</strong> في عام 2021، وهي شركة ديناميكية في قطاع البناء والأشغال العامة تعيد ابتكار معايير البناء والتجديد والهندسة المدنية من خلال مفهوم مبتكر. بالاعتماد على خبرة وكفاءة مهنيين مؤهلين، تلتزم الشركة بمرافقة عملائها في جميع مشاريعهم عبر تقديم حلول متكاملة ومفتاحية بأعلى مستويات الجودة. يرتكز نهجنا على التميز في الخدمة والإدارة المحكمة، مما يضمن إنجاز مشاريع تلبي بدقة أكثر المتطلبات تطلباً.</p>', 'ar', @now, @now),
('about_page', 'rounded_text', 'خبرة وجودة • ثقة ودقة •', 'ar', @now, @now),
('about_page', 'mission_title', 'مهمتنا', 'ar', @now, @now),
('about_page', 'mission_text', '<p>تتمحور مهمة <strong>CITABIC</strong> حول تحقيق رضا العملاء، وجودة الإدارة، والتنفيذ المنظم لجميع مراحل العمليات والأنشطة.</p>', 'ar', @now, @now),
('about_page', 'why_us_title', 'لماذا تختار CITABIC؟', 'ar', @now, @now),
('about_page', 'why_us_text', '<p>خبرة معتمدة في قطاع البناء وفق معايير <strong>ISO 9001 و 45001</strong>. تقدم فرقنا حلولاً مبتكرة ومخصصة، تضمن السلامة والشفافية (ERP) والاستدامة لكل مشروع، مع الالتزام الصارم بمتطلباتكم.</p>', 'ar', @now, @now),
('about_page', 'why_us_cards', 'خبرة شاملة في قطاع البناء والأشغال العامة;الالتزام بالجودة والسلامة;حلول مخصصة ومبتكرة;فريق من المهنيين ذوي الخبرة العالية;بنية تحتية وتكنولوجيا متطورة', 'ar', @now, @now),
('about_page', 'organigrame_title', 'الهيكل التنظيمي', 'ar', @now, @now),
('about_page', 'cartographie_title', 'خريطة عمليات CITABIC', 'ar', @now, @now),
('contact', 'contact_title', 'اتصل بنا', 'ar', @now, @now),
('contact', 'contact_form_text', 'تواصل مع CITABIC', 'ar', @now, @now),
('domain', 'domain_title', 'تغطية شاملة لكافة مراحل دورة البناء والأشغال العامة.', 'ar', @now, @now),
('domain', 'domain_subtitle', 'مجالات الأنشطة', 'ar', @now, @now),
('domain', 'domain_text', '<p>تغطي أنشطة CITABIC الهندسة المدنية، البناء، التطوير العقاري، ومهام التنسيق والإشراف على المشاريع.</p>', 'ar', @now, @now),
('why_choose_us', 'why_title', 'حيث تلتقي الرؤية بالبناء والإنجاز.', 'ar', @now, @now),
('why_choose_us', 'why_subtitle', 'لماذا تختارنا', 'ar', @now, @now),
('why_choose_us', 'why_text', 'خبرة في البناء معتمدة بشهادات ISO 9001 و 45001. توفر فرقنا حلولاً مبتكرة ومخصصة تضمن الأمان والشفافية (ERP) والاستدامة لكل مشاريعكم، مع الامتثال الدقيق لمعاييركم.', 'ar', @now, @now),
('why_choose_us', 'why_features', '[{"title": "خبرة شاملة في قطاع البناء", "text": "تحكم كامل في جميع جوانب البناء والأشغال العامة، من الهندسة المدنية إلى التسليم على المفتاح، مروراً بالتجديد والتهيئة الخارجية."}, {"title": "الالتزام بالجودة والسلامة", "text": "معايير عالية تضمنها شهادات ISO 9001 و ISO 45001، مما يضمن الجودة والأمان الأمثل في جميع مواقع العمل."}, {"title": "حلول مخصصة ومبتكرة", "text": "نهج مصمم خصيصاً يتكيف مع خصوصيات كل مشروع ويدمج حلولاً مبتكرة لتحقيق نتائج فعالة ومستدامة."}, {"title": "فريق من المهنيين ذوي الخبرة", "text": "خبراء مؤهلون وملتزمون في خدمتكم لضمان سير المشاريع بسلاسة مع احترام الآجال والميزانيات."}, {"title": "بنية تحتية وتكنولوجيا متطورة", "text": "إدارة متطورة بفضل نظام ERP المتقدم، مما يوفر شفافية وكفاءة معززة في كل مرحلة من مراحل خدماتنا."}]', 'ar', @now, @now),
('projects', 'projects_subtitle', 'مشاريعنا', 'ar', @now, @now),
('projects', 'projects_title', 'اكتشف أحدث مشاريعنا', 'ar', @now, @now),
('projects', 'projects_text', '<p>يشمل البناء التجاري والصناعي تصميم وتطوير وتشييد المنشآت المخصصة للشركات والمؤسسات.</p>', 'ar', @now, @now),
('home', 'blog_subtitle', 'الأخبار والمدونة', 'ar', @now, @now),
('home', 'blog_title', 'اكتشف رؤانا ومقالاتنا', 'ar', @now, @now),
('home', 'blog_text', '<p>يشمل قطاع البناء التجاري والصناعي تصميم وتطوير وتشييد البنى التحتية الاستراتيجية الموجهة لدعم كفاءة وأداء الشركات.</p>', 'ar', @now, @now),
('home', 'values_subtitle', 'قيمنا', 'ar', @now, @now),
('home', 'values_title', 'المبادئ التي نلتزم بها', 'ar', @now, @now)
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = @now;

-- 2. MISSION TRANSLATIONS (Arabic rows)
INSERT INTO `mission_translations` (`mission_id`, `locale`, `title`, `description`, `created_at`, `updated_at`)
VALUES
(1, 'ar', 'التميز التشغيلي', 'ضمان رضا عملائنا من خلال تقديم خدمات بناء وأشغال عامة عالية الجودة وخدمات متكاملة مصممة حسب الطلب.', @now, @now),
(2, 'ar', 'المعايير الدولية', 'خبرة معتمدة وأنظمة إدارة محكمة مطبقة في جميع مستويات مؤسستنا.', @now, @now),
(3, 'ar', 'حلول متكاملة (مفتاح في اليد)', 'مجموعة شاملة من الأنشطة (الهندسة المدنية، الواجهات، أعمال متنوعة) توفر تكاملاً مثالياً لمشاريعكم.', @now, @now),
(4, 'ar', 'الإدارة والاستدامة', 'إدارة مشاريع مثالية تضمن استدامة وقوة جميع منشآتنا وإنجازاتنا.', @now, @now)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`), `description` = VALUES(`description`), `updated_at` = @now;

-- 3. CERTIFICATIONS (Arabic rows)
INSERT INTO `certifications` (`slug`, `name`, `language`, `description`, `image`, `created_at`, `updated_at`)
VALUES
('certifie-iso-9001-v-2015', 'معتمد ISO 9001 إصدار 2015', 'ar', 'نظام إدارة الجودة', 'certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg', @now, @now),
('certifie-iso-45001-v-2018', 'معتمد ISO 45001 إصدار 2018', 'ar', 'نظام إدارة الصحة والسلامة المهنية', 'certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg', @now, @now)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `image` = VALUES(`image`), `updated_at` = @now;

-- 4. CITABIC DOMAINS (Enrich JSON translations with Arabic)
UPDATE `citabic_domains`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'title', 'الهندسة المدنية',
        'items', JSON_ARRAY('أشغال البنية التحتية', 'شبكات الصرف الصحي والتطهير (VRD)', 'المنشآت ذاتية الدعم', 'المنشآت الفنية والجسور', 'التطهير الصحي', 'تدعيم وتقوية الهياكل الإنشائية')
    )
), `updated_at` = @now
WHERE `id` = 1;

UPDATE `citabic_domains`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'title', 'البناء والتشييد',
        'items', JSON_ARRAY('مشاريع تسليم مفتاح', 'المقاولات العامة', 'الهياكل الخرسانية والأشغال الكبرى', 'التجديد والتحويل', 'التهيئة الخارجية (أرضيات صناعية، خرسانة مطبوعة...)', 'أشغال الواجهات')
    )
), `updated_at` = @now
WHERE `id` = 2;

UPDATE `citabic_domains`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'title', 'التطوير العقاري',
        'items', JSON_ARRAY('البرمجة والجدولة، القيادة والتنسيق (OPC)', 'المحاكاة والدراسات المالية', 'اقتناء وتطوير المشاريع العقارية')
    )
), `updated_at` = @now
WHERE `id` = 3;

-- 5. CITABIC FIGURES (Arabic labels)
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'رقم المعاملات التراكمي'), `updated_at` = @now WHERE `id` = 1;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'إجمالي الكفاءات العاملة'), `updated_at` = @now WHERE `id` = 2;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'إجمالي المساحة المشيدة'), `updated_at` = @now WHERE `id` = 3;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'الالتزام بالمواعيد والآجال'), `updated_at` = @now WHERE `id` = 4;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'الامتثال للمعايير والمواصفات'), `updated_at` = @now WHERE `id` = 5;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'موردون موثوقون'), `updated_at` = @now WHERE `id` = 6;
UPDATE `citabic_figures` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar.label', 'فريق عمل متخصص'), `updated_at` = @now WHERE `id` = 7;

-- 6. CITABIC PROCESSES (Arabic & English translations)
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "إدارة المخاطر", "description": "إرضاء العملاء من خلال تقديم خدمات بناء وتشييد متكاملة وعالية الجودة."}, "en": {"title": "Risk Management", "description": "Satisfying clients through high-quality construction and integrated services."}}' AS JSON), `updated_at` = @now WHERE `id` = 1;
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "الإدارة والتوجيه", "description": "توفير الخبرة وأنظمة الإدارة المتوافقة مع أرقى المعايير الدولية."}, "en": {"title": "Management & Direction", "description": "Providing expertise and management systems aligned with international standards."}}' AS JSON), `updated_at` = @now WHERE `id` = 2;
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "إدارة الورش والمواقع", "description": "تقديم مجموعة أنشطة قياسية ومنهجية ضمن رؤية تسليم المفتاح."}, "en": {"title": "Site Management", "description": "Offering a standardized and systematic range of activities for a turnkey approach."}}' AS JSON), `updated_at` = @now WHERE `id` = 3;
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "إدارة الموارد البشرية", "description": "ضمان جودة تدبير مثلى واستدامة المشاريع والمنجزات."}, "en": {"title": "Human Resources Management", "description": "Ensuring optimal management quality and project durability."}}' AS JSON), `updated_at` = @now WHERE `id` = 4;
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "إدارة العتاد واللوجستيك", "description": "توفير المعدات والآليات الحديثة وضمان صيانتها الفعالة لدعم الإنتاجية."}, "en": {"title": "Equipment & Logistics Management", "description": "Providing modern machinery and maintenance to guarantee site continuity and efficiency."}}' AS JSON), `updated_at` = @now WHERE `id` = 5;
UPDATE `citabic_processes` SET `translations` = CAST('{"ar": {"title": "إدارة الأداء والتحسين المستمر", "description": "متابعة مؤشرات الجودة والأداء بانتظام والارتقاء المستمر بمستوى الخدمات."}, "en": {"title": "Performance Management & Continuous Improvement", "description": "Continuous monitoring of KPIs and refining methodologies to enhance service quality."}}' AS JSON), `updated_at` = @now WHERE `id` = 6;

-- 7. CITABIC VALUES (Arabic values)
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'الالتزام', 'text', '<p>نتبنى ثقافة نقرن فيها القول بالعمل، ونفي بالتزاماتنا تجاه عملائنا ومجتمعنا وفريق عملنا.</p>')), `updated_at` = @now WHERE `id` = 1;
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'الجودة', 'text', '<p>في كل مرحلة من مراحل مشروعكم، تسهر سيتابيك (CITABIC) على ضمان جودة الأعمال المنفذة بواسطة مهنيينا ذوي الخبرة العالية.</p>')), `updated_at` = @now WHERE `id` = 2;
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'الابتكار', 'text', '<p>نؤمن بأن كل مشروع فريد ويتطلب حلولاً مصممة خصيصاً. نبذل قصارى جهدنا لتقديم الحلول التشغيلية الأكثر ابتكاراً لعملائنا.</p>')), `updated_at` = @now WHERE `id` = 3;
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'الأخلاقيات المهنية', 'text', '<p>احترام الأخلاقيات المهنية هو أساس أنشطتنا. نسترشد بمبادئ راسخة تضمن العدالة والاحترام والشفافية الكاملة مع جميع الشركاء.</p>')), `updated_at` = @now WHERE `id` = 4;
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'السلامة', 'text', '<p>إدراكاً منا للأهمية الإنسانية والاقتصادية المرتبطة بالسلامة، نلتزم بالمبادئ الأساسية للوقاية والأمان في جميع مواقع مشاريعنا.</p>')), `updated_at` = @now WHERE `id` = 5;
UPDATE `citabic_values` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', JSON_OBJECT('title', 'النزاهة', 'text', '<p>تستند أنشطتنا وعلاقاتنا المهنية إلى الثقة والصدق والوضوح. نفي بوعودنا ونحرص دائماً على التصرف بأعلى درجات المسؤولية.</p>')), `updated_at` = @now WHERE `id` = 6;

-- 8. CITABIC INFOS (32 Arabic entries)
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تعتبر سيتابيك (CITABIC) شركة يرتكز نشاطها الأساسي على قطاع البناء والأشغال العامة. تتسم خدماتها بالاستجابة السريعة والخبرة الميدانية والديناميكية العالية في مرافقة عملائها عبر كافة مراحل مشاريعهم.'), `updated_at` = @now WHERE `id` = 162;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تأسست الشركة سنة 2021 لتقدم مفهوماً جديداً في قطاع البناء بالسوق المغربي، من خلال عروض متكاملة مفتاح في اليد تشمل البناء، والتجديد، والهندسة المدنية، والاستشارة الهندسية.'), `updated_at` = @now WHERE `id` = 163;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تعتمد الشركة على نخبة من المهنيين ذوي الكفاءة العالية لتقديم خدمات متميزة تضمن راحة البال، وانضباطاً صارماً في التنفيذ، وأعلى المعايير في احترام الآجال والسلامة والاستدامة.'), `updated_at` = @now WHERE `id` = 164;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'يواصل النمو الاقتصادي والتوسع العمراني في المغرب دفع الطلب المتزايد على البنى التحتية الحديثة والسكن عالي الجودة.'), `updated_at` = @now WHERE `id` = 165;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تفرض المعايير البيئية والتطلعات المجتمعية تبني حلول بناء مستدامة وصديقة للبيئة.'), `updated_at` = @now WHERE `id` = 166;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'ضرورة امتثال المشاريع للمعايير الدولية للجودة والسلامة لضمان القيمة طويلة الأمد للأصول العقارية.'), `updated_at` = @now WHERE `id` = 167;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'يظل التحكم في التكاليف والالتزام بالجداول الزمنية أمراً حاسماً في سوق يتسم بالتنافسية العالية.'), `updated_at` = @now WHERE `id` = 168;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'أصبحت الأدوات الرقمية المتقدمة مثل نمذجة معلومات المباني (BIM) ونظام إدارة الموارد (ERP) ضرورية لتعزيز الدقة والشفافية وكفاءة التسليم.'), `updated_at` = @now WHERE `id` = 169;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تقديم خدمات بناء وأشغال عامة عالية الجودة ومرافقة متكاملة تضمن الرضا التام لعملائنا.'), `updated_at` = @now WHERE `id` = 170;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'توفير خبرة وأنظمة تدبير وإدارة متوافقة مع أرقى المعايير الدولية في جميع مستويات المؤسسة.'), `updated_at` = @now WHERE `id` = 171;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'اقتراح مجموعة أنشطة معيارية ومنهجية لنموذج إنجاز متكامل (مفتاح في اليد).'), `updated_at` = @now WHERE `id` = 172;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'ضمان جودة تدبير صارمة للمشاريع واستدامة متميزة لجميع المنشآت.'), `updated_at` = @now WHERE `id` = 173;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'ISO 9001:2015 - نظام إدارة الجودة'), `updated_at` = @now WHERE `id` = 174;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'ISO 45001:2018 - نظام إدارة الصحة والسلامة المهنية'), `updated_at` = @now WHERE `id` = 175;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', '5 مكاتب هندسة معمارية شريكة ومرموقة'), `updated_at` = @now WHERE `id` = 176;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', '5 مكاتب دراسات تقنية متخصصة'), `updated_at` = @now WHERE `id` = 177;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', '4 مختبرات معتمدة للتحاليل ومراقبة الجودة'), `updated_at` = @now WHERE `id` = 178;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'الفحص الدوري والتقني للعتاد بما في ذلك الرافعات البرجية والرافعات التلسكوبية'), `updated_at` = @now WHERE `id` = 179;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'شهادات تأهيل وتدريب سائقي ومشغلي الرافعات الشوكية والآليات'), `updated_at` = @now WHERE `id` = 180;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'معايرة وضبط أدوات القياس وأجهزة التسوية الطوبوغرافية'), `updated_at` = @now WHERE `id` = 181;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تأمين شامل لكافة أخطار الورش (TRC)، التصريح لدى الضمان الاجتماعي (CNSS)، وتغطية حوادث الشغل والمسؤولية المدنية'), `updated_at` = @now WHERE `id` = 182;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'شهادات الانتظام الضريبي والضمان الاجتماعي بما فيها شواهد 1007 و 1220'), `updated_at` = @now WHERE `id` = 183;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'الإدارة العامة والتطوير الاستراتيجي'), `updated_at` = @now WHERE `id` = 184;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'إدارة الجودة والسلامة والبيئة (QHS)، واللوجستيك، والمشتريات، والنقل والصيانة'), `updated_at` = @now WHERE `id` = 185;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'إدارة العمليات، والدراسات وحساب الكميات، وتتبع ومراقبة الأوراش'), `updated_at` = @now WHERE `id` = 186;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'الإدارة المالية والإدارية، وتدبير الموارد البشرية والمالية'), `updated_at` = @now WHERE `id` = 187;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'تطوير الأعمال والتنسيق مع الشركاء'), `updated_at` = @now WHERE `id` = 188;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'خبرة شاملة في قطاع البناء والأشغال العامة'), `updated_at` = @now WHERE `id` = 189;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'الالتزام بالجودة والسلامة المهنية'), `updated_at` = @now WHERE `id` = 190;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'حلول مبتكرة ومصممة حسب الطلب'), `updated_at` = @now WHERE `id` = 191;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'فريق متكامل من المهنيين ذوي الكفاءة العالية'), `updated_at` = @now WHERE `id` = 192;
UPDATE `citabic_infos` SET `translations` = JSON_SET(COALESCE(NULLIF(`translations`, ''), '{}'), '$.ar', 'بنية تحتية وتكنولوجيا متطورة'), `updated_at` = @now WHERE `id` = 193;

-- 9. CITABIC PROFILES
UPDATE `citabic_profiles`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'tagline', 'معاً، نبني مستقبلكم!',
        'full_name', 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة',
        'legal_form', 'شركة ذات مسؤولية محدودة بشريك وحيد (SARL AU)',
        'status', 'في نشاط مستمر',
        'head_office', '26 زنقة الأندلس، عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة',
        'intro', 'تعتبر سيتابيك (CITABIC) شركة يرتكز نشاطها الأساسي على قطاع البناء والأشغال العامة. تتسم خدماتها بالاستجابة السريعة والخبرة الميدانية والديناميكية العالية في مرافقة عملائها عبر كافة مراحل مشاريعهم.\r\nتأسست الشركة سنة 2021 لتقدم مفهوماً جديداً في قطاع البناء بالسوق المغربي، من خلال عروض متكاملة مفتاح في اليد تشمل البناء، والتجديد، والهندسة المدنية، والاستشارة الهندسية.\r\nتعتمد الشركة على نخبة من المهنيين ذوي الكفاءة العالية لتقديم خدمات متميزة تضمن راحة البال، وانضباطاً صارماً في التنفيذ، وأعلى المعايير في احترام الآجال والسلامة والاستدامة.',
        'mission', 'تقديم خدمات بناء وأشغال عامة عالية الجودة ومرافقة متكاملة تضمن الرضا التام لعملائنا.\r\nتوفير خبرة وأنظمة تدبير وإدارة متوافقة مع أرقى المعايير الدولية في جميع مستويات المؤسسة.\r\nاقتراح مجموعة أنشطة معيارية ومنهجية لنموذج إنجاز متكامل (مفتاح في اليد).\r\nضمان جودة تدبير صارمة للمشاريع واستدامة متميزة لجميع المنشآت.',
        'compliance', 'الفحص الدوري والتقني للعتاد بما في ذلك الرافعات البرجية والرافعات التلسكوبية\r\nشهادات تأهيل وتدريب سائقي ومشغلي الرافعات الشوكية والآليات\r\nمعايرة وضبط أدوات القياس وأجهزة التسوية الطوبوغرافية\r\nتأمين شامل لكافة أخطار الورش (TRC)، التصريح لدى الضمان الاجتماعي (CNSS)، وتغطية حوادث الشغل والمسؤولية المدنية\r\nشهادات الانتظام الضريبي والضمان الاجتماعي بما فيها شواهد 1007 و 1220',
        'organization', 'الإدارة العامة والتطوير الاستراتيجي\r\nإدارة الجودة والسلامة والبيئة (QHS)، واللوجستيك، والمشتريات، والنقل والصيانة\r\nإدارة العمليات، والدراسات وحساب الكميات، وتتبع ومراقبة الأوراش\r\nالإدارة المالية والإدارية، وتدبير الموارد البشرية والمالية\r\nتطوير الأعمال والتنسيق مع الشركاء',
        'partnerships', '5 مكاتب هندسة معمارية شريكة ومرموقة\r\n5 مكاتب دراسات تقنية متخصصة\r\n4 مختبرات معتمدة للتحاليل ومراقبة الجودة',
        'why_choose_us', 'خبرة شاملة في قطاع البناء والأشغال العامة\r\nالالتزام بالجودة والسلامة المهنية\r\nحلول مبتكرة ومصممة حسب الطلب\r\nفريق متكامل من المهنيين ذوي الكفاءة العالية\r\nبنية تحتية وتكنولوجيا متطورة',
        'certifications', 'ISO 9001:2015 - نظام إدارة الجودة\r\nISO 45001:2018 - نظام إدارة الصحة والسلامة المهنية',
        'market_context', 'يواصل النمو الاقتصادي والتوسع العمراني في المغرب دفع الطلب المتزايد على البنى التحتية الحديثة والسكن عالي الجودة.\r\nتفرض المعايير البيئية والتطلعات المجتمعية تبني حلول بناء مستدامة وصديقة للبيئة.\r\nضرورة امتثال المشاريع للمعايير الدولية للجودة والسلامة لضمان القيمة طويلة الأمد للأصول العقارية.\r\nيظل التحكم في التكاليف والالتزام بالجداول الزمنية أمراً حاسماً في سوق يتسم بالتنافسية العالية.\r\nأصبحت الأدوات الرقمية المتقدمة مثل نمذجة معلومات المباني (BIM) ونظام إدارة الموارد (ERP) ضرورية لتعزيز الدقة والشفافية وكفاءة التسليم.',
        'information_system', 'اعتمدت CITABIC بنية تحتية معلوماتية متطورة مدعومة بنظام ERP (Odoo) لتحسين جاهزية وسرية ونزاهة البيانات. تعكس هذه الهندسة نضجها التنظيمي وانضباطها المهني العالي.',
        'company', JSON_OBJECT(
            'tagline', 'معاً، نبني مستقبلكم!',
            'full_name', 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة',
            'legal_form', 'شركة ذات مسؤولية محدودة بشريك وحيد (SARL AU)',
            'status', 'في نشاط مستمر',
            'head_office', '26 زنقة الأندلس، عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة'
        )
    )
), `updated_at` = @now
WHERE `id` = 1;

-- 10. CITABIC REFERENCES
UPDATE `citabic_references`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'title', 'بناء وحدة صناعية لإنتاج بلاط الديكور التقليدي',
        'summary', '<p>شركة PJLP SARL AU هي شركة متخصصة في إنتاج وتصنيع وتسويق البلاط التزييني بمختلف الأشكال والمواد. تأسست على يد مؤسس MOSAIC Factory، وهي جزء من مجموعة صناعية أنشئت سنة 2002 في طنجة، متخصصة في صناعة البلاط والألواح وعناصر الأثاث من المواد المعدنية الطبيعية.</p>',
        'description', '<p>شركة PJLP SARL AU هي شركة متخصصة في إنتاج وتصنيع وتسويق البلاط التزييني بمختلف الأشكال والمواد. تأسست على يد مؤسس MOSAIC Factory، وهي جزء من مجموعة صناعية أنشئت سنة 2002 في طنجة، متخصصة في صناعة البلاط والألواح وعناصر الأثاث من المواد المعدنية الطبيعية.</p>',
        'items', JSON_ARRAY()
    )
), `updated_at` = @now
WHERE `id` = 6;

-- 11. BLOG POSTS
UPDATE `posts`
SET `translations` = JSON_SET(
    COALESCE(NULLIF(`translations`, ''), '{}'),
    '$.ar',
    JSON_OBJECT(
        'title', 'المغرب: ورش بناء مفتوح نحو أفق 2030',
        'excerpt', 'يشهد قطاع البناء والأشغال العامة في المغرب طفرة كبرى مع كأس إفريقيا 2025 وكأس العالم 2030، مع استثمارات تفوق 140 مليار درهم. ورش مستقبلي يمثل 6% من الناتج المحلي الإجمالي و10% من فرص الشغل.',
        'meta_title', 'قطاع البناء في المغرب: أفق 2030 وازدهار القطاع | CITABIC',
        'meta_description', 'اكتشف كيف تدفع استضافة كأس إفريقيا 2025 ومونديال 2030 قطاع البناء في المغرب، مع استثمارات تفوق 140 مليار درهم وخبرة سيتابيك المعتمدة.'
    )
), `updated_at` = @now
WHERE `id` = 2;

-- 12. COMPANY INFOS
INSERT INTO `company_infos` (`key`, `value`, `lang`, `created_at`, `updated_at`)
VALUES
('full_name', 'الشركة الدولية للتهيئة والأشغال - البناء والعقار - الاستشارة', 'ar', @now, @now),
('legal_name', 'سيتابيك', 'ar', @now, @now),
('status', 'نشط', 'ar', @now, @now),
('legal_form', 'شركة ذات مسؤولية محدودة بشريك وحيد', 'ar', @now, @now),
('address', 'عمارة مكاتب أناتوليا، الطابق 6، رقم 17، طنجة', 'ar', @now, @now)
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = @now;
