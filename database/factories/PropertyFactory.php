<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;
use App\Models\User;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Property::class;
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'name_tr' => $this->faker->sentence,
            'featured_image' => 'https://picsum.photos/1200/800',
            // 'featured_image' => 'https://picsum.photos/1200/800?random=' . rand(10, 1000),
            'location_id' => $this->configureLocation(),
            'price' => rand(100000,500000),
            'sale' => rand(1,2),
            'type' => rand(1,3),
            'bedrooms' => rand(1,6),
            'drawing_rooms' => rand(1,4),
            'bathrooms' => rand(1,5),
            'net_sqm' => rand(55,300),
            'gross_sqm' => rand(65,450),
            'pool' => rand(1,4),
            'overview' => $this->faker->text(100),
            'overview_tr' => $this->faker->text(100),
            'why_buy' => $this->faker->text(1000),
            'why_buy_tr' => $this->faker->text(1000),
            'description' => $this->faker->sentence(50),
            'description_tr' => $this->faker->sentence(50),
            'user_id' => $this->configureUser()
        ];
    }

    protected function configureLocation()
    {
        $locations = Location::all();
        if($locations->isEmpty()) return null;
        return $locations->isNotEmpty() ? $locations->random()->id : null;
    }

    protected function configureUser()
    {
        $users = User::all();
        if($users->isEmpty()) return null;
        return $users->isNotEmpty() ? $users->random()->id : null;
    }
}
