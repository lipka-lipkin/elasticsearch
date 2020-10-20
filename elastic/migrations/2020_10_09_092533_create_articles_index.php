<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;
use Elasticsearch\Client;

final class CreateArticlesIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('articles', function (Mapping $mapping, Settings $settings){
            $mapping->text('title');
            $mapping->text('description');
            $mapping->text('body');
            $mapping->text('searchable', [
                'analyzer' => 'autocomplete',
                'search_analyzer' => 'autocomplete_search'
            ]);
            $mapping->keyword('user_id');
            $mapping->date('created_at');
            $mapping->date('updated_at');
            $mapping->object('json');

            $settings->analysis([
                'analyzer' => [
                    'autocomplete' => [
                        'type' =>  'custom',
                        'tokenizer' => 'autocomplete',
                    ],
                    'autocomplete_search' => [
                        'tokenizer' => 'lowercase'
                    ]
                ],
                'tokenizer' => [
                    'autocomplete' => [
                        'type' => 'edge_ngram',
                        'min_gram' => 2,
                        'max_gram' => 10,
                        'token_chars' => ['letter']
                    ]
                ]
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('articles');
    }
}
