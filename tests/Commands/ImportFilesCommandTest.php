<?php
namespace Tests\Commands;

use Illuminate\Http\File;
use R64\ContentImport\Models\File as FileModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use R64\ContentImport\Tests\TestCase;

class ImportFilesCommandTest extends TestCase
{
    /** @test */
    public function it_should_import_files_and_save_them()
    {
        $this->markTestSkipped();
        $mockFilename = 'test_import.csv';

        Storage::fake('s3');
        Storage::disk('s3')->putFileAs('imports/1/', new File('tests/files/test_import.csv'), $mockFilename);

        Artisan::call('files:import');

        $record = FileModel::first();

        $this->assertEquals('s3', $record->disk);
        $this->assertEquals('imports/1/test_import.csv', $record->url);
        $this->assertNull($record->processed_at);
    }
}
