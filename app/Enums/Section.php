<?php

namespace App\Enums;

enum Section: string
{
    case HOME = 'home';
    case HERO = 'hero';
    case ABOUT = 'about';
    case ABOUT_PAGE = 'about_page';
    case OUR_APPROACH = 'our_approach';
    case SERVICES = 'services';
    case PROJECTS = 'projects';
    case DOMAIN = 'domain';
    case WHY_CHOOSE_US = 'why_choose_us';
    case CONTACT = 'contact';
    case FOOTER = 'footer';

    public function label(): string
    {
        return match($this) {
            self::HERO => __('admin.sections.hero'),
            self::HOME => __('admin.sections.home'),
            self::ABOUT => __('admin.sections.about'),
            self::SERVICES => __('admin.sections.services'),
            self::PROJECTS => __('admin.sections.projects'),
            self::DOMAIN => __('admin.sections.domain'),
            self::CONTACT => __('admin.sections.contact'),
            self::FOOTER => __('admin.sections.footer'),
        };
    }
}
