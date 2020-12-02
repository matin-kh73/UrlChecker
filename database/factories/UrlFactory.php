<?php


namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;


class UrlFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Url::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'link' => $this->faker->url,
            'description' => $this->faker->text,
        ];
    }
}
