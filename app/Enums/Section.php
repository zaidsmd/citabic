<?php

namespace App\Enums;

enum Section: string
{
    case HOME = 'home';
    case ABOUT = 'about';
    case OUR_APPROACH = 'our_approach';
    case SERVICES = 'services';
    case PROJECTS = 'projects';
    case CONTACT = 'contact';
    case FOOTER = 'footer';

    public function label(): string
    {
        return match($this) {
            self::HOME => __('admin.sections.home'),
            self::ABOUT => __('admin.sections.about'),
            self::SERVICES => __('admin.sections.services'),
            self::PROJECTS => __('admin.sections.projects'),
            self::CONTACT => __('admin.sections.contact'),
            self::FOOTER => __('admin.sections.footer'),
        };
    }
}
