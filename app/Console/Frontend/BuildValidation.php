<?php

namespace App\Console\Commands\Frontend;

use App\Services\ValidationRules;
use Illuminate\Filesystem\Filesystem;

class BuildValidation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:frontend:validation';

    /**
     * Name of the created file.
     *
     * @var string
     */
    protected $targetFilename = 'validation.json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build validation rules for frontend (put all rules into a .json file).';

    /**
     * List of all validation rules that should be passed to FE
     * (VeeValidate knows how to handle it).
     *
     * @var array
     */
    protected $availableRules = [
        'email',
        'max',
        'min',
        'required',
    ];

    /**
     * @var ValidationRules
     */
    protected $validationRules;

    /**
     * BuildValidation constructor.
     * @param Filesystem $filesystem
     * @param ValidationRules $validationRules
     */
    public function __construct(Filesystem $filesystem, ValidationRules $validationRules)
    {
        $this->validationRules = $validationRules;

        parent::__construct($filesystem);
    }

    /**
     * Export data into json file.
     *
     * @return array
     */
    public function export(): array
    {
        return $this->getValidationRules();
    }

    /**
     * Get all validation rules for all the fields.
     *
     * @return array
     */
    protected function getValidationRules(): array
    {
        return $this->filterRules($this->validationRules->all());
    }

    /**
     * Return only rules available on frontend.
     *
     * @param array $rules
     * @return array
     */
    protected function filterRules(array $rules): array
    {
        $filtered = [];

        foreach ($rules as $key => $value) {
            if (is_array($value)) {
                $filtered[$key] = $this->filterRules($value);

                continue;
            }

            if (in_array($key, $this->availableRules)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }
}
