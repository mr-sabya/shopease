<?php

namespace App\Enums;

enum AttributeDisplayType: string
{
    case Text = 'text';
    case ColorSwatch = 'color_swatch';
    case ImageSwatch = 'image_swatch';
    case Dropdown = 'dropdown';
    case Radio = 'radio';
    case Checkbox = 'checkbox';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'Text Input',
            self::ColorSwatch => 'Color Swatch',
            self::ImageSwatch => 'Image Swatch',
            self::Dropdown => 'Dropdown Select',
            self::Radio => 'Radio Buttons',
            self::Checkbox => 'Checkboxes',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
