<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\DTO\Archive;

use DateTime;
use Rugaard\OldDMI\DTO\AbstractDTO;
use Tightenco\Collect\Support\Collection;

/**
 * Class Parameter.
 *
 * @package Rugaard\OldDMI\DTO\Archive
 */
class Parameter extends AbstractDTO
{
    /**
     * Title of parameter.
     *
     * @var string|null
     */
    protected $title;

    /**
     * ID of parameter.
     *
     * @var int|null
     */
    protected $parameterId;

    /**
     * Collection of values.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $values;

    /**
     * URL to image map.
     *
     * @var string|null
     */
    protected $imageUrl;

    /**
     * Parameter constructor.
     *
     * @param int   $parameterId
     * @param array $data
     */
    public function __construct(int $parameterId, array $data = [])
    {
        // Set parameter ID.
        $this->setParameterId($parameterId);

        parent::__construct($data);
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setTitle($data['parameter'])
             ->setValues($data['dataserie']);
    }

    /**
     * Set parameter title.
     *
     * @param  string $title
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get parameter title.
     *
     * @return string|null
     */
    public function getTitle() :? string
    {
        return $this->title;
    }

    /**
     * Set parameter ID.
     *
     * @param  int|null $parameterId
     * @return $this
     */
    public function setParameterId(?int $parameterId) : self
    {
        $this->parameterId = $parameterId;
        return $this;
    }

    /**
     * Get parameter ID.
     *
     * @return int|null
     */
    public function getParameterId() :? int
    {
        return $this->parameterId;
    }

    /**
     * Set parameter values.
     *
     * @param  array $data
     * @return $this
     */
    public function setValues(array $data) : self
    {
        // Collection of values.
        $values = Collection::make();

        foreach ($data as $value) {
            $values->push(new Value($value));
        }

        // Set parameter values.
        $this->values = $values;

        return $this;
    }

    /**
     * Get parameter values.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getValues() :? Collection
    {
        return $this->values;
    }

    /**
     * Set image URL by parameter key.
     *
     * @param  string    $frequency
     * @param  \DateTime $period
     * @return $this
     */
    public function setImageUrl(string $frequency, DateTime $period) : self
    {
        // DMI do not support "yearly" maps.
        if ($frequency === 'yearly') {
            return $this;
        }

        // Determine map frequency.
        switch ($frequency) {
            case 'monthly':
                $mapFrequency = 'year';
                $mapFilename = $period->format('Y') . '.png';
                break;
            case 'daily':
                $mapFrequency = 'month';
                $mapFilename = $period->format('Y') . '/' . $period->format('Ym') . '.png';
                break;
            default:
                $mapFrequency = 'day';
                $mapFilename = $period->format('Y') . '/' . $period->format('m') . '/' . $period->format('Ymd') . '.png';
        }

        // Set image URL.
        $this->imageUrl = sprintf(
            'https://www.dmi.dk/fileadmin/tkdata/KlGridDK/grid_maps/%s/%d/interpolated_1/%s',
            $mapFrequency,
            $this->getParameterId(),
            $mapFilename
        );

        return $this;
    }

    /**
     * Get image URL.
     *
     * @return string|null
     */
    public function getImageUrl() :? string
    {
        return $this->imageUrl;
    }
}
