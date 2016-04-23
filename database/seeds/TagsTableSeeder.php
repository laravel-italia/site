<?php

use Illuminate\Database\Seeder;
use LaravelItalia\Domain\Repositories\TagRepository;
use LaravelItalia\Domain\Factories\TagFactory;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tagRepository = new TagRepository();

        $tagRepository->save(TagFactory::createTag('Presentazioni'));
        $tagRepository->save(TagFactory::createTag('Laravel'));
        $tagRepository->save(TagFactory::createTag('Lavoro'));
        $tagRepository->save(TagFactory::createTag('Progetti'));
        $tagRepository->save(TagFactory::createTag('Community'));

        $tagRepository->save(TagFactory::createTag('Installazione'));
        $tagRepository->save(TagFactory::createTag('Configurazione'));

        $tagRepository->save(TagFactory::createTag('Autenticazione'));
        $tagRepository->save(TagFactory::createTag('Sicurezza'));

        $tagRepository->save(TagFactory::createTag('Richieste'));
        $tagRepository->save(TagFactory::createTag('Input'));
        $tagRepository->save(TagFactory::createTag('Risposte'));

        $tagRepository->save(TagFactory::createTag('Sessioni'));
        $tagRepository->save(TagFactory::createTag('Cache'));

        $tagRepository->save(TagFactory::createTag('Database'));
        $tagRepository->save(TagFactory::createTag('Eloquent'));

        $tagRepository->save(TagFactory::createTag('Package'));
        $tagRepository->save(TagFactory::createTag('IoC'));

        $tagRepository->save(TagFactory::createTag('View'));
        $tagRepository->save(TagFactory::createTag('Blade'));
        $tagRepository->save(TagFactory::createTag('Form'));

        $tagRepository->save(TagFactory::createTag('Mail'));
        $tagRepository->save(TagFactory::createTag('Code'));
    }
}
