<?php

namespace App\Enums;

enum ContentKey: string
{
    // HOME SECTION
    case HERO_TITLE = 'hero_title';
    case HERO_SUBTITLE = 'hero_subtitle';
    case HERO_BACKGROUND = 'hero_background';
    case CTA_1_TEXT = 'cta_1_text';
    case CTA_1_LINK = 'cta_1_link';
    case CTA_2_TEXT = 'cta_2_text';
    case CTA_2_LINK = 'cta_2_link';

    // ABOUT SECTION
    case ABOUT_TITLE = 'about_title';
    case ABOUT_TEXT = 'about_text';

    case OUR_APPROACH_TITLE = 'our_approach_title';

    // VALUES (1-6)
    case VALUE_1_TITLE = 'value_1_title';
    case VALUE_1_TEXT = 'value_1_text';
    case VALUE_2_TITLE = 'value_2_title';
    case VALUE_2_TEXT = 'value_2_text';
    case VALUE_3_TITLE = 'value_3_title';
    case VALUE_3_TEXT = 'value_3_text';
    case VALUE_4_TITLE = 'value_4_title';
    case VALUE_4_TEXT = 'value_4_text';
    case VALUE_5_TITLE = 'value_5_title';
    case VALUE_5_TEXT = 'value_5_text';
    case VALUE_6_TITLE = 'value_6_title';
    case VALUE_6_TEXT = 'value_6_text';

    // CONTACT SECTION
    case ADDRESS = 'address';
    case PHONE = 'phone';
    case EMAIL = 'email';
    case MAP_EMBED = 'map_embed';
    case CONTACT_FORM_TEXT = 'contact_form_text';

    // FOOTER SECTION
    case FOOTER_ADDRESS = 'footer_address';
    case FOOTER_PHONE = 'footer_phone';
    case FOOTER_EMAIL = 'footer_email';
    case FOOTER_COPYRIGHT = 'footer_copyright';
    case FACEBOOK_LINK = 'facebook_link';
    case LINKEDIN_LINK = 'linkedin_link';
    case INSTAGRAM_LINK = 'instagram_link';

    // SEO
    case META_TITLE = 'meta_title';
    case META_DESCRIPTION = 'meta_description';
    case META_KEYWORDS = 'meta_keywords';

    public function section(): Section
    {
        return match($this) {
            self::HERO_TITLE, self::HERO_SUBTITLE, self::HERO_BACKGROUND,
            self::CTA_1_TEXT, self::CTA_1_LINK, self::CTA_2_TEXT, self::CTA_2_LINK => Section::HOME,

            self::MISSION_TITLE, self::MISSION_TEXT, self::VALUES_TITLE,
            self::VALUE_1_TITLE, self::VALUE_1_TEXT, self::VALUE_2_TITLE, self::VALUE_2_TEXT,
            self::VALUE_3_TITLE, self::VALUE_3_TEXT, self::VALUE_4_TITLE, self::VALUE_4_TEXT,
            self::VALUE_5_TITLE, self::VALUE_5_TEXT, self::VALUE_6_TITLE, self::VALUE_6_TEXT => Section::ABOUT,

            self::ADDRESS, self::PHONE, self::EMAIL, self::MAP_EMBED,
            self::CONTACT_FORM_TEXT => Section::CONTACT,

            self::FOOTER_ADDRESS, self::FOOTER_PHONE, self::FOOTER_EMAIL,
            self::FOOTER_COPYRIGHT, self::FACEBOOK_LINK, self::LINKEDIN_LINK,
            self::INSTAGRAM_LINK => Section::FOOTER,

            default => Section::HOME,
        };
    }

    public function label(): string
    {
        return match($this) {
            self::HERO_TITLE => __('admin.content_keys.hero_title'),
            self::HERO_SUBTITLE => __('admin.content_keys.hero_subtitle'),
            self::HERO_BACKGROUND => __('admin.content_keys.hero_background'),
            self::CTA_1_TEXT => __('admin.content_keys.cta_1_text'),
            self::CTA_1_LINK => __('admin.content_keys.cta_1_link'),
            self::CTA_2_TEXT => __('admin.content_keys.cta_2_text'),
            self::CTA_2_LINK => __('admin.content_keys.cta_2_link'),
            self::MISSION_TITLE => __('admin.content_keys.mission_title'),
            self::MISSION_TEXT => __('admin.content_keys.mission_text'),
            self::VALUES_TITLE => __('admin.content_keys.values_title'),
            self::ADDRESS => __('admin.content_keys.address'),
            self::PHONE => __('admin.content_keys.phone'),
            self::EMAIL => __('admin.content_keys.email'),
            self::MAP_EMBED => __('admin.content_keys.map_embed'),
            self::CONTACT_FORM_TEXT => __('admin.content_keys.contact_form_text'),
            self::FOOTER_ADDRESS => __('admin.content_keys.footer_address'),
            self::FOOTER_PHONE => __('admin.content_keys.footer_phone'),
            self::FOOTER_EMAIL => __('admin.content_keys.footer_email'),
            self::FACEBOOK_LINK =>  __('admin.content_keys.facebook_link'),
            self::LINKEDIN_LINK => __('admin.content_keys.linkedin_link'),
            self::INSTAGRAM_LINK => __('admin.content_keys.instagram_link'),
            default => $this->value,
        };
    }
}
