<?php

namespace App\Console\Commands;

use App\Models\Visit;
use Illuminate\Console\Command;

class CreateVisit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-visit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new visit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nombre = $this->ask('Ingrese el nombre:');
        $email = $this->ask('Ingrese el correo electrónico:');
        $latitud = $this->ask('Ingrese la latitud:');
        $longitud = $this->ask('Ingrese la longitud:');

        $this->validateInput($nombre, $email, $latitud, $longitud);

        $visita = Visit::create([
            'name' => $nombre,
            'email' => $email,
            'latitude' => $latitud,
            'longitude' => $longitud,
        ]);

        $this->info('Visita creada correctamente!');
    }

    protected function validateInput($nombre, $email, $latitud, $longitud)
    {
        if (empty($nombre) || empty($email) || empty($latitud) || empty($longitud)) {
            $this->error('Todos los campos son obligatorios.');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('El correo electrónico no es válido.');
            exit;
        }

        if (!is_numeric($latitud) || !is_numeric($longitud)) {
            $this->error('La latitud y longitud deben ser números.');
            exit;
        }
    }
}
