<?php

use LaravelItalia\Domain\Template;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\TemplateRepository;

class TemplateRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var TemplateRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new TemplateRepository();
        parent::setUp();
    }

    public function testCanGetAll()
    {
        $emptyTemplatesResults = $this->repository->getAll(1);

        $this->assertEmpty($emptyTemplatesResults);

        $this->saveTestTemplate();

        $templatesResults = $this->repository->getAll(1);

        $this->assertCount(1, $templatesResults);
    }

    public function testFindById()
    {
        $expectedTemplate = $this->saveTestTemplate();

        $template = $this->repository->findById($expectedTemplate->id);

        $this->assertEquals($expectedTemplate->id, $template->id);
    }

    public function testCanSave()
    {
        $template = $this->prepareTestTemplate();

        $this->repository->save($template);

        $this->seeInDatabase('templates', [
            'name' => 'my test template',
        ]);
    }

    public function testCanDelete()
    {
        $template = $this->saveTestTemplate();

        $this->seeInDatabase('templates', [
            'name' => 'my test template',
        ]);

        $this->repository->delete($template);

        $this->dontSeeInDatabase('templates', [
            'name' => 'my test template',
        ]);
    }

    public function prepareTestTemplate()
    {
        return Template::fromNameAndBody(
            'my test template',
            'my test template body'
        );
    }

    public function saveTestTemplate()
    {
        $template = $this->prepareTestTemplate();
        $template->save();

        return $template;
    }
}
