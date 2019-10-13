<?php

namespace App\Models\Traits;

use App\Helpers\DataFormat;

/**
 * Trait FormatValue
 *
 * @property string meta_value
 * @property string meta_format
 * @package App\Models\Traits
 */
trait FormatValue
{
    /**
     * Meta value
     *
     * @return mixed
     */
    public function value()
    {
        return DataFormat::toFormat($this->meta_value, $this->meta_format);
    }
}
